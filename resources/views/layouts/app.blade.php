<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>ApiFlex — @yield('title', 'Dashboard')</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700,800&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script>
        // Apply theme before DOM rendering to prevent flashing
        (function() {
            const stored = localStorage.getItem('theme');
            if (stored === 'light') {
                document.documentElement.classList.remove('dark');
            } else {
                document.documentElement.classList.add('dark');
            }
        })();
    </script>
</head>
<body class="bg-slate-50 dark:bg-[#070A10] text-slate-800 dark:text-slate-100 font-sans h-screen flex overflow-hidden selection:bg-emerald-500/30 selection:text-emerald-300 antialiased transition-colors duration-200">

    {{-- Collapsible Sidebar --}}
    <aside id="appSidebar"
           class="w-64 bg-white dark:bg-[#0A0E17] text-slate-700 dark:text-slate-200 flex flex-col shrink-0 h-full border-r border-slate-200 dark:border-white/[0.07] transition-all duration-300 ease-in-out">
        {{-- Logo & App Brand --}}
        <div class="px-6 py-5 border-b border-slate-200 dark:border-white/[0.07] flex items-center justify-between">
            <a href="/" class="flex items-center gap-2.5 group">
                <div class="w-8 h-8 rounded-xl bg-gradient-to-tr from-emerald-500 to-teal-400 shadow-sm shadow-emerald-500/20 flex items-center justify-center transition-transform group-hover:scale-105">
                    <svg class="w-4.5 h-4.5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M13 10V3L4 14h7v7l9-11h-7z" />
                    </svg>
                </div>
                <span class="text-lg font-bold tracking-tight text-slate-900 dark:text-white group-hover:text-emerald-600 dark:group-hover:text-emerald-300 transition-colors">ApiFlex</span>
            </a>
            <span class="text-[10px] font-mono uppercase tracking-wider text-emerald-700 dark:text-emerald-400 bg-emerald-50 dark:bg-emerald-950/60 border border-emerald-200 dark:border-emerald-800/50 px-1.5 py-0.5 rounded">v2.4</span>
        </div>

        {{-- Navigation Links --}}
        <nav class="flex-1 px-3 py-5 space-y-1.5 overflow-y-auto">
            <a href="/dashboard"
               class="flex items-center gap-3 px-3 py-2 rounded-xl text-xs font-semibold transition-all
                      {{ request()->is('dashboard') ? 'bg-emerald-50 dark:bg-emerald-950/50 text-emerald-700 dark:text-emerald-300 border border-emerald-200 dark:border-emerald-800/40 shadow-xs' : 'text-slate-600 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-white/[0.04] hover:text-slate-900 dark:hover:text-white border border-transparent' }}">
                <svg class="w-4 h-4 shrink-0 {{ request()->is('dashboard') ? 'text-emerald-600 dark:text-emerald-400' : 'text-slate-400 dark:text-slate-500' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                </svg>
                Dashboard
            </a>

            <a href="{{ route('projects.index') }}"
               class="flex items-center gap-3 px-3 py-2 rounded-xl text-xs font-semibold transition-all
                      {{ (request()->is('projects') || (request()->is('projects/*') && !request()->is('*tester*'))) ? 'bg-emerald-50 dark:bg-emerald-950/50 text-emerald-700 dark:text-emerald-300 border border-emerald-200 dark:border-emerald-800/40 shadow-xs' : 'text-slate-600 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-white/[0.04] hover:text-slate-900 dark:hover:text-white border border-transparent' }}">
                <svg class="w-4 h-4 shrink-0 {{ (request()->is('projects') || (request()->is('projects/*') && !request()->is('*tester*'))) ? 'text-emerald-600 dark:text-emerald-400' : 'text-slate-400 dark:text-slate-500' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                </svg>
                My Projects
            </a>

            <a href="{{ route('tester') }}"
               class="flex items-center gap-3 px-3 py-2 rounded-xl text-xs font-semibold transition-all
                      {{ request()->is('*tester*') ? 'bg-emerald-50 dark:bg-emerald-950/50 text-emerald-700 dark:text-emerald-300 border border-emerald-200 dark:border-emerald-800/40 shadow-xs' : 'text-slate-600 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-white/[0.04] hover:text-slate-900 dark:hover:text-white border border-transparent' }}">
                <svg class="w-4 h-4 shrink-0 {{ request()->is('*tester*') ? 'text-emerald-600 dark:text-emerald-400' : 'text-slate-400 dark:text-slate-500' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M13 10V3L4 14h7v7l9-11h-7z" />
                </svg>
                API Tester
            </a>

            <button type="button"
                    onclick="openApiKeysModal()"
                    class="w-full text-left flex items-center gap-3 px-3 py-2 rounded-xl text-xs font-semibold text-slate-600 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-white/[0.04] hover:text-slate-900 dark:hover:text-white border border-transparent transition-all cursor-pointer">
                <svg class="w-4 h-4 shrink-0 text-slate-400 dark:text-slate-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-11.9 1M8 14l-4 4m0 0l-1-1m1 1l1 1m3-3l-2-2m7-9a6 6 0 00-6 6v1"/>
                </svg>
                API Secret Keys
            </button>

            <a href="#"
               class="flex items-center gap-3 px-3 py-2 rounded-xl text-xs font-semibold text-slate-600 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-white/[0.04] hover:text-slate-900 dark:hover:text-white border border-transparent transition-all">
                <svg class="w-4 h-4 shrink-0 text-slate-400 dark:text-slate-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                </svg>
                Documentation
            </a>
        </nav>

        {{-- Bottom Status Pill --}}
        <div class="px-5 py-4 border-t border-slate-200 dark:border-white/[0.07] bg-slate-50 dark:bg-[#070A10]/60">
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-2.5">
                    <div class="w-7 h-7 rounded-lg bg-gradient-to-tr from-emerald-500 to-teal-500 flex items-center justify-center text-xs font-bold text-white shadow-2xs">A</div>
                    <div>
                        <p class="text-xs font-medium text-slate-800 dark:text-slate-200 leading-none">Developer Console</p>
                        <span class="text-[10px] text-slate-500 dark:text-slate-500 mt-0.5 inline-block">Production Workspace</span>
                    </div>
                </div>
            </div>
        </div>
    </aside>

    {{-- Main Viewport --}}
    <div class="flex-1 flex flex-col min-w-0 overflow-hidden bg-slate-50 dark:bg-[#070A10] transition-colors duration-200">

        {{-- Top Navigation Bar --}}
        <header class="bg-white/90 dark:bg-[#0A0E17]/90 backdrop-blur-md border-b border-slate-200 dark:border-white/[0.07] px-6 lg:px-8 py-3.5 flex items-center justify-between shrink-0 transition-colors duration-200 z-30">
            <div class="flex items-center gap-3">
                {{-- Sidebar Toggle Button (Matching Screenshot Top-Left Icon) --}}
                <button type="button"
                        onclick="toggleSidebar()"
                        class="w-9 h-9 rounded-xl bg-slate-100 hover:bg-slate-200 border border-slate-200 dark:bg-[#131B26] dark:hover:bg-[#1C2636] dark:border-white/10 dark:hover:border-white/20 flex items-center justify-center text-slate-600 hover:text-slate-900 dark:text-slate-300 dark:hover:text-white transition-all cursor-pointer shadow-2xs"
                        title="Toggle Navigation Menu">
                    <svg class="w-4.5 h-4.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </button>

                <a href="/" class="hidden sm:flex items-center gap-2 text-sm font-bold text-slate-900 dark:text-white tracking-tight hover:text-emerald-600 dark:hover:text-emerald-400 transition-colors">
                    <span>ApiFlex</span>
                    <span class="text-[10px] font-mono text-emerald-700 dark:text-emerald-400 bg-emerald-50 dark:bg-emerald-950/60 border border-emerald-200 dark:border-emerald-800/40 px-1.5 py-0.5 rounded">Telemetry</span>
                </a>
            </div>

            {{-- Top-Right Controls --}}
            <div class="flex items-center gap-2.5">
                {{-- ☼ Light / Dark Theme Button --}}
                <button type="button"
                        id="themeToggleBtn"
                        onclick="toggleTheme()"
                        class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl text-xs font-semibold bg-slate-100 hover:bg-slate-200 text-slate-700 border border-slate-200 dark:bg-[#131B26] dark:hover:bg-[#1C2636] dark:text-amber-300 dark:border-white/10 dark:hover:border-white/20 transition-all cursor-pointer shadow-2xs"
                        title="Toggle Light / Dark mode">
                    <svg class="theme-toggle-icon-sun w-3.5 h-3.5 text-amber-500 dark:text-amber-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z" />
                    </svg>
                    <svg class="theme-toggle-icon-moon w-3.5 h-3.5 text-violet-600 dark:text-violet-400 hidden" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z" />
                    </svg>
                    <span class="theme-toggle-text text-[11px] font-medium hidden sm:inline">Light Theme</span>
                </button>

                {{-- 🔑 API Keys Button --}}
                <button type="button"
                        onclick="openApiKeysModal()"
                        class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl text-xs font-semibold bg-slate-100 hover:bg-slate-200 text-emerald-700 border border-slate-200 dark:bg-[#131B26] dark:hover:bg-[#1C2636] dark:text-emerald-400 dark:border-white/10 dark:hover:border-white/20 transition-all cursor-pointer shadow-2xs">
                    <svg class="w-3.5 h-3.5 text-emerald-600 dark:text-emerald-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-11.9 1M8 14l-4 4m0 0l-1-1m1 1l1 1m3-3l-2-2m7-9a6 6 0 00-6 6v1"/>
                    </svg>
                    <span>API Keys</span>
                </button>

                {{-- Admin Profile Pill with Dropdown --}}
                <div class="relative" id="userMenuContainer">
                    <button type="button"
                            onclick="toggleUserMenu()"
                            class="inline-flex items-center gap-2 pl-1.5 pr-2.5 py-1 rounded-xl text-xs font-semibold bg-slate-100 hover:bg-slate-200 text-slate-700 border border-slate-200 dark:bg-[#131B26] dark:hover:bg-[#1C2636] dark:text-slate-200 dark:border-white/10 dark:hover:border-white/20 transition-all cursor-pointer shadow-2xs">
                        <div class="w-5 h-5 rounded-full bg-teal-500 text-white flex items-center justify-center text-[10px] font-bold">A</div>
                        <span class="text-xs font-medium text-slate-700 dark:text-slate-200">admin</span>
                        <svg class="w-3 h-3 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>

                    <div id="userDropdown"
                         class="hidden absolute right-0 mt-2 w-48 bg-white dark:bg-[#0D1320] border border-slate-200 dark:border-white/10 rounded-2xl shadow-xl dark:shadow-2xl p-2 z-50 text-xs text-slate-700 dark:text-slate-300">
                        <div class="px-3 py-2 border-b border-slate-100 dark:border-white/[0.08] mb-1">
                            <p class="font-bold text-slate-900 dark:text-white">admin</p>
                            <p class="text-[10px] text-emerald-600 dark:text-emerald-400">● Sandbox Owner</p>
                        </div>
                        <a href="/dashboard" class="flex items-center gap-2 px-3 py-2 rounded-xl hover:bg-slate-100 dark:hover:bg-white/[0.06] hover:text-slate-900 dark:hover:text-white transition-colors">
                            Dashboard
                        </a>
                        <a href="{{ route('projects.index') }}" class="flex items-center gap-2 px-3 py-2 rounded-xl hover:bg-slate-100 dark:hover:bg-white/[0.06] hover:text-slate-900 dark:hover:text-white transition-colors">
                            My Projects
                        </a>
                        <a href="{{ route('tester') }}" class="flex items-center gap-2 px-3 py-2 rounded-xl hover:bg-slate-100 dark:hover:bg-white/[0.06] hover:text-slate-900 dark:hover:text-white transition-colors">
                            API Tester
                        </a>
                        <button type="button" onclick="openApiKeysModal(); toggleUserMenu();" class="w-full text-left flex items-center gap-2 px-3 py-2 rounded-xl hover:bg-slate-100 dark:hover:bg-white/[0.06] hover:text-slate-900 dark:hover:text-white transition-colors">
                            View API Keys
                        </button>
                    </div>
                </div>

                @yield('header-actions')
            </div>
        </header>

        {{-- Main Page Scrollable Content --}}
        <main class="flex-1 overflow-y-auto p-6 sm:p-8 bg-slate-50 dark:bg-[#070A10] transition-colors duration-200">
            {{-- Flash Messages --}}
            @if(session('success'))
                <div class="mb-6 flex items-center justify-between gap-3 bg-emerald-50 dark:bg-emerald-950/40 border border-emerald-200 dark:border-emerald-800/50 text-emerald-800 dark:text-emerald-300 text-xs px-4 py-3 rounded-xl shadow-xs">
                    <div class="flex items-center gap-2.5">
                        <svg class="w-4 h-4 text-emerald-600 dark:text-emerald-400 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <span class="font-medium">{{ session('success') }}</span>
                    </div>
                    <button type="button" onclick="this.parentElement.remove()" class="text-emerald-600 dark:text-emerald-400 hover:text-emerald-800 dark:hover:text-emerald-200 transition-colors cursor-pointer">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
            @endif

            @if($errors->any())
                <div class="mb-6 bg-rose-50 dark:bg-rose-950/40 border border-rose-200 dark:border-rose-800/50 text-rose-800 dark:text-rose-300 text-xs p-4 rounded-xl shadow-xs">
                    <div class="flex items-center gap-2 mb-2 font-semibold text-rose-900 dark:text-rose-200">
                        <svg class="w-4 h-4 text-rose-600 dark:text-rose-400 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                        </svg>
                        <span>Please fix the following issues:</span>
                    </div>
                    <ul class="list-disc list-inside space-y-1 text-rose-700 dark:text-rose-300/90 text-xs">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @yield('content')
        </main>
    </div>

    {{-- Global API Keys Modal --}}
    <div id="globalApiKeysModal"
         class="hidden fixed inset-0 bg-slate-900/60 dark:bg-black/80 backdrop-blur-md z-50 flex items-center justify-center p-4"
         onclick="closeApiKeysModal(event)">
        <div class="bg-white dark:bg-[#0D1320] border border-slate-200 dark:border-white/10 rounded-3xl shadow-2xl w-full max-w-xl overflow-hidden text-slate-800 dark:text-slate-100 animate-in fade-in zoom-in-95 duration-150"
             onclick="event.stopPropagation()">
            <div class="flex items-center justify-between px-6 py-5 border-b border-slate-200 dark:border-white/[0.08] bg-slate-50 dark:bg-[#101726]">
                <div class="flex items-center gap-3">
                    <div class="w-9 h-9 rounded-xl bg-emerald-50 dark:bg-emerald-950/60 border border-emerald-200 dark:border-emerald-800/50 flex items-center justify-center text-emerald-600 dark:text-emerald-400">
                        <svg class="w-4.5 h-4.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-11.9 1M8 14l-4 4m0 0l-1-1m1 1l1 1m3-3l-2-2m7-9a6 6 0 00-6 6v1"/>
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-base font-bold text-slate-900 dark:text-white">Project API Secret Keys</h3>
                        <p class="text-xs text-slate-500 dark:text-slate-400 mt-0.5">SHA-256 protected Bearer authentication tokens</p>
                    </div>
                </div>
                <button onclick="closeApiKeysModal()" class="text-slate-400 hover:text-slate-700 dark:hover:text-white p-1.5 rounded-lg hover:bg-slate-100 dark:hover:bg-white/[0.06] transition-colors cursor-pointer">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <div class="p-6 space-y-4 max-h-[60vh] overflow-y-auto">
                @php
                    $allProjects = \App\Models\Project::latest()->get();
                @endphp

                @forelse($allProjects as $proj)
                    <div class="p-4 rounded-2xl bg-slate-50 dark:bg-[#080C14] border border-slate-200 dark:border-white/[0.08] space-y-2.5">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-2">
                                <span class="font-bold text-slate-900 dark:text-white text-sm">{{ $proj->name }}</span>
                                <span class="text-[10px] font-mono text-emerald-700 dark:text-emerald-400 bg-emerald-50 dark:bg-emerald-950/60 border border-emerald-200 dark:border-emerald-800/50 px-2 py-0.5 rounded">/api/{{ $proj->database_name }}</span>
                            </div>
                            <a href="{{ route('projects.show', $proj->database_name) }}" class="text-[11px] font-semibold text-emerald-600 dark:text-emerald-400 hover:text-emerald-700 dark:hover:text-emerald-300">
                                View Tables →
                            </a>
                        </div>
                        <div class="flex items-center gap-2">
                            <input type="password"
                                   id="apiKeyModal_{{ $proj->id }}"
                                   value="{{ $proj->api_key }}"
                                   readonly
                                   class="flex-1 bg-white dark:bg-[#101726] border border-slate-300 dark:border-white/10 rounded-xl px-3 py-1.5 text-xs font-mono text-slate-800 dark:text-slate-200 select-all focus:outline-none">
                            <button type="button"
                                    onclick="toggleKeyVisibility('apiKeyModal_{{ $proj->id }}')"
                                    class="px-2.5 py-1.5 bg-slate-100 hover:bg-slate-200 border border-slate-300 dark:bg-[#172133] dark:hover:bg-[#202D44] dark:border-white/10 rounded-xl text-[11px] font-semibold text-slate-700 dark:text-slate-300 cursor-pointer transition-colors">
                                Show
                            </button>
                            <button type="button"
                                    onclick="copyKeyModal('{{ $proj->api_key }}', this)"
                                    class="px-3 py-1.5 bg-emerald-500 hover:bg-emerald-400 text-white rounded-xl text-[11px] font-semibold cursor-pointer shadow-xs transition-colors">
                                Copy
                            </button>
                        </div>
                    </div>
                @empty
                    <p class="text-xs text-slate-500 text-center py-6">No projects created yet. Create a project to generate your first API key.</p>
                @endforelse
            </div>

            <div class="px-6 py-4 border-t border-slate-200 dark:border-white/[0.08] bg-slate-50 dark:bg-[#0A0E17] flex justify-end">
                <button type="button"
                        onclick="closeApiKeysModal()"
                        class="text-xs font-semibold px-4 py-2 bg-slate-200 hover:bg-slate-300 dark:bg-white/[0.06] dark:hover:bg-white/[0.1] text-slate-800 dark:text-white rounded-xl transition-colors cursor-pointer">
                    Close
                </button>
            </div>
        </div>
    </div>

    {{-- Core Client Scripts --}}
    <script>
        // Sidebar Toggle with State Preservation
        function toggleSidebar() {
            const sidebar = document.getElementById('appSidebar');
            if (!sidebar) return;
            const isCollapsed = sidebar.classList.toggle('hidden');
            localStorage.setItem('apiflex_sidebar_hidden', isCollapsed ? 'true' : 'false');
        }

        // Apply saved sidebar state
        document.addEventListener('DOMContentLoaded', function() {
            const sidebar = document.getElementById('appSidebar');
            if (sidebar && localStorage.getItem('apiflex_sidebar_hidden') === 'true') {
                sidebar.classList.add('hidden');
            }
        });

        // Theme Toggle (Light / Dark)
        function toggleTheme() {
            const isDark = document.documentElement.classList.toggle('dark');
            localStorage.setItem('theme', isDark ? 'dark' : 'light');
            syncThemeToggleUI(isDark);
            window.dispatchEvent(new CustomEvent('themeChanged', { detail: { isDark } }));
        }

        function syncThemeToggleUI(isDark) {
            document.querySelectorAll('.theme-toggle-icon-sun').forEach(el => {
                if (isDark) el.classList.remove('hidden');
                else el.classList.add('hidden');
            });
            document.querySelectorAll('.theme-toggle-icon-moon').forEach(el => {
                if (isDark) el.classList.add('hidden');
                else el.classList.remove('hidden');
            });
            document.querySelectorAll('.theme-toggle-text').forEach(el => {
                el.textContent = isDark ? 'Light Theme' : 'Dark Theme';
            });
        }

        document.addEventListener('DOMContentLoaded', function() {
            syncThemeToggleUI(document.documentElement.classList.contains('dark'));
        });

        // User dropdown menu
        function toggleUserMenu() {
            const drop = document.getElementById('userDropdown');
            if (drop) drop.classList.toggle('hidden');
        }

        document.addEventListener('click', function(e) {
            const container = document.getElementById('userMenuContainer');
            const drop = document.getElementById('userDropdown');
            if (container && drop && !container.contains(e.target)) {
                drop.classList.add('hidden');
            }
        });

        // API Keys Modal
        function openApiKeysModal() {
            const modal = document.getElementById('globalApiKeysModal');
            if (modal) modal.classList.remove('hidden');
        }

        function closeApiKeysModal(e) {
            const modal = document.getElementById('globalApiKeysModal');
            if (modal) modal.classList.add('hidden');
        }

        function toggleKeyVisibility(id) {
            const el = document.getElementById(id);
            if (!el) return;
            el.type = el.type === 'password' ? 'text' : 'password';
        }

        function copyKeyModal(key, btn) {
            navigator.clipboard.writeText(key).then(() => {
                const orig = btn.innerText;
                btn.innerText = '✓ Copied';
                setTimeout(() => btn.innerText = orig, 1500);
            });
        }
    </script>

    @stack('scripts')
</body>
</html>
