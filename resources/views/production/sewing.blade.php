@extends('layouts.app')

@section('title', 'Sewing Line Tracking & QC Inspection')
@section('page_header_title', 'Sewing Production & Line QC')
@section('page_header_subtitle', 'Track Tech Solutions | In-Line Inspection, Mid-Line QC & End-Line Checking')

@section('top_header_action')
<button type="button" class="btn-ent-primary" data-bs-toggle="modal" data-bs-target="#sewingInspectionModal">
    <i class="bi bi-qr-code-scan"></i> Record Sewing QC Inspection
</button>
@endsection

@section('content')
<!-- Metric Summary Cards for 3 Sewing Stages -->
<div class="row g-3 mb-4">
    <div class="col-md-3 col-sm-6">
        <div class="card-ent h-100 p-3">
            <div class="d-flex justify-content-between align-items-center mb-1">
                <span class="text-uppercase fw-bold text-slate-500 font-mono" style="font-size:0.65rem;">1. In-Line Issued</span>
                <span class="badge-ent badge-ent-blue">Sew In</span>
            </div>
            <div class="fw-bold text-slate-900 font-mono-num mb-1" style="font-size: 1.75rem; line-height: 1;">{{ $sewInCount }}</div>
            <div class="text-slate-500 small" style="font-size:0.72rem;">Bundles issued to lines</div>
        </div>
    </div>

    <div class="col-md-3 col-sm-6">
        <div class="card-ent h-100 p-3">
            <div class="d-flex justify-content-between align-items-center mb-1">
                <span class="text-uppercase fw-bold text-slate-500 font-mono" style="font-size:0.65rem;">2. Mid-Line Inspected</span>
                <span class="badge-ent badge-ent-amber">Process QC</span>
            </div>
            <div class="fw-bold text-amber-600 font-mono-num mb-1" style="font-size: 1.75rem; line-height: 1;">{{ $midLineCount }}</div>
            <div class="text-slate-500 small" style="font-size:0.72rem;">Assembly line QC checks</div>
        </div>
    </div>

    <div class="col-md-3 col-sm-6">
        <div class="card-ent h-100 p-3">
            <div class="d-flex justify-content-between align-items-center mb-1">
                <span class="text-uppercase fw-bold text-slate-500 font-mono" style="font-size:0.65rem;">3. End-Line Passed</span>
                <span class="badge-ent badge-ent-emerald">Sew Out</span>
            </div>
            <div class="fw-bold text-emerald-600 font-mono-num mb-1" style="font-size: 1.75rem; line-height: 1;">{{ $endLineCount }}</div>
            <div class="text-slate-500 small" style="font-size:0.72rem;">Cleared sew out bundles</div>
        </div>
    </div>

    <div class="col-md-3 col-sm-6">
        <div class="card-ent h-100 p-3">
            <div class="d-flex justify-content-between align-items-center mb-1">
                <span class="text-uppercase fw-bold text-slate-500 font-mono" style="font-size:0.65rem;">Total Scans Today</span>
                <span class="badge-ent badge-ent-blue">Scans</span>
            </div>
            <div class="fw-bold text-sky-600 font-mono-num mb-1" style="font-size: 1.75rem; line-height: 1;">{{ $scans->count() }}</div>
            <div class="text-slate-500 small" style="font-size:0.72rem;">In-line, Mid-line & End-line</div>
        </div>
    </div>
</div>

