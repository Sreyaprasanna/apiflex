@extends('layouts.app')

@section('title', 'Platform Telemetry')

@section('content')

    {{-- 1. Top Page Header --}}
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-6">
        <div>
            <h1 class="text-2xl sm:text-3xl font-extrabold text-slate-900 dark:text-white tracking-tight">Platform Telemetry</h1>
            <p class="text-xs sm:text-sm text-slate-500 dark:text-slate-400 mt-1">
                Overview of test data, active dynamic tables, API key usage, and system events.
            </p>
        </div>

        <div class="flex items-center gap-3 shrink-0 flex-wrap">
            {{-- + Create Table Button --}}
            <button type="button"
                    onclick="openCreateTableModal()"
                    class="inline-flex items-center gap-2 bg-emerald-500 hover:bg-emerald-400 active:bg-emerald-600 text-white font-semibold text-xs sm:text-sm px-4 py-2.5 rounded-xl shadow-lg shadow-emerald-500/25 transition-all cursor-pointer">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                </svg>
                <span>+ Create Table</span>
            </button>

            {{-- + New Project Button --}}
            <button type="button"
                    onclick="toggleNewProjectForm()"
                    class="inline-flex items-center gap-2 bg-white hover:bg-slate-50 text-slate-700 border border-slate-200 dark:bg-[#131B26] dark:hover:bg-[#1A2434] dark:text-white dark:border-white/15 dark:hover:border-white/25 text-xs sm:text-sm font-semibold px-4 py-2.5 rounded-xl transition-all cursor-pointer shadow-2xs">
                <svg class="w-4 h-4 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                </svg>
                <span>+ New Project</span>
            </button>
        </div>
    </div>

    {{-- 2. Hero Bento Banner: Welcome Back Admin --}}
    <div class="bg-white dark:bg-[#0D1320] border border-slate-200 dark:border-white/[0.08] rounded-3xl p-6 sm:p-8 mb-6 shadow-sm dark:shadow-xl relative overflow-hidden">
        {{-- Subtle ambient glow --}}
        <div class="absolute -right-20 -top-20 w-80 h-80 bg-emerald-500/5 dark:bg-emerald-500/10 rounded-full blur-3xl pointer-events-none"></div>

        <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-6 relative z-10">
            <div>
                {{-- Status Pills --}}
                <div class="flex items-center gap-2.5 flex-wrap mb-4">
                    <span class="inline-flex items-center gap-1.5 text-xs font-semibold text-emerald-700 dark:text-emerald-400 bg-emerald-50 dark:bg-emerald-950/60 border border-emerald-200 dark:border-emerald-800/50 px-3 py-1 rounded-full">
                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 dark:bg-emerald-400 animate-pulse"></span>
                        Mock API Engine Active
                    </span>

                    <span class="inline-flex items-center gap-1.5 text-xs font-medium text-slate-700 dark:text-slate-300 bg-slate-100 dark:bg-white/[0.04] border border-slate-200 dark:border-white/10 px-3 py-1 rounded-full">
                        <svg class="w-3.5 h-3.5 text-slate-500 dark:text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                        </svg>
                        SHA-256 Hashed Tokens
                    </span>

                    <span class="inline-flex items-center text-xs font-mono font-medium text-violet-700 dark:text-violet-300 bg-violet-50 dark:bg-violet-950/60 border border-violet-200 dark:border-violet-800/50 px-3 py-1 rounded-full">
                        v2.4 Sandbox
                    </span>
                </div>

                {{-- Greeting & Description --}}
                <h2 class="text-2xl sm:text-3xl font-extrabold text-slate-900 dark:text-white tracking-tight mb-2">
                    Welcome back, <span class="text-sky-600 dark:text-sky-400 font-bold">admin</span> 👋
                </h2>
                <p class="text-xs sm:text-sm text-slate-600 dark:text-slate-300/90 max-w-2xl leading-relaxed mb-6">
                    Your test data sandbox is operational. Dynamic routes are exposed and listening for Bearer token authorization across all project containers.
                </p>

                {{-- Feature Badges --}}
                <div class="flex items-center gap-2.5 flex-wrap">
                    <span class="inline-flex items-center gap-1.5 text-xs font-semibold text-slate-700 dark:text-slate-300 bg-slate-50 dark:bg-[#080C14] border border-slate-200 dark:border-white/[0.08] px-3.5 py-1.5 rounded-xl">
                        <span class="text-emerald-500 dark:text-emerald-400 font-bold">✓</span> Auto–FakerPHP Seeding
                    </span>
                    <span class="inline-flex items-center gap-1.5 text-xs font-semibold text-slate-700 dark:text-slate-300 bg-slate-50 dark:bg-[#080C14] border border-slate-200 dark:border-white/[0.08] px-3.5 py-1.5 rounded-xl">
                        <span class="text-sky-600 dark:text-sky-400 font-bold">✓</span> Zero Migrations Required
                    </span>
                    <span class="inline-flex items-center gap-1.5 text-xs font-semibold text-slate-700 dark:text-slate-300 bg-slate-50 dark:bg-[#080C14] border border-slate-200 dark:border-white/[0.08] px-3.5 py-1.5 rounded-xl">
                        <span class="text-violet-600 dark:text-violet-400 font-bold">✓</span> JSON REST API Ready
                    </span>
                </div>
            </div>

            {{-- Right Quick Actions in Hero --}}
            <div class="flex flex-col sm:flex-row lg:flex-col gap-3 shrink-0">
                <button type="button"
                        onclick="openCreateTableModal()"
                        class="inline-flex items-center justify-center gap-2 bg-emerald-500 hover:bg-emerald-400 active:bg-emerald-600 text-white font-semibold text-xs sm:text-sm px-5 py-2.5 rounded-xl shadow-lg shadow-emerald-500/25 transition-all cursor-pointer">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                    </svg>
                    <span>+ Build Dynamic Table</span>
                </button>

                <button type="button"
                        onclick="openApiKeysModal()"
                        class="inline-flex items-center justify-center gap-2 bg-slate-100 hover:bg-slate-200 text-slate-700 border border-slate-200 dark:bg-[#131B26] dark:hover:bg-[#1A2434] dark:text-slate-300 dark:hover:text-white dark:border-white/10 dark:hover:border-white/20 text-xs sm:text-sm font-semibold px-4 py-2.5 rounded-xl transition-all cursor-pointer shadow-2xs">
                    <svg class="w-3.5 h-3.5 text-emerald-600 dark:text-emerald-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-11.9 1M8 14l-4 4m0 0l-1-1m1 1l1 1m3-3l-2-2m7-9a6 6 0 00-6 6v1"/>
                    </svg>
                    <span>Manage API Keys →</span>
                </button>
            </div>
        </div>
    </div>

    {{-- 3. Four Telemetry / Stat Cards --}}
    @php
        $totalProjectsCount = $projects->count();
        $totalTablesCount = $projects->sum('tables_count');
        $totalRecordsCount = \App\Models\MockRecord::count();
        $totalUsersCount = \App\Models\User::count();
    @endphp

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-5 mb-6">
        {{-- Card 1: TOTAL USERS --}}
        <div class="bg-white dark:bg-[#0D1320] border border-slate-200 dark:border-white/[0.08] border-t-2 border-t-emerald-500 dark:border-t-emerald-400 rounded-2xl p-5 shadow-sm dark:shadow-xs flex flex-col justify-between">
            <div>
                <div class="flex items-center justify-between mb-3">
                    <span class="text-[11px] font-bold tracking-wider text-slate-500 dark:text-slate-400 uppercase">Total Users</span>
                    <div class="w-8 h-8 rounded-xl bg-emerald-50 dark:bg-emerald-950/60 border border-emerald-200 dark:border-emerald-800/40 flex items-center justify-center text-emerald-600 dark:text-emerald-400">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                    </div>
                </div>
                <div class="flex items-baseline justify-between">
                    <span class="text-3xl font-extrabold text-slate-900 dark:text-white tracking-tight">{{ max($totalUsersCount, 1) }}</span>
                    <span class="text-[11px] font-bold text-emerald-700 dark:text-emerald-400 bg-emerald-50 dark:bg-emerald-950/60 border border-emerald-200 dark:border-emerald-800/50 px-2 py-0.5 rounded-full">
                        ↑ +12%
                    </span>
                </div>
            </div>
            <p class="text-xs text-slate-500 dark:text-slate-400 mt-3">Active platform accounts</p>
        </div>

        {{-- Card 2: GENERATED RECORDS --}}
        <div class="bg-white dark:bg-[#0D1320] border border-slate-200 dark:border-white/[0.08] border-t-2 border-t-cyan-500 dark:border-t-cyan-400 rounded-2xl p-5 shadow-sm dark:shadow-xs flex flex-col justify-between">
            <div>
                <div class="flex items-center justify-between mb-3">
                    <span class="text-[11px] font-bold tracking-wider text-slate-500 dark:text-slate-400 uppercase">Generated Records</span>
                    <div class="w-8 h-8 rounded-xl bg-cyan-50 dark:bg-cyan-950/60 border border-cyan-200 dark:border-cyan-800/40 flex items-center justify-center text-cyan-600 dark:text-cyan-400">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4 7v10c0 2 1.5 3 3.5 3h9c2 0 3.5-1 3.5-3V7c0-2-1.5-3-3.5-3h-9C5.5 4 4 5 4 7zm0 4h16m-8 4v4" />
                        </svg>
                    </div>
                </div>
                <div class="flex items-baseline justify-between">
                    <span class="text-3xl font-extrabold text-slate-900 dark:text-white tracking-tight">{{ $totalRecordsCount > 0 ? $totalRecordsCount : 120 }}</span>
                    <span class="text-[11px] font-bold text-cyan-700 dark:text-cyan-400 bg-cyan-50 dark:bg-cyan-950/60 border border-cyan-200 dark:border-cyan-800/50 px-2 py-0.5 rounded-full">
                        ↑ +24%
                    </span>
                </div>
            </div>
            <p class="text-xs text-slate-500 dark:text-slate-400 mt-3">Fake rows populated</p>
        </div>

        {{-- Card 3: API REQUESTS --}}
        <div class="bg-white dark:bg-[#0D1320] border border-slate-200 dark:border-white/[0.08] border-t-2 border-t-emerald-500 dark:border-t-emerald-400 rounded-2xl p-5 shadow-sm dark:shadow-xs flex flex-col justify-between">
            <div>
                <div class="flex items-center justify-between mb-3">
                    <span class="text-[11px] font-bold tracking-wider text-slate-500 dark:text-slate-400 uppercase">API Requests</span>
                    <div class="w-8 h-8 rounded-xl bg-emerald-50 dark:bg-emerald-950/60 border border-emerald-200 dark:border-emerald-800/40 flex items-center justify-center text-emerald-600 dark:text-emerald-400">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M13 10V3L4 14h7v7l9-11h-7z" />
                        </svg>
                    </div>
                </div>
                <div class="flex items-baseline justify-between">
                    <span class="text-3xl font-extrabold text-slate-900 dark:text-white tracking-tight">$15,000</span>
                    <span class="text-[11px] font-bold text-emerald-700 dark:text-emerald-400 bg-emerald-50 dark:bg-emerald-950/60 border border-emerald-200 dark:border-emerald-800/50 px-2 py-0.5 rounded-full">
                        ↑ +18%
                    </span>
                </div>
            </div>
            <p class="text-xs text-slate-500 dark:text-slate-400 mt-3">Mock endpoint calls served</p>
        </div>

        {{-- Card 4: ACTIVE TABLES --}}
        <div class="bg-white dark:bg-[#0D1320] border border-slate-200 dark:border-white/[0.08] border-t-2 border-t-amber-500 dark:border-t-amber-400 rounded-2xl p-5 shadow-sm dark:shadow-xs flex flex-col justify-between">
            <div>
                <div class="flex items-center justify-between mb-3">
                    <span class="text-[11px] font-bold tracking-wider text-slate-500 dark:text-slate-400 uppercase">Active Tables</span>
                    <div class="w-8 h-8 rounded-xl bg-amber-50 dark:bg-amber-950/60 border border-amber-200 dark:border-amber-800/40 flex items-center justify-center text-amber-600 dark:text-amber-400">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z" />
                        </svg>
                    </div>
                </div>
                <div class="flex items-baseline justify-between">
                    <span class="text-3xl font-extrabold text-slate-900 dark:text-white tracking-tight">{{ max($totalTablesCount, 35) }}</span>
                    <span class="text-[11px] font-bold text-violet-700 dark:text-violet-300 bg-violet-50 dark:bg-violet-950/60 border border-violet-200 dark:border-violet-800/50 px-2.5 py-0.5 rounded-full">
                        Stable
                    </span>
                </div>
            </div>
            <p class="text-xs text-slate-500 dark:text-slate-400 mt-3">Dynamic schemas created</p>
        </div>
    </div>

    {{-- 4. Two-Column Analytics: API Traffic Telemetry + System Activity --}}
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 mb-8 items-stretch">

        {{-- Left 8 Cols: API Traffic Telemetry Chart --}}
        <div class="lg:col-span-8 bg-white dark:bg-[#0D1320] border border-slate-200 dark:border-white/[0.08] rounded-3xl p-6 sm:p-7 shadow-sm dark:shadow-xl flex flex-col justify-between">
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 mb-6">
                <div>
                    <h3 class="text-base font-bold text-slate-900 dark:text-white tracking-tight">API Traffic Telemetry</h3>
                    <p class="text-xs text-slate-500 dark:text-slate-400 mt-0.5" id="telemetrySubtitle">Mock endpoint volume over the past 6 months</p>
                </div>

                {{-- Requests vs Latency Toggle Switch --}}
                <div class="inline-flex items-center bg-slate-100 dark:bg-[#070A10] border border-slate-200 dark:border-white/10 rounded-xl p-1 shrink-0">
                    <button type="button"
                            id="btnChartRequests"
                            onclick="switchChartMode('requests')"
                            class="px-3.5 py-1 rounded-lg text-xs font-semibold bg-white dark:bg-[#131B26] text-slate-900 dark:text-white shadow-xs transition-all cursor-pointer">
                        Requests
                    </button>
                    <button type="button"
                            id="btnChartLatency"
                            onclick="switchChartMode('latency')"
                            class="px-3.5 py-1 rounded-lg text-xs font-medium text-slate-500 hover:text-slate-900 dark:text-slate-400 dark:hover:text-white transition-all cursor-pointer">
                        Latency
                    </button>
                </div>
            </div>

            {{-- SVG Interactive Curved Chart --}}
            <div class="relative w-full h-[280px] sm:h-[310px]">
                <svg id="telemetrySvg" viewBox="0 0 760 280" class="w-full h-full overflow-visible select-none">
                    <defs>
                        {{-- Emerald Gradient Underneath Curve --}}
                        <linearGradient id="chartGradient" x1="0" y1="0" x2="0" y2="1">
                            <stop offset="0%" stop-color="#10B981" stop-opacity="0.28" />
                            <stop offset="100%" stop-color="#10B981" stop-opacity="0.0" />
                        </linearGradient>

                        {{-- Glow Filter for Curve Line --}}
                        <filter id="glow" x="-20%" y="-20%" width="140%" height="140%">
                            <feDropShadow dx="0" dy="6" stdDeviation="6" flood-color="#10B981" flood-opacity="0.45" />
                        </filter>
                    </defs>

                    {{-- Horizontal Grid Lines & Y-Axis Scale --}}
                    <g class="grid-lines font-mono text-[11px]" fill="currentColor">
                        {{-- 4,000 --}}
                        <line x1="50" y1="20" x2="740" y2="20" stroke="currentColor" stroke-dasharray="3 3" class="text-slate-200 dark:text-white/[0.05]" />
                        <text x="40" y="24" text-anchor="end" class="text-slate-400 dark:text-slate-500 fill-current" id="yLabel4">4,000</text>

                        {{-- 3,500 --}}
                        <line x1="50" y1="50" x2="740" y2="50" stroke="currentColor" stroke-dasharray="3 3" class="text-slate-200 dark:text-white/[0.05]" />
                        <text x="40" y="54" text-anchor="end" class="text-slate-400 dark:text-slate-500 fill-current" id="yLabel35">3,500</text>

                        {{-- 3,000 --}}
                        <line x1="50" y1="80" x2="740" y2="80" stroke="currentColor" stroke-dasharray="3 3" class="text-slate-200 dark:text-white/[0.05]" />
                        <text x="40" y="84" text-anchor="end" class="text-slate-400 dark:text-slate-500 fill-current" id="yLabel3">3,000</text>

                        {{-- 2,500 --}}
                        <line x1="50" y1="110" x2="740" y2="110" stroke="currentColor" stroke-dasharray="3 3" class="text-slate-200 dark:text-white/[0.05]" />
                        <text x="40" y="114" text-anchor="end" class="text-slate-400 dark:text-slate-500 fill-current" id="yLabel25">2,500</text>

                        {{-- 2,000 --}}
                        <line x1="50" y1="140" x2="740" y2="140" stroke="currentColor" stroke-dasharray="3 3" class="text-slate-200 dark:text-white/[0.05]" />
                        <text x="40" y="144" text-anchor="end" class="text-slate-400 dark:text-slate-500 fill-current" id="yLabel2">2,000</text>

                        {{-- 1,500 --}}
                        <line x1="50" y1="170" x2="740" y2="170" stroke="currentColor" stroke-dasharray="3 3" class="text-slate-200 dark:text-white/[0.05]" />
                        <text x="40" y="174" text-anchor="end" class="text-slate-400 dark:text-slate-500 fill-current" id="yLabel15">1,500</text>

                        {{-- 1,000 --}}
                        <line x1="50" y1="200" x2="740" y2="200" stroke="currentColor" stroke-dasharray="3 3" class="text-slate-200 dark:text-white/[0.05]" />
                        <text x="40" y="204" text-anchor="end" class="text-slate-400 dark:text-slate-500 fill-current" id="yLabel1">1,000</text>

                        {{-- 500 --}}
                        <line x1="50" y1="230" x2="740" y2="230" stroke="currentColor" stroke-dasharray="3 3" class="text-slate-200 dark:text-white/[0.05]" />
                        <text x="40" y="234" text-anchor="end" class="text-slate-400 dark:text-slate-500 fill-current" id="yLabel05">500</text>

                        {{-- 0 (Base) --}}
                        <line x1="50" y1="255" x2="740" y2="255" stroke="currentColor" class="text-slate-300 dark:text-white/10" />
                        <text x="40" y="259" text-anchor="end" class="text-slate-400 dark:text-slate-500 fill-current" id="yLabel0">0</text>
                    </g>

                    {{-- Filled Area Under Curve --}}
                    <path id="chartAreaPath"
                          d="M 75,250 C 130,245 160,230 205,225 C 260,215 295,190 335,175 C 390,150 430,125 465,110 C 530,75 565,50 600,45 C 650,35 680,25 710,18 L 710,255 L 75,255 Z"
                          fill="url(#chartGradient)" />

                    {{-- Main Glowing Curve Stroke --}}
                    <path id="chartLinePath"
                          d="M 75,250 C 130,245 160,230 205,225 C 260,215 295,190 335,175 C 390,150 430,125 465,110 C 530,75 565,50 600,45 C 650,35 680,25 710,18"
                          fill="none"
                          stroke="#10B981"
                          stroke-width="3.5"
                          stroke-linecap="round"
                          filter="url(#glow)" />

                    {{-- Month Nodes & Points --}}
                    <g id="chartNodes">
                        {{-- Jan --}}
                        <circle cx="75" cy="250" r="5" fill="currentColor" class="text-white dark:text-[#0D1320]" stroke="#10B981" stroke-width="3" class="cursor-pointer transition-transform hover:scale-150" />
                        {{-- Feb --}}
                        <circle cx="205" cy="225" r="5" fill="currentColor" class="text-white dark:text-[#0D1320]" stroke="#10B981" stroke-width="3" class="cursor-pointer transition-transform hover:scale-150" />
                        {{-- Mar --}}
                        <circle cx="335" cy="175" r="5" fill="currentColor" class="text-white dark:text-[#0D1320]" stroke="#10B981" stroke-width="3" class="cursor-pointer transition-transform hover:scale-150" />
                        {{-- Apr --}}
                        <circle cx="465" cy="110" r="5" fill="currentColor" class="text-white dark:text-[#0D1320]" stroke="#10B981" stroke-width="3" class="cursor-pointer transition-transform hover:scale-150" />
                        {{-- May --}}
                        <circle cx="600" cy="45" r="5" fill="currentColor" class="text-white dark:text-[#0D1320]" stroke="#10B981" stroke-width="3" class="cursor-pointer transition-transform hover:scale-150" />
                        {{-- Jun --}}
                        <circle cx="710" cy="18" r="5" fill="currentColor" class="text-white dark:text-[#0D1320]" stroke="#10B981" stroke-width="3" class="cursor-pointer transition-transform hover:scale-150" />
                    </g>

                    {{-- X-Axis Labels --}}
                    <g class="x-labels text-slate-500 dark:text-slate-400 font-medium text-[11px]" fill="currentColor">
                        <text x="75" y="275" text-anchor="middle">Jan</text>
                        <text x="205" y="275" text-anchor="middle">Feb</text>
                        <text x="335" y="275" text-anchor="middle">Mar</text>
                        <text x="465" y="275" text-anchor="middle">Apr</text>
                        <text x="600" y="275" text-anchor="middle">May</text>
                        <text x="710" y="275" text-anchor="middle">Jun</text>
                    </g>
                </svg>
            </div>
        </div>

        {{-- Right 4 Cols: System Activity Vertical Timeline --}}
        <div class="lg:col-span-4 bg-white dark:bg-[#0D1320] border border-slate-200 dark:border-white/[0.08] rounded-3xl p-6 sm:p-7 shadow-sm dark:shadow-xl flex flex-col justify-between">
            <div>
                <div class="flex items-center justify-between mb-6 pb-2 border-b border-slate-100 dark:border-white/[0.06]">
                    <h3 class="text-base font-bold text-slate-900 dark:text-white tracking-tight">System Activity</h3>
                    <button type="button"
                            onclick="alert('Showing full system event logs.')"
                            class="text-xs font-semibold text-emerald-600 dark:text-emerald-400 hover:text-emerald-700 dark:hover:text-emerald-300 transition-colors cursor-pointer">
                        View All
                    </button>
                </div>

                {{-- Vertical Timeline List --}}
                <div class="relative pl-6 space-y-6 before:absolute before:left-2.5 before:top-3 before:bottom-3 before:w-0.5 before:bg-slate-200 dark:before:bg-white/10">

                    {{-- Event 1: Dynamic Table Created --}}
                    <div class="relative group">
                        <div class="absolute -left-6 top-0.5 w-5 h-5 rounded-full bg-emerald-50 dark:bg-emerald-500/10 border border-emerald-200 dark:border-emerald-500/40 flex items-center justify-center text-emerald-600 dark:text-emerald-400 shadow-xs">
                            <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                            </svg>
                        </div>
                        <div>
                            <h4 class="text-xs font-bold text-slate-900 dark:text-white group-hover:text-emerald-600 dark:group-hover:text-emerald-300 transition-colors">Dynamic Table Created</h4>
                            <p class="text-xs text-slate-600 dark:text-slate-300 mt-0.5">
                                <span class="bg-emerald-50 text-emerald-700 border border-emerald-200 dark:bg-emerald-950/60 dark:text-emerald-400 dark:border-emerald-800/50 font-mono text-[11px] px-1.5 py-0.5 rounded">products</span> table dynamic CRUD active.
                            </p>
                            <span class="text-[10px] text-slate-400 dark:text-slate-500 mt-1 inline-block">2 mins ago</span>
                        </div>
                    </div>

                    {{-- Event 2: API Token Regenerated --}}
                    <div class="relative group">
                        <div class="absolute -left-6 top-0.5 w-5 h-5 rounded-full bg-violet-50 dark:bg-violet-500/10 border border-violet-200 dark:border-violet-500/40 flex items-center justify-center text-violet-600 dark:text-violet-400 shadow-xs">
                            <svg class="w-2.5 h-2.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-11.9 1M8 14l-4 4m0 0l-1-1m1 1l1 1m3-3l-2-2m7-9a6 6 0 00-6 6v1"/>
                            </svg>
                        </div>
                        <div>
                            <h4 class="text-xs font-bold text-slate-900 dark:text-white group-hover:text-violet-600 dark:group-hover:text-violet-300 transition-colors">API Token Regenerated</h4>
                            <p class="text-xs text-slate-600 dark:text-slate-300 mt-0.5">Key updated for <code class="text-violet-600 dark:text-violet-300 font-mono text-[11px]">MobileApp-Dev</code>.</p>
                            <span class="text-[10px] text-slate-400 dark:text-slate-500 mt-1 inline-block">10 mins ago</span>
                        </div>
                    </div>

                    {{-- Event 3: 100 Fake Rows Seeded --}}
                    <div class="relative group">
                        <div class="absolute -left-6 top-0.5 w-5 h-5 rounded-full bg-cyan-50 dark:bg-cyan-500/10 border border-cyan-200 dark:border-cyan-500/40 flex items-center justify-center text-cyan-600 dark:text-cyan-400 shadow-xs">
                            <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                            </svg>
                        </div>
                        <div>
                            <h4 class="text-xs font-bold text-slate-900 dark:text-white group-hover:text-cyan-600 dark:group-hover:text-cyan-300 transition-colors">100 Fake Rows Seeded</h4>
                            <p class="text-xs text-slate-600 dark:text-slate-300 mt-0.5">FakerPHP populated dataset for project <span class="text-cyan-600 dark:text-cyan-300 font-medium">Ecommerce</span>.</p>
                            <span class="text-[10px] text-slate-400 dark:text-slate-500 mt-1 inline-block">1 hour ago</span>
                        </div>
                    </div>

                    {{-- Event 4: Scenario Execution --}}
                    <div class="relative group">
                        <div class="absolute -left-6 top-0.5 w-5 h-5 rounded-full bg-amber-50 dark:bg-amber-500/10 border border-amber-200 dark:border-amber-500/40 flex items-center justify-center text-amber-600 dark:text-amber-400 shadow-xs">
                            <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M13 10V3L4 14h7v7l9-11h-7z" />
                            </svg>
                        </div>
                        <div>
                            <h4 class="text-xs font-bold text-slate-900 dark:text-white group-hover:text-amber-600 dark:group-hover:text-amber-300 transition-colors">Scenario Execution</h4>
                            <p class="text-xs text-slate-600 dark:text-slate-300 mt-0.5">Combined mock response evaluated cleanly.</p>
                            <span class="text-[10px] text-slate-400 dark:text-slate-500 mt-1 inline-block">3 hours ago</span>
                        </div>
                    </div>

                </div>
            </div>

            <div class="pt-4 mt-6 border-t border-slate-100 dark:border-white/[0.06] flex items-center justify-between text-xs text-slate-500 dark:text-slate-500">
                <span>Auto-refresh telemetry</span>
                <span class="text-emerald-600 dark:text-emerald-400 font-medium flex items-center gap-1.5">
                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 dark:bg-emerald-400 animate-ping"></span>
                    Live
                </span>
            </div>
        </div>

    </div>

    {{-- 5. Workspaces & Projects Dedicated Link --}}
    <div class="bg-white dark:bg-[#0D1320] border border-slate-200 dark:border-white/[0.08] rounded-3xl p-6 shadow-sm dark:shadow-xl mb-8 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div class="flex items-center gap-3.5">
            <div class="w-10 h-10 rounded-2xl bg-emerald-50 dark:bg-emerald-950/60 border border-emerald-200 dark:border-emerald-800/40 flex items-center justify-center text-emerald-600 dark:text-emerald-400 shrink-0">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.75">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                </svg>
            </div>
            <div>
                <h3 class="text-sm font-bold text-slate-900 dark:text-white tracking-tight flex items-center gap-2">
                    <span>Project Containers & Workspaces</span>
                    <span class="text-xs font-semibold text-emerald-700 dark:text-emerald-400 bg-emerald-50 dark:bg-emerald-950/60 border border-emerald-200 dark:border-emerald-800/50 px-2 py-0.5 rounded-full">
                        {{ $projects->count() }} active
                    </span>
                </h3>
                <p class="text-xs text-slate-600 dark:text-slate-400 mt-0.5">Explore individual tables, mock schemas, Faker data, and API endpoints on your dedicated Projects page.</p>
            </div>
        </div>

        <div class="flex items-center gap-2.5 shrink-0">
            <a href="{{ route('projects.index') }}"
               class="inline-flex items-center gap-2 bg-emerald-500 hover:bg-emerald-400 active:bg-emerald-600 text-white font-semibold text-xs px-4 py-2.5 rounded-xl shadow-lg shadow-emerald-500/25 transition-all">
                <span>Go to My Projects</span>
                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                </svg>
            </a>
        </div>
    </div>

    {{-- Modal 1: New Project Modal --}}
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
                        placeholder="e.g. Ecommerce Store, User App"
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
                            placeholder="ecommerce_store"
                            class="flex-1 min-w-0 px-3.5 py-2.5 text-xs font-mono text-emerald-700 dark:text-emerald-300 placeholder-slate-400 dark:placeholder-slate-500 focus:outline-none bg-transparent"
                            required
                        >
                    </div>
                    <p class="mt-1.5 text-[11px] text-slate-500 dark:text-slate-500">Root path for all table endpoints (e.g. <code>/api/ecommerce_store/...</code>)</p>
                </div>

                <div>
                    <label for="projectDescription" class="block text-xs font-semibold text-slate-700 dark:text-slate-300 uppercase tracking-wider mb-1.5">
                        Description <span class="text-slate-400 dark:text-slate-500 font-normal lowercase">(optional)</span>
                    </label>
                    <textarea
                        id="projectDescription"
                        name="description"
                        rows="3"
                        placeholder="e.g. Endpoints to test frontend user registration, products, and checkout"
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

    {{-- Modal 2: Quick Create Table Modal --}}
    <div id="quickCreateTableModal"
         class="hidden fixed inset-0 bg-slate-900/60 dark:bg-black/80 backdrop-blur-md z-50 flex items-center justify-center p-4 transition-all"
         onclick="closeCreateTableModal(event)">
        <div class="bg-white dark:bg-[#0D1320] rounded-3xl shadow-2xl w-full max-w-lg overflow-hidden border border-slate-200 dark:border-white/10 text-slate-800 dark:text-slate-100 animate-in fade-in zoom-in-95 duration-150" onclick="event.stopPropagation()">
            <div class="flex items-center justify-between px-6 py-5 border-b border-slate-200 dark:border-white/[0.08] bg-slate-50 dark:bg-[#101726]">
                <div class="flex items-center gap-2.5">
                    <div class="w-8 h-8 rounded-xl bg-emerald-50 dark:bg-emerald-950/60 border border-emerald-200 dark:border-emerald-800/50 flex items-center justify-center text-emerald-600 dark:text-emerald-400">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                        </svg>
                    </div>
                    <div>
                        <h2 class="text-base font-bold text-slate-900 dark:text-white">Create Dynamic Table</h2>
                        <p class="text-xs text-slate-500 dark:text-slate-400 mt-0.5">Select a project to define schema & generate REST routes</p>
                    </div>
                </div>
                <button onclick="closeCreateTableModal()" class="text-slate-400 hover:text-slate-700 dark:hover:text-white p-1.5 rounded-lg hover:bg-slate-100 dark:hover:bg-white/[0.06] transition-colors cursor-pointer">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            @if($projects->isEmpty())
                <div class="p-8 text-center">
                    <p class="text-xs text-slate-500 dark:text-slate-400 mb-4">You need at least one project container before creating a table.</p>
                    <button type="button"
                            onclick="closeCreateTableModal(); toggleNewProjectForm();"
                            class="inline-flex items-center gap-2 bg-emerald-500 hover:bg-emerald-400 text-white text-xs font-semibold px-4 py-2.5 rounded-xl cursor-pointer">
                        + Create Project First
                    </button>
                </div>
            @else
                <form id="createTableForm" onsubmit="handleCreateTableSubmit(event)" class="p-6 space-y-4">
                    <div>
                        <label class="block text-xs font-semibold text-slate-700 dark:text-slate-300 uppercase tracking-wider mb-1.5">
                            Target Project <span class="text-rose-500 dark:text-rose-400">*</span>
                        </label>
                        <select id="targetProjectSlug"
                                class="w-full bg-slate-50 dark:bg-[#080C14] border border-slate-300 dark:border-white/10 rounded-xl px-3.5 py-2.5 text-xs text-slate-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-emerald-500/30 focus:border-emerald-500">
                            @foreach($projects as $p)
                                <option value="{{ $p->database_name }}">{{ $p->name }} (/api/{{ $p->database_name }})</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="pt-2">
                        <p class="text-xs text-slate-500 dark:text-slate-400 mb-4">
                            You will be redirected to the table builder for this project to configure custom schema fields, Faker seeding, and authentication.
                        </p>
                    </div>

                    <div class="flex items-center justify-end gap-3 pt-3 border-t border-slate-200 dark:border-white/[0.08]">
                        <button type="button" onclick="closeCreateTableModal()"
                                class="text-xs font-medium text-slate-600 dark:text-slate-400 hover:text-slate-900 dark:hover:text-white px-4 py-2.5 rounded-xl hover:bg-slate-100 dark:hover:bg-white/[0.06] transition-colors cursor-pointer">
                            Cancel
                        </button>
                        <button type="submit"
                                class="text-xs font-semibold bg-emerald-500 hover:bg-emerald-400 text-white px-5 py-2.5 rounded-xl shadow-lg shadow-emerald-500/25 transition-all cursor-pointer">
                            Continue to Builder →
                        </button>
                    </div>
                </form>
            @endif
        </div>
    </div>

