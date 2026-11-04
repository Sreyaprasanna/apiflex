@extends('layouts.app')

@section('title', $project->name)

@section('header-actions')
    <div class="flex items-center gap-3">
        <button onclick="toggleAddTableForm()"
                class="inline-flex items-center gap-2 bg-indigo-600 hover:bg-indigo-500 text-white text-sm font-semibold px-4 py-2.5 rounded-xl shadow-xs hover:shadow transition-all">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
            </svg>
            Add Table
        </button>
    </div>
@endsection

@section('content')

    {{-- Breadcrumb --}}
    <nav class="flex items-center gap-2 text-sm text-slate-400 mb-6">
        <a href="{{ route('dashboard') }}" class="hover:text-indigo-600 font-medium transition-colors">Dashboard</a>
        <svg class="w-4 h-4 text-slate-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
        </svg>
        <span class="text-slate-800 font-semibold">{{ $project->name }}</span>
    </nav>

    {{-- Project Header / Base URL banner --}}
    <div class="bg-white border border-slate-200 rounded-2xl p-6 mb-8 shadow-xs">
        <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-4">
            <div>
                <div class="flex items-center gap-3 flex-wrap">
                    <h2 class="text-xl font-bold text-slate-900">{{ $project->name }}</h2>
                    <span class="text-xs font-mono font-medium text-indigo-700 bg-indigo-50 border border-indigo-100 px-2.5 py-1 rounded-lg">
                        db: {{ $project->database_name }}
                    </span>
                </div>
                @if($project->description)
                    <p class="text-sm text-slate-500 mt-1 max-w-2xl leading-relaxed">{{ $project->description }}</p>
                @endif
            </div>

            <div class="flex items-center gap-2">
                <form action="{{ route('projects.destroy', $project->database_name) }}" method="POST"
                      onsubmit="return confirm('Are you sure you want to delete this project and all its tables?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="text-xs font-medium text-red-600 hover:text-red-700 border border-red-200 hover:border-red-300 bg-red-50/50 hover:bg-red-50 px-3 py-2 rounded-xl transition-colors">
                        Delete Project
                    </button>
                </form>
            </div>
        </div>

        {{-- Base URL Bar --}}
        <div class="mt-5 pt-5 border-t border-slate-100 flex flex-col sm:flex-row sm:items-center justify-between gap-3 bg-slate-900 text-white rounded-xl px-4 py-3">
            <div class="flex items-center gap-3 overflow-hidden">
                <span class="text-xs font-bold uppercase tracking-wider text-slate-400 shrink-0">API Base URL:</span>
                <code class="text-sm text-indigo-300 font-mono truncate select-all" id="baseUrlText">{{ url('/api/' . $project->database_name) }}/</code>
            </div>
            <button onclick="copyToClipboard('{{ url('/api/' . $project->database_name) }}/')"
                    class="shrink-0 self-start sm:self-auto text-xs font-semibold text-slate-200 hover:text-white bg-slate-800 hover:bg-slate-700 border border-slate-700 px-3 py-1.5 rounded-lg transition-colors flex items-center gap-1.5">
                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z" />
                </svg>
                Copy Base URL
            </button>
        </div>
    </div>

    {{-- Add Table Modal --}}
    <div id="addTableBackdrop"
         class="hidden fixed inset-0 bg-slate-950/70 backdrop-blur-sm z-50 flex items-center justify-center p-4 transition-all"
         onclick="closeAddTableForm(event)">
        <div class="bg-white rounded-2xl shadow-2xl w-full max-w-xl mx-4 overflow-hidden border border-slate-100 max-h-[90vh] flex flex-col animate-in fade-in zoom-in-95 duration-150" onclick="event.stopPropagation()">
            <div class="flex items-center justify-between px-6 py-5 border-b border-slate-100 bg-slate-50/50 shrink-0">
                <div>
                    <h2 class="text-base font-semibold text-slate-900">Create Table & Fields</h2>
                    <p class="text-xs text-slate-500 mt-0.5">Specify table name and the fields your frontend form sends</p>
                </div>
                <button onclick="closeAddTableForm()" class="text-slate-400 hover:text-slate-600 p-1 rounded-lg hover:bg-slate-100 transition-colors">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <form action="{{ route('projects.tables.store', $project->database_name) }}" method="POST" class="flex-1 overflow-y-auto p-6 space-y-5">
                @csrf
                <div>
                    <label for="tableName" class="block text-xs font-semibold uppercase tracking-wider text-slate-700 mb-1.5">
                        Table Name <span class="text-red-500">*</span>
                    </label>
                    <input
                        type="text"
                        id="tableName"
                        name="name"
                        placeholder="e.g. users, registrations, products, orders"
                        class="w-full border border-slate-200 rounded-xl px-3.5 py-2.5 text-sm text-slate-800 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition"
                        required
                        autofocus
                    >
                    <p class="mt-1 text-xs text-slate-400">Routes will be generated at <code>/api/{{ $project->database_name }}/<span id="tableSlugPreview">your_table</span></code></p>
                </div>

                <div>
                    <div class="flex items-center justify-between mb-2">
                        <label class="block text-xs font-semibold uppercase tracking-wider text-slate-700">
                            Table Fields / Form Inputs
                        </label>
                        <span class="text-xs text-slate-400">(Auto-includes <code>id</code> & timestamps)</span>
                    </div>

                    {{-- Field rows container --}}
                    <div id="fieldRows" class="space-y-2.5">
                        {{-- Row 0 --}}
                        <div class="field-row flex items-center gap-2 p-2.5 bg-slate-50/70 border border-slate-200 rounded-xl">
                            <input
                                type="text"
                                name="fields[0][name]"
                                placeholder="Field name (e.g. name)"
                                class="flex-1 min-w-0 border border-slate-200 bg-white rounded-lg px-3 py-2 text-sm text-slate-800 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500"
                                required
                            >
                            <select
                                name="fields[0][type]"
                                class="border border-slate-200 bg-white rounded-lg px-3 py-2 text-sm text-slate-700 focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500"
                            >
                                <option value="string">String</option>
                                <option value="email">Email</option>
                                <option value="number">Number</option>
                                <option value="boolean">Boolean</option>
                                <option value="date">Date</option>
                                <option value="text">Long Text</option>
                            </select>
                            <label class="flex items-center gap-1.5 text-xs text-slate-600 shrink-0 cursor-pointer px-1">
                                <input type="checkbox" name="fields[0][required]" value="1" class="rounded border-slate-300 text-indigo-600 focus:ring-indigo-500">
                                <span>Req</span>
                            </label>
                            <button type="button" onclick="removeFieldRow(this)"
                                    class="text-slate-300 hover:text-red-500 transition-colors p-1.5 rounded-lg hover:bg-white shrink-0">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>
                        </div>

                        {{-- Row 1 --}}
                        <div class="field-row flex items-center gap-2 p-2.5 bg-slate-50/70 border border-slate-200 rounded-xl">
                            <input
                                type="text"
                                name="fields[1][name]"
                                placeholder="Field name (e.g. email)"
                                value="email"
                                class="flex-1 min-w-0 border border-slate-200 bg-white rounded-lg px-3 py-2 text-sm text-slate-800 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500"
                            >
                            <select
                                name="fields[1][type]"
                                class="border border-slate-200 bg-white rounded-lg px-3 py-2 text-sm text-slate-700 focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500"
                            >
                                <option value="string">String</option>
                                <option value="email" selected>Email</option>
                                <option value="number">Number</option>
                                <option value="boolean">Boolean</option>
                                <option value="date">Date</option>
                                <option value="text">Long Text</option>
                            </select>
                            <label class="flex items-center gap-1.5 text-xs text-slate-600 shrink-0 cursor-pointer px-1">
                                <input type="checkbox" name="fields[1][required]" value="1" checked class="rounded border-slate-300 text-indigo-600 focus:ring-indigo-500">
                                <span>Req</span>
                            </label>
                            <button type="button" onclick="removeFieldRow(this)"
                                    class="text-slate-300 hover:text-red-500 transition-colors p-1.5 rounded-lg hover:bg-white shrink-0">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>
                        </div>
                    </div>

                    <button type="button" onclick="addFieldRow()"
                            class="mt-3 inline-flex items-center gap-1.5 text-xs font-semibold text-indigo-600 hover:text-indigo-700 bg-indigo-50 hover:bg-indigo-100/70 border border-indigo-100 px-3 py-2 rounded-xl transition-colors">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                        </svg>
                        Add Another Field
                    </button>
                </div>

                <div class="flex items-center justify-end gap-3 pt-4 border-t border-slate-100">
                    <button type="button" onclick="closeAddTableForm()"
                            class="text-sm font-medium text-slate-600 hover:text-slate-800 px-4 py-2 rounded-xl hover:bg-slate-100 transition-colors">
                        Cancel
                    </button>
                    <button type="submit"
                            class="text-sm font-semibold bg-indigo-600 hover:bg-indigo-500 text-white px-5 py-2.5 rounded-xl shadow-xs transition-colors">
                        Generate Table & Routes
                    </button>
                </div>
            </form>
        </div>
    </div>

    {{-- Tables Section --}}
    <div class="flex items-center justify-between mb-4">
        <div>
            <h3 class="text-base font-semibold text-slate-900 flex items-center gap-2">
                Tables & Endpoints
                <span class="text-xs font-semibold text-indigo-600 bg-indigo-50 border border-indigo-100 px-2 py-0.5 rounded-full">
                    {{ $tables->count() }}
                </span>
            </h3>
            <p class="text-xs text-slate-500 mt-0.5">Each table automatically provides 5 REST routes (GET, GET by ID, POST, PUT, DELETE).</p>
        </div>
    </div>

    @if($tables->isEmpty())
        <div class="flex flex-col items-center justify-center py-16 px-4 text-center bg-white border border-dashed border-slate-300 rounded-2xl">
            <div class="w-14 h-14 bg-indigo-50 rounded-2xl flex items-center justify-center mb-4 text-indigo-500">
                <svg class="w-7 h-7" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.75">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          d="M3 10h18M3 14h18m-9-4v8m-7 0h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z" />
                </svg>
            </div>
            <h4 class="text-base font-bold text-slate-800 mb-1">No tables in this project yet</h4>
            <p class="text-xs text-slate-500 mb-5 max-w-sm leading-relaxed">
                Add a table (e.g. <code>users</code> with <code>name</code> and <code>email</code> fields) to generate your mock API endpoints.
            </p>
            <button onclick="toggleAddTableForm()"
                    class="inline-flex items-center gap-2 bg-indigo-600 hover:bg-indigo-500 text-white text-sm font-semibold px-4 py-2.5 rounded-xl shadow-xs transition-all">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                </svg>
                Create First Table
            </button>
        </div>
    @else
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5">
            @foreach($tables as $table)
            <div class="bg-white border border-slate-200 rounded-2xl p-5 hover:shadow-md hover:border-indigo-200 transition-all flex flex-col justify-between group">
                <div>
                    <div class="flex items-start justify-between mb-3">
                        <div class="w-10 h-10 bg-violet-50 border border-violet-100 rounded-xl flex items-center justify-center text-violet-600">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.75">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                      d="M3 10h18M3 14h18m-9-4v8m-7 0h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z" />
                            </svg>
                        </div>
                        <span class="inline-flex items-center gap-1 text-xs font-semibold text-emerald-700 bg-emerald-50 border border-emerald-100 px-2 py-0.5 rounded-md">
                            5 Routes Active
                        </span>
                    </div>

                    <h4 class="font-bold text-slate-900 text-base mb-1 group-hover:text-indigo-600 transition-colors">
                        {{ $table->name }}
                    </h4>

                    <div class="mb-3">
                        <span class="text-xs font-mono text-slate-500 bg-slate-50 px-2 py-0.5 rounded border border-slate-200">
                            /api/{{ $project->database_name }}/{{ $table->slug }}
                        </span>
                    </div>

                    {{-- Fields preview pills --}}
                    <div class="mb-4">
                        <span class="block text-xs font-semibold text-slate-400 uppercase tracking-wider mb-2">
                            Fields ({{ $table->fields->count() }})
                        </span>
                        <div class="flex flex-wrap gap-1.5 max-h-24 overflow-y-auto">
                            <span class="inline-flex items-center text-xs font-mono bg-slate-100 text-slate-600 px-2 py-0.5 rounded">id</span>
                            @foreach($table->fields as $field)
                                <span class="inline-flex items-center gap-1 text-xs font-mono bg-indigo-50/70 border border-indigo-100 text-indigo-700 px-2 py-0.5 rounded">
                                    {{ $field->name }}
                                    <span class="text-[10px] text-indigo-400">({{ $field->type }})</span>
                                    @if($field->required)
                                        <span class="text-red-500 font-bold">*</span>
                                    @endif
                                </span>
                            @endforeach
                        </div>
                    </div>
                </div>

                <div class="pt-4 border-t border-slate-100 flex items-center justify-between">
                    <a href="{{ route('projects.tables.show', ['project' => $project->database_name, 'table' => $table->slug]) }}"
                       class="inline-flex items-center gap-1.5 text-sm font-semibold text-indigo-600 hover:text-indigo-500 transition-colors">
                        View Routes & Test
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                        </svg>
                    </a>

                    <form action="{{ route('projects.tables.destroy', ['project' => $project->database_name, 'table' => $table->id]) }}" method="POST"
                          onsubmit="return confirm('Delete table \'{{ $table->name }}\'?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-slate-400 hover:text-red-500 p-1.5 rounded-lg hover:bg-red-50 transition-colors" title="Delete Table">
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

