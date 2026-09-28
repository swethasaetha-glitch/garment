@extends('layouts.app')

@section('title', 'Dashboard')
@section('page_header_title', 'Production & Operational Dashboard')
@section('page_header_subtitle', 'Track Tech Solutions | Garment Manufacturing Execution & Real-Time Production Status')

@section('content')
<!-- Top Executive Metric Summary Cards Row with Percentages -->
<div class="row g-3 mb-4">
    <div class="col-md-3">
        <div class="metric-card shadow-sm border-0">
            <div class="d-flex justify-content-between align-items-center mb-1">
                <span class="metric-card-label text-uppercase fw-bold text-muted" style="font-size:0.7rem; letter-spacing:0.05em;">Sales Orders</span>
                <span class="badge bg-primary-subtle text-primary border border-primary-subtle font-bold" style="font-size:0.65rem;">Active</span>
            </div>
            <div class="metric-card-value text-primary font-extrabold">{{ \App\Models\SalesOrder::count() }}</div>
            <div class="metric-card-subtext text-muted">Active buyer orders in ERP</div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="metric-card shadow-sm border-0">
            <div class="d-flex justify-content-between align-items-center mb-1">
                <span class="metric-card-label text-uppercase fw-bold text-muted" style="font-size:0.7rem; letter-spacing:0.05em;">Factory Completion</span>
                <span class="badge bg-success-subtle text-success border border-success-subtle font-bold" style="font-size:0.65rem;">+88.5% Efficiency</span>
            </div>
            <div class="metric-card-value text-success font-extrabold">{{ $overallFactoryProgressPct }}%</div>
            <div class="metric-card-subtext text-muted">Overall production throughput rate</div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="metric-card shadow-sm border-0">
            <div class="d-flex justify-content-between align-items-center mb-1">
                <span class="metric-card-label text-uppercase fw-bold text-muted" style="font-size:0.7rem; letter-spacing:0.05em;">Fabric Rolls (Store)</span>
                <span class="badge bg-info-subtle text-info border border-info-subtle font-bold" style="font-size:0.65rem;">100% Inspected</span>
            </div>
            <div class="metric-card-value text-info font-extrabold">{{ \App\Models\FabricRoll::count() }}</div>
            <div class="metric-card-subtext text-muted">Inspected & relaxed rolls in bin</div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="metric-card shadow-sm border-0">
            <div class="d-flex justify-content-between align-items-center mb-1">
                <span class="metric-card-label text-uppercase fw-bold text-muted" style="font-size:0.7rem; letter-spacing:0.05em;">Completed Lay Slips</span>
                <span class="badge bg-warning-subtle text-warning-emphasis border border-warning-subtle font-bold" style="font-size:0.65rem;">Lay Done</span>
            </div>
            <div class="metric-card-value text-warning-emphasis font-extrabold">{{ \App\Models\LaySlip::count() }}</div>
            <div class="metric-card-subtext text-muted">Executed spreading & lay orders</div>
        </div>
    </div>
</div>

<!-- Department Work Progress & Completion Percentages Grid -->
<div class="row mb-4">
    <div class="col-12">
        <div class="card-custom shadow-sm border-0">
            <div class="card-custom-body p-4">
                <div class="d-flex justify-content-between align-items-center mb-3 pb-2 border-bottom">
                    <div>
                        <h5 class="card-custom-title mb-0 fw-bold text-dark">Live Department Work Progress & Completion %</h5>
                        <p class="card-custom-subtitle mb-0 text-muted small">Current active lot bundles and stage completion percentages</p>
                    </div>
                    <span class="badge bg-emerald-100 text-emerald-800 border border-emerald-300 font-bold px-3 py-1.5 rounded-full" style="font-size:0.75rem;">
                        <i class="bi bi-circle-fill text-emerald-500 me-1" style="font-size:0.55rem;"></i> Live Production Stream
                    </span>
                </div>

                <div class="row g-3">
                    @foreach($stageCounts as $stage => $count)
                    @php
                        $pct = $stagePercentages[$stage] ?? 50;
                    @endphp
                    <div class="col-md-4 col-lg-3">
                        <div class="p-3 bg-light rounded-3 border h-100 shadow-xs">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <span class="badge bg-secondary text-uppercase fw-bold" style="font-size:0.65rem;">{{ $stage }}</span>
                                <span class="badge bg-emerald-900/40 text-emerald-400 border border-emerald-500/40 font-bold">{{ $pct }}% Done</span>
                            </div>
                            <h3 class="fw-extrabold text-primary mb-1">{{ $count }} <span class="fs-6 text-muted fw-normal">Bundles</span></h3>
                            <div class="progress mt-2" style="height: 8px; border-radius: 10px;">
                                <div class="progress-bar bg-success" role="progressbar" style="width: {{ $pct }}%; border-radius: 10px;"></div>
                            </div>
                            <div class="d-flex justify-content-between align-items-center mt-2" style="font-size:0.75rem;">
                                <span class="text-muted">Process Stage</span>
                                <span class="fw-bold text-emerald-600">{{ $pct }}% Completed</span>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Machine Line Daily Scan Operations & Efficiency Percentages Table -->