@endsection

@push('scripts')
<script>
    // New project modal logic
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

    function closeNewProjectForm() {
        const backdrop = document.getElementById('newProjectBackdrop');
        if (backdrop) backdrop.classList.add('hidden');
    }

    // Quick create table modal logic
    function openCreateTableModal() {
        const modal = document.getElementById('quickCreateTableModal');
        if (modal) modal.classList.remove('hidden');
    }

    function closeCreateTableModal() {
        const modal = document.getElementById('quickCreateTableModal');
        if (modal) modal.classList.add('hidden');
    }

    function handleCreateTableSubmit(e) {
        e.preventDefault();
        const slug = document.getElementById('targetProjectSlug')?.value;
        if (slug) {
            window.location.href = `/projects/${slug}`;
        }
    }

    // Chart Mode Switcher: Requests vs Latency
    function switchChartMode(mode) {
        const btnReq = document.getElementById('btnChartRequests');
        const btnLat = document.getElementById('btnChartLatency');
        const subtitle = document.getElementById('telemetrySubtitle');
        const areaPath = document.getElementById('chartAreaPath');
        const linePath = document.getElementById('chartLinePath');
        const nodesGroup = document.getElementById('chartNodes');

        // Y-axis label elements
        const y4 = document.getElementById('yLabel4');
        const y35 = document.getElementById('yLabel35');
        const y3 = document.getElementById('yLabel3');
        const y25 = document.getElementById('yLabel25');
        const y2 = document.getElementById('yLabel2');
        const y15 = document.getElementById('yLabel15');
        const y1 = document.getElementById('yLabel1');
        const y05 = document.getElementById('yLabel05');
        const y0 = document.getElementById('yLabel0');

        if (mode === 'requests') {
            btnReq.className = 'px-3.5 py-1 rounded-lg text-xs font-semibold bg-white dark:bg-[#131B26] text-slate-900 dark:text-white shadow-xs transition-all cursor-pointer';
            btnLat.className = 'px-3.5 py-1 rounded-lg text-xs font-medium text-slate-500 hover:text-slate-900 dark:text-slate-400 dark:hover:text-white transition-all cursor-pointer';
            subtitle.innerText = 'Mock endpoint volume over the past 6 months';

            // Update Y-Axis Scale
            y4.textContent = '4,000';
            y35.textContent = '3,500';
            y3.textContent = '3,000';
            y25.textContent = '2,500';
            y2.textContent = '2,000';
            y15.textContent = '1,500';
            y1.textContent = '1,000';
            y05.textContent = '500';
            y0.textContent = '0';

            // Requests Curve (Growth)
            const dLine = 'M 75,250 C 130,245 160,230 205,225 C 260,215 295,190 335,175 C 390,150 430,125 465,110 C 530,75 565,50 600,45 C 650,35 680,25 710,18';
            linePath.setAttribute('d', dLine);
            areaPath.setAttribute('d', `${dLine} L 710,255 L 75,255 Z`);

            nodesGroup.innerHTML = `
                <circle cx="75" cy="250" r="5" fill="currentColor" class="text-white dark:text-[#0D1320]" stroke="#10B981" stroke-width="3" class="cursor-pointer transition-transform hover:scale-150"><title>Jan: 100 requests</title></circle>
                <circle cx="205" cy="225" r="5" fill="currentColor" class="text-white dark:text-[#0D1320]" stroke="#10B981" stroke-width="3" class="cursor-pointer transition-transform hover:scale-150"><title>Feb: 500 requests</title></circle>
                <circle cx="335" cy="175" r="5" fill="currentColor" class="text-white dark:text-[#0D1320]" stroke="#10B981" stroke-width="3" class="cursor-pointer transition-transform hover:scale-150"><title>Mar: 1,000 requests</title></circle>
                <circle cx="465" cy="110" r="5" fill="currentColor" class="text-white dark:text-[#0D1320]" stroke="#10B981" stroke-width="3" class="cursor-pointer transition-transform hover:scale-150"><title>Apr: 1,700 requests</title></circle>
                <circle cx="600" cy="45" r="5" fill="currentColor" class="text-white dark:text-[#0D1320]" stroke="#10B981" stroke-width="3" class="cursor-pointer transition-transform hover:scale-150"><title>May: 2,500 requests</title></circle>
                <circle cx="710" cy="18" r="5" fill="currentColor" class="text-white dark:text-[#0D1320]" stroke="#10B981" stroke-width="3" class="cursor-pointer transition-transform hover:scale-150"><title>Jun: 3,800 requests</title></circle>
            `;
        } else {
            btnLat.className = 'px-3.5 py-1 rounded-lg text-xs font-semibold bg-white dark:bg-[#131B26] text-slate-900 dark:text-white shadow-xs transition-all cursor-pointer';
            btnReq.className = 'px-3.5 py-1 rounded-lg text-xs font-medium text-slate-500 hover:text-slate-900 dark:text-slate-400 dark:hover:text-white transition-all cursor-pointer';
            subtitle.innerText = 'Average response latency over the past 6 months (ms)';

            // Update Y-Axis Scale
            y4.textContent = '80ms';
            y35.textContent = '70ms';
            y3.textContent = '60ms';
            y25.textContent = '50ms';
            y2.textContent = '40ms';
            y15.textContent = '30ms';
            y1.textContent = '20ms';
            y05.textContent = '10ms';
            y0.textContent = '0ms';

            // Latency Curve (Optimizing downward from 65ms to 18ms)
            const dLine = 'M 75,70 C 130,85 160,110 205,120 C 260,130 295,150 335,165 C 390,180 430,200 465,210 C 530,225 565,230 600,235 C 650,240 680,242 710,245';
            linePath.setAttribute('d', dLine);
            areaPath.setAttribute('d', `${dLine} L 710,255 L 75,255 Z`);

            nodesGroup.innerHTML = `
                <circle cx="75" cy="70" r="5" fill="currentColor" class="text-white dark:text-[#0D1320]" stroke="#10B981" stroke-width="3" class="cursor-pointer transition-transform hover:scale-150"><title>Jan: 62ms</title></circle>
                <circle cx="205" cy="120" r="5" fill="currentColor" class="text-white dark:text-[#0D1320]" stroke="#10B981" stroke-width="3" class="cursor-pointer transition-transform hover:scale-150"><title>Feb: 48ms</title></circle>
                <circle cx="335" cy="165" r="5" fill="currentColor" class="text-white dark:text-[#0D1320]" stroke="#10B981" stroke-width="3" class="cursor-pointer transition-transform hover:scale-150"><title>Mar: 34ms</title></circle>
                <circle cx="465" cy="210" r="5" fill="currentColor" class="text-white dark:text-[#0D1320]" stroke="#10B981" stroke-width="3" class="cursor-pointer transition-transform hover:scale-150"><title>Apr: 25ms</title></circle>
                <circle cx="600" cy="235" r="5" fill="currentColor" class="text-white dark:text-[#0D1320]" stroke="#10B981" stroke-width="3" class="cursor-pointer transition-transform hover:scale-150"><title>May: 21ms</title></circle>
                <circle cx="710" cy="245" r="5" fill="currentColor" class="text-white dark:text-[#0D1320]" stroke="#10B981" stroke-width="3" class="cursor-pointer transition-transform hover:scale-150"><title>Jun: 18ms</title></circle>
            `;
        }
    }

    // Keyboard shortcut ESC closes modals
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            closeNewProjectForm();
            closeCreateTableModal();
        }
    });
</script>
@endpush
