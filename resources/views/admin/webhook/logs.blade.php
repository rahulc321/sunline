@extends('layouts.admin')
@section('title', "API Logs")

@section('content')
<div class="page-header">
    <div class="page-header-content d-lg-flex">
        <div class="d-flex">
            <h4 class="page-title mb-0 crm_c">
                API Logs
            </h4>
        </div>
    </div>
</div>

<div class="content pt-0">
    <div class="row">
        <div class="col-xl-12">
            @if($logs->isEmpty())
                <div class="alert alert-warning">No logs found for this webhook.</div>
            @else
                @foreach($logs as $index => $log)
                    <div class="card mb-3 shadow-sm border">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <div>
                                <strong>#{{ $index + 1 }}</strong>
                                <span class="badge bg-primary">{{ $log->method }}</span>
                                <span class="badge {{ $log->status_code == 200 ? 'bg-success' : 'bg-danger' }}">
                                    {{ $log->status_code }}
                                </span>
                            </div>
                            <small class="text-muted">{{ $log->created_at->format('d M Y H:i:s') }}</small>
                        </div>

                        <div class="card-body">
                            <p class="mb-2"><strong>URL:</strong> <span class="text-break">{{ $log->url }}</span></p>

                            {{-- Request --}}
                            <div class="mb-3">
                                <strong>Request body</strong>
                                <div class="code-toolbar">
                                    <pre><code class="language-json">{{ json_encode(json_decode($log->request_body), JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES) }}</code></pre>
                                    <div class="toolbar">
                                        <button onclick="copyToClipboard(this)" data-code="{{ htmlentities(json_encode(json_decode($log->request_body), JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES)) }}">📋 Copy</button>
                                        <button onclick="downloadJSON('request-{{ $log->id }}', this)" data-code="{{ htmlentities(json_encode(json_decode($log->request_body), JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES)) }}">⬇ Download</button>
                                    </div>
                                </div>
                            </div>

                            {{-- Response --}}
                            <div>
                                <strong>Response body</strong>
                                <div class="code-toolbar">
                                    <pre><code class="language-json">{{ json_encode(json_decode($log->response_body), JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES) }}</code></pre>
                                    <div class="toolbar">
                                        <button onclick="copyToClipboard(this)" data-code="{{ htmlentities(json_encode(json_decode($log->response_body), JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES)) }}">📋 Copy</button>
                                        <button onclick="downloadJSON('response-{{ $log->id }}', this)" data-code="{{ htmlentities(json_encode(json_decode($log->response_body), JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES)) }}">⬇ Download</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            @endif
        </div>
    </div>
</div>

{{-- Prism.js for JSON highlighting --}}
<link href="https://cdnjs.cloudflare.com/ajax/libs/prism/1.29.0/themes/prism-tomorrow.min.css" rel="stylesheet"/>
<script src="https://cdnjs.cloudflare.com/ajax/libs/prism/1.29.0/prism.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/prism/1.29.0/components/prism-json.min.js"></script>

<style>
    .code-toolbar {
        position: relative;
        background: #2d2d2d;
        border-radius: 6px;
        overflow: hidden;
    }
    .code-toolbar pre {
        margin: 0;
        padding: 15px;
        max-height: 250px;
        overflow-y: auto;
        font-size: 13px;
        font-family: 'Fira Code', monospace;
    }
    .code-toolbar .toolbar {
        position: absolute;
        top: 5px;
        right: 10px;
    }
    .code-toolbar .toolbar button {
        background: #444;
        color: #fff;
        border: none;
        padding: 3px 8px;
        margin-left: 5px;
        border-radius: 4px;
        cursor: pointer;
        font-size: 12px;
    }
    .code-toolbar .toolbar button:hover {
        background: #666;
    }
</style>

<script>
function copyToClipboard(el) {
    const code = el.getAttribute('data-code');
    navigator.clipboard.writeText(code);
    alert("Copied to clipboard!");
}
function downloadJSON(filename, el) {
    const code = el.getAttribute('data-code');
    const blob = new Blob([code], {type: "application/json"});
    const link = document.createElement("a");
    link.href = URL.createObjectURL(blob);
    link.download = filename + ".json";
    link.click();
}
</script>
@endsection
