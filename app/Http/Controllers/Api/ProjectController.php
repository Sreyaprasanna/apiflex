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
     * Web: list all projects (dedicated Projects page)
     */
    public function indexWeb()
    {
        $projects = Project::withCount('tables')->latest()->get();

        return view('projects.index', compact('projects'));
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

    // Generate API secret key
    $secretKey = 'sk_live_' . Str::random(48);

    // Store project and key
    $project = Project::create([
        ...$validated,
        'api_key' => $secretKey,
        'api_key_hash' => hash('sha256', $secretKey),
    ]);

    // API request
    if ($request->wantsJson() || $request->is('api/*')) {
        return response()->json([
            'message' => 'Project created successfully',
            'project' => $project,
            'secret_key' => $secretKey,
        ], 201);
    }

    // Web dashboard request
    return redirect()
        ->route('projects.show', $project->database_name)
        ->with('success', "Project '{$project->name}' created successfully!")
        ->with('secret_key', $secretKey);
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
    // public function update(Request $request, $id)
    // {
    //     $project = Project::where('id', $id)
    //         ->orWhere('database_name', $id)
    //         ->first();

    //     if (!$project) {
    //         return response()->json(['message' => 'Project not found'], 404);
    //     }

    //     $validated = $request->validate([
    //         'name' => 'sometimes|required|string|max:255',
    //         'database_name' => 'sometimes|required|string|alpha_dash|unique:projects,database_name,' . $project->id,
    //         'description' => 'nullable|string',
    //     ]);

    //     $project->update($validated);

    //     return response()->json([
    //         'message' => 'Project updated successfully',
    //         'data' => $project
    //     ]);
    // }

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

    /**
     * Web: Show a specific table and its generated routes
     */

    /**
     * Web: Delete a table
     */

}