<!-- 1. Sewing Line QR Scan History & Logs -->
<div class="card-ent mb-4">
    <div class="card-ent-body p-3">
        <div class="d-flex justify-content-between align-items-center mb-3 pb-2 border-bottom">
            <div>
                <h5 class="fw-bold text-slate-900 mb-0 fs-6">Live Sewing Scan Terminal Logs</h5>
                <p class="text-slate-500 mb-0 small" style="font-size:0.75rem;">Timestamped records for In-Scan, Mid-Line QC, and Out-Scan</p>
            </div>
            <span class="badge-ent badge-ent-blue">{{ $scans->count() }} Scans Logged</span>
        </div>

        <div class="table-responsive">
            <table class="table table-hover align-middle text-xs mb-0">
                <thead>
                    <tr class="text-slate-500 border-bottom">
                        <th class="fw-bold font-mono">SCAN ID</th>
                        <th class="fw-bold">BUNDLE TICKET</th>
                        <th class="fw-bold">SCAN TYPE</th>
                        <th class="fw-bold">MACHINE</th>
                        <th class="fw-bold">OPERATOR</th>
                        <th class="text-end fw-bold">TIMESTAMP</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($scans as $sc)
                    <tr>
                        <td class="fw-bold text-primary font-mono">#SCAN-{{ $sc->id }}</td>
                        <td>
                            <div class="fw-bold text-slate-900 font-mono">{{ $sc->lotBundle?->bundle_no }}</div>
                            <div class="text-slate-500" style="font-size:0.7rem;">Size: {{ $sc->lotBundle?->size }} ({{ number_format($sc->lotBundle?->garment_qty) }} Pcs)</div>
                        </td>
                        <td>
                            @if($sc->scan_type === 'in_scan')
                                <span class="badge-ent badge-ent-amber">1. IN-LINE (IN-SCAN)</span>
                            @elseif($sc->scan_type === 'mid_scan')
                                <span class="badge-ent badge-ent-blue">2. MID-LINE QC</span>
                            @else
                                <span class="badge-ent badge-ent-emerald">3. END-LINE (SEW OUT)</span>
                            @endif
                        </td>
                        <td class="fw-bold text-slate-800 font-mono">{{ $sc->machine?->machine_no ?? 'MC-SEW-101' }}</td>
                        <td class="text-slate-700">{{ $sc->operator?->name ?? 'Priya Ramesh' }}</td>
                        <td class="text-end font-mono-num text-slate-500">{{ $sc->scanned_at?->format('H:i:s, d M Y') ?? now()->format('H:i:s, d M Y') }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center py-4 text-slate-500">No sewing scans logged yet. Click "Record Sewing QC Inspection" above to scan.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- 2. Sewing Line Bundles Stage Status -->
<div class="card-ent">
    <div class="card-ent-body p-3">
        <div class="d-flex justify-content-between align-items-center mb-3 pb-2 border-bottom">
            <div>
                <h5 class="fw-bold text-slate-900 mb-0 fs-6">Sewing Bundle Operational Flow</h5>
                <p class="text-slate-500 mb-0 small" style="font-size:0.75rem;">Bundle tracking through In-Line &rarr; Mid-Line QC &rarr; End-Line &rarr; Laundry/Washing</p>
            </div>
            <span class="badge-ent badge-ent-slate">{{ $lotBundles->count() }} Active Bundles</span>
        </div>

        <div class="table-responsive">
            <table class="table table-hover align-middle text-xs mb-0">
                <thead>
                    <tr class="text-slate-500 border-bottom">
                        <th class="fw-bold font-mono">BUNDLE TICKET</th>
                        <th class="fw-bold">SIZE & SHADE</th>
                        <th class="fw-bold">GARMENT QTY</th>
                        <th class="fw-bold">CURRENT STAGE</th>
                        <th class="fw-bold">LINE OPERATOR</th>
                        <th class="text-end fw-bold">LAUNDRY ROUTING</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($lotBundles as $bnd)
                    <tr>
                        <td class="fw-bold text-primary font-mono fs-6">{{ $bnd->bundle_no }}</td>
                        <td>
                            <span class="badge-ent badge-ent-slate font-mono">{{ $bnd->size }}</span>
                            <span class="text-sky-700 fw-semibold font-mono ms-1">{{ $bnd->shade_group }}</span>
                        </td>
                        <td class="fw-bold font-mono-num text-emerald-700">{{ number_format($bnd->garment_qty) }} Pcs</td>
                        <td>
                            <span class="badge-ent badge-ent-emerald uppercase">
                                {{ str_replace('_', ' ', $bnd->stage) }}
                            </span>
                        </td>
                        <td class="text-slate-700">{{ $bnd->operator?->name ?? 'Priya Ramesh' }}</td>
                        <td class="text-end">
                            @if(in_array($bnd->stage, ['sew_out', 'washing_laundry']))
                                <span class="badge-ent badge-ent-blue uppercase"><i class="bi bi-droplet-fill me-1"></i> Routed to Laundry</span>
                            @else
                                <span class="badge-ent badge-ent-slate uppercase"><i class="bi bi-clock me-1"></i> In Assembly</span>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal: Record Sewing QC Inspection -->
<div class="modal fade" id="sewingInspectionModal" tabindex="-1" aria-labelledby="sewingInspectionModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content rounded border-0 shadow-lg">
            <div class="modal-header bg-slate-900 text-white p-3">
                <h6 class="modal-title fw-bold text-white mb-0" id="sewingInspectionModalLabel">
                    <i class="bi bi-patch-check me-2"></i> Record Sewing QC Inspection (In-Line, Mid-Line, End-Line)
                </h6>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('production.sewing.store') }}" method="POST">
                @csrf
                <div class="modal-body p-4">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label fw-semibold small text-slate-700">Lot Bundle QR Ticket</label>
                            <select name="lot_bundle_id" required class="form-select form-select-ent">
                                <option value="" disabled selected>Select Bundle Ticket...</option>
                                @foreach($lotBundles as $bnd)
                                    <option value="{{ $bnd->id }}">{{ $bnd->bundle_no }} — Size: {{ $bnd->size }} ({{ $bnd->garment_qty }} Pcs) [Stage: {{ strtoupper(str_replace('_', ' ', $bnd->stage)) }}]</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-semibold small text-slate-700">Sewing Inspection Stage</label>
                            <select name="scan_stage" required class="form-select form-select-ent">
                                <option value="in_line">1. In-Line Inspection (Line Start / Sew In)</option>
                                <option value="mid_line" selected>2. Mid-Line QC Tracking (Assembly Seams)</option>
                                <option value="end_line">3. End-Line Checking (Sew Out Clearance)</option>
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-semibold small text-slate-700">Sewing Machine & Line</label>
                            <select name="machine_id" class="form-select form-select-ent">
                                <option value="">Select Sewing Machine...</option>
                                @foreach($sewingMachines as $mc)
                                    <option value="{{ $mc->id }}">{{ $mc->machine_no }} — {{ $mc->machine_name }} ({{ $mc->line_no ?? 'Line 1' }})</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-semibold small text-slate-700">Line Operator</label>
                            <select name="operator_id" class="form-select form-select-ent">
                                <option value="">Select Operator...</option>
                                @foreach($operators as $op)
                                    <option value="{{ $op->id }}">{{ $op->operator_code }} — {{ $op->name }} ({{ $op->skill_level }})</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-semibold small text-slate-700">Inspection Result</label>
                            <select name="inspection_result" required class="form-select form-select-ent">
                                <option value="pass">PASS — Approved</option>
                                <option value="rework">REWORK — Defect Detected</option>
                                <option value="reject">REJECT — Scrap</option>
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-semibold small text-slate-700">Garment Defect (If Rework)</label>
                            <select name="garment_defect_id" class="form-select form-select-ent">
                                <option value="">None / Pass</option>
                                @foreach($defects as $def)
                                    <option value="{{ $def->id }}">{{ $def->defect_code }} — {{ $def->defect_name }} ({{ $def->category }})</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-12">
                            <label class="form-label fw-semibold small text-slate-700">Inspector Remarks / QC Notes</label>
                            <input type="text" name="remarks" placeholder="e.g. Seam tension adjusted on single needle machine." class="form-control form-control-ent">
                        </div>
                    </div>
                </div>
                <div class="modal-footer bg-slate-50 p-3">
                    <button type="button" class="btn-ent-outline" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn-ent-primary">
                        Save Inspection Record
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
