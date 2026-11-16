<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>ApiFlex — Mock APIs in Seconds</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700,800&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-[#0B0D13] text-slate-100 font-sans selection:bg-violet-600/30 selection:text-violet-200 antialiased">

    {{-- Navbar --}}
    <nav class="border-b border-white/[0.07] bg-[#0C0E14]/80 backdrop-blur-md sticky top-0 z-50 px-6 py-4">
        <div class="max-w-6xl mx-auto flex items-center justify-between">
            <a href="/" class="flex items-center gap-2.5 group">
                <div class="w-8 h-8 bg-gradient-to-tr from-violet-600 to-indigo-500 rounded-xl flex items-center justify-center shadow-xs shadow-violet-900/40 group-hover:scale-105 transition-transform">
                    <svg class="w-4.5 h-4.5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M13 10V3L4 14h7v7l9-11h-7z" />
                    </svg>
                </div>
                <span class="text-lg font-bold tracking-tight text-white group-hover:text-violet-300 transition-colors">ApiFlex</span>
            </a>
            <div class="flex items-center gap-4">
                <a href="#features" class="text-xs font-semibold text-slate-400 hover:text-white transition-colors">Features</a>
                <a href="/dashboard"
                   class="text-xs font-semibold bg-violet-600 hover:bg-violet-500 text-white px-4 py-2 rounded-xl transition-all shadow-xs shadow-violet-900/40">
                    Get Started
                </a>
            </div>
        </div>
    </nav>

    {{-- Hero --}}
    <section class="max-w-6xl mx-auto px-6 pt-24 pb-20 text-center">
        {{-- Badge --}}
        <div class="inline-flex items-center gap-2 bg-violet-950/60 border border-violet-800/50 text-violet-300 text-xs font-medium px-3 py-1.5 rounded-full mb-8">
            <span class="w-1.5 h-1.5 bg-violet-400 rounded-full animate-pulse"></span>
            No backend required
        </div>

        <h1 class="text-5xl sm:text-6xl font-extrabold tracking-tight text-white leading-tight mb-6">
            Mock APIs in seconds.<br>
            <span class="text-transparent bg-clip-text bg-gradient-to-r from-violet-400 via-indigo-300 to-violet-300">
                Test your frontend without a backend.
            </span>
        </h1>

        <p class="text-base sm:text-lg text-slate-400 max-w-2xl mx-auto mb-10 leading-relaxed">
            Create projects, define your data tables, and instantly get REST API endpoints
            you can hit right away — no server setup, no configuration, no waiting.
        </p>

        <div class="flex flex-col sm:flex-row items-center justify-center gap-4">
            <a href="/dashboard"
               class="inline-flex items-center gap-2 bg-violet-600 hover:bg-violet-500 text-white font-semibold text-sm px-8 py-3.5 rounded-xl transition-all shadow-lg shadow-violet-950/50">
                Get Started →
            </a>
            <a href="#features"
               class="inline-flex items-center gap-2 text-slate-400 hover:text-white text-xs font-semibold transition-colors px-4 py-3">
                See how it works ↓
            </a>
        </div>

        {{-- Mock terminal --}}
        <div class="mt-16 max-w-2xl mx-auto bg-[#0E1117] border border-white/[0.08] rounded-2xl overflow-hidden text-left shadow-2xl shadow-black/80">
            <div class="flex items-center gap-1.5 px-4 py-3 border-b border-white/[0.08] bg-[#0A0C11]">
                <span class="w-3 h-3 rounded-full bg-rose-500/70"></span>
                <span class="w-3 h-3 rounded-full bg-amber-500/70"></span>
                <span class="w-3 h-3 rounded-full bg-emerald-500/70"></span>
                <span class="ml-3 text-xs text-slate-500 font-mono">https://apiflex.test/api/my-app/users</span>
            </div>
            <div class="px-6 py-5 font-mono text-xs sm:text-sm space-y-2 bg-[#0B0D13]">
                <div><span class="text-sky-400 font-bold">GET</span> <span class="text-slate-300">/api/my-app/users</span> <span class="text-slate-500">→ 200 OK</span></div>
                <div><span class="text-emerald-400 font-bold">POST</span> <span class="text-slate-300">/api/my-app/users</span> <span class="text-slate-500">→ 201 Created</span></div>
                <div><span class="text-sky-400 font-bold">GET</span> <span class="text-slate-300">/api/my-app/users/1</span> <span class="text-slate-500">→ 200 OK</span></div>
                <div><span class="text-amber-400 font-bold">PUT</span> <span class="text-slate-300">/api/my-app/users/1</span> <span class="text-slate-500">→ 200 OK</span></div>
                <div><span class="text-rose-400 font-bold">DELETE</span> <span class="text-slate-300">/api/my-app/users/1</span> <span class="text-slate-500">→ 204 No Content</span></div>
            </div>
        </div>
    </section>

    {{-- Features --}}
    <section id="features" class="max-w-6xl mx-auto px-6 py-20">
        <div class="text-center mb-14">
            <h2 class="text-3xl font-bold text-white mb-3 tracking-tight">Everything you need to ship faster</h2>
            <p class="text-slate-400 text-sm">Three simple steps to get your mock API running.</p>
        </div>

        <div class="grid sm:grid-cols-3 gap-6">
            {{-- Card 1 --}}
            <div class="bg-[#141721] border border-white/[0.08] rounded-2xl p-7 hover:border-violet-500/40 transition-all shadow-xs">
                <div class="w-11 h-11 bg-violet-950/60 border border-violet-800/50 rounded-xl flex items-center justify-center mb-5">
                    <svg class="w-6 h-6 text-violet-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.75">
                        <path stroke-linecap="round" stroke-linejoin="round"
                              d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                    </svg>
                </div>
                <h3 class="text-white font-semibold text-base mb-2">Create Tables</h3>
                <p class="text-slate-400 text-xs leading-relaxed">
                    Define your data structures with typed fields — string, number, boolean, email, date.
                    Think of it like your database schema, but in seconds.
                </p>
            </div>

            {{-- Card 2 --}}
            <div class="bg-[#141721] border border-white/[0.08] rounded-2xl p-7 hover:border-violet-500/40 transition-all shadow-xs">
                <div class="w-11 h-11 bg-violet-950/60 border border-violet-800/50 rounded-xl flex items-center justify-center mb-5">
                    <svg class="w-6 h-6 text-violet-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.75">
                        <path stroke-linecap="round" stroke-linejoin="round"
                              d="M8 9l3 3-3 3m5 0h3M5 20h14a2 2 0 002-2V6a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                </div>
                <h3 class="text-white font-semibold text-base mb-2">Generate Routes</h3>
                <p class="text-slate-400 text-xs leading-relaxed">
                    Every table instantly gets all REST endpoints: GET, POST, PUT, DELETE.
                    Protected with your secure project API key.
                </p>
            </div>

            {{-- Card 3 --}}
            <div class="bg-[#141721] border border-white/[0.08] rounded-2xl p-7 hover:border-violet-500/40 transition-all shadow-xs">
                <div class="w-11 h-11 bg-violet-950/60 border border-violet-800/50 rounded-xl flex items-center justify-center mb-5">
                    <svg class="w-6 h-6 text-emerald-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.75">
                        <path stroke-linecap="round" stroke-linejoin="round"
                              d="M13 10V3L4 14h7v7l9-11h-7z" />
                    </svg>
                </div>
                <h3 class="text-white font-semibold text-base mb-2">Postman Tester</h3>
                <p class="text-slate-400 text-xs leading-relaxed">
                    Built-in Postman REST console allows you to execute requests, inspect response codes, format JSON payloads, and view latency in real time.
                </p>
            </div>
        </div>
    </section>

    {{-- CTA --}}
    <section class="border-t border-white/[0.07] py-20 bg-[#0A0C11]/50">
        <div class="max-w-2xl mx-auto text-center px-6">
            <h2 class="text-3xl font-bold text-white mb-4 tracking-tight">Ready to mock your first API?</h2>
            <p class="text-slate-400 text-sm mb-8">It takes less than a minute to create your first project and table.</p>
            <a href="/dashboard"
               class="inline-flex items-center gap-2 bg-violet-600 hover:bg-violet-500 text-white font-semibold text-sm px-8 py-3.5 rounded-xl transition-all shadow-lg shadow-violet-950/50">
                Get Started →
            </a>
        </div>
    </section>

    {{-- Footer --}}
    <footer class="border-t border-white/[0.07] py-6 text-center text-slate-500 text-xs">
        © {{ date('Y') }} ApiFlex. Built for developers, by developers.
    </footer>

</body>
</html>
