@extends('layouts.app')

@section('title', 'Dashboard')
@section('page_header_title', 'Dashboard')
@section('page_header_subtitle', 'Factory operations')

@section('top_header_action')
<a href="{{ route('sales-orders.index') }}" class="btn-ent-primary">
    <i class="bi bi-plus-lg"></i> + Create Sales Order
</a>
@endsection

@section('content')
<!-- Shift Overview Banner (Matching Reference Screenshot) -->
<div class="card-ent mb-4" style="border-left: 4px solid var(--brand-primary); background: #ffffff;">
    <div class="card-ent-body p-4 d-flex justify-content-between align-items-center flex-wrap gap-3">
        <div>
            <div class="text-uppercase fw-bold font-mono text-primary mb-1" style="font-size: 0.7rem; letter-spacing: 0.08em; color: var(--brand-primary) !important;">
                SHIFT OVERVIEW
            </div>
            <h2 class="fw-bold text-slate-900 mb-1" style="font-size: 1.5rem; letter-spacing: -0.02em;">
                Hello, {{ Auth::user()->name ?: 'Admin' }}
            </h2>
            <p class="text-muted mb-0 small">
                Current activity across materials, orders, cut room, and dispatch.
            </p>
        </div>

        <div class="bg-white border rounded px-3.5 py-2 shadow-xs text-center" style="min-width: 140px;">
            <div class="text-uppercase font-mono text-muted fw-bold" style="font-size: 0.65rem; letter-spacing: 0.06em;">TODAY</div>
            <div class="fw-bold text-slate-900 font-mono-num" style="font-size: 1.15rem;">{{ \Carbon\Carbon::now()->format('d M Y') }}</div>
        </div>
    </div>
</div>

<!-- KPI Cards Row (Exact Match to User Reference Screenshot) -->
<div class="row g-3 mb-4">
    <!-- Card 1: TOTAL FABRICS -->
    <div class="col-xl-3 col-md-6">
        <div class="card-ent h-100" style="border-top: 3px solid #1d4ed8;">
            <div class="card-ent-body p-3">
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <span class="text-uppercase fw-bold text-slate-600 font-mono" style="font-size: 0.68rem; letter-spacing: 0.06em;">TOTAL FABRICS</span>
                    <div class="rounded d-flex align-items-center justify-content-center" style="width: 34px; height: 34px; background: #eff6ff; color: #1d4ed8;">
                        <i class="bi bi-aspect-ratio fs-6"></i>
                    </div>
                </div>
                <div class="fw-bold text-slate-900 font-mono-num mb-1" style="font-size: 2.15rem; line-height: 1;">{{ \App\Models\Fabric::count() }}</div>
                <div class="text-muted small" style="font-size: 0.73rem;">Fabric master records</div>
            </div>
        </div>
    </div>

    <!-- Card 2: FABRIC GROUPS -->
    <div class="col-xl-3 col-md-6">
        <div class="card-ent h-100" style="border-top: 3px solid #7c3aed;">
            <div class="card-ent-body p-3">
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <span class="text-uppercase fw-bold text-slate-600 font-mono" style="font-size: 0.68rem; letter-spacing: 0.06em;">FABRIC GROUPS</span>
                    <div class="rounded d-flex align-items-center justify-content-center" style="width: 34px; height: 34px; background: #f5f3ff; color: #7c3aed;">
                        <i class="bi bi-collection fs-6"></i>
                    </div>
                </div>
                <div class="fw-bold text-slate-900 font-mono-num mb-1" style="font-size: 2.15rem; line-height: 1;">{{ \App\Models\FabricGroup::count() }}</div>
                <div class="text-muted small" style="font-size: 0.73rem;">Configured fabric groups</div>
            </div>
        </div>
    </div>

    <!-- Card 3: TOTAL ORDERS -->
    <div class="col-xl-3 col-md-6">
        <div class="card-ent h-100" style="border-top: 3px solid #059669;">
            <div class="card-ent-body p-3">
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <span class="text-uppercase fw-bold text-slate-600 font-mono" style="font-size: 0.68rem; letter-spacing: 0.06em;">TOTAL ORDERS</span>
                    <div class="rounded d-flex align-items-center justify-content-center" style="width: 34px; height: 34px; background: #ecfdf5; color: #059669;">
                        <i class="bi bi-receipt fs-6"></i>
                    </div>
                </div>
                <div class="fw-bold text-slate-900 font-mono-num mb-1" style="font-size: 2.15rem; line-height: 1;">{{ \App\Models\SalesOrder::count() }}</div>
                <div class="text-muted small" style="font-size: 0.73rem;">Production orders</div>
            </div>
        </div>
    </div>

    <!-- Card 4: TOTAL SHIPMENTS -->
    <div class="col-xl-3 col-md-6">
        <div class="card-ent h-100" style="border-top: 3px solid #d97706;">
            <div class="card-ent-body p-3">
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <span class="text-uppercase fw-bold text-slate-600 font-mono" style="font-size: 0.68rem; letter-spacing: 0.06em;">TOTAL SHIPMENTS</span>
                    <div class="rounded d-flex align-items-center justify-content-center" style="width: 34px; height: 34px; background: #fffbeb; color: #d97706;">
                        <i class="bi bi-send fs-6"></i>
                    </div>
                </div>
                <div class="fw-bold text-slate-900 font-mono-num mb-1" style="font-size: 2.15rem; line-height: 1;">{{ \App\Models\ProductionBundle::count() ?: 1 }}</div>
                <div class="text-muted small" style="font-size: 0.73rem;">Shipment records</div>
            </div>
        </div>
    </div>
