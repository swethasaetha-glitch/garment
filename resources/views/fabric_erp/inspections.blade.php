@extends('layouts.app')

@section('title', 'Fabric Inspection')
@section('page_header_title', 'Fabric Quality Inspection (4-Point System)')
@section('page_header_subtitle', 'Stage 6: Fabric Defect Inspection & Roll Grading Standards')

@section('top_header_action')
<button type="button" class="btn-ent-primary" data-bs-toggle="modal" data-bs-target="#addInspectionModal">
    <i class="bi bi-patch-check"></i> Inspect Fabric Roll
</button>
@endsection

@section('content')
<!-- High Precision Enterprise Table -->
<div class="card-ent">
    <div class="card-ent-body p-3">
        <div class="d-flex justify-content-between align-items-center mb-3 pb-2 border-bottom">
            <div>
                <h5 class="fw-bold text-slate-900 mb-0 fs-6">4-Point Inspection Logs</h5>
                <p class="text-slate-500 mb-0 small" style="font-size:0.75rem;">Quality penalty point calculation per 100 square yards</p>
            </div>
            <span class="badge-ent badge-ent-slate">{{ $inspections->count() }} Inspection Log(s)</span>
        </div>

        <div class="table-responsive">
            <table class="table table-hover align-middle text-xs mb-0">
                <thead>
                    <tr class="text-slate-500 border-bottom">
                        <th class="fw-bold font-mono">INSPECTION NO</th>
                        <th class="fw-bold">ROLL NO</th>
                        <th class="fw-bold">FABRIC NAME</th>
                        <th class="fw-bold">INSPECTED YARDS</th>
                        <th class="fw-bold">PENALTY POINTS</th>
                        <th class="fw-bold">PTS / 100 SQ YDS</th>
                        <th class="fw-bold">GRADE</th>
                        <th class="fw-bold">INSPECTOR</th>
                        <th class="text-end fw-bold">STATUS</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($inspections as $ins)
                    <tr>
                        <td class="fw-bold text-primary font-mono fs-6">{{ $ins->inspection_no }}</td>
                        <td class="fw-bold font-mono text-slate-900">{{ $ins->fabricRoll ? $ins->fabricRoll->roll_no : '-' }}</td>
                        <td class="fw-medium text-slate-800">{{ $ins->fabricRoll && $ins->fabricRoll->fabric ? $ins->fabricRoll->fabric->fabric_name : '-' }}</td>
                        <td class="font-mono-num text-slate-700">{{ number_format($ins->inspected_length) }} Yds</td>
                        <td><span class="badge-ent badge-ent-amber font-mono">{{ $ins->total_penalty_points }} pts</span></td>
                        <td class="fw-bold font-mono-num text-slate-900">{{ $ins->points_per_100_sq_yds }}</td>
                        <td><span class="badge-ent badge-ent-blue font-bold">Grade {{ $ins->grade }}</span></td>
                        <td class="text-slate-700">{{ $ins->inspector_name }}</td>
                        <td class="text-end">
                            @if($ins->status === 'Passed')
                                <span class="badge-ent badge-ent-emerald">Passed</span>
                            @else
                                <span class="badge-ent badge-ent-rose">Rejected</span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="9" class="text-center py-4 text-slate-500">No fabric roll inspections logged yet. Click <strong>+ Inspect Fabric Roll</strong> to log.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal: Log 4-Point Inspection -->
<div class="modal fade" id="addInspectionModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content rounded border-0 shadow-lg">
            <div class="modal-header bg-slate-900 text-white p-3">
                <h6 class="modal-title fw-bold text-white mb-0"><i class="bi bi-patch-check me-2"></i> Log 4-Point Fabric Inspection</h6>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('fabric-inspections.store') }}" method="POST">
                @csrf
                <div class="modal-body p-4">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label fw-semibold small text-slate-700">Inspection No <span class="text-danger">*</span></label>
                            <input type="text" name="inspection_no" class="form-control form-control-ent" required placeholder="e.g. INSP-2026-001">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold small text-slate-700">Select Fabric Roll <span class="text-danger">*</span></label>
                            <select name="fabric_roll_id" class="form-select form-select-ent" required>
                                <option value="">-- Select Pending Roll --</option>
                                @foreach($pendingRolls as $roll)
                                    <option value="{{ $roll->id }}">{{ $roll->roll_no }} - {{ $roll->fabric ? $roll->fabric->fabric_code : '' }} ({{ $roll->gross_weight }} KG)</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-semibold small text-slate-700">Inspected Length (Yds) <span class="text-danger">*</span></label>
                            <input type="number" step="0.01" min="1" name="inspected_length" class="form-control form-control-ent" required placeholder="e.g. 100">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-semibold small text-slate-700">Total Penalty Points <span class="text-danger">*</span></label>
                            <input type="number" min="0" name="total_penalty_points" class="form-control form-control-ent" required placeholder="e.g. 12">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-semibold small text-slate-700">Inspector Name <span class="text-danger">*</span></label>
                            <input type="text" name="inspector_name" class="form-control form-control-ent" value="{{ Auth::user()->name }}" required>
                        </div>
                        <div class="col-md-12">
                            <label class="form-label fw-semibold small text-slate-700">Defect Notes</label>
                            <textarea name="notes" class="form-control form-control-ent" rows="2" placeholder="e.g. Minor slubs at 25m, width uniform 72 inches"></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer bg-slate-50 p-3">
                    <button type="button" class="btn-ent-outline" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn-ent-primary">Calculate 4-Point Score & Save</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