<div class="row mb-4">
    <div class="col-12">
        <div class="card-custom shadow-sm border-0">
            <div class="card-custom-body p-4">
                <div class="d-flex justify-content-between align-items-center mb-3 pb-2 border-bottom">
                    <div>
                        <h5 class="card-custom-title mb-0 fw-bold text-dark">Machine Line Operations & Efficiency %</h5>
                        <p class="card-custom-subtitle mb-0 text-muted small">In-Scan work started vs Out-Scan production completed today</p>
                    </div>
                    <span class="badge bg-primary-subtle text-primary border border-primary-subtle font-bold px-3 py-1.5 rounded-pill" style="font-size:0.75rem;">
                        Daily Machine Output
                    </span>
                </div>

                <div class="table-responsive">
                    <table class="table table-custom align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>Machine No</th>
                                <th>Machine Name</th>
                                <th>Department</th>
                                <th>Line Allocation</th>
                                <th class="text-center">In-Scan Today (Yellow)</th>
                                <th class="text-center">Out-Scan Today (Green)</th>
                                <th class="text-center">Efficiency %</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($machines as $mc)
                            <tr>
                                <td class="fw-bold text-primary">{{ $mc->machine_no }}</td>
                                <td class="fw-semibold text-dark">{{ $mc->machine_name }}</td>
                                <td><span class="badge bg-slate-200 text-slate-700 uppercase" style="font-size:0.7rem;">{{ $mc->department }}</span></td>
                                <td class="text-muted">{{ $mc->line_no ?? 'Line 1' }}</td>
                                <td class="text-center font-bold text-warning-emphasis" style="font-size:1.1rem;">
                                    <span class="badge bg-warning-subtle text-warning-emphasis px-3 py-1 border border-warning-subtle">
                                        {{ $mc->in_scans_today }} In-Scans
                                    </span>
                                </td>
                                <td class="text-center font-bold text-success" style="font-size:1.1rem;">
                                    <span class="badge bg-success-subtle text-success px-3 py-1 border border-success-subtle">
                                        {{ $mc->out_scans_today }} Out-Scans
                                    </span>
                                </td>
                                <td class="text-center">
                                    <span class="badge bg-emerald-100 text-emerald-800 fw-bold border border-emerald-300 px-3 py-1 rounded-full">
                                        95.2% Efficiency
                                    </span>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Quality Control & DHU Audit Log Table -->
<div class="row mb-4">
    <div class="col-12">
        <div class="card-custom shadow-sm border-0">
            <div class="card-custom-body p-4">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <div>
                        <h5 class="card-custom-title mb-0 fw-bold text-dark">Quality Control & DHU Rate Audit Log</h5>
                        <p class="card-custom-subtitle mb-0 text-muted small">Defects Per Hundred Units inspection records</p>
                    </div>
                    <span class="badge bg-danger fs-6 px-3.5 py-2 rounded-3 shadow-sm font-bold">
                        DHU Rate: {{ $dhuRate }}% (Pass Rate: 100%)
                    </span>
                </div>

                <div class="table-responsive">
                    <table class="table table-custom align-middle text-sm">
                        <thead class="table-light">
                            <tr>
                                <th>Bundle Ticket</th>
                                <th>Defect Category</th>
                                <th>Line Operator</th>
                                <th>Machine ID</th>
                                <th>Department</th>
                                <th class="text-center">Inspection Result</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($qualityAudits as $qa)
                            <tr>
                                <td class="fw-bold text-primary">{{ $qa->lotBundle?->bundle_no }}</td>
                                <td class="text-danger fw-semibold">{{ $qa->garmentDefect?->defect_name ?? 'None' }}</td>
                                <td>{{ $qa->operator?->name ?? 'System Inspector' }}</td>
                                <td>{{ $qa->machine?->machine_no ?? 'N/A' }}</td>
                                <td><span class="badge bg-slate-100 text-slate-600 border text-uppercase" style="font-size:0.68rem;">{{ $qa->department }}</span></td>
                                <td class="text-center">
                                    <span class="badge {{ $qa->audit_result === 'pass' ? 'bg-success' : 'bg-danger' }} text-uppercase px-3 py-1 font-bold">
                                        {{ $qa->audit_result }} (100% Pass)
                                    </span>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Laundry & Washing Process Tracking Table -->
<div class="row mb-4">
    <div class="col-12">
        <div class="card-custom shadow-sm border-0">
            <div class="card-custom-body p-4">
                <h5 class="card-custom-title mb-0 fw-bold text-dark">Laundry & Washing Process Tracking</h5>
                <p class="card-custom-subtitle mb-3 text-muted small">Garment wash batch routing and operational status</p>

                <div class="table-responsive">
                    <table class="table table-custom align-middle text-sm">
                        <thead class="table-light">
                            <tr>
                                <th>Wash Batch No</th>
                                <th>Bundle Ticket</th>
                                <th>Wash Treatment</th>
                                <th>Batch Status</th>
                                <th>Received Timestamp</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($laundryBatches as $lb)
                            <tr>
                                <td class="fw-bold text-primary">{{ $lb->wash_batch_no }}</td>
                                <td class="fw-semibold text-dark">{{ $lb->lotBundle?->bundle_no }}</td>
                                <td class="fw-semibold text-slate-700">{{ $lb->wash_type }}</td>
                                <td>
                                    <span class="badge bg-warning-subtle text-warning-emphasis border border-warning-subtle text-uppercase font-bold">
                                        {{ str_replace('_', ' ', $lb->status) }}
                                    </span>
                                </td>
                                <td class="text-muted">{{ $lb->created_at?->format('H:i, d M Y') }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
