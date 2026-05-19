@extends(config('dialer.layout', 'layouts.admin'))
@section('content')

<script>
(function(){
    function addCss(href, id){
        if(document.getElementById(id)) return;
        var l = document.createElement('link');
        l.rel='stylesheet'; l.href=href; l.id=id;
        document.head.appendChild(l);
    }
    if(!document.querySelector('link[href*="tabler-icons"]'))
        addCss('https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@3.31.0/dist/tabler-icons.min.css','__ti');
})();
</script>

<style>
.dh-card {
    display:flex; align-items:center; gap:18px;
    border:1.5px solid #e2e8f0; border-radius:14px;
    padding:28px 26px; background:#fff;
    text-decoration:none; color:inherit; height:100%;
    transition:box-shadow .18s, border-color .18s, transform .12s;
    box-shadow:0 1px 4px rgba(0,0,0,.04);
}
.dh-card:hover {
    box-shadow:0 6px 28px rgba(0,0,117,.10);
    border-color:#000075; transform:translateY(-2px);
    color:inherit; text-decoration:none;
}
.dh-icon {
    width:58px; height:58px; border-radius:14px; flex-shrink:0;
    display:flex; align-items:center; justify-content:center;
    font-size:26px; color:#fff;
}
.dh-title { font-size:16px; font-weight:700; color:#0f172a; margin-bottom:4px; }
.dh-desc  { font-size:13px; color:#64748b; line-height:1.5; }
.dh-pill  {
    display:inline-flex; align-items:center; gap:6px;
    background:#f0f4ff; border-radius:20px;
    padding:5px 14px; font-size:12px; font-weight:600; color:#3b4cca;
    margin-top:8px;
}
</style>

<div class="px-4 pt-4 pb-2">
    <h2 class="d-flex align-items-center gap-2 mb-4" style="font-size:20px;font-weight:700;color:#0f172a;">
        <i class="ti ti-phone-call"></i> Dialer
    </h2>

    <div class="row g-3">
        <div class="col-md-6">
            <a href="#"
               onclick="window.open('{{ dialer_route('softphone') }}','softphone','width=440,height=800,resizable=yes,toolbar=no,menubar=no,location=no,scrollbars=yes');return false;"
               class="dh-card">
                <div class="dh-icon" style="background:linear-gradient(135deg,#000075,#2f80ed);">
                    <i class="ti ti-headset"></i>
                </div>
                <div>
                    <div class="dh-title">Softphone</div>
                    <div class="dh-desc">Open the agent softphone to make and receive calls via WebRTC</div>
                    <div class="dh-pill"><i class="ti ti-external-link" style="font-size:11px;"></i> Opens in new window</div>
                </div>
            </a>
        </div>
        <div class="col-md-6">
            <a href="{{ dialer_route('call-log') }}" class="dh-card">
                <div class="dh-icon" style="background:linear-gradient(135deg,#059669,#0ea5e9);">
                    <i class="ti ti-file-analytics"></i>
                </div>
                <div>
                    <div class="dh-title">Call Report</div>
                    <div class="dh-desc">View full call history with duration, disposition, and recordings</div>
                    <div class="dh-pill"><i class="ti ti-phone-check" style="font-size:11px;"></i> {{ $todayCalls }} call(s) today</div>
                </div>
            </a>
        </div>
    </div>
</div>

@endsection
