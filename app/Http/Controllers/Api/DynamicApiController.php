<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DynamicApiController extends Controller
{
    private function readJson($project, $table)
    {
        $path = storage_path("app/mock_data/{$project}/{$table}.json");
        if (!file_exists($path))
            return [];
        return json_decode(file_get_contents($path), true) ?? [];
    }
    private function writeJson($project, $table, array $data)
    {
        $dir = storage_path("app/mock_data/{$project}");
        if (!is_dir($dir))
            mkdir($dir, 0755, true);
        file_put_contents("{$dir}/{$table}.json", json_encode($data, JSON_PRETTY_PRINT));
    }
    // ─── GET /api/{project}/{table} ────────────────────────
    public function index($project, $table)
    {
        $records = $this->readJson($project, $table);
        return response()->json([
            'data' => $records,
            'count' => count($records),
        ]);
    }


    // ─── POST /api/{project}/{table} ───────────────────────

    public function store(Request $request, $project, $table)
    {
        $records = $this->readJson($project, $table);

        $newId = count($records) > 0
            ? max(array_column($records, 'id')) + 1
            : 1;

        $newRecord = array_merge(['id' => $newId], $request->all());

        $records[] = $newRecord;

        $this->writeJson($project, $table, $records);

        return response()->json([
            'message' => 'Record created',
            'data' => $newRecord,
        ], 201);
    }


}


