@extends('layouts.app')

@section('title', 'Lay Planning & Slips')
@section('page_header_title', 'Lay Planning & Lay Slips Execution')
@section('page_header_subtitle', 'Final Cut Room Stage: Marker Efficiency, Fabric Spreading & Lay Completion Slips')

@section('top_header_action')
<button type="button" class="btn-ent-primary" data-bs-toggle="modal" data-bs-target="#addLaySlipModal">
    <i class="bi bi-grid-3x3-gap"></i> Issue Lay Slip (Complete Lay)
</button>
@endsection

@section('content')
<!-- High Precision Enterprise Table -->
<div class="card-ent">
    <div class="card-ent-body p-3">
        <div class="d-flex justify-content-between align-items-center mb-3 pb-2 border-bottom">
            <div>
                <h5 class="fw-bold text-slate-900 mb-0 fs-6">Lay Slips & Completed Lays</h5>
                <p class="text-slate-500 mb-0 small" style="font-size:0.75rem;">Executed spreading lay slips, marker efficiency %, and table assignments</p>
            </div>
            <span class="badge-ent badge-ent-slate">{{ $laySlips->count() }} Lay Slip(s)</span>
        </div>

        <div class="table-responsive">
            <table class="table table-hover align-middle text-xs mb-0">
                <thead>
                    <tr class="text-slate-500 border-bottom">
                        <th class="fw-bold font-mono">LAY SLIP NO</th>
                        <th class="fw-bold">PLAN NO</th>
                        <th class="fw-bold">LAY MODEL</th>
                        <th class="fw-bold">FABRIC GROUP</th>
                        <th class="fw-bold">TABLE NO</th>
                        <th class="fw-bold">SPREADER OPERATOR</th>
                        <th class="fw-bold">PLIES</th>
                        <th class="fw-bold">LAY LENGTH</th>
                        <th class="fw-bold">MARKER EFFICIENCY</th>
                        <th class="text-end fw-bold">STATUS</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($laySlips as $slip)
                    <tr>
                        <td class="fw-bold text-primary font-mono fs-6">{{ $slip->lay_slip_no }}</td>
                        <td class="font-mono text-slate-900">{{ $slip->productionPlan ? $slip->productionPlan->plan_no : '-' }}</td>
                        <td>
                            <div class="fw-bold text-slate-900 font-mono">{{ $slip->layModel ? $slip->layModel->lay_model_code : '-' }}</div>
                            <div class="text-slate-500" style="font-size:0.7rem;">{{ $slip->layModel ? $slip->layModel->lay_model_name : '' }}</div>
                        </td>
                        <td><span class="badge-ent badge-ent-slate">{{ $slip->fabricGroup ? $slip->fabricGroup->group_name : '-' }}</span></td>
                        <td><span class="badge-ent badge-ent-blue">{{ $slip->table_no }}</span></td>
                        <td class="text-slate-700">{{ $slip->spreader_operator }}</td>
                        <td class="fw-bold font-mono-num text-slate-900">{{ number_format($slip->total_plies) }} plies</td>
                        <td class="font-mono-num text-slate-700">{{ $slip->lay_length }} yds</td>
                        <td class="fw-bold font-mono-num text-emerald-700">{{ $slip->marker_efficiency_pct }}%</td>
                        <td class="text-end">
                            <span class="badge-ent badge-ent-emerald">
                                {{ $slip->status }}
                            </span>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="10" class="text-center py-4 text-slate-500">No lay slips generated yet. Click <strong>+ Issue Lay Slip</strong> to execute.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal: Issue Lay Slip -->
<div class="modal fade" id="addLaySlipModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content rounded border-0 shadow-lg">
            <div class="modal-header bg-slate-900 text-white p-3">
                <h6 class="modal-title fw-bold text-white mb-0"><i class="bi bi-scissors me-2"></i> Issue Lay Slip & Execute Lay Completion</h6>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('lay-slips.store') }}" method="POST">
                @csrf
                <div class="modal-body p-4">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label fw-semibold small text-slate-700">Lay Slip No <span class="text-danger">*</span></label>
                            <input type="text" name="lay_slip_no" class="form-control form-control-ent" required placeholder="e.g. LS-2026-001">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold small text-slate-700">Production Plan <span class="text-danger">*</span></label>
                            <select name="production_plan_id" class="form-select form-select-ent" required>
                                <option value="">-- Select Production Plan --</option>
                                @foreach($plans as $plan)
                                    <option value="{{ $plan->id }}">{{ $plan->plan_no }} - {{ $plan->salesOrder ? $plan->salesOrder->style_no : '' }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold small text-slate-700">Lay Model <span class="text-danger">*</span></label>
                            <select name="lay_model_id" class="form-select form-select-ent" required>
                                <option value="">-- Select Lay Model --</option>
                                @foreach($layModels as $lm)
                                    <option value="{{ $lm->id }}">{{ $lm->lay_model_code }} - {{ $lm->lay_model_name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold small text-slate-700">Fabric Group <span class="text-danger">*</span></label>
                            <select name="fabric_group_id" class="form-select form-select-ent" required>
                                <option value="">-- Select Fabric Group --</option>
                                @foreach($fabricGroups as $fg)
                                    <option value="{{ $fg->id }}">{{ $fg->group_code }} - {{ $fg->group_name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-semibold small text-slate-700">Table No <span class="text-danger">*</span></label>
                            <input type="text" name="table_no" class="form-control form-control-ent" required placeholder="e.g. Table 03">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-semibold small text-slate-700">Spreader Operator <span class="text-danger">*</span></label>
                            <input type="text" name="spreader_operator" class="form-control form-control-ent" required placeholder="e.g. Robert / Team A">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-semibold small text-slate-700">Total Plies <span class="text-danger">*</span></label>
                            <input type="number" min="1" name="total_plies" class="form-control form-control-ent" value="50" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-semibold small text-slate-700">Lay Length (Yds) <span class="text-danger">*</span></label>
                            <input type="number" step="0.01" min="0.1" name="lay_length" class="form-control form-control-ent" value="12.50" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-semibold small text-slate-700">Marker Efficiency %</label>
                            <input type="number" step="0.01" min="50" max="100" name="marker_efficiency_pct" class="form-control form-control-ent" value="87.50">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-semibold small text-slate-700">Status <span class="text-danger">*</span></label>
                            <select name="status" class="form-select form-select-ent" required>
                                <option value="Lay Completed" selected>Lay Completed</option>
                                <option value="In Spreading">In Spreading</option>
                                <option value="Planned">Planned</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer bg-slate-50 p-3">
                    <button type="button" class="btn-ent-outline" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn-ent-primary">Complete Lay Process & Issue Ticket</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
