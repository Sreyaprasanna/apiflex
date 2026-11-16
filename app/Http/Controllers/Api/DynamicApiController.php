<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Models\ApiTable;
use App\Models\MockRecord;
use Illuminate\Http\Request;

class DynamicApiController extends Controller
{
    // ─── Helpers ───────────────────────────────────────────
    
    

    private function resolveTable($projectSlug, $tableName)
    {
        $project = Project::where('database_name', $projectSlug)
            ->orWhere('id', $projectSlug)
            ->first();

        if (!$project) {
            return null;
        }

        return $project->tables()
            ->where(function ($query) use ($tableName) {
                $query->where('slug', $tableName)
                    ->orWhere('name', $tableName)
                    ->orWhere('id', $tableName);
            })
            ->first();
    }

    private function findRecord($table, $id)
    {
        return MockRecord::where('api_table_id', $table->id)->find($id);
    }

    private function format($record)
    {
        return array_merge(['id' => $record->id], $record->data ?? []);
    }

    // ─── GET /api/{project}/{table} ────────────────────────

    public function index($projectSlug, $tableName)
    {
        $table = $this->resolveTable($projectSlug, $tableName);
        if (!$table) {
            return response()->json(['message' => 'Project or table not found'], 404);
        }

        $records = MockRecord::where('api_table_id', $table->id)
            ->get()
            ->map(fn($r) => $this->format($r));

        return response()->json([
            'data'  => $records,
            'count' => $records->count(),
        ]);
    }

    // ─── POST /api/{project}/{table} ───────────────────────

    public function store(Request $request, $projectSlug, $tableName)
    {
        $table = $this->resolveTable($projectSlug, $tableName);
        if (!$table) {
            return response()->json(['message' => 'Project or table not found'], 404);
        }

        $record = MockRecord::create([
            'api_table_id' => $table->id,
            'data'         => $request->all(),
        ]);

        return response()->json([
            'message' => 'Record created successfully',
            'data'    => $this->format($record),
        ], 201);
    }

    // ─── GET /api/{project}/{table}/{id} ───────────────────

    public function show($projectSlug, $tableName, $id)
    {
        $table  = $this->resolveTable($projectSlug, $tableName);
        $record = $table ? $this->findRecord($table, $id) : null;

        if (!$record) {
            return response()->json(['message' => 'Record not found'], 404);
        }

        return response()->json([
            'data' => $this->format($record),
        ]);
    }

    // ─── PUT /api/{project}/{table}/{id} ───────────────────

    public function update(Request $request, $projectSlug, $tableName, $id)
    {
        $table  = $this->resolveTable($projectSlug, $tableName);
        $record = $table ? $this->findRecord($table, $id) : null;

        if (!$record) {
            return response()->json(['message' => 'Record not found'], 404);
        }

        $record->update([
            'data' => array_merge($record->data ?? [], $request->all()),
        ]);

        return response()->json([
            'message' => 'Record updated successfully',
            'data'    => $this->format($record),
        ]);
    }

    // ─── DELETE /api/{project}/{table}/{id} ────────────────

    public function destroy($projectSlug, $tableName, $id)
    {
        $table  = $this->resolveTable($projectSlug, $tableName);
        $record = $table ? $this->findRecord($table, $id) : null;

        if (!$record) {
            return response()->json(['message' => 'Record not found'], 404);
        }

        $record->delete();

        return response()->json(['message' => 'Record deleted successfully']);
    }

    // ─── POST /api/{project}/{table}/seed ──────────────────

    public function seed($projectSlug, $tableName)
    {
        $table = $this->resolveTable($projectSlug, $tableName);
        if (!$table) {
            return response()->json(['message' => 'Project or table not found'], 404);
        }

        $created = [];

        for ($i = 0; $i < 100; $i++) {
            $data = [];
            foreach ($table->fields as $field) {
                $data[$field->name] = match ($field->type) {
                    'email'   => fake()->safeEmail(),
                    'number'  => fake()->numberBetween(1, 100),
                    'boolean' => fake()->boolean(),
                    'date'    => fake()->date(),
                    'text'    => fake()->sentence(),
                    default   => fake()->name(),
                };
            }

            $record = MockRecord::create([
                'api_table_id' => $table->id,
                'data'         => $data,
            ]);

            $created[] = $this->format($record);
        }

        return response()->json([
            'message' => '100 dummy records generated successfully',
            'data'    => $created,
        ]);
    }
}
