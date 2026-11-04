@extends('layouts.app')

@section('title', $table->name . ' — API Routes')

@section('header-actions')
    <a href="{{ route('projects.show', $project->database_name) }}"
       class="inline-flex items-center gap-2 bg-slate-100 hover:bg-slate-200 text-slate-700 text-sm font-semibold px-4 py-2.5 rounded-xl transition-colors">
        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
        </svg>
        Back to Tables
    </a>
@endsection

@section('content')

    {{-- Breadcrumb --}}
    <nav class="flex items-center gap-2 text-sm text-slate-400 mb-6 flex-wrap">
        <a href="{{ route('dashboard') }}" class="hover:text-indigo-600 font-medium transition-colors">Dashboard</a>
        <svg class="w-4 h-4 text-slate-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
        </svg>
        <a href="{{ route('projects.show', $project->database_name) }}" class="hover:text-indigo-600 font-medium transition-colors">{{ $project->name }}</a>
        <svg class="w-4 h-4 text-slate-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
        </svg>
        <span class="text-slate-800 font-semibold">{{ $table->name }}</span>
    </nav>

    {{-- Top Info Banner --}}
    <div class="bg-white border border-slate-200 rounded-2xl p-6 mb-8 shadow-xs">
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <div class="flex items-center gap-3 flex-wrap">
                    <h2 class="text-xl font-bold text-slate-900">{{ $table->name }}</h2>
                    <span class="text-xs font-mono font-medium text-emerald-700 bg-emerald-50 border border-emerald-100 px-2.5 py-1 rounded-lg">
                        5 Endpoints Ready
                    </span>
                    <span class="text-xs text-slate-500 bg-slate-100 px-2.5 py-1 rounded-lg">
                        {{ $table->fields->count() }} {{ Str::plural('field', $table->fields->count()) }}
                    </span>
                </div>
                <p class="text-xs text-slate-500 mt-1.5">
                    Use these URLs directly in your frontend code (React, Vue, HTML forms, or Postman) to test without a backend.
                </p>
            </div>

            <div class="flex items-center gap-2">
                <form action="{{ route('projects.destroy', ['project' => $project->database_name, 'table' => $table->id]) }}" method="POST"
                      onsubmit="return confirm('Delete table \'{{ $table->name }}\' and its endpoints?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="text-xs font-medium text-red-600 hover:text-red-700 border border-red-200 hover:border-red-300 bg-red-50/50 hover:bg-red-50 px-3 py-2 rounded-xl transition-colors">
                        Delete Table
                    </button>
                </form>
            </div>
        </div>
    </div>

    @php
        $baseUrl = url('/api/' . $project->database_name . '/' . $table->slug);

        $endpoints = [
            [
                'method'      => 'GET',
                'badge'       => 'bg-blue-50 text-blue-700 border-blue-200',
                'url'         => $baseUrl,
                'action_name' => 'Get All Records',
                'description' => "Returns an array of all {$table->name} records.",
                'has_body'    => false,
            ],
            [
                'method'      => 'GET',
                'badge'       => 'bg-blue-50 text-blue-700 border-blue-200',
                'url'         => $baseUrl . '/{id}',
                'action_name' => 'Get Record by ID',
                'description' => "Fetches a single {$table->name} record by its ID.",
                'has_body'    => false,
            ],
            [
                'method'      => 'POST',
                'badge'       => 'bg-emerald-50 text-emerald-700 border-emerald-200',
                'url'         => $baseUrl,
                'action_name' => 'Create Record',
                'description' => "Submit your frontend form here. Accepts JSON body with defined fields.",
                'has_body'    => true,
            ],
            [
                'method'      => 'PUT',
                'badge'       => 'bg-amber-50 text-amber-700 border-amber-200',
                'url'         => $baseUrl . '/{id}',
                'action_name' => 'Update Record',
                'description' => "Updates an existing {$table->name} record by ID.",
                'has_body'    => true,
            ],
            [
                'method'      => 'DELETE',
                'badge'       => 'bg-red-50 text-red-700 border-red-200',
                'url'         => $baseUrl . '/{id}',
                'action_name' => 'Delete Record',
                'description' => "Deletes a {$table->name} record by ID.",
                'has_body'    => false,
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

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        {{-- Left 2 Cols: Endpoints List --}}
        <div class="lg:col-span-2 space-y-4">
            <h3 class="text-base font-bold text-slate-900 flex items-center justify-between">
                <span>Generated REST Routes</span>
                <span class="text-xs font-normal text-slate-500">Click Copy to use in your frontend</span>
            </h3>

            @foreach($endpoints as $endpoint)
            <div class="bg-white border border-slate-200 rounded-2xl p-4.5 hover:shadow-md hover:border-indigo-200 transition-all">
                <div class="flex items-start justify-between gap-3 mb-2">
                    <div class="flex items-center gap-2.5 flex-wrap">
                        <span class="text-xs font-bold font-mono px-2.5 py-1 rounded-lg border {{ $endpoint['badge'] }}">
                            {{ $endpoint['method'] }}
                        </span>
                        <span class="text-sm font-semibold text-slate-800">{{ $endpoint['action_name'] }}</span>
                    </div>

                    <button
                        type="button"
                        onclick="copyEndpoint(this, '{{ $endpoint['url'] }}')"
                        class="text-xs font-semibold text-slate-600 hover:text-indigo-600 border border-slate-200 hover:border-indigo-300 bg-slate-50/80 hover:bg-indigo-50/50 px-3 py-1.5 rounded-lg transition-all flex items-center gap-1.5 shrink-0">
                        <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z" />
                        </svg>
                        <span>Copy URL</span>
                    </button>
                </div>

                {{-- URL Display --}}
                <div class="bg-slate-900 rounded-xl px-3.5 py-2.5 mb-2 overflow-x-auto">
                    <code class="text-xs font-mono text-indigo-300 select-all">{{ $endpoint['url'] }}</code>
                </div>

                <p class="text-xs text-slate-500 leading-relaxed">{{ $endpoint['description'] }}</p>
            </div>
            @endforeach

            {{-- Frontend Integration Code Preview --}}
            <div class="bg-white border border-slate-200 rounded-2xl p-5 mt-6 shadow-xs">
                <div class="flex items-center justify-between mb-3">
                    <h4 class="text-sm font-bold text-slate-900 flex items-center gap-2">
                        <svg class="w-4 h-4 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4" />
                        </svg>
                        Test from Frontend (Quick Snippet)
                    </h4>
                    <button onclick="copySnippet()"
                            class="text-xs font-semibold text-indigo-600 hover:text-indigo-700 bg-indigo-50 px-2.5 py-1 rounded-lg border border-indigo-100 transition-colors">
                        Copy Code
                    </button>
                </div>

                <pre id="codeSnippet" class="bg-slate-950 text-slate-200 text-xs font-mono rounded-xl p-4 overflow-x-auto leading-relaxed">
// Example: Submit your form data with fetch()
fetch('{{ $baseUrl }}', {
  method: 'POST',
  headers: {
    'Content-Type': 'application/json',
    'Accept': 'application/json'
  },
  body: JSON.stringify({!! $jsonPreview !!})
})
  .then(res => res.json())
  .then(data => console.log('Response:', data))
  .catch(err => console.error('Error:', err));</pre>
            </div>
        </div>

        {{-- Right Col: Table Schema & JSON Body --}}
        <div class="space-y-6">

            {{-- Table Schema --}}
            <div class="bg-white border border-slate-200 rounded-2xl p-5 shadow-xs">
                <h4 class="text-sm font-bold text-slate-900 mb-4 flex items-center justify-between">
                    <span>Table Fields / Schema</span>
                    <span class="text-xs font-normal text-slate-400">Total: {{ $table->fields->count() + 3 }}</span>
                </h4>

                <div class="space-y-2">
                    {{-- id --}}
                    <div class="flex items-center justify-between p-2.5 bg-slate-50/70 border border-slate-100 rounded-xl">
                        <div class="flex items-center gap-2">
                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                            <span class="text-xs font-mono font-bold text-slate-800">id</span>
                        </div>
                        <div class="flex items-center gap-1.5">
                            <span class="text-[10px] font-mono text-slate-500 bg-white border border-slate-200 px-1.5 py-0.5 rounded">number</span>
                            <span class="text-[10px] text-emerald-600 font-semibold bg-emerald-50 px-1.5 py-0.5 rounded">auto</span>
                        </div>
                    </div>

                    {{-- Dynamic Fields --}}
                    @forelse($table->fields as $field)
                    <div class="flex items-center justify-between p-2.5 bg-slate-50/70 border border-slate-100 rounded-xl">
                        <div class="flex items-center gap-2">
                            <span class="w-1.5 h-1.5 rounded-full bg-indigo-500"></span>
                            <span class="text-xs font-mono font-bold text-slate-800">{{ $field->name }}</span>
                        </div>
                        <div class="flex items-center gap-1.5">
                            <span class="text-[10px] font-mono text-indigo-700 bg-indigo-50 border border-indigo-100 px-1.5 py-0.5 rounded font-medium">
                                {{ $field->type }}
                            </span>
                            @if($field->required)
                                <span class="text-[10px] text-red-600 font-semibold bg-red-50 px-1.5 py-0.5 rounded">req</span>
                            @else
                                <span class="text-[10px] text-slate-400 bg-slate-100 px-1.5 py-0.5 rounded">opt</span>
                            @endif
                        </div>
                    </div>
                    @empty
                    <p class="text-xs text-slate-400 italic py-2 text-center">No custom fields defined.</p>
                    @endforelse

                    {{-- Timestamps --}}
                    <div class="flex items-center justify-between p-2.5 bg-slate-50/40 border border-slate-100 rounded-xl opacity-75">
                        <span class="text-xs font-mono text-slate-500">created_at</span>
                        <span class="text-[10px] font-mono text-slate-400 bg-white border border-slate-200 px-1.5 py-0.5 rounded">timestamp</span>
                    </div>
                    <div class="flex items-center justify-between p-2.5 bg-slate-50/40 border border-slate-100 rounded-xl opacity-75">
                        <span class="text-xs font-mono text-slate-500">updated_at</span>
                        <span class="text-[10px] font-mono text-slate-400 bg-white border border-slate-200 px-1.5 py-0.5 rounded">timestamp</span>
                    </div>
                </div>
            </div>

            {{-- Example JSON Payload --}}
            <div class="bg-white border border-slate-200 rounded-2xl p-5 shadow-xs">
                <div class="flex items-center justify-between mb-3">
                    <h4 class="text-sm font-bold text-slate-900">Example JSON Body</h4>
                    <span class="text-[10px] font-semibold text-emerald-700 bg-emerald-50 border border-emerald-100 px-2 py-0.5 rounded">
                        POST / PUT
                    </span>
                </div>
                <p class="text-xs text-slate-500 mb-3">Sample payload matching your table's fields:</p>
                <div class="relative">
                    <pre class="bg-slate-950 text-indigo-200 text-xs font-mono rounded-xl p-4 overflow-x-auto leading-relaxed">{{ $jsonPreview }}</pre>
                    <button
                        type="button"
                        onclick="copyEndpoint(this, {{ json_encode($jsonPreview) }})"
                        class="absolute top-2.5 right-2.5 text-[11px] font-semibold text-slate-300 hover:text-white bg-slate-800 hover:bg-slate-700 border border-slate-700 px-2.5 py-1 rounded-lg transition-colors">
                        Copy
                    </button>
                </div>
            </div>

        </div>

    </div>

@endsection

@push('scripts')
<script>
    function copyEndpoint(btn, text) {
        navigator.clipboard.writeText(text).then(() => {
            const originalHTML = btn.innerHTML;
            btn.innerHTML = '✓ Copied';
            btn.classList.add('text-emerald-600', 'border-emerald-300', 'bg-emerald-50');
            setTimeout(() => {
                btn.innerHTML = originalHTML;
                btn.classList.remove('text-emerald-600', 'border-emerald-300', 'bg-emerald-50');
            }, 1800);
        }).catch(() => {
            prompt('Copy this URL:', text);
        });
    }

    function copySnippet() {
        const text = document.getElementById('codeSnippet').innerText;
        navigator.clipboard.writeText(text).then(() => {
            alert('✓ Copied JavaScript fetch snippet to clipboard!');
        });
    }
</script>
@endpush
