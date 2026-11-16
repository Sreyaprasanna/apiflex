<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Project;
use App\Models\ApiTable;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class ApiTableController extends Controller
{
    public function storeTable(Request $request, $projectIdentifier)
    {
        $project = Project::where('database_name', $projectIdentifier)
            ->orWhere('id', $projectIdentifier)
            ->firstOrFail();

        $request->validate([
            'name' => 'required|string|max:100',
            'fields' => 'nullable|array',
            'fields.*.name' => 'nullable|string|max:100',
            'fields.*.type' => 'nullable|string|in:string,number,boolean,email,date,text',
            'fields.*.required' => 'nullable',
        ]);

        $tableName = trim($request->name);
        $slug = Str::slug($tableName, '_');

        $exists = $project->tables()->where('slug', $slug)->exists();
        if ($exists) {
            return back()->withInput()->withErrors(['name' => 'A table with this name already exists in this project.']);
        }

        $table = DB::transaction(function () use ($project, $tableName, $slug, $request) {
            $table = $project->tables()->create([
                'name' => $tableName,
                'slug' => $slug,
            ]);

            if ($request->has('fields') && is_array($request->fields)) {
                foreach ($request->fields as $fieldData) {
                    $fieldName = trim($fieldData['name'] ?? '');
                    if ($fieldName === '') {
                        continue;
                    }

                    $fieldType = $fieldData['type'] ?? 'string';
                    $isRequired = !empty($fieldData['required']);

                    $table->fields()->create([
                        'name' => Str::snake($fieldName),
                        'type' => $fieldType,
                        'required' => $isRequired,
                    ]);
                }
            }

            return $table;
        });

        if ($request->wantsJson() || $request->is('api/*')) {
            return response()->json([
                'message' => 'Table created successfully',
                'data' => $table->load('fields')
            ], 201);
        }

        return redirect()->route('projects.tables.show', [
            'project' => $project->database_name,
            'table' => $slug,
        ])->with('success', "Table '{$tableName}' and fields created successfully!");
    }


    public function showTable($projectIdentifier, $tableIdentifier)
    {
        $project = Project::where('database_name', $projectIdentifier)
            ->orWhere('id', $projectIdentifier)
            ->firstOrFail();

        // Ensure project has an API key generated and stored
        if (!$project->api_key) {
            $key = 'sk_live_' . Str::random(48);
            $project->update([
                'api_key' => $key,
                'api_key_hash' => hash('sha256', $key),
            ]);
        }

        $table = ApiTable::with('fields')
            ->where('project_id', $project->id)
            ->where(function ($query) use ($tableIdentifier) {
                $query->where('slug', $tableIdentifier)
                    ->orWhere('name', $tableIdentifier)
                    ->orWhere('id', $tableIdentifier);
            })
            ->firstOrFail();

        return view('projects.table', compact('project', 'table'));
    }


    public function destroyTable($projectIdentifier, $tableId)
    {
        $project = Project::where('database_name', $projectIdentifier)
            ->orWhere('id', $projectIdentifier)
            ->firstOrFail();

        $table = $project->tables()->findOrFail($tableId);
        $name = $table->name;
        $table->delete();

        return redirect()->route('projects.show', $project->database_name)
            ->with('success', "Table '{$name}' was deleted.");
    }


}
