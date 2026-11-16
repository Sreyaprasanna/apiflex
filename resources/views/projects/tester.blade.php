@extends('layouts.app')

@section('title', ($project->name ?? 'API') . ' — REST API Tester')

@section('header-actions')
    <div class="flex items-center gap-2.5 flex-wrap">
        @if(isset($project))
            <a href="{{ route('projects.show', $project->database_name) }}"
               class="inline-flex items-center gap-1.5 bg-[#181C28] hover:bg-[#222738] border border-white/[0.08] hover:border-violet-500/40 text-slate-300 hover:text-white text-xs font-semibold px-3.5 py-2.5 rounded-xl transition-all shadow-2xs">
                <svg class="w-3.5 h-3.5 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                <span>Back to Project</span>
            </a>
        @endif
        <span class="inline-flex items-center gap-1.5 text-xs font-medium text-emerald-400 bg-emerald-950/50 border border-emerald-800/40 px-3 py-1.5 rounded-xl">
            <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span>
            Postman Engine Online
        </span>
    </div>
@endsection

@section('content')

    {{-- Breadcrumb Navigation --}}
    <nav class="flex items-center gap-2 text-xs text-slate-500 mb-6 flex-wrap">
        <a href="{{ route('dashboard') }}" class="hover:text-violet-500 dark:hover:text-violet-400 font-medium transition-colors">Dashboard</a>
        @if(isset($project))
            <svg class="w-3.5 h-3.5 text-slate-400 dark:text-slate-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
            </svg>
            <a href="{{ route('projects.show', $project->database_name) }}" class="hover:text-violet-500 dark:hover:text-violet-400 font-medium transition-colors">
                {{ $project->name }}
            </a>
        @endif
        <svg class="w-3.5 h-3.5 text-slate-400 dark:text-slate-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
        </svg>
        <span class="text-slate-900 dark:text-white font-semibold">API Tester (Postman Console)</span>
    </nav>

    {{-- Top Info & API Key Bar --}}
    <div class="bg-white dark:bg-[#141721] border border-slate-200 dark:border-white/[0.08] rounded-2xl p-5 mb-6 shadow-sm dark:shadow-xs flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 bg-violet-50 dark:bg-violet-950/60 border border-violet-200 dark:border-violet-800/50 rounded-xl flex items-center justify-center text-violet-600 dark:text-violet-400 shrink-0">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M13 10V3L4 14h7v7l9-11h-7z" />
                </svg>
            </div>
            <div>
                <div class="flex items-center gap-2">
                    <h2 class="text-base font-bold text-slate-900 dark:text-white tracking-tight">Postman-Style REST Console</h2>
                    <span class="text-[10px] font-bold uppercase tracking-wider text-violet-700 dark:text-violet-300 bg-violet-50 dark:bg-violet-950/60 border border-violet-200 dark:border-violet-800/50 px-2 py-0.5 rounded">Backend Proxy Powered</span>
                </div>
                <p class="text-xs text-slate-500 dark:text-slate-400 mt-0.5">Send custom HTTP requests, test headers, payload validation, and inspect server responses in real time.</p>
            </div>
        </div>

        <div class="flex items-center gap-2.5 flex-wrap">
            @php
                $allTesterProjects = \App\Models\Project::latest()->get();
            @endphp
            @if($allTesterProjects->count() > 1)
            <div class="flex items-center gap-1.5 bg-slate-100 dark:bg-[#0B0D13] border border-slate-200 dark:border-white/[0.08] px-3 py-1 rounded-xl">
                <span class="text-[11px] font-semibold text-slate-500 dark:text-slate-400">Project:</span>
                <select onchange="window.location.href = '/projects/' + this.value + '/tester'"
                        class="bg-transparent text-xs font-semibold text-emerald-600 dark:text-emerald-400 focus:outline-none cursor-pointer">
                    @foreach($allTesterProjects as $p)
                        <option value="{{ $p->database_name }}" class="bg-white dark:bg-[#0D1320] text-slate-800 dark:text-white" {{ isset($project) && $project->id === $p->id ? 'selected' : '' }}>
                            {{ $p->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            @endif

            @if(isset($project))
            <div class="flex items-center gap-2 bg-slate-100 dark:bg-[#0B0D13] border border-slate-200 dark:border-white/[0.08] px-3 py-1.5 rounded-xl shrink-0">
                <span class="text-[11px] font-semibold text-slate-500 dark:text-slate-400">API Key:</span>
                <code class="text-xs font-mono text-emerald-700 dark:text-emerald-400 bg-white dark:bg-[#0E1117] px-2 py-0.5 rounded border border-slate-200 dark:border-white/[0.1] select-all" id="activeApiKeyDisplay">
                    {{ Str::limit($project->api_key, 24, '...') }}
                </code>
                <button type="button"
                        onclick="copyTesterApiKey('{{ $project->api_key }}', this)"
                        class="text-[11px] font-semibold text-violet-600 dark:text-violet-400 hover:text-violet-700 dark:hover:text-violet-300 px-2 py-0.5 rounded hover:bg-slate-200 dark:hover:bg-white/[0.04] transition-colors cursor-pointer">
                    Copy
                </button>
            </div>
            @endif
        </div>
    </div>

    {{-- 2-Column Workspace: Quick Endpoints Sidebar + Tester Panel --}}
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-start">

        {{-- Left 4 Cols: Quick Route & Table Selectors --}}
        <div class="lg:col-span-4 space-y-4">
            <div class="bg-white dark:bg-[#141721] border border-slate-200 dark:border-white/[0.08] rounded-2xl p-4.5 shadow-sm dark:shadow-xs">
                <div class="flex items-center justify-between mb-3">
                    <h3 class="text-xs font-bold text-slate-900 dark:text-white uppercase tracking-wider flex items-center gap-2">
                        <svg class="w-4 h-4 text-violet-500 dark:text-violet-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 10h16M4 14h16M4 18h16" />
                        </svg>
                        <span>Saved Endpoints</span>
                    </h3>
                    <span class="text-[10px] font-medium text-slate-400 dark:text-slate-500">Click to load</span>
                </div>

                @if(isset($project) && $project->tables->isNotEmpty())
                    <div class="space-y-3">
                        @foreach($project->tables as $t)
                        <div class="border border-slate-200 dark:border-white/[0.08] rounded-xl p-3 bg-slate-50/60 dark:bg-[#0F1219]">
                            <div class="flex items-center justify-between mb-2">
                                <span class="text-xs font-bold text-slate-800 dark:text-slate-200 flex items-center gap-1.5">
                                    <span class="w-1.5 h-1.5 rounded-full bg-violet-500 dark:bg-violet-400"></span>
                                    {{ $t->name }}
                                </span>
                                <span class="text-[10px] font-mono text-slate-400 dark:text-slate-500">/{{ $t->slug }}</span>
                            </div>

                            @php
                                $sampleData = [];
                                foreach($t->fields as $f) {
                                    $sampleData[$f->name] = match($f->type) {
                                        'email' => 'test@example.com',
                                        'number' => 42,
                                        'boolean' => true,
                                        'date' => '2026-11-10',
                                        'text' => 'Sample text description',
                                        default => 'Sample ' . $f->name,
                                    };
                                }
                                $sampleJson = json_encode($sampleData, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
                                $tBaseUrl = url('/api/' . $project->database_name . '/' . $t->slug);
                            @endphp

                            <div class="space-y-1.5">
                                {{-- GET All --}}
                                <button type="button"
                                        onclick="loadPreset('GET', '{{ $tBaseUrl }}', '')"
                                        class="w-full text-left flex items-center justify-between px-2.5 py-1.5 rounded-lg bg-white dark:bg-[#0B0D13] hover:bg-slate-100 dark:hover:bg-[#1A1E2B] border border-slate-200 dark:border-white/[0.08] hover:border-violet-400 dark:hover:border-violet-500/40 transition-all text-xs group cursor-pointer shadow-2xs">
                                    <div class="flex items-center gap-2">
                                        <span class="text-[10px] font-mono font-bold px-1.5 py-0.5 rounded bg-sky-50 dark:bg-sky-950/60 text-sky-700 dark:text-sky-400 border border-sky-200 dark:border-sky-800/50">GET</span>
                                        <span class="text-slate-700 dark:text-slate-300 group-hover:text-slate-900 dark:group-hover:text-white font-medium">All records</span>
                                    </div>
                                    <span class="text-slate-400 group-hover:text-violet-500 dark:text-slate-500 dark:group-hover:text-violet-400 text-[11px]">→</span>
                                </button>

                                {{-- POST Create --}}
                                <button type="button"
                                        onclick="loadPreset('POST', '{{ $tBaseUrl }}', {{ json_encode($sampleJson) }})"
                                        class="w-full text-left flex items-center justify-between px-2.5 py-1.5 rounded-lg bg-white dark:bg-[#0B0D13] hover:bg-slate-100 dark:hover:bg-[#1A1E2B] border border-slate-200 dark:border-white/[0.08] hover:border-violet-400 dark:hover:border-violet-500/40 transition-all text-xs group cursor-pointer shadow-2xs">
                                    <div class="flex items-center gap-2">
                                        <span class="text-[10px] font-mono font-bold px-1.5 py-0.5 rounded bg-emerald-50 dark:bg-emerald-950/60 text-emerald-700 dark:text-emerald-400 border border-emerald-200 dark:border-emerald-800/50">POST</span>
                                        <span class="text-slate-700 dark:text-slate-300 group-hover:text-slate-900 dark:group-hover:text-white font-medium">Create record</span>
                                    </div>
                                    <span class="text-slate-400 group-hover:text-emerald-500 dark:text-slate-500 dark:group-hover:text-emerald-400 text-[11px]">→</span>
                                </button>

                                {{-- PUT Update --}}
                                <button type="button"
                                        onclick="loadPreset('PUT', '{{ $tBaseUrl }}/1', {{ json_encode($sampleJson) }})"
                                        class="w-full text-left flex items-center justify-between px-2.5 py-1.5 rounded-lg bg-white dark:bg-[#0B0D13] hover:bg-slate-100 dark:hover:bg-[#1A1E2B] border border-slate-200 dark:border-white/[0.08] hover:border-violet-400 dark:hover:border-violet-500/40 transition-all text-xs group cursor-pointer shadow-2xs">
                                    <div class="flex items-center gap-2">
                                        <span class="text-[10px] font-mono font-bold px-1.5 py-0.5 rounded bg-amber-50 dark:bg-amber-950/60 text-amber-700 dark:text-amber-400 border border-amber-200 dark:border-amber-800/50">PUT</span>
                                        <span class="text-slate-700 dark:text-slate-300 group-hover:text-slate-900 dark:group-hover:text-white font-medium">Update record</span>
                                    </div>
                                    <span class="text-slate-400 group-hover:text-amber-500 dark:text-slate-500 dark:group-hover:text-amber-400 text-[11px]">→</span>
                                </button>

                                {{-- DELETE --}}
                                <button type="button"
                                        onclick="loadPreset('DELETE', '{{ $tBaseUrl }}/1', '')"
                                        class="w-full text-left flex items-center justify-between px-2.5 py-1.5 rounded-lg bg-white dark:bg-[#0B0D13] hover:bg-slate-100 dark:hover:bg-[#1A1E2B] border border-slate-200 dark:border-white/[0.08] hover:border-violet-400 dark:hover:border-violet-500/40 transition-all text-xs group cursor-pointer shadow-2xs">
                                    <div class="flex items-center gap-2">
                                        <span class="text-[10px] font-mono font-bold px-1.5 py-0.5 rounded bg-rose-50 dark:bg-rose-950/60 text-rose-700 dark:text-rose-400 border border-rose-200 dark:border-rose-800/50">DEL</span>
                                        <span class="text-slate-700 dark:text-slate-300 group-hover:text-slate-900 dark:group-hover:text-white font-medium">Delete record</span>
                                    </div>
                                    <span class="text-slate-400 group-hover:text-rose-500 dark:text-slate-500 dark:group-hover:text-rose-400 text-[11px]">→</span>
                                </button>
                            </div>
                        </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-6 text-slate-500 text-xs">
                        <p>No tables found in this project.</p>
                        <p class="mt-1 text-[11px]">You can still enter any URL in the URL bar.</p>
                    </div>
                @endif
            </div>

            {{-- Keyboard Shortcuts Card --}}
            <div class="bg-white dark:bg-[#141721] border border-slate-200 dark:border-white/[0.08] rounded-2xl p-4 shadow-sm dark:shadow-xs text-xs text-slate-500 dark:text-slate-400">
                <span class="font-bold text-slate-800 dark:text-slate-200 block mb-2">Tester Shortcuts:</span>
                <ul class="space-y-1.5 text-[11px]">
                    <li class="flex items-center justify-between">
                        <span>Send request</span>
                        <kbd class="px-1.5 py-0.5 rounded bg-slate-100 dark:bg-[#0B0D13] border border-slate-200 dark:border-white/[0.12] font-mono text-[10px] text-slate-700 dark:text-slate-300">Ctrl + Enter</kbd>
                    </li>
                    <li class="flex items-center justify-between">
                        <span>Format JSON Body</span>
                        <kbd class="px-1.5 py-0.5 rounded bg-slate-100 dark:bg-[#0B0D13] border border-slate-200 dark:border-white/[0.12] font-mono text-[10px] text-slate-700 dark:text-slate-300">Beautify JSON</kbd>
                    </li>
                    <li class="flex items-center justify-between">
                        <span>Authentication</span>
                        <span class="text-emerald-600 dark:text-emerald-400 font-medium">Auto X-API-KEY</span>
                    </li>
                </ul>
            </div>
        </div>

        {{-- Right 8 Cols: Main Postman Request & Response Console --}}
        <div class="lg:col-span-8 space-y-6">

            {{-- 1. Main Request Bar Card --}}
            <div class="bg-white dark:bg-[#141721] border border-slate-200 dark:border-white/[0.08] rounded-2xl p-5 shadow-sm dark:shadow-xs">
                <form id="testerForm" onsubmit="executeRequest(event)" class="space-y-4">
                    {{-- URL Bar & Method Dropdown --}}
                    <div>
                        <label class="block text-xs font-semibold text-slate-700 dark:text-slate-300 uppercase tracking-wider mb-1.5">
                            HTTP Method & Endpoint URL
                        </label>
                        <div class="flex flex-col sm:flex-row items-stretch rounded-xl border border-slate-300 dark:border-white/[0.12] overflow-hidden focus-within:ring-2 focus-within:ring-violet-500/30 focus-within:border-violet-500 transition bg-slate-50 dark:bg-[#0B0D13]">
                            {{-- Method Selector --}}
                            <select id="httpMethod"
                                    onchange="handleMethodChange(this.value)"
                                    class="bg-slate-100 dark:bg-[#141721] hover:bg-slate-200 dark:hover:bg-[#1A1E2B] px-4 py-2.5 text-xs font-bold font-mono tracking-wider text-slate-800 dark:text-slate-100 border-r border-slate-300 dark:border-white/[0.08] focus:outline-none cursor-pointer transition-colors shrink-0">
                                <option value="GET" selected>GET</option>
                                <option value="POST">POST</option>
                                <option value="PUT">PUT</option>
                                <option value="DELETE">DELETE</option>
                                <option value="PATCH">PATCH</option>
                            </select>

                            {{-- Endpoint URL Input --}}
                            <input
                                type="text"
                                id="requestUrl"
                                value="{{ isset($project) ? url('/api/' . $project->database_name . '/' . ($project->tables->first()->slug ?? '')) : url('/api/') }}"
                                placeholder="https://..."
                                class="flex-1 min-w-0 px-3.5 py-2.5 text-xs font-mono text-slate-900 dark:text-violet-200 focus:outline-none bg-transparent placeholder-slate-400 dark:placeholder-slate-600"
                                required
                            >

                            {{-- Send Request Button --}}
                            <button
                                type="submit"
                                id="sendBtn"
                                class="bg-violet-600 hover:bg-violet-500 active:bg-violet-700 text-white font-semibold text-xs px-6 py-2.5 transition-all flex items-center justify-center gap-2 shrink-0 cursor-pointer shadow-xs shadow-violet-900/40">
                                <svg id="sendBtnIcon" class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                                </svg>
                                <span id="sendBtnText">Send</span>
                            </button>
                        </div>
                    </div>

                    {{-- Request Config Tabs (Headers, Body, Params) --}}
                    <div>
                        <div class="flex items-center gap-1 border-b border-slate-200 dark:border-white/[0.08] mb-3">
                            <button type="button"
                                    id="tabBtnBody"
                                    onclick="switchReqTab('body')"
                                    class="px-4 py-2 text-xs font-semibold border-b-2 border-violet-500 text-violet-600 dark:text-violet-400 cursor-pointer transition-colors">
                                Body (JSON)
                            </button>
                            <button type="button"
                                    id="tabBtnHeaders"
                                    onclick="switchReqTab('headers')"
                                    class="px-4 py-2 text-xs font-semibold border-b-2 border-transparent text-slate-500 dark:text-slate-400 hover:text-slate-800 dark:hover:text-slate-200 cursor-pointer transition-colors">
                                Headers (<span id="headersCount">2</span>)
                            </button>
                            <button type="button"
                                    id="tabBtnParams"
                                    onclick="switchReqTab('params')"
                                    class="px-4 py-2 text-xs font-semibold border-b-2 border-transparent text-slate-500 dark:text-slate-400 hover:text-slate-800 dark:hover:text-slate-200 cursor-pointer transition-colors">
                                Params
                            </button>
                        </div>

                        {{-- Tab 1: Body (JSON) --}}
                        <div id="tabContentBody" class="space-y-2">
                            <div class="flex items-center justify-between">
                                <span class="text-[11px] text-slate-500 font-medium">Payload format: application/json</span>
                                <div class="flex items-center gap-2">
                                    <button type="button"
                                            onclick="prettifyRequestBody()"
                                            class="text-[11px] font-semibold text-slate-700 dark:text-slate-300 hover:text-slate-900 dark:hover:text-white bg-slate-100 hover:bg-slate-200 dark:bg-[#1A1E2B] dark:hover:bg-[#252A3C] border border-slate-200 dark:border-white/[0.08] px-2.5 py-1 rounded transition-colors cursor-pointer">
                                        Beautify JSON
                                    </button>
                                    <button type="button"
                                            onclick="clearRequestBody()"
                                            class="text-[11px] font-semibold text-slate-500 hover:text-rose-500 dark:hover:text-rose-400 px-2 py-1 transition-colors cursor-pointer">
                                        Clear
                                    </button>
                                </div>
                            </div>
                            <textarea
                                id="requestBody"
                                rows="6"
                                placeholder="{&#10;  &quot;key&quot;: &quot;value&quot;&#10;}"
                                class="w-full bg-slate-50 dark:bg-[#0B0D13] text-slate-900 dark:text-violet-200 font-mono text-xs rounded-xl p-3.5 focus:outline-none focus:ring-2 focus:ring-violet-500/30 resize-y leading-relaxed border border-slate-300 dark:border-white/[0.12] placeholder-slate-400 dark:placeholder-slate-600"
                            ></textarea>
                        </div>

                        {{-- Tab 2: Headers Table --}}
                        <div id="tabContentHeaders" class="space-y-3" style="display: none;">
                            <p class="text-xs text-slate-500 dark:text-slate-400">Headers sent with your HTTP request:</p>
                            <div id="headersContainer" class="space-y-2">
                                {{-- Row 1: X-API-KEY --}}
                                <div class="header-row flex items-center gap-2">
                                    <input type="text"
                                           name="header_key"
                                           value="X-API-KEY"
                                           class="w-1/3 border border-slate-300 dark:border-white/[0.08] rounded-lg px-3 py-1.5 text-xs font-mono text-slate-500 dark:text-slate-400 bg-slate-100 dark:bg-[#0B0D13]"
                                           readonly>
                                    <input type="text"
                                           id="apiKeyHeaderInput"
                                           name="header_val"
                                           value="{{ $project->api_key ?? '' }}"
                                           placeholder="sk_live_..."
                                           class="flex-1 min-w-0 border border-slate-300 dark:border-white/[0.1] rounded-lg px-3 py-1.5 text-xs font-mono text-slate-900 dark:text-slate-200 bg-white dark:bg-[#0B0D13] focus:outline-none focus:border-violet-500">
                                </div>
                                {{-- Row 2: Content-Type --}}
                                <div class="header-row flex items-center gap-2">
                                    <input type="text"
                                           name="header_key"
                                           value="Content-Type"
                                           class="w-1/3 border border-slate-300 dark:border-white/[0.08] rounded-lg px-3 py-1.5 text-xs font-mono text-slate-500 dark:text-slate-400 bg-slate-100 dark:bg-[#0B0D13]"
                                           readonly>
                                    <input type="text"
                                           name="header_val"
                                           value="application/json"
                                           class="flex-1 min-w-0 border border-slate-300 dark:border-white/[0.08] rounded-lg px-3 py-1.5 text-xs font-mono text-slate-500 dark:text-slate-400 bg-slate-100 dark:bg-[#0B0D13]"
                                           readonly>
                                </div>
                            </div>
                        </div>

                        {{-- Tab 3: Query Params --}}
                        <div id="tabContentParams" class="space-y-3" style="display: none;">
                            <p class="text-xs text-slate-500 dark:text-slate-400">Query parameters automatically appended to the URL:</p>
                            <div id="paramsContainer" class="space-y-2">
                                <div class="param-row flex items-center gap-2">
                                    <input type="text"
                                           placeholder="Key (e.g. limit)"
                                           oninput="syncQueryParams()"
                                           class="param-key w-1/3 border border-slate-300 dark:border-white/[0.1] rounded-lg px-3 py-1.5 text-xs font-mono text-slate-900 dark:text-slate-200 bg-white dark:bg-[#0B0D13] placeholder-slate-400 dark:placeholder-slate-600 focus:outline-none focus:border-violet-500">
                                    <input type="text"
                                           placeholder="Value (e.g. 10)"
                                           oninput="syncQueryParams()"
                                           class="param-val flex-1 min-w-0 border border-slate-300 dark:border-white/[0.1] rounded-lg px-3 py-1.5 text-xs font-mono text-slate-900 dark:text-slate-200 bg-white dark:bg-[#0B0D13] placeholder-slate-400 dark:placeholder-slate-600 focus:outline-none focus:border-violet-500">
                                </div>
                            </div>
                            <button type="button"
                                    onclick="addParamRow()"
                                    class="text-xs font-semibold text-violet-600 dark:text-violet-400 hover:text-violet-700 dark:hover:text-violet-300 transition-colors cursor-pointer">
                                + Add Param
                            </button>
                        </div>
                    </div>
                </form>
            </div>

            {{-- 2. Response Inspector Panel --}}
            <div class="bg-white dark:bg-[#141721] border border-slate-200 dark:border-white/[0.08] rounded-2xl p-5 shadow-sm dark:shadow-xs">
                <div class="flex items-center justify-between mb-4 pb-3 border-b border-slate-200 dark:border-white/[0.08] flex-wrap gap-2">
                    <div class="flex items-center gap-2.5">
                        <h3 class="text-sm font-bold text-slate-900 dark:text-white tracking-tight">Server Response</h3>
                        <span id="resStatusBadge" class="text-xs font-bold font-mono px-2.5 py-0.5 rounded-full bg-slate-100 dark:bg-white/[0.04] text-slate-600 dark:text-slate-400 border border-slate-200 dark:border-white/[0.08]">
                            No Request Sent Yet
                        </span>
                    </div>

                    <div class="flex items-center gap-3">
                        <span id="resTimeBadge" class="text-xs font-mono text-slate-500 dark:text-slate-400" style="display: none;">
                            Time: <strong id="resTimeVal" class="text-slate-800 dark:text-slate-200">0 ms</strong>
                        </span>
                        <span id="resSizeBadge" class="text-xs font-mono text-slate-500 dark:text-slate-400" style="display: none;">
                            Size: <strong id="resSizeVal" class="text-slate-800 dark:text-slate-200">0 B</strong>
                        </span>
                        <button type="button"
                                id="copyResBtn"
                                onclick="copyResponseBody()"
                                class="text-xs font-semibold text-slate-700 dark:text-slate-300 hover:text-slate-900 dark:hover:text-white border border-slate-200 dark:border-white/[0.08] hover:border-violet-400 dark:hover:border-violet-500/40 bg-slate-100 hover:bg-slate-200 dark:bg-[#1A1E2B] dark:hover:bg-[#252A3C] px-3 py-1 rounded-lg transition-all cursor-pointer"
                                style="display: none;">
                            Copy Body
                        </button>
                    </div>
                </div>

                {{-- Placeholder / Empty State --}}
                <div id="resEmptyPlaceholder" class="py-16 text-center text-slate-500 bg-slate-50 dark:bg-[#0B0D13]/50 border border-dashed border-slate-300 dark:border-white/[0.08] rounded-2xl">
                    <div class="w-12 h-12 bg-violet-50 dark:bg-violet-950/40 border border-violet-200 dark:border-violet-800/40 rounded-2xl flex items-center justify-center mx-auto mb-3 text-violet-600 dark:text-violet-400">
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M13 10V3L4 14h7v7l9-11h-7z" />
                        </svg>
                    </div>
                    <p class="text-sm font-medium text-slate-800 dark:text-slate-300">Enter a URL and click "Send"</p>
                    <p class="text-xs text-slate-500 mt-1 max-w-sm mx-auto">
                        Your response status, execution latency, headers, and formatted JSON output will render here.
                    </p>
                </div>

                {{-- Response Content Viewer --}}
                <div id="resContentViewer" style="display: none;" class="space-y-3">
                    {{-- Response Tabs (Body vs Headers) --}}
                    <div class="flex items-center gap-1 border-b border-slate-200 dark:border-white/[0.08] pb-2">
                        <button type="button"
                                id="btnResTabBody"
                                onclick="switchResTab('body')"
                                class="px-3 py-1 text-xs font-semibold text-violet-700 dark:text-violet-300 bg-violet-50 dark:bg-violet-950/60 rounded-lg border border-violet-200 dark:border-violet-800/50 transition-colors">
                            Response Body (JSON)
                        </button>
                        <button type="button"
                                id="btnResTabHeaders"
                                onclick="switchResTab('headers')"
                                class="px-3 py-1 text-xs font-semibold text-slate-500 dark:text-slate-400 hover:text-slate-800 dark:hover:text-slate-200 rounded-lg transition-colors">
                            Response Headers
                        </button>
                    </div>

                    {{-- Body View --}}
                    <div id="resTabBody">
                        <pre id="responseJsonOutput" class="bg-slate-950 text-emerald-400 font-mono text-xs rounded-xl p-4 overflow-x-auto max-h-[480px] leading-relaxed border border-slate-800 select-all"></pre>
                    </div>

                    {{-- Headers View --}}
                    <div id="resTabHeaders" style="display: none;">
                        <div class="border border-slate-200 dark:border-white/[0.08] rounded-xl overflow-hidden bg-white dark:bg-[#0B0D13]">
                            <table class="w-full text-left text-xs font-mono">
                                <thead class="bg-slate-100 dark:bg-[#141721] text-slate-700 dark:text-slate-300 border-b border-slate-200 dark:border-white/[0.08]">
                                    <tr>
                                        <th class="px-3 py-2 font-semibold">Header Key</th>
                                        <th class="px-3 py-2 font-semibold">Value</th>
                                    </tr>
                                </thead>
                                <tbody id="resHeadersTableBody" class="divide-y divide-slate-100 dark:divide-white/[0.06] bg-white dark:bg-[#0B0D13]">
                                    {{-- Dynamically populated --}}
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

        </div>

    </div>

@endsection

@push('scripts')
<script>
    // Tab switching between Body / Headers / Params for Request
    function switchReqTab(tab) {
        document.getElementById('tabContentBody').style.display = tab === 'body' ? 'block' : 'none';
        document.getElementById('tabContentHeaders').style.display = tab === 'headers' ? 'block' : 'none';
        document.getElementById('tabContentParams').style.display = tab === 'params' ? 'block' : 'none';

        const btnBody = document.getElementById('tabBtnBody');
        const btnHeaders = document.getElementById('tabBtnHeaders');
        const btnParams = document.getElementById('tabBtnParams');

        const activeClass = 'px-4 py-2 text-xs font-semibold border-b-2 border-violet-500 text-violet-400 cursor-pointer transition-colors';
        const inactiveClass = 'px-4 py-2 text-xs font-semibold border-b-2 border-transparent text-slate-400 hover:text-slate-200 cursor-pointer transition-colors';

        btnBody.className = tab === 'body' ? activeClass : inactiveClass;
        btnHeaders.className = tab === 'headers' ? activeClass : inactiveClass;
        btnParams.className = tab === 'params' ? activeClass : inactiveClass;
    }

    // Switch between Response Body vs Response Headers tabs
    function switchResTab(tab) {
        const bodyEl = document.getElementById('resTabBody');
        const headersEl = document.getElementById('resTabHeaders');
        const btnBody = document.getElementById('btnResTabBody');
        const btnHeaders = document.getElementById('btnResTabHeaders');

        const activeStyle = 'px-3 py-1 text-xs font-semibold text-violet-300 bg-violet-950/60 rounded-lg border border-violet-800/50 transition-colors';
        const inactiveStyle = 'px-3 py-1 text-xs font-semibold text-slate-400 hover:text-slate-200 rounded-lg transition-colors';

        if (tab === 'body') {
            bodyEl.style.display = 'block';
            headersEl.style.display = 'none';
            btnBody.className = activeStyle;
            btnHeaders.className = inactiveStyle;
        } else {
            bodyEl.style.display = 'none';
            headersEl.style.display = 'block';
            btnHeaders.className = activeStyle;
            btnBody.className = inactiveStyle;
        }
    }

    // Prettify Request JSON
    function prettifyRequestBody() {
        const textarea = document.getElementById('requestBody');
        try {
            const val = textarea.value.trim();
            if (val) {
                const parsed = JSON.parse(val);
                textarea.value = JSON.stringify(parsed, null, 2);
            }
        } catch (e) {
            alert('Invalid JSON syntax: ' + e.message);
        }
    }

    function clearRequestBody() {
        document.getElementById('requestBody').value = '';
    }

    // Load preset endpoint into tester
    function loadPreset(method, url, sampleJson) {
        document.getElementById('httpMethod').value = method;
        document.getElementById('requestUrl').value = url;
        document.getElementById('requestBody').value = sampleJson || '';
        handleMethodChange(method);

        // Visual flash indication on the URL bar
        const input = document.getElementById('requestUrl');
        input.classList.add('bg-violet-950/40');
        setTimeout(() => input.classList.remove('bg-violet-950/40'), 400);

        // Switch to body tab if POST/PUT
        if (['POST', 'PUT', 'PATCH'].includes(method)) {
            switchReqTab('body');
        }
    }

    // Style adjustments when method changes
    function handleMethodChange(method) {
        if (['POST', 'PUT', 'PATCH'].includes(method)) {
            switchReqTab('body');
        }
    }

    // Add query param row
    function addParamRow() {
        const container = document.getElementById('paramsContainer');
        const row = document.createElement('div');
        row.className = 'param-row flex items-center gap-2';
        row.innerHTML = `
            <input type="text" placeholder="Key" oninput="syncQueryParams()" class="param-key w-1/3 border border-white/[0.1] rounded-lg px-3 py-1.5 text-xs font-mono text-slate-200 bg-[#0B0D13] placeholder-slate-600 focus:outline-none focus:border-violet-500">
            <input type="text" placeholder="Value" oninput="syncQueryParams()" class="param-val flex-1 min-w-0 border border-white/[0.1] rounded-lg px-3 py-1.5 text-xs font-mono text-slate-200 bg-[#0B0D13] placeholder-slate-600 focus:outline-none focus:border-violet-500">
            <button type="button" onclick="this.parentElement.remove(); syncQueryParams();" class="text-slate-500 hover:text-rose-400 text-xs px-1">✕</button>
        `;
        container.appendChild(row);
    }

    // Sync query params into URL
    function syncQueryParams() {
        const urlInput = document.getElementById('requestUrl');
        let baseUrl = urlInput.value.split('?')[0];
        const rows = document.querySelectorAll('.param-row');
        const params = new URLSearchParams();

        rows.forEach(r => {
            const key = r.querySelector('.param-key')?.value.trim();
            const val = r.querySelector('.param-val')?.value.trim();
            if (key) params.append(key, val);
        });

        const qs = params.toString();
        urlInput.value = qs ? `${baseUrl}?${qs}` : baseUrl;
    }

    // Copy API key helper
    function copyTesterApiKey(key, btn) {
        navigator.clipboard.writeText(key).then(() => {
            const orig = btn.innerText;
            btn.innerText = 'Copied!';
            btn.classList.add('text-emerald-400');
            setTimeout(() => {
                btn.innerText = orig;
                btn.classList.remove('text-emerald-400');
            }, 1500);
        });
    }

    // Copy Response Body
    function copyResponseBody() {
        const text = document.getElementById('responseJsonOutput').innerText;
        navigator.clipboard.writeText(text).then(() => {
            const btn = document.getElementById('copyResBtn');
            const orig = btn.innerText;
            btn.innerText = '✓ Copied';
            setTimeout(() => btn.innerText = orig, 1500);
        });
    }

    // Main Request Execution Engine (Calls Laravel Backend Proxy)
    async function executeRequest(e) {
        e.preventDefault();

        const method = document.getElementById('httpMethod').value;
        const url = document.getElementById('requestUrl').value.trim();
        const apiKey = document.getElementById('apiKeyHeaderInput')?.value.trim() || '';
        const bodyContent = document.getElementById('requestBody').value.trim();

        const sendBtn = document.getElementById('sendBtn');
        const sendBtnText = document.getElementById('sendBtnText');
        const statusBadge = document.getElementById('resStatusBadge');
        const timeBadge = document.getElementById('resTimeBadge');
        const timeVal = document.getElementById('resTimeVal');
        const sizeBadge = document.getElementById('resSizeBadge');
        const sizeVal = document.getElementById('resSizeVal');
        const placeholder = document.getElementById('resEmptyPlaceholder');
        const viewer = document.getElementById('resContentViewer');
        const output = document.getElementById('responseJsonOutput');
        const headersTableBody = document.getElementById('resHeadersTableBody');
        const copyBtn = document.getElementById('copyResBtn');

        // Loading state
        sendBtn.disabled = true;
        sendBtnText.innerText = 'Sending...';
        statusBadge.className = 'text-xs font-bold font-mono px-2.5 py-0.5 rounded-full bg-violet-950/60 text-violet-300 border border-violet-800/50 animate-pulse';
        statusBadge.innerText = 'Sending via Postman Engine...';

        try {
            // Prepare request headers
            const customHeaders = {
                'Accept': 'application/json',
            };
            if (apiKey) {
                customHeaders['X-API-KEY'] = apiKey;
            }
            if (['POST', 'PUT', 'PATCH'].includes(method) && bodyContent) {
                customHeaders['Content-Type'] = 'application/json';
            }

            // Post to Laravel backend proxy route
            const proxyEndpoint = "{{ isset($project) ? route('projects.tester.send', $project->database_name) : '' }}";

            const response = await fetch(proxyEndpoint, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    method: method,
                    url: url,
                    headers: customHeaders,
                    body: bodyContent || null
                })
            });

            const result = await response.json();

            // Calculate byte size
            const sizeBytes = result.size_bytes ?? 0;
            const sizeStr = sizeBytes > 1024 ? (sizeBytes / 1024).toFixed(2) + ' KB' : sizeBytes + ' B';

            // Show UI viewer components
            placeholder.style.display = 'none';
            viewer.style.display = 'block';
            timeBadge.style.display = 'inline-block';
            sizeBadge.style.display = 'inline-block';
            copyBtn.style.display = 'inline-block';

            timeVal.innerText = `${result.time_ms ?? 0} ms`;
            sizeVal.innerText = sizeStr;

            // Render status badge with color coding
            const status = result.status ?? 200;
            let badgeStyle = 'bg-white/[0.04] text-slate-300 border-white/[0.08]';
            if (status >= 200 && status < 300) {
                badgeStyle = 'bg-emerald-950/60 text-emerald-400 border-emerald-800/50';
            } else if (status >= 400 && status < 500) {
                badgeStyle = 'bg-amber-950/60 text-amber-400 border-amber-800/50';
            } else if (status >= 500) {
                badgeStyle = 'bg-rose-950/60 text-rose-400 border-rose-800/50';
            }

            statusBadge.className = `text-xs font-bold font-mono px-2.5 py-0.5 rounded-full border ${badgeStyle}`;
            statusBadge.innerText = `${status} ${result.status_text || ''}`;

            // Render JSON Output
            const dataToRender = result.data !== undefined ? result.data : (result.error ? { error: result.error } : result);
            if (typeof dataToRender === 'object' && dataToRender !== null) {
                output.innerText = JSON.stringify(dataToRender, null, 2);
            } else {
                output.innerText = dataToRender || '(Empty response body)';
            }

            // Populate Response Headers Table
            headersTableBody.innerHTML = '';
            const resHeaders = result.headers || {};
            const headerKeys = Object.keys(resHeaders);

            if (headerKeys.length === 0) {
                headersTableBody.innerHTML = '<tr><td colspan="2" class="px-3 py-3 text-slate-500 text-center italic">No response headers returned</td></tr>';
            } else {
                headerKeys.forEach(k => {
                    const row = document.createElement('tr');
                    const val = Array.isArray(resHeaders[k]) ? resHeaders[k].join(', ') : resHeaders[k];
                    row.innerHTML = `
                        <td class="px-3 py-2 font-medium text-slate-300">${k}</td>
                        <td class="px-3 py-2 text-violet-300 break-all select-all">${val}</td>
                    `;
                    headersTableBody.appendChild(row);
                });
            }

            // Reset back to response body tab
            switchResTab('body');

        } catch (error) {
            placeholder.style.display = 'none';
            viewer.style.display = 'block';
            statusBadge.className = 'text-xs font-bold font-mono px-2.5 py-0.5 rounded-full bg-rose-950/60 text-rose-400 border border-rose-800/50';
            statusBadge.innerText = 'Network / Proxy Error';
            output.innerText = `Error: ${error.message}\n\nPlease check your server logs or ensure the backend server is running.`;
        } finally {
            sendBtn.disabled = false;
            sendBtnText.innerText = 'Send';
        }
    }

    // Keyboard shortcut: Ctrl + Enter to send
    document.addEventListener('keydown', function(e) {
        if ((e.ctrlKey || e.metaKey) && e.key === 'Enter') {
            e.preventDefault();
            document.getElementById('sendBtn').click();
        }
    });
</script>
@endpush
