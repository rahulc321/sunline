@extends(config('dialer.layout', 'layouts.admin'))
@section('content')

{{-- ── Inject DataTables + Icons into <head> if not already loaded ── --}}
<script>
(function(){
    function addCss(href, id){
        if(document.getElementById(id)) return;
        var l = document.createElement('link');
        l.rel='stylesheet'; l.href=href; l.id=id;
        document.head.appendChild(l);
    }
    // DataTables Bootstrap 5 theme
    addCss('https://cdn.jsdelivr.net/npm/datatables.net-bs5@1.13.8/css/dataTables.bootstrap5.min.css','__dt-bs5');
    // Tabler icons
    if(!document.querySelector('link[href*="tabler-icons"]'))
        addCss('https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@3.31.0/dist/tabler-icons.min.css','__ti');
})();
</script>

<style>
/* ── Call Report — scoped styles ─────────────────────────────────────────── */
.cr-page-hd {
    display:flex; align-items:center; justify-content:space-between;
    padding:20px 24px 0; flex-wrap:wrap; gap:10px;
}
.cr-page-hd h2 {
    font-size:20px; font-weight:700; color:#0f172a; margin:0;
    display:flex; align-items:center; gap:8px;
}
.cr-back-btn {
    display:inline-flex; align-items:center; gap:6px;
    padding:6px 14px; border-radius:8px; font-size:13px; font-weight:500;
    border:1.5px solid #e2e8f0; color:#475569; background:#fff;
    text-decoration:none; transition:background .15s;
}
.cr-back-btn:hover { background:#f8fafc; color:#0f172a; text-decoration:none; }

/* Stat cards */
.cr-stat-card {
    background:#fff; border:1.5px solid #e2e8f0; border-radius:12px;
    padding:18px 20px; display:flex; align-items:center; gap:14px;
    box-shadow:0 1px 4px rgba(0,0,0,.04); height:100%;
}
.cr-stat-icon {
    width:48px; height:48px; border-radius:12px; flex-shrink:0;
    display:flex; align-items:center; justify-content:center;
    font-size:22px; color:#fff;
}
.cr-stat-label { font-size:11px; color:#94a3b8; font-weight:600; text-transform:uppercase; letter-spacing:.05em; }
.cr-stat-val   { font-size:24px; font-weight:700; color:#0f172a; line-height:1.2; margin-top:2px; }

/* Table container */
.cr-table-wrap {
    border:1.5px solid #e2e8f0; border-radius:12px;
    background:#fff; overflow:hidden;
    box-shadow:0 1px 4px rgba(0,0,0,.04);
}

/* DataTables Bootstrap overrides */
#callLogTable_wrapper { padding:0 !important; }
#callLogTable_wrapper .row { margin:0; }
#callLogTable_wrapper > .row:first-child > div { padding:12px 16px; border-bottom:1px solid #f1f5f9; }
#callLogTable_wrapper > .row:last-child  > div { padding:10px 16px; border-top:1px solid #f1f5f9; }
#callLogTable_wrapper .dataTables_filter label { font-size:13px; font-weight:500; color:#475569; margin:0; }
#callLogTable_wrapper .dataTables_filter input {
    border:1.5px solid #e2e8f0 !important; border-radius:8px !important;
    padding:5px 12px !important; font-size:13px !important;
    outline:none !important; box-shadow:none !important;
    width:200px !important;
}
#callLogTable_wrapper .dataTables_filter input:focus { border-color:#000075 !important; }
#callLogTable_wrapper .dataTables_length label { font-size:13px; color:#94a3b8; margin:0; }
#callLogTable_wrapper .dataTables_length select {
    border:1.5px solid #e2e8f0 !important; border-radius:8px !important;
    padding:4px 10px !important; font-size:13px !important; outline:none !important;
}
#callLogTable_wrapper .dataTables_info { font-size:12px; color:#94a3b8; padding:0; }
#callLogTable_wrapper .dataTables_paginate { padding:0; }
#callLogTable_wrapper .dataTables_paginate .page-link {
    font-size:12px; color:#475569; border-color:#e2e8f0; padding:4px 10px;
}
#callLogTable_wrapper .dataTables_paginate .page-item.active .page-link {
    background:#000075 !important; border-color:#000075 !important; color:#fff !important;
}
#callLogTable_wrapper .dataTables_paginate .page-link:hover:not(.active) { background:#f1f5f9; }
#callLogTable_wrapper .dataTables_processing {
    background:rgba(255,255,255,.85); font-size:13px; color:#475569;
    border:1.5px solid #e2e8f0; border-radius:8px; padding:8px 20px;
    box-shadow:0 4px 12px rgba(0,0,0,.08);
}

