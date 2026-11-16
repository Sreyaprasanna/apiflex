<?php

namespace App\Http\Middleware;

use App\Models\Project;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class VerifyApiKey
{
    public function handle(Request $request, Closure $next): Response
    {
        // Get API key from request header
        $apiKey = $request->header('X-API-KEY');

        if (!$apiKey) {
            return response()->json([
                'message' => 'API key is required'
            ], 401);
        }

        // Get project from URL
        $projectSlug = $request->route('projectSlug');

        $project = Project::where('database_name', $projectSlug)
            ->orWhere('id', $projectSlug)
            ->first();

        if (!$project) {
            return response()->json([
                'message' => 'Project not found'
            ], 404);
        }

        // Hash the supplied key
        $hashedKey = hash('sha256', $apiKey);

        // Compare stored hash with supplied key hash
        if (!hash_equals($project->api_key_hash ?? '', $hashedKey)) {
            return response()->json([
                'message' => 'Invalid API key'
            ], 401);
        }

        // Key is valid, continue request
        return $next($request);
    }
}