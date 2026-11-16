@extends('layouts.app')

@section('title', $table->name . ' — API Routes')

@section('header-actions')
    <a href="{{ route('projects.show', $project->database_name) }}"
       class="inline-flex items-center gap-2 bg-slate-100 hover:bg-slate-200 text-slate-700 hover:text-slate-900 border border-slate-200 dark:bg-[#181C28] dark:hover:bg-[#222738] dark:border-white/[0.08] dark:hover:border-violet-500/40 dark:text-slate-300 dark:hover:text-white text-xs font-semibold px-3.5 py-2.5 rounded-xl transition-all shadow-2xs">
        <svg class="w-4 h-4 text-slate-500 dark:text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
        </svg>
        Back to Tables
    </a>
@endsection

@section('content')

    {{-- Breadcrumb --}}
    <nav class="flex items-center gap-2 text-xs text-slate-500 mb-6 flex-wrap">
        <a href="{{ route('dashboard') }}" class="hover:text-violet-600 dark:hover:text-violet-400 font-medium transition-colors">Dashboard</a>
        <svg class="w-3.5 h-3.5 text-slate-400 dark:text-slate-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
        </svg>
        <a href="{{ route('projects.show', $project->database_name) }}" class="hover:text-violet-600 dark:hover:text-violet-400 font-medium transition-colors">{{ $project->name }}</a>
        <svg class="w-3.5 h-3.5 text-slate-400 dark:text-slate-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
        </svg>
        <span class="text-slate-900 dark:text-white font-semibold">{{ $table->name }}</span>
    </nav>

    {{-- Top Info Banner --}}
    <div class="bg-white dark:bg-[#141721] border border-slate-200 dark:border-white/[0.08] rounded-2xl p-6 mb-6 shadow-xs">
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <div class="flex items-center gap-2.5 flex-wrap">
                    <h2 class="text-2xl font-bold text-slate-900 dark:text-white tracking-tight">{{ $table->name }}</h2>
                    <span id="topReadyBadge" class="text-xs font-semibold text-emerald-700 dark:text-emerald-400 bg-emerald-50 dark:bg-emerald-950/50 border border-emerald-200 dark:border-emerald-800/40 px-2.5 py-1 rounded-lg">
                        3 Endpoints Ready
                    </span>
                    <span class="text-xs font-medium text-slate-600 dark:text-slate-400 bg-slate-100 dark:bg-white/[0.04] border border-slate-200 dark:border-white/[0.08] px-2.5 py-1 rounded-lg">
                        {{ $table->fields->count() }} {{ Str::plural('field', $table->fields->count()) }}
                    </span>
                </div>
                <p class="text-xs text-slate-500 dark:text-slate-400 mt-2 leading-relaxed">
                    Use these URLs directly in your frontend code (React, Vue, HTML forms, or Postman) to test your UI without a real backend.
                </p>
            </div>

            <div class="flex items-center gap-2.5 shrink-0 flex-wrap">
                {{-- API Tester Button --}}
                <a href="{{ route('projects.tester', $project->database_name) }}"
                   class="inline-flex items-center gap-1.5 text-xs font-semibold text-slate-700 hover:text-slate-900 bg-slate-100 hover:bg-slate-200 border-slate-200 dark:text-violet-300 dark:hover:text-white dark:bg-[#181C28] dark:hover:bg-[#222738] border dark:border-white/[0.08] dark:hover:border-violet-500/40 px-3.5 py-2.5 rounded-xl transition-all shadow-2xs">
                    <svg class="w-4 h-4 text-violet-600 dark:text-violet-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M13 10V3L4 14h7v7l9-11h-7z" />
                    </svg>
                    <span>API Tester</span>
                </a>

                {{-- Seed Dummy Data Button --}}
                <button type="button"
                        id="seedBtn"
                        onclick="generateDummyData()"
                        class="inline-flex items-center gap-2 text-xs font-semibold text-violet-700 dark:text-violet-200 hover:text-violet-900 dark:hover:text-white bg-violet-50 dark:bg-violet-950/60 hover:bg-violet-100 dark:hover:bg-violet-900/70 border border-violet-200 dark:border-violet-800/60 px-4 py-2.5 rounded-xl transition-all shadow-2xs cursor-pointer">
                    <svg class="w-4 h-4 text-violet-600 dark:text-violet-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z" />
                    </svg>
                    <span>Generate Dummy Data</span>
                </button>

                {{-- Delete Table Form --}}
                <form action="{{ route('projects.tables.destroy', ['project' => $project->database_name, 'table' => $table->id]) }}" method="POST"
                      onsubmit="return confirm('Delete table \'{{ $table->name }}\' and all its endpoints?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="inline-flex items-center gap-1.5 text-xs font-semibold text-rose-600 dark:text-rose-300 hover:text-white hover:bg-rose-600 border border-rose-200 dark:border-rose-800/40 dark:hover:border-rose-700/60 bg-rose-50 dark:bg-rose-950/40 dark:hover:bg-rose-900/50 px-3.5 py-2.5 rounded-xl transition-all cursor-pointer">
                        <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                        </svg>
                        <span>Delete Table</span>
                    </button>
                </form>
            </div>
        </div>
    </div>

    {{-- API Key Card --}}
    <div class="bg-white dark:bg-[#141721] border border-slate-200 dark:border-white/[0.08] rounded-2xl p-5 mb-8 shadow-xs">
        <div class="flex items-center justify-between gap-3 mb-3">
            <div class="flex items-center gap-3">
                <div class="w-9 h-9 bg-emerald-50 dark:bg-emerald-950/60 border border-emerald-200 dark:border-emerald-800/50 rounded-xl flex items-center justify-center text-emerald-600 dark:text-emerald-400 shrink-0">
                    <svg class="w-4.5 h-4.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-11.9 1M8 14l-4 4m0 0l-1-1m1 1l1 1m3-3l-2-2m7-9a6 6 0 00-6 6v1"/>
                    </svg>
                </div>
                <div>
                    <div class="flex items-center gap-2">
                        <h3 class="font-bold text-slate-900 dark:text-white text-sm">Project API Secret Key</h3>
                        <span class="text-[10px] font-bold uppercase tracking-wider text-emerald-700 dark:text-emerald-400 bg-emerald-50 dark:bg-emerald-950/60 border border-emerald-200 dark:border-emerald-800/50 px-2 py-0.5 rounded">Saved in Database</span>
                    </div>
                    <p class="text-xs text-slate-500 dark:text-slate-400 mt-0.5">Send this in the <code class="font-mono text-emerald-700 dark:text-emerald-400 bg-emerald-50 dark:bg-emerald-950/60 px-1.5 py-0.5 rounded border border-emerald-200 dark:border-emerald-800/40 font-semibold">X-API-KEY</code> header for all API requests.</p>
                </div>
            </div>
        </div>

        <div class="bg-slate-50 dark:bg-[#0B0D13] border border-slate-200 dark:border-white/[0.08] rounded-xl p-2.5">
            <div class="flex flex-col sm:flex-row items-center gap-2">
                <input
                    type="password"
                    id="apiSecretKey"
                    value="{{ $project->api_key }}"
                    readonly
                    class="w-full flex-1 min-w-0 bg-white dark:bg-[#0E1117] border border-slate-300 dark:border-white/[0.1] rounded-lg px-3.5 py-2 text-xs font-mono text-slate-800 dark:text-slate-200 select-all focus:outline-none focus:border-violet-500"
                >

                <div class="flex items-center gap-2 w-full sm:w-auto shrink-0">
                    <button
                        type="button"
                        onclick="toggleSecretKey()"
                        id="toggleKeyBtn"
                        class="flex-1 sm:flex-none px-3.5 py-2 bg-white hover:bg-slate-100 text-slate-700 border border-slate-300 dark:bg-[#1A1E2B] dark:hover:bg-[#252A3C] dark:border-white/[0.08] dark:hover:border-violet-500/40 rounded-lg text-xs font-semibold dark:text-slate-300 dark:hover:text-white transition-colors cursor-pointer text-center">
                        Show / Hide
                    </button>

                    <button
                        type="button"
                        onclick="copyApiSecretKey()"
                        id="copyKeyBtn"
                        class="flex-1 sm:flex-none px-4 py-2 bg-emerald-600 hover:bg-emerald-500 active:bg-emerald-700 text-white rounded-lg text-xs font-semibold transition-colors flex items-center justify-center gap-1.5 cursor-pointer shadow-xs shadow-emerald-950/50">
                        <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z" />
                        </svg>
                        <span>Copy Key</span>
                    </button>
                </div>
            </div>
        </div>
    </div>

    @php
        $baseUrl = url('/api/' . $project->database_name . '/' . $table->slug);

        // Core REST endpoints for this table
        $endpoints = [
            [
                'method'      => 'GET',
                'badge'       => 'bg-blue-50 text-blue-700 border-blue-200 dark:bg-sky-950/60 dark:text-sky-400 dark:border-sky-800/50',
                'url'         => $baseUrl,
                'action_name' => 'Get All Records',
                'description' => "Returns an array of all {$table->name} records.",
            ],
            [
                'method'      => 'PUT',
                'badge'       => 'bg-amber-50 text-amber-700 border-amber-200 dark:bg-amber-950/60 dark:text-amber-400 dark:border-amber-800/50',
                'url'         => $baseUrl . '/{id}',
                'action_name' => 'Edit Record',
                'description' => "Updates an existing {$table->name} record by ID.",
            ],
            [
                'method'      => 'DELETE',
                'badge'       => 'bg-rose-50 text-rose-700 border-rose-200 dark:bg-rose-950/60 dark:text-rose-400 dark:border-rose-800/50',
                'url'         => $baseUrl . '/{id}',
                'action_name' => 'Delete Record',
                'description' => "Deletes a {$table->name} record by ID.",
            ],
        ];

        // Generate sample mock values
        $samplePayload = [];
        foreach ($table->fields as $field) {
            switch ($field->type) {
                case 'email':
                    $samplePayload[$field->name] = 'user@example.com';
                    break;
                case 'number':
                    $samplePayload[$field->name] = 25;
                    break;
                case 'boolean':
                    $samplePayload[$field->name] = true;
                    break;
                case 'date':
                    $samplePayload[$field->name] = '2026-11-03';
                    break;
                case 'text':
                    $samplePayload[$field->name] = 'Sample paragraph content for ' . $field->name;
                    break;
                default:
                    $samplePayload[$field->name] = 'Sample ' . $field->name;
            }
        }
        $jsonPreview = json_encode($samplePayload, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
    @endphp

    {{-- Main 2-Column Grid Layout --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 items-start">

        {{-- Left 2 Columns: Endpoints & Quick Snippet --}}
        <div class="lg:col-span-2 space-y-6">

            {{-- Routes Header with Show / Hide Toggle Button --}}
            <div class="flex items-center justify-between flex-wrap gap-3">
                <div class="flex items-center gap-2.5">
                    <h3 class="text-base font-bold text-slate-900 dark:text-white tracking-tight">Generated REST Routes</h3>
                    <span class="text-xs font-semibold px-2.5 py-0.5 rounded-full bg-slate-100 dark:bg-white/[0.04] text-slate-700 dark:text-slate-300 border border-slate-200 dark:border-white/[0.08]">
                        3 Routes
                    </span>
                </div>

                {{-- Show / Hide Button --}}
                <button type="button"
                        id="toggleRoutesBtn"
                        onclick="toggleRoutesVisibility()"
                        class="inline-flex items-center gap-1.5 text-xs font-semibold text-violet-700 hover:text-violet-900 bg-violet-50 hover:bg-violet-100 border border-violet-200 dark:text-violet-300 dark:hover:text-white dark:bg-[#1A1E2B] dark:hover:bg-[#252A3C] dark:border-white/[0.08] dark:hover:border-violet-500/40 px-3 py-1.5 rounded-xl transition-all shadow-2xs cursor-pointer">
                    <svg id="toggleRoutesIcon" class="w-3.5 h-3.5 text-violet-600 dark:text-violet-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l18 18" />
                    </svg>
                    <span id="toggleRoutesText">Hide Routes</span>
                </button>
            </div>

            {{-- Endpoints Cards List (Toggleable) --}}
            <div id="routesListContainer" class="space-y-4">
                @foreach($endpoints as $endpoint)
                <div class="bg-white dark:bg-[#141721] border border-slate-200 dark:border-white/[0.08] hover:border-violet-300 dark:hover:border-violet-500/30 rounded-2xl p-4.5 shadow-xs hover:shadow-md dark:hover:shadow-black/50 transition-all">
                    <div class="flex items-start justify-between gap-3 mb-2.5">
                        <div class="flex items-center gap-2.5 flex-wrap">
                            <span class="text-xs font-bold font-mono px-2.5 py-1 rounded-lg border {{ $endpoint['badge'] }}">
                                {{ $endpoint['method'] }}
                            </span>
                            <span class="text-sm font-semibold text-slate-900 dark:text-white">{{ $endpoint['action_name'] }}</span>
                        </div>

                        <button
                            type="button"
                            onclick="copyEndpoint(this, '{{ $endpoint['url'] }}')"
                            class="text-xs font-semibold text-slate-700 hover:text-violet-700 bg-slate-50 hover:bg-slate-100 border border-slate-200 dark:text-slate-300 dark:hover:text-violet-300 dark:border-white/[0.08] dark:hover:border-violet-500/40 dark:bg-[#0B0D13] dark:hover:bg-[#1A1E2B] px-3 py-1.5 rounded-lg transition-all flex items-center gap-1.5 shrink-0 cursor-pointer">
                            <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z" />
                            </svg>
                            <span>Copy URL</span>
                        </button>
                    </div>

                    {{-- URL Display --}}
                    <div class="bg-slate-900 dark:bg-[#0B0D13] border border-slate-800 dark:border-white/[0.08] rounded-xl px-3.5 py-2.5 mb-2 overflow-x-auto">
                        <code class="text-xs font-mono text-violet-300 select-all">{{ $endpoint['url'] }}</code>
                    </div>

                    <p class="text-xs text-slate-500 dark:text-slate-400 leading-relaxed">{{ $endpoint['description'] }}</p>
                </div>
                @endforeach
            </div>

            {{-- Placeholder when hidden --}}
            <div id="routesHiddenPlaceholder" style="display: none;" class="p-6 bg-slate-50 dark:bg-[#141721] border border-dashed border-slate-300 dark:border-white/[0.1] rounded-2xl text-center">
                <svg class="w-7 h-7 text-slate-400 dark:text-slate-500 mx-auto mb-1.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l18 18" />
                </svg>
                <p class="text-xs font-medium text-slate-700 dark:text-slate-300">Routes are currently hidden</p>
                <p class="text-[11px] text-slate-500 mt-0.5">Click "Show Routes" above to display them.</p>
            </div>

            {{-- Frontend Integration Code Preview --}}
            <div class="bg-white dark:bg-[#141721] border border-slate-200 dark:border-white/[0.08] rounded-2xl p-5 shadow-xs">
                <div class="flex items-center justify-between mb-3 flex-wrap gap-2">
                    <h4 class="text-sm font-bold text-slate-900 dark:text-white flex items-center gap-2">
                        <svg class="w-4 h-4 text-violet-600 dark:text-violet-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4" />
                        </svg>
                        <span>Test from Frontend (Quick Snippet)</span>
                    </h4>
                    <button onclick="copySnippet()"
                            class="text-xs font-semibold text-violet-700 hover:text-violet-900 bg-violet-50 hover:bg-violet-100 border border-violet-200 dark:text-violet-300 dark:hover:text-white dark:bg-[#1A1E2B] dark:hover:bg-[#252A3C] px-3 py-1.5 rounded-lg dark:border-white/[0.08] dark:hover:border-violet-500/40 transition-colors cursor-pointer">
                        Copy Code
                    </button>
                </div>

                <pre id="codeSnippet" class="bg-slate-950 dark:bg-[#0B0D13] border border-slate-800 dark:border-white/[0.08] text-violet-300 dark:text-violet-200 text-xs font-mono rounded-xl p-4 overflow-x-auto leading-relaxed">
// 1. Fetch all records (GET)
fetch('{{ $baseUrl }}', {
  headers: {
    'Accept': 'application/json',
    'X-API-KEY': '{{ $project->api_key }}'
  }
})
  .then(res => res.json())
  .then(data => console.log('All records:', data.data));

// 2. Edit a record by ID (PUT)
fetch('{{ $baseUrl }}/1', {
  method: 'PUT',
  headers: {
    'Content-Type': 'application/json',
    'Accept': 'application/json',
    'X-API-KEY': '{{ $project->api_key }}'
  },
  body: JSON.stringify({!! $jsonPreview !!})
})
  .then(res => res.json())
  .then(data => console.log('Updated:', data));</pre>
            </div>

        </div>

        {{-- Right 1 Column: Table Schema & JSON Body --}}
        <div class="lg:col-span-1 space-y-6">

            {{-- Table Schema --}}
            <div class="bg-white dark:bg-[#141721] border border-slate-200 dark:border-white/[0.08] rounded-2xl p-5 shadow-xs">
                <h4 class="text-sm font-bold text-slate-900 dark:text-white mb-4 flex items-center justify-between">
                    <span>Table Fields / Schema</span>
                    <span class="text-xs font-normal text-slate-500">Total: {{ $table->fields->count() + 3 }}</span>
                </h4>

                <div class="space-y-2">
                    {{-- id --}}
                    <div class="flex items-center justify-between p-2.5 bg-slate-50 dark:bg-[#0F1219] border border-slate-200 dark:border-white/[0.08] rounded-xl">
                        <div class="flex items-center gap-2">
                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 dark:bg-emerald-400"></span>
                            <span class="text-xs font-mono font-bold text-slate-800 dark:text-slate-200">id</span>
                        </div>
                        <div class="flex items-center gap-1.5">
                            <span class="text-[10px] font-mono text-slate-600 dark:text-slate-400 bg-white dark:bg-[#0B0D13] border border-slate-200 dark:border-white/[0.08] px-1.5 py-0.5 rounded">number</span>
                            <span class="text-[10px] text-emerald-700 dark:text-emerald-400 font-semibold bg-emerald-50 dark:bg-emerald-950/60 border border-emerald-200 dark:border-emerald-800/40 px-1.5 py-0.5 rounded">auto</span>
                        </div>
                    </div>

                    {{-- Dynamic Fields --}}
                    @forelse($table->fields as $field)
                    <div class="flex items-center justify-between p-2.5 bg-slate-50 dark:bg-[#0F1219] border border-slate-200 dark:border-white/[0.08] rounded-xl">
                        <div class="flex items-center gap-2">
                            <span class="w-1.5 h-1.5 rounded-full bg-violet-600 dark:bg-violet-400"></span>
                            <span class="text-xs font-mono font-bold text-slate-800 dark:text-slate-200">{{ $field->name }}</span>
                        </div>
                        <div class="flex items-center gap-1.5">
                            <span class="text-[10px] font-mono text-violet-700 dark:text-violet-300 bg-violet-50 dark:bg-violet-950/60 border border-violet-200 dark:border-violet-800/50 px-1.5 py-0.5 rounded font-medium">
                                {{ $field->type }}
                            </span>
                            @if($field->required)
                                <span class="text-[10px] text-rose-600 dark:text-rose-400 font-semibold bg-rose-50 dark:bg-rose-950/60 border border-rose-200 dark:border-rose-800/40 px-1.5 py-0.5 rounded">req</span>
                            @else
                                <span class="text-[10px] text-slate-500 dark:text-slate-400 bg-slate-100 dark:bg-white/[0.04] border border-slate-200 dark:border-white/[0.08] px-1.5 py-0.5 rounded">opt</span>
                            @endif
                        </div>
                    </div>
                    @empty
                    <p class="text-xs text-slate-500 italic py-2 text-center">No custom fields defined.</p>
                    @endforelse

                    {{-- Timestamps --}}
                    <div class="flex items-center justify-between p-2.5 bg-slate-50/50 dark:bg-[#0F1219]/60 border border-slate-100 dark:border-white/[0.04] rounded-xl opacity-60">
                        <span class="text-xs font-mono text-slate-500 dark:text-slate-400">created_at</span>
                        <span class="text-[10px] font-mono text-slate-500 bg-white dark:bg-[#0B0D13] border border-slate-200 dark:border-white/[0.06] px-1.5 py-0.5 rounded">timestamp</span>
                    </div>
                    <div class="flex items-center justify-between p-2.5 bg-slate-50/50 dark:bg-[#0F1219]/60 border border-slate-100 dark:border-white/[0.04] rounded-xl opacity-60">
                        <span class="text-xs font-mono text-slate-500 dark:text-slate-400">updated_at</span>
                        <span class="text-[10px] font-mono text-slate-500 bg-white dark:bg-[#0B0D13] border border-slate-200 dark:border-white/[0.06] px-1.5 py-0.5 rounded">timestamp</span>
                    </div>
                </div>
            </div>

            {{-- Example JSON Payload --}}
            <div class="bg-white dark:bg-[#141721] border border-slate-200 dark:border-white/[0.08] rounded-2xl p-5 shadow-xs">
                <div class="flex items-center justify-between mb-3">
                    <h4 class="text-sm font-bold text-slate-900 dark:text-white">Example JSON Body</h4>
                    <span class="text-[10px] font-semibold text-amber-700 dark:text-amber-400 bg-amber-50 dark:bg-amber-950/60 border border-amber-200 dark:border-amber-800/50 px-2 py-0.5 rounded">
                        PUT / POST
                    </span>
                </div>
                <p class="text-xs text-slate-500 dark:text-slate-400 mb-3 leading-relaxed">Sample payload matching your table's fields for updates:</p>
                <div class="relative">
                    <pre class="bg-slate-950 dark:bg-[#0B0D13] border border-slate-800 dark:border-white/[0.08] text-violet-300 dark:text-violet-200 text-xs font-mono rounded-xl p-4 overflow-x-auto leading-relaxed">{{ $jsonPreview }}</pre>
                    <button
                        type="button"
                        onclick="copyEndpoint(this, {{ json_encode($jsonPreview) }})"
                        class="absolute top-2.5 right-2.5 text-[11px] font-semibold text-slate-300 hover:text-white bg-slate-800 hover:bg-slate-700 dark:bg-[#1A1E2B] dark:hover:bg-[#252A3C] border border-slate-700 dark:border-white/[0.08] px-2.5 py-1 rounded-lg transition-colors cursor-pointer">
                        Copy
                    </button>
                </div>
            </div>

        </div>

    </div>

@endsection

@push('scripts')
<script>
    // Copy single endpoint URL
    function copyEndpoint(btn, text) {
        navigator.clipboard.writeText(text).then(() => {
            const originalHTML = btn.innerHTML;
            btn.innerHTML = '✓ Copied';
            btn.classList.add('text-emerald-500', 'border-emerald-500', 'bg-emerald-500/10');
            setTimeout(() => {
                btn.innerHTML = originalHTML;
                btn.classList.remove('text-emerald-500', 'border-emerald-500', 'bg-emerald-500/10');
            }, 1800);
        }).catch(() => {
            prompt('Copy this URL:', text);
        });
    }

    // Copy frontend test code snippet
    function copySnippet() {
        const text = document.getElementById('codeSnippet').innerText;
        navigator.clipboard.writeText(text).then(() => {
            alert('✓ Copied JavaScript fetch snippet to clipboard!');
        });
    }

    // Toggle API Secret Key visibility
    function toggleSecretKey() {
        const input = document.getElementById('apiSecretKey');
        if (!input) return;
        input.type = input.type === 'password' ? 'text' : 'password';
    }

    // Copy API Secret Key
    function copyApiSecretKey() {
        const input = document.getElementById('apiSecretKey');
        const btn = document.getElementById('copyKeyBtn');
        if (!input) return;

        navigator.clipboard.writeText(input.value).then(() => {
            const originalHTML = btn.innerHTML;
            btn.innerHTML = '✓ Copied!';
            btn.classList.add('bg-emerald-700');
            setTimeout(() => {
                btn.innerHTML = originalHTML;
                btn.classList.remove('bg-emerald-700');
            }, 1800);
        }).catch(() => {
            input.type = 'text';
            input.select();
            prompt('Copy your API Key:', input.value);
        });
    }

    // Toggle routes visibility (Show / Hide)
    function toggleRoutesVisibility() {
        const container = document.getElementById('routesListContainer');
        const placeholder = document.getElementById('routesHiddenPlaceholder');
        const text = document.getElementById('toggleRoutesText');
        const icon = document.getElementById('toggleRoutesIcon');

        if (!container) return;

        const isHidden = container.style.display === 'none';

        if (isHidden) {
            container.style.display = 'block';
            if (placeholder) placeholder.style.display = 'none';
            if (text) text.innerText = 'Hide Routes';
            if (icon) {
                icon.innerHTML = `<path stroke-linecap="round" stroke-linejoin="round" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l18 18" />`;
            }
        } else {
            container.style.display = 'none';
            if (placeholder) placeholder.style.display = 'block';
            if (text) text.innerText = 'Show Routes';
            if (icon) {
                icon.innerHTML = `<path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />`;
            }
        }
    }

    // Generate Dummy Data (Faker)
    function generateDummyData() {
        if (!confirm('Generate 5 dummy records with Faker for this table?')) return;

        const btn = document.getElementById('seedBtn');
        const originalContent = btn.innerHTML;
        btn.disabled = true;
        btn.innerHTML = `
            <svg class="animate-spin w-4 h-4 text-violet-600 dark:text-violet-400" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8H4z"></path>
            </svg>
            <span>Generating...</span>
        `;

        fetch('{{ url("/api/" . $project->database_name . "/" . $table->slug . "/seed") }}', {
            method: 'POST',
            headers: {
                'Accept': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        })
        .then(res => res.json())
        .then(data => {
            alert(data.message || '5 dummy records generated successfully!');
            btn.disabled = false;
            btn.innerHTML = originalContent;
            window.location.reload();
        })
        .catch(err => {
            alert('Failed to generate dummy records.');
            btn.disabled = false;
            btn.innerHTML = originalContent;
        });
    }
</script>
@endpush