/* Table headers & cells */
#callLogTable thead th {
    background:#f8fafc !important; color:#475569 !important;
    font-size:11px !important; font-weight:700 !important;
    text-transform:uppercase; letter-spacing:.05em;
    border-bottom:1.5px solid #e2e8f0 !important;
    padding:11px 14px !important; white-space:nowrap;
}
#callLogTable tbody td {
    padding:12px 14px !important; font-size:13px; color:#334155;
    border-bottom:1px solid #f1f5f9 !important; vertical-align:middle;
}
#callLogTable tbody tr:last-child td { border-bottom:none !important; }
#callLogTable tbody tr:hover td { background:#f8fafc; }

/* Filter bar inputs */
.cr-filter-bar .form-control:focus {
    border-color:#000075 !important; box-shadow:none !important;
}
.cr-filter-bar .btn-primary { background:#000075; border-color:#000075; }
.cr-filter-bar .btn-primary:hover { background:#0000a0; border-color:#0000a0; }

/* Audio */
.cr-audio { height:30px; max-width:180px; border-radius:4px; vertical-align:middle; }

/* Empty state */
.cr-empty-state { text-align:center; padding:48px 0; color:#94a3b8; }
.cr-empty-state i { font-size:32px; display:block; margin:0 auto 10px; color:#cbd5e1; }
</style>

{{-- ── Page header ─────────────────────────────────────────────────────────── --}}
<div class="cr-page-hd">
    <h2><i class="ti ti-file-analytics"></i> Call Report</h2>
    <a href="{{ dialer_route('index') }}" class="cr-back-btn">
        <i class="ti ti-arrow-left" style="font-size:14px;"></i> Back
    </a>
</div>

{{-- ── Stats ──────────────────────────────────────────────────────────────── --}}
<div class="px-4 pt-4">
    <div class="row g-3 mb-4">
        <div class="col-6 col-md-3">
            <div class="cr-stat-card">
                <div class="cr-stat-icon" style="background:linear-gradient(135deg,#000075,#2f80ed);">
                    <i class="ti ti-phone-check"></i>
                </div>
                <div>
                    <div class="cr-stat-label">Total Calls</div>
                    <div class="cr-stat-val" id="statTotal">—</div>
                </div>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="cr-stat-card">
                <div class="cr-stat-icon" style="background:linear-gradient(135deg,#059669,#0ea5e9);">
                    <i class="ti ti-check"></i>
                </div>
                <div>
                    <div class="cr-stat-label">Contacted</div>
                    <div class="cr-stat-val" id="statContacted">—</div>
                </div>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="cr-stat-card">
                <div class="cr-stat-icon" style="background:linear-gradient(135deg,#f59e0b,#ef4444);">
                    <i class="ti ti-clock"></i>
                </div>
                <div>
                    <div class="cr-stat-label">Total Duration</div>
                    <div class="cr-stat-val" id="statDuration">—</div>
                </div>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="cr-stat-card">
                <div class="cr-stat-icon" style="background:linear-gradient(135deg,#6366f1,#8b5cf6);">
                    <i class="ti ti-player-record"></i>
                </div>
                <div>
                    <div class="cr-stat-label">Recordings</div>
                    <div class="cr-stat-val" id="statRecordings">—</div>
                </div>
            </div>
        </div>
    </div>

    {{-- ── Date filter ──────────────────────────────────────────────────── --}}
    <div class="d-flex align-items-center gap-2 mb-3 flex-wrap cr-filter-bar">
        <span style="font-size:13px;font-weight:600;color:#475569;">Filter:</span>
        <input type="date" id="filterFrom" class="form-control form-control-sm" style="width:160px;">
        <span style="font-size:13px;color:#94a3b8;">to</span>
        <input type="date" id="filterTo" class="form-control form-control-sm" style="width:160px;">
        <button id="applyFilter" class="btn btn-sm btn-primary d-inline-flex align-items-center gap-1">
            <i class="ti ti-filter" style="font-size:13px;"></i> Apply
        </button>
        <button id="clearFilter" class="btn btn-sm btn-outline-secondary d-inline-flex align-items-center gap-1">
            <i class="ti ti-x" style="font-size:13px;"></i> Clear
        </button>
    </div>
</div>

{{-- ── Table ───────────────────────────────────────────────────────────────── --}}
<div class="px-4 pb-4">
    <div class="cr-table-wrap">
        <div style="overflow-x:auto;">
            <table id="callLogTable" class="table table-hover mb-0" style="width:100%;">
                <thead>
                    <tr>
                        <th>Agent</th>
                        <th>Contact</th>
                        <th>Phone</th>
                        <th>Direction</th>
                        <th>Status</th>
                        <th>Disposition</th>
                        <th>Duration</th>
                        <th>Recording</th>
                        <th>Date</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
(function(){
    /* Load DataTables with Bootstrap 5 theme from CDN, then boot */
    function loadScript(src, cb) {
        var s = document.createElement('script');
        s.src = src;
        s.onload = cb;
        document.head.appendChild(s);
    }

    function boot() {
        var table = $('#callLogTable').DataTable({
            processing : true,
            serverSide : true,
            order      : [[8, 'desc']],
            pageLength : 50,
            dom: "<'row align-items-center'<'col-sm-6'f><'col-sm-6 d-flex justify-content-end'l>>" +
                 "<'row'<'col-12'tr>>" +
                 "<'row align-items-center py-2'<'col-sm-5'i><'col-sm-7 d-flex justify-content-end'p>>",
            language: {
                search: '',
                searchPlaceholder: 'Search…',
                lengthMenu: 'Show _MENU_ rows',
                info: 'Showing _START_–_END_ of _TOTAL_',
                paginate: {
                    first:    '<i class="ti ti-chevrons-left"></i>',
                    previous: '<i class="ti ti-chevron-left"></i>',
                    next:     '<i class="ti ti-chevron-right"></i>',
                    last:     '<i class="ti ti-chevrons-right"></i>'
                },
                emptyTable:  '<div class="cr-empty-state"><i class="ti ti-zoom-cancel"></i><p class="mb-0">No records found</p></div>',
                zeroRecords: '<div class="cr-empty-state"><i class="ti ti-zoom-cancel"></i><p class="mb-0">No matching records</p></div>'
            },
            ajax: {
                url: '{{ dialer_route('call-log') }}',
                data: function(d) {
                    d.from = $('#filterFrom').val();
                    d.to   = $('#filterTo').val();
                }
            },
            columns: [
                { data: 'agent_name',        orderable: false,
                  render: function(d){ return d || '<span style="color:#94a3b8">—</span>'; } },
                { data: 'contact',           orderable: false,
                  render: function(d){ return d || '<span style="color:#94a3b8">—</span>'; } },
                { data: 'phone',             orderable: true,
                  render: function(d){ return '<span style="font-family:monospace;font-size:12px;">'+(d||'—')+'</span>'; } },
                { data: 'direction',         orderable: true,
                  render: function(d){
                      if(!d) return '<span style="color:#94a3b8">—</span>';
                      var cfg = d==='inbound'
                          ? {bg:'#dbeafe',fg:'#1d4ed8',ic:'ti-phone-incoming'}
                          : {bg:'#dcfce7',fg:'#15803d',ic:'ti-phone-outgoing'};
                      return '<span style="background:'+cfg.bg+';color:'+cfg.fg+';padding:2px 10px;border-radius:999px;font-size:11px;font-weight:600;display:inline-flex;align-items:center;gap:4px;">'
                           + '<i class="ti '+cfg.ic+'" style="font-size:11px;"></i>'
                           + d.charAt(0).toUpperCase()+d.slice(1)+'</span>';
                  }},
                { data: 'status_badge',      orderable: false,
                  render: function(d){ return d || '<span style="color:#94a3b8">—</span>'; } },
                { data: 'disposition_badge', orderable: false,
                  render: function(d){ return d || '<span style="color:#94a3b8">—</span>'; } },
                { data: 'duration_fmt',      orderable: false,
                  render: function(d){ return '<span style="color:#475569;">'+(d||'—')+'</span>'; } },
                { data: 'recording',         orderable: false, defaultContent: '—' },
                { data: 'created_at',        orderable: true,
                  render: function(d){ return '<span style="white-space:nowrap;font-size:12px;color:#64748b;">'+(d||'—')+'</span>'; } }
            ]
        });

        function loadStats(){
            var url = '{{ dialer_route('call-log') }}?stats=1';
            var f = $('#filterFrom').val(), t = $('#filterTo').val();
            if(f) url += '&from='+encodeURIComponent(f);
            if(t) url += '&to='+encodeURIComponent(t);
            $.getJSON(url, function(s){
                $('#statTotal').text(s.total);
                $('#statContacted').text(s.contacted);
                $('#statDuration').text(s.duration_fmt);
                $('#statRecordings').text(s.recordings);
            });
        }
        loadStats();

        $('#applyFilter').on('click', function(){ table.ajax.reload(); loadStats(); });
        $('#clearFilter').on('click', function(){
            $('#filterFrom,#filterTo').val('');
            table.ajax.reload(); loadStats();
        });
    }

    /* Chain: ensure DataTables + BS5 adapter are loaded */
    function ensureDataTables(cb){
        if(typeof $.fn.DataTable !== 'undefined'){ cb(); return; }
        loadScript('https://cdn.jsdelivr.net/npm/datatables.net@1.13.8/js/jquery.dataTables.min.js', function(){
            loadScript('https://cdn.jsdelivr.net/npm/datatables.net-bs5@1.13.8/js/dataTables.bootstrap5.min.js', cb);
        });
    }

    $(function(){ ensureDataTables(boot); });
})();
</script>
@endpush
