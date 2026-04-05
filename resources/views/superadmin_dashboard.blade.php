@extends('layouts.super')
@section('title', 'Dashboard')

@section('content')
<style>
@import url('https://fonts.googleapis.com/css2?family=Outfit:wght@400;500;600;700&display=swap');

.premium-dashboard {
    font-family: 'Outfit', sans-serif;
    position: relative;
    padding: 1rem 0 1.25rem;
}

.premium-dashboard::before {
    content: "";
    position: absolute;
    inset: -40px -24px auto -24px;
    height: 280px;
    background:
        radial-gradient(circle at 10% 20%, rgba(9, 45, 79, .18), transparent 40%),
        radial-gradient(circle at 85% 0%, rgba(0, 128, 128, .18), transparent 42%),
        linear-gradient(135deg, #f7fafc 0%, #edf4f8 100%);
    border-radius: 20px;
    z-index: 0;
}

.premium-dashboard > * {
    position: relative;
    z-index: 1;
}

.dash-title {
    font-size: 1.95rem;
    font-weight: 700;
    color: #0f2f45;
    letter-spacing: .1px;
}

.dash-subtitle {
    color: #517081;
    font-weight: 500;
    margin-bottom: 0;
}

.pill-chip {
    display: inline-flex;
    align-items: center;
    gap: .45rem;
    font-size: .78rem;
    font-weight: 600;
    letter-spacing: .25px;
    color: #0d3d5a;
    border: 1px solid rgba(15, 47, 69, .16);
    background: rgba(255, 255, 255, .78);
    backdrop-filter: blur(4px);
    border-radius: 999px;
    padding: .42rem .82rem;
}

.premium-card {
    background: linear-gradient(165deg, rgba(255,255,255,.96), rgba(255,255,255,.86));
    border: 1px solid rgba(15, 47, 69, .09);
    border-radius: 16px;
    box-shadow: 0 10px 30px rgba(15, 47, 69, .08);
    transition: transform .25s ease, box-shadow .25s ease;
}

.premium-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 16px 38px rgba(15, 47, 69, .12);
}

.kpi-card {
    padding: 1rem;
    position: relative;
    overflow: hidden;
}

.kpi-card::after {
    content: "";
    position: absolute;
    inset: auto -26% -50% auto;
    width: 140px;
    height: 140px;
    border-radius: 50%;
    background: rgba(255,255,255,.35);
}