@endsection

@push('scripts')
<script>
    let fieldCount = 2;

    document.getElementById('tableName').addEventListener('input', function() {
        const preview = document.getElementById('tableSlugPreview');
        const val = this.value.trim().toLowerCase().replace(/[^a-z0-9]+/g, '_');
        preview.textContent = val || 'your_table';
    });

    function toggleAddTableForm() {
        const backdrop = document.getElementById('addTableBackdrop');
        backdrop.classList.remove('hidden');
        setTimeout(() => document.getElementById('tableName').focus(), 50);
    }

    function closeAddTableForm(event) {
        const backdrop = document.getElementById('addTableBackdrop');
        backdrop.classList.add('hidden');
    }

    function addFieldRow() {
        const container = document.getElementById('fieldRows');
        const row = document.createElement('div');
        row.className = 'field-row flex items-center gap-2 p-2.5 bg-slate-50/70 border border-slate-200 rounded-xl';
        row.innerHTML = `
            <input
                type="text"
                name="fields[${fieldCount}][name]"
                placeholder="Field name"
                class="flex-1 min-w-0 border border-slate-200 bg-white rounded-lg px-3 py-2 text-sm text-slate-800 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500"
                required
            >
            <select
                name="fields[${fieldCount}][type]"
                class="border border-slate-200 bg-white rounded-lg px-3 py-2 text-sm text-slate-700 focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500"
            >
                <option value="string">String</option>
                <option value="email">Email</option>
                <option value="number">Number</option>
                <option value="boolean">Boolean</option>
                <option value="date">Date</option>
                <option value="text">Long Text</option>
            </select>
            <label class="flex items-center gap-1.5 text-xs text-slate-600 shrink-0 cursor-pointer px-1">
                <input type="checkbox" name="fields[${fieldCount}][required]" value="1" class="rounded border-slate-300 text-indigo-600 focus:ring-indigo-500">
                <span>Req</span>
            </label>
            <button type="button" onclick="removeFieldRow(this)"
                    class="text-slate-300 hover:text-red-500 transition-colors p-1.5 rounded-lg hover:bg-white shrink-0">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        `;
        container.appendChild(row);
        fieldCount++;
        row.querySelector('input').focus();
    }

    function removeFieldRow(btn) {
        const row = btn.closest('.field-row');
        const container = document.getElementById('fieldRows');
        if (container.querySelectorAll('.field-row').length > 1) {
            row.remove();
        }
    }

    function copyToClipboard(text) {
        navigator.clipboard.writeText(text).then(() => {
            alert('✓ Copied to clipboard: ' + text);
        }).catch(() => {
            prompt('Copy this URL:', text);
        });
    }

    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') closeAddTableForm();
    });
</script>
@endpush
