@extends('layouts.app')

@section('title', 'My Projects')

@section('header-actions')
    <button onclick="toggleNewProjectForm()"
            class="inline-flex items-center gap-2 bg-emerald-500 hover:bg-emerald-400 active:bg-emerald-600 text-white text-xs font-semibold px-4 py-2.5 rounded-xl shadow-lg shadow-emerald-500/25 transition-all cursor-pointer">
        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
        </svg>
        <span>+ New Project</span>
    </button>
@endsection

@section('content')

    {{-- Breadcrumb Navigation --}}
    <nav class="flex items-center gap-2 text-xs text-slate-500 mb-6 flex-wrap">
        <a href="{{ route('dashboard') }}" class="hover:text-emerald-500 dark:hover:text-emerald-400 font-medium transition-colors">Dashboard</a>
        <svg class="w-3.5 h-3.5 text-slate-400 dark:text-slate-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
        </svg>
        <span class="text-slate-900 dark:text-white font-semibold">My Projects</span>
    </nav>

    {{-- Header Banner --}}
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6">
        <div>
            <h1 class="text-2xl sm:text-3xl font-extrabold text-slate-900 dark:text-white tracking-tight flex items-center gap-3">
                <span>My Projects & Workspaces</span>
                <span class="text-xs font-semibold text-emerald-700 dark:text-emerald-400 bg-emerald-50 dark:bg-emerald-950/60 border border-emerald-200 dark:border-emerald-800/50 px-2.5 py-0.5 rounded-full">
                    {{ $projects->count() }} active
                </span>
            </h1>
            <p class="text-xs sm:text-sm text-slate-500 dark:text-slate-400 mt-1">
                Manage your mock database containers, inspect generated REST endpoints, or launch the API tester.
            </p>
        </div>

        <button onclick="toggleNewProjectForm()"
                class="sm:hidden inline-flex items-center gap-2 bg-emerald-500 hover:bg-emerald-400 text-white text-xs font-semibold px-4 py-2.5 rounded-xl self-start">
            + New Project
        </button>
    </div>

    {{-- Projects Grid / Empty State --}}
    @if($projects->isEmpty())
        <div class="flex flex-col items-center justify-center py-20 px-4 text-center bg-white dark:bg-[#0D1320] border border-dashed border-slate-300 dark:border-white/10 rounded-3xl max-w-xl mx-auto my-8 shadow-sm">
            <div class="w-16 h-16 bg-emerald-50 dark:bg-emerald-950/60 border border-emerald-200 dark:border-emerald-800/50 rounded-2xl flex items-center justify-center mb-5 text-emerald-600 dark:text-emerald-400 shadow-lg">
                <svg class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.75">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                </svg>
            </div>
            <h2 class="text-xl font-bold text-slate-900 dark:text-white mb-2 tracking-tight">No projects created yet</h2>
            <p class="text-slate-500 dark:text-slate-400 text-xs mb-6 leading-relaxed max-w-sm">
                Create your first project container to start setting up tables, defining fields, and generating instant REST endpoints for your frontend.
            </p>
            <button onclick="toggleNewProjectForm()"
                    class="inline-flex items-center gap-2 bg-emerald-500 hover:bg-emerald-400 text-white text-xs font-semibold px-5 py-2.5 rounded-xl shadow-lg shadow-emerald-500/25 transition-all cursor-pointer">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                </svg>
                <span>Create First Project</span>
            </button>
        </div>
    @else
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5">
            @foreach($projects as $project)
            <div class="bg-white dark:bg-[#0D1320] border border-slate-200 dark:border-white/[0.08] hover:border-emerald-500/50 dark:hover:border-emerald-500/40 rounded-2xl p-5 shadow-sm hover:shadow-xl dark:shadow-xs transition-all flex flex-col justify-between group">
                <div>
                    <div class="flex items-start justify-between mb-3">
                        <div class="w-10 h-10 bg-emerald-50 dark:bg-emerald-950/60 border border-emerald-200 dark:border-emerald-800/40 rounded-xl flex items-center justify-center text-emerald-600 dark:text-emerald-400 shadow-2xs">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.75">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                      d="M4 7v10c0 2 1.5 3 3.5 3h9c2 0 3.5-1 3.5-3V7c0-2-1.5-3-3.5-3h-9C5.5 4 4 5 4 7zm0 4h16m-8 4v4" />
                            </svg>
                        </div>
                        <span class="inline-flex items-center text-[11px] font-semibold text-slate-600 dark:text-slate-300 bg-slate-100 dark:bg-white/[0.04] border border-slate-200 dark:border-white/[0.08] px-2.5 py-1 rounded-lg">
                            {{ $project->tables_count }} {{ Str::plural('table', $project->tables_count) }}
                        </span>
                    </div>

                    <h3 class="font-bold text-slate-900 dark:text-white text-base mb-1 group-hover:text-emerald-600 dark:group-hover:text-emerald-300 transition-colors">
                        {{ $project->name }}
                    </h3>

                    <div class="flex items-center gap-1.5 mb-3">
                        <span class="text-xs font-mono text-emerald-700 dark:text-emerald-400 bg-slate-50 dark:bg-[#080C14] px-2 py-0.5 rounded border border-slate-200 dark:border-white/[0.08]">
                            /api/{{ $project->database_name }}
                        </span>
                    </div>

                    @if($project->description)
                        <p class="text-xs text-slate-600 dark:text-slate-400 line-clamp-2 mb-4 leading-relaxed">
                            {{ $project->description }}
                        </p>
                    @else
                        <p class="text-xs text-slate-400 dark:text-slate-500 italic mb-4">No description provided</p>
                    @endif
                </div>

                <div class="pt-4 border-t border-slate-100 dark:border-white/[0.06] flex items-center justify-between">
                    <div class="flex items-center gap-2.5">
                        <a href="{{ route('projects.show', $project->database_name) }}"
                           class="inline-flex items-center gap-1 text-xs font-semibold text-emerald-600 dark:text-emerald-400 hover:text-emerald-700 dark:hover:text-emerald-300 transition-colors">
                            <span>Open Project</span>
                            <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                            </svg>
                        </a>

                        <a href="{{ route('projects.tester', $project->database_name) }}"
                           class="inline-flex items-center gap-1 text-[11px] font-semibold text-slate-700 dark:text-slate-300 hover:text-slate-900 dark:hover:text-white bg-slate-100 hover:bg-slate-200 dark:bg-[#131B26] dark:hover:bg-[#1A2434] border border-slate-200 dark:border-white/10 px-2.5 py-1 rounded-lg transition-all"
                           title="Test this project's APIs in Postman console">
                            <svg class="w-3 h-3 text-emerald-500 dark:text-emerald-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M13 10V3L4 14h7v7l9-11h-7z" />
                            </svg>
                            <span>Tester</span>
                        </a>
                    </div>

                    <form action="{{ route('projects.destroy', $project->database_name) }}" method="POST"
                          onsubmit="return confirm('Delete project \'{{ $project->name }}\' and all its tables?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-slate-400 hover:text-rose-500 dark:text-slate-500 dark:hover:text-rose-400 p-1.5 rounded-lg hover:bg-rose-50 dark:hover:bg-rose-950/40 transition-colors cursor-pointer" title="Delete Project">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.75">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                            </svg>
                        </button>
                    </form>
                </div>
            </div>
            @endforeach
        </div>
    @endif

    {{-- New Project Modal --}}
    <div id="newProjectBackdrop"
         class="hidden fixed inset-0 bg-slate-900/60 dark:bg-black/80 backdrop-blur-md z-50 flex items-center justify-center p-4 transition-all"
         onclick="closeNewProjectForm(event)">
        <div class="bg-white dark:bg-[#0D1320] rounded-3xl shadow-2xl w-full max-w-lg overflow-hidden border border-slate-200 dark:border-white/10 text-slate-800 dark:text-slate-100 animate-in fade-in zoom-in-95 duration-150" onclick="event.stopPropagation()">
            <div class="flex items-center justify-between px-6 py-5 border-b border-slate-200 dark:border-white/[0.08] bg-slate-50 dark:bg-[#101726]">
                <div>
                    <h2 class="text-base font-bold text-slate-900 dark:text-white">Create New Project Container</h2>
                    <p class="text-xs text-slate-500 dark:text-slate-400 mt-0.5">Organize mock tables, routes, and auto-generated API tokens</p>
                </div>
                <button onclick="closeNewProjectForm()" class="text-slate-400 hover:text-slate-700 dark:hover:text-white p-1.5 rounded-lg hover:bg-slate-100 dark:hover:bg-white/[0.06] transition-colors cursor-pointer">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <form action="{{ route('projects.store') }}" method="POST" class="p-6 space-y-5">
                @csrf
                <div>
                    <label for="projectName" class="block text-xs font-semibold text-slate-700 dark:text-slate-300 uppercase tracking-wider mb-1.5">
                        Project Name <span class="text-rose-500 dark:text-rose-400">*</span>
                    </label>
                    <input
                        type="text"
                        id="projectName"
                        name="name"
                        value="{{ old('name') }}"
                        placeholder="e.g. User Registration App"
                        class="w-full bg-slate-50 dark:bg-[#080C14] border border-slate-300 dark:border-white/10 rounded-xl px-3.5 py-2.5 text-xs text-slate-900 dark:text-white placeholder-slate-400 dark:placeholder-slate-500 focus:outline-none focus:ring-2 focus:ring-emerald-500/30 focus:border-emerald-500 transition"
                        required
                        autofocus
                        oninput="autoGenerateDatabaseName(this.value)"
                    >
                </div>

                <div>
                    <label for="databaseName" class="block text-xs font-semibold text-slate-700 dark:text-slate-300 uppercase tracking-wider mb-1.5">
                        Database / URL Slug <span class="text-rose-500 dark:text-rose-400">*</span>
                    </label>
                    <div class="flex items-stretch rounded-xl border border-slate-300 dark:border-white/10 bg-slate-50 dark:bg-[#080C14] overflow-hidden focus-within:ring-2 focus-within:ring-emerald-500/30 focus-within:border-emerald-500 transition">
                        <span class="inline-flex items-center px-3.5 bg-slate-100 dark:bg-[#101726] text-slate-600 dark:text-slate-400 font-mono text-xs border-r border-slate-300 dark:border-white/[0.08] select-none">
                            /api/
                        </span>
                        <input
                            type="text"
                            id="databaseName"
                            name="database_name"
                            value="{{ old('database_name') }}"
                            placeholder="user_registration_app"
                            class="flex-1 min-w-0 px-3.5 py-2.5 text-xs font-mono text-emerald-700 dark:text-emerald-300 placeholder-slate-400 dark:placeholder-slate-500 focus:outline-none bg-transparent"
                            required
                        >
                    </div>
                    <p class="mt-1.5 text-[11px] text-slate-500 dark:text-slate-500">Unique identifier for your API routes (e.g. <code>/api/user_registration_app/...</code>)</p>
                </div>

                <div>
                    <label for="projectDescription" class="block text-xs font-semibold text-slate-700 dark:text-slate-300 uppercase tracking-wider mb-1.5">
                        Description <span class="text-slate-400 dark:text-slate-500 font-normal lowercase">(optional)</span>
                    </label>
                    <textarea
                        id="projectDescription"
                        name="description"
                        rows="3"
                        placeholder="e.g. Endpoints to test frontend user registration, login, and profiles"
                        class="w-full bg-slate-50 dark:bg-[#080C14] border border-slate-300 dark:border-white/10 rounded-xl px-3.5 py-2 text-xs text-slate-900 dark:text-white placeholder-slate-400 dark:placeholder-slate-500 focus:outline-none focus:ring-2 focus:ring-emerald-500/30 focus:border-emerald-500 transition resize-none"
                    >{{ old('description') }}</textarea>
                </div>

                <div class="flex items-center justify-end gap-3 pt-3 border-t border-slate-200 dark:border-white/[0.08]">
                    <button type="button" onclick="closeNewProjectForm()"
                            class="text-xs font-medium text-slate-600 dark:text-slate-400 hover:text-slate-900 dark:hover:text-white px-4 py-2.5 rounded-xl hover:bg-slate-100 dark:hover:bg-white/[0.06] transition-colors cursor-pointer">
                        Cancel
                    </button>
                    <button type="submit"
                            class="text-xs font-semibold bg-emerald-500 hover:bg-emerald-400 active:bg-emerald-600 text-white px-5 py-2.5 rounded-xl shadow-lg shadow-emerald-500/25 transition-all cursor-pointer">
                        Create Project
                    </button>
                </div>
            </form>
        </div>
    </div>

@endsection

@push('scripts')
<script>
    let userEditedDatabaseName = false;

    function autoGenerateDatabaseName(val) {
        if (!userEditedDatabaseName) {
            const slug = val.toLowerCase()
                .trim()
                .replace(/[^a-z0-9]+/g, '_')
                .replace(/^_+|_+$/g, '');
            const input = document.getElementById('databaseName');
            if (input) input.value = slug;
        }
    }

    const dbNameInput = document.getElementById('databaseName');
    if (dbNameInput) {
        dbNameInput.addEventListener('input', function() {
            userEditedDatabaseName = true;
        });
    }

    function toggleNewProjectForm() {
        const backdrop = document.getElementById('newProjectBackdrop');
        if (!backdrop) return;
        backdrop.classList.remove('hidden');
        userEditedDatabaseName = false;
        setTimeout(() => {
            const pName = document.getElementById('projectName');
            if (pName) pName.focus();
        }, 50);
    }

    function closeNewProjectForm(event) {
        const backdrop = document.getElementById('newProjectBackdrop');
        if (backdrop) backdrop.classList.add('hidden');
    }

    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') closeNewProjectForm();
    });
</script>
@endpush