.tone-navy { border-top: 4px solid #0c4a6e; }
.tone-cyan { border-top: 4px solid #0e7490; }
.tone-emerald { border-top: 4px solid #047857; }
.tone-gold { border-top: 4px solid #b45309; }

.kpi-meta {
    color: #607989;
    font-size: .83rem;
    font-weight: 500;
}

.kpi-value {
    color: #112f46;
    font-weight: 700;
    margin-bottom: 0;
}

.kpi-growth {
    background: rgba(5, 150, 105, .12);
    color: #047857;
    font-size: .78rem;
    font-weight: 700;
    border-radius: 999px;
    padding: .2rem .55rem;
}

.icon-badge {
    width: 34px;
    height: 34px;
    border-radius: 9px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    font-size: .78rem;
    font-weight: 700;
    color: #fff;
}

.icon-navy { background: #0c4a6e; }
.icon-cyan { background: #0e7490; }
.icon-emerald { background: #047857; }
.icon-gold { background: #b45309; }

.chart-title {
    color: #0f2f45;
    font-weight: 650;
}

.chart-muted {
    color: #5f7889;
    font-size: .84rem;
}

.chart-shell {
    padding: 1rem 1rem .8rem;
}

/* Animation states */
.premium-dashboard .premium-card {
    opacity: 0;
    transform: translateY(12px) scale(.985);
}

.premium-dashboard .pill-chip {
    opacity: 0;
}

.kpi-card canvas,
.chart-shell canvas {
    opacity: 0;
}

.premium-dashboard.is-animated {
    animation: fadeSlideIn .6s ease both;
}

.premium-dashboard.is-animated .premium-card {
    animation: riseIn .55s ease both;
}

.premium-dashboard.is-animated .pill-chip {
    opacity: 1;
    animation: chipFadeIn .45s ease both, chipFloat 3.4s ease-in-out .45s infinite;
}

.premium-dashboard.is-animated .kpi-card canvas {
    animation: fadeIn .7s ease both;
}

.premium-dashboard.is-animated .chart-shell canvas {
    animation: fadeIn .85s ease both;
}

@keyframes fadeSlideIn {
    from { opacity: 0; transform: translateY(8px); }
    to { opacity: 1; transform: translateY(0); }
}

@keyframes riseIn {
    from { opacity: 0; transform: translateY(12px) scale(.985); }
    to { opacity: 1; transform: translateY(0) scale(1); }
}

@keyframes chipFloat {
    0%, 100% { transform: translateY(0); }
    50% { transform: translateY(-2px); }
}

@keyframes chipFadeIn {
    from { opacity: 0; transform: translateY(4px); }
    to { opacity: 1; transform: translateY(0); }
}

@keyframes fadeIn {
    from { opacity: .3; }
    to { opacity: 1; }
}

@media (prefers-reduced-motion: reduce) {
    .premium-dashboard,
    .pill-chip,
    .premium-card,
    .kpi-card canvas,
    .chart-shell canvas {
        animation: none !important;
        transition: none !important;
        opacity: 1 !important;
        transform: none !important;
    }
}
</style>

<div class="premium-dashboard" id="premiumDashboard">
    <div class="page-header mb-4">
        <div class="page-header-content d-lg-flex">
            <div class="d-flex justify-content-between align-items-center w-100 flex-wrap gap-2">
                <div>
                    <h4 class="page-title mb-1 dash-title">Administrator Dashboard</h4>
                    <p class="dash-subtitle">Performance overview and pipeline insights</p>
                </div>
                <span class="pill-chip"><i class="ph ph-waveform"></i> Live Analytics • This Month</span>
            </div>
        </div>
    </div>

    <div class="content pt-0">
        <div class="row g-3 mb-4">
            @php
            $cards = [
                [
                    'title' => 'Total Leads',
                    'value' => '1,248',
                    'growth' => '+14%',
                    'id' => 'lineLeads',
                    'tone' => 'tone-navy',
                    'icon' => 'ph-users-three',
                    'icon_class' => 'icon-navy',
                    'color' => 'rgb(12,74,110)'
                ],
                [
                    'title' => 'Contacted',
                    'value' => '978',
                    'growth' => '+11%',
                    'id' => 'lineContacted',
                    'tone' => 'tone-cyan',
                    'icon' => 'ph-phone-call',
                    'icon_class' => 'icon-cyan',
                    'color' => 'rgb(14,116,144)'
                ],
                [
                    'title' => 'Quotes',
                    'value' => '312',
                    'growth' => '+8%',
                    'id' => 'lineQuotes',
                    'tone' => 'tone-emerald',
                    'icon' => 'ph-file-text',
                    'icon_class' => 'icon-emerald',
                    'color' => 'rgb(4,120,87)'
                ],
                [
                    'title' => 'Closed',
                    'value' => '128',
                    'growth' => '+6%',
                    'id' => 'lineSales',
                    'tone' => 'tone-gold',
                    'icon' => 'ph-check-circle',
                    'icon_class' => 'icon-gold',
                    'color' => 'rgb(180,83,9)'
                ],
            ];
            @endphp

            @foreach($cards as $card)
            <div class="col-md-3">
                <div class="premium-card kpi-card {{ $card['tone'] }}" style="animation-delay: {{ 0.05 + ($loop->index * 0.07) }}s;">
                    <div class="d-flex align-items-center justify-content-between mb-2">
                        <span class="kpi-meta">{{ $card['title'] }}</span>
                        <span class="icon-badge {{ $card['icon_class'] }}"><i class="ph {{ $card['icon'] }}"></i></span>
                    </div>

                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <h4 class="kpi-value">{{ $card['value'] }}</h4>
                        <span class="kpi-growth">{{ $card['growth'] }}</span>
                    </div>

                    <canvas id="{{ $card['id'] }}" height="80" data-color="{{ $card['color'] }}"></canvas>
                </div>
            </div>
            @endforeach
        </div>

        <div class="row g-3 mb-4">
            <div class="col-md-7">
                <div class="premium-card chart-shell h-100" style="animation-delay:.2s;">
                    <div class="d-flex justify-content-between mb-2 flex-wrap gap-2">
                        <h6 class="mb-0 chart-title"><i class="ph ph-chart-bar me-1"></i>Monthly Product Sales</h6>
                        <small class="chart-muted">Total: <strong>221 Units</strong></small>
                    </div>
                    <canvas id="barProducts" height="260"></canvas>
                </div>
            </div>

            <div class="col-md-5">
                <div class="premium-card chart-shell h-100" style="animation-delay:.28s;">
                    <h6 class="mb-3 chart-title"><i class="ph ph-chart-donut me-1"></i>Lead Conversion</h6>

                    <div class="position-relative" style="height:260px">
                        <canvas id="donutConversion"></canvas>

                        <div class="position-absolute top-50 start-50 translate-middle text-center">
                            <h3 class="mb-0 chart-title">25.8%</h3>
                            <small class="chart-muted">128 / 496 Leads</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
@parent
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
const days = ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'];

function miniLine(id, data) {
    const canvas = document.getElementById(id);
    if (!canvas) return;

    const color = canvas.dataset.color;

    new Chart(canvas, {
        type: 'line',
        data: {
            labels: days,
            datasets: [{
                data: data,
                borderColor: color,
                borderWidth: 2,
                tension: .45,
                pointRadius: 0,
                fill: false
            }]
        },
        options: {
            responsive: true,
            plugins: { legend: { display: false } },
            scales: {
                x: { display: false },
                y: { display: false }
            },
            elements: { line: { capBezierPoints: true } }
        }
    });
}

miniLine('lineLeads', [12, 18, 16, 22, 20, 25, 30]);
miniLine('lineContacted', [9, 13, 12, 18, 17, 21, 26]);
miniLine('lineQuotes', [4, 5, 6, 7, 6, 8, 10]);
miniLine('lineSales', [2, 3, 3, 4, 5, 6, 7]);

new Chart(document.getElementById('barProducts'), {
    type: 'bar',
    data: {
        labels: ['Battery', 'Solar', 'Solar+Battery', 'Heat Pump', 'Aircon', 'EV Charger', 'Inverter', 'Maintenance'],
        datasets: [{
            data: [40, 32, 60, 20, 14, 18, 25, 12],
            backgroundColor: [
                'rgb(12,74,110)',
                'rgb(14,116,144)',
                'rgb(4,120,87)',
                'rgb(59,130,246)',
                'rgb(180,83,9)',
                'rgb(220,38,38)',
                'rgb(15,118,110)',
                'rgb(2,132,199)'
            ],
            borderRadius: 10,
            barThickness: 18
        }]
    },
    options: {
        plugins: { legend: { display: false } },
        scales: {
            x: { grid: { display: false }, ticks: { color: '#4d6779' } },
            y: { beginAtZero: true, grid: { color: 'rgba(117, 146, 164, .18)' }, ticks: { color: '#4d6779' } }
        }
    }
});

new Chart(document.getElementById('donutConversion'), {
    type: 'doughnut',
    data: {
        labels: ['Converted', 'Remaining'],
        datasets: [{
            data: [25.8, 74.2],
            backgroundColor: [
                'rgb(12,74,110)',
                'rgb(214,225,233)'
            ],
            borderWidth: 0
        }]
    },
    options: {
        cutout: '74%',
        plugins: {
            legend: {
                position: 'bottom',
                labels: {
                    usePointStyle: true,
                    padding: 16,
                    boxWidth: 10
                }
            }
        }
    }
});

(() => {
    const startDashboardAnimations = () => {
        const dashboard = document.getElementById('premiumDashboard');
        if (!dashboard) return;

        dashboard.classList.remove('is-animated');
        requestAnimationFrame(() => {
            requestAnimationFrame(() => dashboard.classList.add('is-animated'));
        });
    };

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', startDashboardAnimations);
    } else {
        startDashboardAnimations();
    }

    window.addEventListener('pageshow', startDashboardAnimations);
})();
</script>
@endsection
