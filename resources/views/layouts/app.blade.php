<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>ApiFlex — @yield('title', 'Dashboard')</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-slate-50 text-slate-800 font-sans h-screen flex overflow-hidden">

    {{-- Sidebar --}}
    <aside class="w-64 bg-slate-900 text-white flex flex-col shrink-0 h-full">
        {{-- Logo --}}
        <div class="px-6 py-5 border-b border-slate-700/60">
            <a href="/" class="flex items-center gap-2.5">
                <div class="w-8 h-8 bg-indigo-500 rounded-lg flex items-center justify-center">
                    <svg class="w-5 h-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M13 10V3L4 14h7v7l9-11h-7z" />
                    </svg>
                </div>
                <span class="text-lg font-bold tracking-tight text-white">ApiFlex</span>
            </a>
        </div>

        {{-- Navigation --}}
        <nav class="flex-1 px-3 py-5 space-y-1 overflow-y-auto">
            <a href="/dashboard"
               class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-colors
                      {{ request()->is('dashboard') ? 'bg-indigo-600 text-white' : 'text-slate-400 hover:bg-slate-800 hover:text-white' }}">
                <svg class="w-5 h-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.75">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                </svg>
                Dashboard
            </a>

            <a href="/dashboard"
               class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-colors
                      {{ request()->is('projects*') ? 'bg-indigo-600 text-white' : 'text-slate-400 hover:bg-slate-800 hover:text-white' }}">
                <svg class="w-5 h-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.75">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                </svg>
                My Projects
            </a>

            <a href="#"
               class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium text-slate-400 hover:bg-slate-800 hover:text-white transition-colors">
                <svg class="w-5 h-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.75">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                </svg>
                Docs
            </a>
        </nav>

        {{-- Bottom user/version area --}}
        <div class="px-5 py-4 border-t border-slate-700/60">
            <div class="flex items-center gap-2">
                <div class="w-7 h-7 rounded-full bg-indigo-500 flex items-center justify-center text-xs font-bold text-white">A</div>
                <span class="text-xs text-slate-400 font-medium">ApiFlex v1.0</span>
            </div>
        </div>
    </aside>

    {{-- Main content area --}}
    <div class="flex-1 flex flex-col min-w-0 overflow-hidden">
        {{-- Top bar --}}
        <header class="bg-white border-b border-slate-200 px-8 py-4 flex items-center justify-between shrink-0">
            <h1 class="text-xl font-semibold text-slate-800">@yield('title', 'Dashboard')</h1>
            <div class="flex items-center gap-3">
                @yield('header-actions')
            </div>
        </header>

        {{-- Page content --}}
        <main class="flex-1 overflow-y-auto p-8">
            {{-- Flash messages --}}
            @if(session('success'))
                <div class="mb-6 flex items-center justify-between gap-3 bg-emerald-50 border border-emerald-200 text-emerald-800 text-sm px-4 py-3 rounded-xl shadow-xs">
                    <div class="flex items-center gap-2.5">
                        <svg class="w-5 h-5 text-emerald-500 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <span>{{ session('success') }}</span>
                    </div>
                    <button type="button" onclick="this.parentElement.remove()" class="text-emerald-500 hover:text-emerald-700">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
            @endif

            @if($errors->any())
                <div class="mb-6 bg-red-50 border border-red-200 text-red-800 text-sm p-4 rounded-xl shadow-xs">
                    <div class="flex items-center gap-2 mb-2 font-semibold text-red-900">
                        <svg class="w-5 h-5 text-red-500 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                        </svg>
                        <span>Please fix the following errors:</span>
                    </div>
                    <ul class="list-disc list-inside space-y-1 text-xs text-red-700">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @yield('content')
        </main>
    </div>

    @stack('scripts')
</body>
</html>
