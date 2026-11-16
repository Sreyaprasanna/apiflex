<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Http;
use App\Models\Project;

class postmancontroller extends Controller
{
    /**
     * Global Tester Entry Point (from Sidebar)
     */
    public function globalTester()
    {
        $project = Project::with(['tables.fields'])->latest()->first();

        if ($project) {
            return redirect()->route('projects.tester', $project->database_name);
        }

        return view('projects.tester', ['project' => null]);
    }

    /**
     * Display the Postman-style REST API tester UI
     */
    public function tester($projectIdentifier)
    {
        $project = Project::with(['tables.fields'])
            ->where('database_name', $projectIdentifier)
            ->orWhere('id', $projectIdentifier)
            ->firstOrFail();

        return view('projects.tester', compact('project'));
    }

    /**
     * Proxy HTTP Request Executor (Postman Engine)
     */
    public function send(Request $request, $projectIdentifier)
    {
        $project = Project::where('database_name', $projectIdentifier)
            ->orWhere('id', $projectIdentifier)
            ->firstOrFail();

        $validated = $request->validate([
            'method'  => 'required|string|in:GET,POST,PUT,DELETE,PATCH',
            'url'     => 'required|url',
            'headers' => 'nullable|array',
            'body'    => 'nullable',
        ]);

        $method  = strtoupper($validated['method']);
        $url     = $validated['url'];
        $headers = $validated['headers'] ?? [];
        $body    = $validated['body'] ?? null;

        $startTime = microtime(true);

        try {
            $parsedUrl   = parse_url($url);
            $requestHost = $parsedUrl['host'] ?? 'localhost';
            $requestPort = $parsedUrl['port'] ?? null;

            $currentHost = $request->getHost();
            $currentPort = $request->getPort();

            // Detect if this is a request to the local application
            $isInternal = (
                in_array($requestHost, ['localhost', '127.0.0.1', $currentHost]) &&
                (!$requestPort || $requestPort == $currentPort)
            );

            if ($isInternal) {
                // Internal request dispatch: executes middleware & DynamicApiController directly without network deadlock
                $path = ($parsedUrl['path'] ?? '/') . (isset($parsedUrl['query']) ? '?' . $parsedUrl['query'] : '');
                
                $rawContent = is_array($body) ? json_encode($body) : ($body ?? '');
                
                $subRequest = Request::create(
                    $path,
                    $method,
                    [],
                    [],
                    [],
                    [
                        'HTTP_ACCEPT' => 'application/json',
                    ],
                    $rawContent
                );

                foreach ($headers as $k => $v) {
                    $subRequest->headers->set($k, $v);
                }

                if (in_array($method, ['POST', 'PUT', 'PATCH']) && !empty($rawContent)) {
                    $subRequest->headers->set('Content-Type', 'application/json');
                }

                $response = app()->handle($subRequest);

                $durationMs = round((microtime(true) - $startTime) * 1000);
                $rawBody    = $response->getContent();
                $byteSize   = strlen($rawBody);
                $jsonBody   = json_decode($rawBody, true);

                $status = $response->getStatusCode();

                return response()->json([
                    'success'     => true,
                    'status'      => $status,
                    'status_text' => Response::$statusTexts[$status] ?? 'OK',
                    'time_ms'     => $durationMs,
                    'size_bytes'  => $byteSize,
                    'headers'     => $response->headers->all(),
                    'data'        => $jsonBody ?? $rawBody,
                ]);

            } else {
                // External requests executed via Guzzle HTTP Client
                $httpRequest = Http::withHeaders($headers)->timeout(12);

                if (in_array($method, ['POST', 'PUT', 'PATCH']) && !empty($body)) {
                    $payload = is_string($body) ? json_decode($body, true) : $body;
                    $response = $httpRequest->send($method, $url, [
                        'json' => $payload ?? $body,
                    ]);
                } else {
                    $response = $httpRequest->send($method, $url);
                }

                $durationMs = round((microtime(true) - $startTime) * 1000);
                $rawBody    = $response->body();
                $byteSize   = strlen($rawBody);
                $jsonBody   = json_decode($rawBody, true);

                return response()->json([
                    'success'     => true,
                    'status'      => $response->status(),
                    'status_text' => $response->reason(),
                    'time_ms'     => $durationMs,
                    'size_bytes'  => $byteSize,
                    'headers'     => $response->headers(),
                    'data'        => $jsonBody ?? $rawBody,
                ]);
            }

        } catch (\Throwable $e) {
            $durationMs = round((microtime(true) - $startTime) * 1000);

            return response()->json([
                'success'     => false,
                'status'      => 500,
                'status_text' => 'Request Failed',
                'time_ms'     => $durationMs,
                'error'       => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Download a native Postman Collection (.json) compatible with Postman v2.1
     */
    public function exportCollection($projectIdentifier)
    {
        $project = Project::with(['tables.fields'])
            ->where('database_name', $projectIdentifier)
            ->orWhere('id', $projectIdentifier)
            ->firstOrFail();

        $items = [];

        foreach ($project->tables as $table) {
            $baseUrl = url("/api/{$project->database_name}/{$table->slug}");

            // Generate sample JSON body from fields
            $samplePayload = [];
            foreach ($table->fields as $f) {
                $samplePayload[$f->name] = match ($f->type) {
                    'email'   => 'user@example.com',
                    'number'  => 25,
                    'boolean' => true,
                    'date'    => '2026-11-10',
                    'text'    => 'Sample text content',
                    default   => 'Sample ' . $f->name,
                };
            }
            $sampleJson = json_encode($samplePayload, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);

            $tableFolder = [
                'name' => $table->name,
                'item' => [
                    // 1. GET All
                    [
                        'name' => "GET All {$table->name}",
                        'request' => [
                            'method' => 'GET',
                            'header' => [
                                ['key' => 'X-API-KEY', 'value' => $project->api_key, 'type' => 'text'],
                                ['key' => 'Accept', 'value' => 'application/json', 'type' => 'text'],
                            ],
                            'url' => [
                                'raw' => $baseUrl,
                                'host' => [url('/')],
                                'path' => ['api', $project->database_name, $table->slug],
                            ],
                            'description' => "Returns all records from the {$table->name} table.",
                        ],
                    ],
                    // 2. GET by ID
                    [
                        'name' => "GET {$table->name} by ID",
                        'request' => [
                            'method' => 'GET',
                            'header' => [
                                ['key' => 'X-API-KEY', 'value' => $project->api_key, 'type' => 'text'],
                                ['key' => 'Accept', 'value' => 'application/json', 'type' => 'text'],
                            ],
                            'url' => [
                                'raw' => $baseUrl . '/1',
                                'host' => [url('/')],
                                'path' => ['api', $project->database_name, $table->slug, '1'],
                            ],
                            'description' => "Fetches a single record by numeric ID.",
                        ],
                    ],
                    // 3. POST Create
                    [
                        'name' => "POST Create {$table->name}",
                        'request' => [
                            'method' => 'POST',
                            'header' => [
                                ['key' => 'X-API-KEY', 'value' => $project->api_key, 'type' => 'text'],
                                ['key' => 'Content-Type', 'value' => 'application/json', 'type' => 'text'],
                                ['key' => 'Accept', 'value' => 'application/json', 'type' => 'text'],
                            ],
                            'body' => [
                                'mode' => 'raw',
                                'raw' => $sampleJson,
                                'options' => [
                                    'raw' => ['language' => 'json']
                                ]
                            ],
                            'url' => [
                                'raw' => $baseUrl,
                                'host' => [url('/')],
                                'path' => ['api', $project->database_name, $table->slug],
                            ],
                            'description' => "Creates a new record with your custom fields.",
                        ],
                    ],
                    // 4. PUT Update
                    [
                        'name' => "PUT Update {$table->name}",
                        'request' => [
                            'method' => 'PUT',
                            'header' => [
                                ['key' => 'X-API-KEY', 'value' => $project->api_key, 'type' => 'text'],
                                ['key' => 'Content-Type', 'value' => 'application/json', 'type' => 'text'],
                                ['key' => 'Accept', 'value' => 'application/json', 'type' => 'text'],
                            ],
                            'body' => [
                                'mode' => 'raw',
                                'raw' => $sampleJson,
                                'options' => [
                                    'raw' => ['language' => 'json']
                                ]
                            ],
                            'url' => [
                                'raw' => $baseUrl . '/1',
                                'host' => [url('/')],
                                'path' => ['api', $project->database_name, $table->slug, '1'],
                            ],
                            'description' => "Updates an existing record by ID.",
                        ],
                    ],
                    // 5. DELETE
                    [
                        'name' => "DELETE {$table->name}",
                        'request' => [
                            'method' => 'DELETE',
                            'header' => [
                                ['key' => 'X-API-KEY', 'value' => $project->api_key, 'type' => 'text'],
                                ['key' => 'Accept', 'value' => 'application/json', 'type' => 'text'],
                            ],
                            'url' => [
                                'raw' => $baseUrl . '/1',
                                'host' => [url('/')],
                                'path' => ['api', $project->database_name, $table->slug, '1'],
                            ],
                            'description' => "Deletes a record by ID.",
                        ],
                    ],
                ]
            ];

            $items[] = $tableFolder;
        }

        $collection = [
            'info' => [
                'name' => $project->name . ' — ApiFlex Collection',
                '_postman_id' => (string) \Illuminate\Support\Str::uuid(),
                'description' => "Auto-generated Postman collection for project {$project->name}",
                'schema' => 'https://schema.getpostman.com/json/collection/v2.1.0/collection.json',
            ],
            'item' => $items,
        ];

        return response()->json($collection, 200, [
            'Content-Disposition' => 'attachment; filename="' . $project->database_name . '_postman_collection.json"',
            'Content-Type' => 'application/json; charset=UTF-8',
        ]);
    }
}
