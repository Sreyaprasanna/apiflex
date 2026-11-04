<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Project;
use App\Models\ApiTable;
use App\Models\ApiField;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class ProjectController extends Controller
{
    /**
     * Web Dashboard: list all projects
     */
    public function dashboard()
    {
        $projects = Project::withCount('tables')->latest()->get();

        return view('dashboard', compact('projects'));
    }

    /**
     * API: list all projects (JSON)
     */
    public function index()
    {
        $projects = Project::withCount('tables')->latest()->get();

        return response()->json([
            'data' => $projects
        ]);
    }

    /**
     * Store a new project (handles both Web form and API POST)
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'database_name' => 'required|string|alpha_dash|unique:projects,database_name',
            'description' => 'nullable|string',

        ]);

        $project = Project::create($validated);

        if ($request->wantsJson() || $request->is('api/*')) {
            return response()->json([
                'message' => 'Project created successfully',
                'data' => $project
            ], 201);
        }

        return redirect()->route('projects.show', $project->database_name)
            ->with('success', "Project '{$project->name}' created successfully!");
    }

    /**
     * Display a single project:
     * - In browser: renders projects.show Blade view
     * - In API: returns JSON
     */
    public function show($id)
    {
        $project = Project::with(['tables.fields'])
            ->where('id', $id)
            ->orWhere('database_name', $id)
            ->first();

        if (!$project) {
            if (!request()->wantsJson() && !request()->is('api/*')) {
                return redirect()->route('dashboard')->withErrors(['error' => 'Project not found.']);
            }
            return response()->json(['message' => 'Project not found'], 404);
        }

        if (!request()->wantsJson() && !request()->is('api/*')) {
            $tables = $project->tables;
            return view('projects.show', compact('project', 'tables'));
        }

        return response()->json([
            'data' => $project
        ]);
    }

    /**
     * Update project
     */
    public function update(Request $request, $id)
    {
        $project = Project::where('id', $id)
            ->orWhere('database_name', $id)
            ->first();

        if (!$project) {
            return response()->json(['message' => 'Project not found'], 404);
        }

        $validated = $request->validate([
            'name' => 'sometimes|required|string|max:255',
            'database_name' => 'sometimes|required|string|alpha_dash|unique:projects,database_name,' . $project->id,
            'description' => 'nullable|string',
        ]);

        $project->update($validated);

        return response()->json([
            'message' => 'Project updated successfully',
            'data' => $project
        ]);
    }

    /**
     * Delete project (handles both Web button and API DELETE)
     */
    public function destroy($id)
    {
        $project = Project::where('id', $id)
            ->orWhere('database_name', $id)
            ->first();

        if (!$project) {
            if (!request()->wantsJson() && !request()->is('api/*')) {
                return redirect()->route('dashboard')->withErrors(['error' => 'Project not found.']);
            }
            return response()->json(['message' => 'Project not found'], 404);
        }

        $name = $project->name;
        $project->delete();

        if (!request()->wantsJson() && !request()->is('api/*')) {
            return redirect()->route('dashboard')
                ->with('success', "Project '{$name}' deleted successfully!");
        }

        return response()->json([
            'message' => 'Project deleted successfully'
        ]);
    }

    /**
     * Web & API: Store a new table with fields under a project
     */
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

    /**
     * Web: Show a specific table and its generated routes
     */
    public function showTable($projectIdentifier, $tableIdentifier)
    {
        $project = Project::where('database_name', $projectIdentifier)
            ->orWhere('id', $projectIdentifier)
            ->firstOrFail();

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

    /**
     * Web: Delete a table
     */
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
