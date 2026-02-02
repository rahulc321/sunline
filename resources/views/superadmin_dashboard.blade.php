@extends('layouts.super')
@section('title', 'Dashboard')

@section('content')

<style>
/* ===== CARD COLORS (RGB) ===== */
.card-indigo { border-left: 4px solid rgb(79,70,229) !important; }
.card-blue   { border-left: 4px solid rgb(14,165,233) !important; }
.card-green  { border-left: 4px solid rgb(34,197,94) !important; }
.card-amber  { border-left: 4px solid rgb(245,158,11) !important; }
.card-purple { border-left: 4px solid rgb(168,85,247) !important; }

.card-soft {
    background: #fff;
    transition: all .25s ease;
}
.card-soft:hover {
    transform: translateY(-2px);
    box-shadow: 0 12px 28px rgba(0,0,0,.08);
}
</style>

<div class="page-header">
    <div class="page-header-content d-lg-flex">
        <div class="d-flex justify-content-between align-items-center w-100">
            <div>
                <h4 class="page-title mb-0 crm_c" style="font-size:1.9rem">
                    Administrator Dashboard
                </h4>
                <p class="mb-0 txt_1">Performance overview & pipeline insights</p>
            </div>
        </div>
    </div>
</div>

<div class="content pt-0">

    <!-- ================= MINI LINE CARDS ================= -->
    <div class="row g-3 mb-4">
        @php
        $cards = [
            [
                'title'=>'Total Leads',
                'value'=>'1,248',
                'growth'=>'+14%',
                'id'=>'lineLeads',
                'class'=>'card-indigo',
                'color'=>'rgb(79,70,229)'
            ],
            [
                'title'=>'Contacted',
                'value'=>'978',
                'growth'=>'+11%',
                'id'=>'lineContacted',
                'class'=>'card-blue',
                'color'=>'rgb(14,165,233)'
            ],
            [
                'title'=>'Quotes',
                'value'=>'312',
                'growth'=>'+8%',
                'id'=>'lineQuotes',
                'class'=>'card-green',
                'color'=>'rgb(34,197,94)'
            ],
            [
                'title'=>'Closed',
                'value'=>'128',
                'growth'=>'+6%',
                'id'=>'lineSales',
                'class'=>'card-amber',
                'color'=>'rgb(245,158,11)'
            ],
        ];
        @endphp

        @foreach($cards as $card)
        <div class="col-md-3">
            <div class="border rounded p-3 card-soft {{ $card['class'] }}">
                <span class="txt_2">{{ $card['title'] }}</span>

                <div class="d-flex justify-content-between align-items-center mb-1">
                    <h4 class="mb-0">{{ $card['value'] }}</h4>
                    <small class="text-success">{{ $card['growth'] }}</small>
                </div>

                <canvas
                    id="{{ $card['id'] }}"
                    height="80"
                    data-color="{{ $card['color'] }}"
                ></canvas>
            </div>
        </div>
        @endforeach
    </div>

    <!-- ================= BAR + DONUT ================= -->
    <div class="row g-3 mb-4">

        <!-- BAR -->
        <div class="col-md-7">
            <div class="border rounded p-3 h-100 card-soft card-purple">
                <div class="d-flex justify-content-between mb-2">
                    <h6 class="mb-0">Monthly Product Sales</h6>
                    <small class="text-muted">Total: <strong>221 Units</strong></small>
                </div>
                <canvas id="barProducts" height="260"></canvas>
            </div>
        </div>

        <!-- DONUT -->
        <div class="col-md-5">
            <div class="border rounded p-3 h-100 card-soft card-indigo">
                <h6 class="mb-3">Lead Conversion</h6>

                <div class="position-relative" style="height:260px">
                    <canvas id="donutConversion"></canvas>

                    <div class="position-absolute top-50 start-50 translate-middle text-center">
                        <h3 class="mb-0 txt_2">25.8%</h3>
                        <small class="text-muted">128 / 496 Leads</small>
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
/* ================= LINE CHARTS (PER-CANVAS COLOR) ================= */
const days = ['Mon','Tue','Wed','Thu','Fri','Sat','Sun'];

function miniLine(id, data) {
    const canvas = document.getElementById(id);
    const color  = canvas.dataset.color;

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
            }
        }
    });
}

miniLine('lineLeads',[12,18,16,22,20,25,30]);
miniLine('lineContacted',[9,13,12,18,17,21,26]);
miniLine('lineQuotes',[4,5,6,7,6,8,10]);
miniLine('lineSales',[2,3,3,4,5,6,7]);

/* ================= BAR CHART ================= */
new Chart(document.getElementById('barProducts'), {
    type:'bar',
    data:{
        labels:['Battery','Solar','Solar+Battery','Heat Pump','Aircon','EV Charger','Inverter','Maintenance'],
        datasets:[{
            data:[40,32,60,20,14,18,25,12],
            backgroundColor:[
                'rgb(79,70,229)',
                'rgb(14,165,233)',
                'rgb(34,197,94)',
                'rgb(14,165,233)',
                'rgb(245,158,11)',
                'rgb(236,72,153)',
                'rgb(20,184,166)',
                'rgb(168,85,247)'
            ],
            borderRadius:8,
            barThickness:18
        }]
    },
    options:{
        plugins:{ legend:{ display:false }},
        scales:{
            x:{ grid:{ display:false }},
            y:{ beginAtZero:true, grid:{ color:'#f1f5f9' }}
        }
    }
});

/* ================= DONUT ================= */
new Chart(document.getElementById('donutConversion'), {
    type:'doughnut',
    data:{
        labels:['Converted','Remaining'],
        datasets:[{
            data:[25.8,74.2],
            backgroundColor:[
                'rgb(79,70,229)',
                'rgb(229,231,235)'
            ],
            borderWidth:0
        }]
    },
    options:{
        cutout:'74%',
        plugins:{
            legend:{
                position:'bottom',
                labels:{
                    usePointStyle:true,
                    padding:16,
                    boxWidth:10
                }
            }
        }
    }
});
</script>
@endsection