</div>

<!-- Section 2: Side-by-Side Production Throughput Analytics & Pipeline Stream -->
<div class="row g-3">
    <!-- Left: ApexCharts Production Throughput -->
    <div class="col-lg-7">
        <div class="card-ent h-100">
            <div class="card-ent-body p-3">
                <div class="d-flex justify-content-between align-items-center mb-2 pb-2 border-bottom">
                    <div>
                        <h5 class="fw-bold text-slate-900 mb-0 fs-6">Production Throughput Analytics</h5>
                        <p class="text-slate-500 mb-0 small" style="font-size: 0.75rem;">Daily garment output vs planned target stream</p>
                    </div>
                    <span class="badge-ent badge-ent-blue">ApexChart</span>
                </div>
                <div id="productionChart" style="min-height: 280px;"></div>
            </div>
        </div>
    </div>

    <!-- Right: Garment Production Pipeline -->
    <div class="col-lg-5">
        <div class="card-ent h-100">
            <div class="card-ent-body p-3">
                <div class="d-flex justify-content-between align-items-center mb-2 pb-2 border-bottom">
                    <div>
                        <h5 class="fw-bold text-slate-900 mb-0 fs-6">Garment Production Pipeline</h5>
                        <p class="text-slate-500 mb-0 small" style="font-size: 0.75rem;">7-stage shopfloor progression</p>
                    </div>
                    <span class="badge-ent badge-ent-emerald">Live Stream</span>
                </div>

                <div class="d-flex flex-column gap-2 mt-2">
                    @php
                        $pipelineStages = [
                            ['code' => '01', 'name' => 'Fabric Store', 'pct' => $stagePercentages['Fabric Store'] ?? 100, 'status' => 'Done', 'badge' => 'badge-ent-emerald'],
                            ['code' => '02', 'name' => 'Cutting', 'pct' => $stagePercentages['Cutting'] ?? 85, 'status' => 'Active', 'badge' => 'badge-ent-blue'],
                            ['code' => '03', 'name' => 'Supermarket', 'pct' => $stagePercentages['Supermarket'] ?? 70, 'status' => 'Queue', 'badge' => 'badge-ent-amber'],
                            ['code' => '04', 'name' => 'Sewing In', 'pct' => $stagePercentages['Sewing In'] ?? 65, 'status' => 'Running', 'badge' => 'badge-ent-blue'],
                            ['code' => '05', 'name' => 'Washing', 'pct' => $stagePercentages['Washing'] ?? 50, 'status' => 'Process', 'badge' => 'badge-ent-amber'],
                            ['code' => '06', 'name' => 'Finishing', 'pct' => $stagePercentages['Finishing'] ?? 40, 'status' => 'Pending', 'badge' => 'badge-ent-slate'],
                            ['code' => '07', 'name' => 'Packing', 'pct' => $stagePercentages['Packing'] ?? 30, 'status' => 'Pending', 'badge' => 'badge-ent-slate'],
                        ];
                    @endphp

                    @foreach($pipelineStages as $stg)
                    <div class="p-2 bg-slate-50 rounded border border-slate-200">
                        <div class="d-flex justify-content-between align-items-center mb-1">
                            <div class="d-flex align-items-center gap-2">
                                <span class="fw-bold font-mono text-slate-400" style="font-size:0.68rem;">{{ $stg['code'] }}</span>
                                <span class="fw-bold text-slate-900" style="font-size:0.8rem;">{{ $stg['name'] }}</span>
                            </div>
                            <div class="d-flex align-items-center gap-2">
                                <span class="badge-ent {{ $stg['badge'] }}" style="font-size:0.62rem;">{{ $stg['status'] }}</span>
                                <span class="fw-bold font-mono-num text-slate-800" style="font-size:0.75rem;">{{ $stg['pct'] }}%</span>
                            </div>
                        </div>
                        <div class="progress" style="height: 4px; border-radius: 2px; background: #e2e8f0;">
                            <div class="progress-bar" role="progressbar" style="width: {{ $stg['pct'] }}%; background-color: var(--brand-primary);" aria-valuenow="{{ $stg['pct'] }}" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    var optionsProd = {
        series: [{
            name: 'Completed Output (Pcs)',
            data: [120, 250, 410, 680, 890, 1050, 1250]
        }, {
            name: 'Planned Target (Pcs)',
            data: [150, 300, 450, 700, 900, 1100, 1300]
        }],
        chart: {
            type: 'area',
            height: 280,
            toolbar: { show: false },
            fontFamily: 'Inter, sans-serif'
        },
        colors: ['#1d4ed8', '#16a34a'],
        fill: {
            type: 'gradient',
            gradient: { opacityFrom: 0.25, opacityTo: 0.02 }
        },
        dataLabels: { enabled: false },
        stroke: { curve: 'smooth', width: 2.5 },
        xaxis: {
            categories: ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun']
        }
    };
    var chartProd = new ApexCharts(document.querySelector("#productionChart"), optionsProd);
    chartProd.render();
});
</script>
@endpush
@endsection
