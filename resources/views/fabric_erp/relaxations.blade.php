@extends('layouts.app')

@section('title', 'Fabric Relaxation')
@section('page_header_title', 'Fabric Relaxation & Shrinkage Log')
@section('page_header_subtitle', 'Stage 7: Pre-Cutting Fabric Relaxation Hours & Shrinkage Test Stream')

@section('top_header_action')
<button type="button" class="btn-ent-primary" data-bs-toggle="modal" data-bs-target="#addRelaxationModal">
    <i class="bi bi-clock-history"></i> Log Fabric Relaxation
</button>
@endsection

@section('content')
<!-- High Precision Enterprise Table -->
<div class="card-ent">
    <div class="card-ent-body p-3">
        <div class="d-flex justify-content-between align-items-center mb-3 pb-2 border-bottom">
            <div>
                <h5 class="fw-bold text-slate-900 mb-0 fs-6">Fabric Relaxation Records</h5>
                <p class="text-slate-500 mb-0 small" style="font-size:0.75rem;">Roll relaxation duration, tension release, and shrinkage test results</p>
            </div>
            <span class="badge-ent badge-ent-slate">{{ $relaxations->count() }} Relaxation Log(s)</span>
        </div>

        <div class="table-responsive">
            <table class="table table-hover align-middle text-xs mb-0">
                <thead>
                    <tr class="text-slate-500 border-bottom">
                        <th class="fw-bold font-mono">RELAXATION NO</th>
                        <th class="fw-bold">ROLL NO</th>
                        <th class="fw-bold">FABRIC NAME</th>
                        <th class="fw-bold">START TIME</th>
                        <th class="fw-bold">END TIME</th>
                        <th class="fw-bold">REQUIRED HOURS</th>
                        <th class="fw-bold">SHRINKAGE %</th>
                        <th class="text-end fw-bold">STATUS</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($relaxations as $rel)
                    <tr>
                        <td class="fw-bold text-primary font-mono fs-6">{{ $rel->relaxation_no }}</td>
                        <td class="fw-bold font-mono text-slate-900">{{ $rel->fabricRoll ? $rel->fabricRoll->roll_no : '-' }}</td>
                        <td class="fw-medium text-slate-800">{{ $rel->fabricRoll && $rel->fabricRoll->fabric ? $rel->fabricRoll->fabric->fabric_name : '-' }}</td>
                        <td class="font-mono-num text-slate-700">{{ \Carbon\Carbon::parse($rel->start_time)->format('M d, H:i') }}</td>
                        <td class="font-mono-num text-slate-700">{{ $rel->end_time ? \Carbon\Carbon::parse($rel->end_time)->format('M d, H:i') : '-' }}</td>
                        <td><span class="badge-ent badge-ent-slate font-mono">{{ $rel->required_hours }} Hours</span></td>
                        <td class="fw-bold font-mono-num text-sky-700">{{ $rel->shrinkage_pct }}%</td>
                        <td class="text-end">
                            <span class="badge-ent badge-ent-emerald">
                                {{ $rel->status }}
                            </span>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="text-center py-4 text-slate-500">No fabric relaxation logs recorded yet. Click <strong>+ Log Fabric Relaxation</strong> to record.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal: Log Fabric Relaxation -->
<div class="modal fade" id="addRelaxationModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content rounded border-0 shadow-lg">
            <div class="modal-header bg-slate-900 text-white p-3">
                <h6 class="modal-title fw-bold text-white mb-0"><i class="bi bi-clock-history me-2"></i> Log Fabric Relaxation & Shrinkage Test</h6>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('fabric-relaxations.store') }}" method="POST">
                @csrf
                <div class="modal-body p-4">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label fw-semibold small text-slate-700">Relaxation No <span class="text-danger">*</span></label>
                            <input type="text" name="relaxation_no" class="form-control form-control-ent" required placeholder="e.g. REL-2026-001">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold small text-slate-700">Passed Fabric Roll <span class="text-danger">*</span></label>
                            <select name="fabric_roll_id" class="form-select form-select-ent" required>
                                <option value="">-- Select Passed Roll --</option>
                                @foreach($passedRolls as $roll)
                                    <option value="{{ $roll->id }}">{{ $roll->roll_no }} - {{ $roll->fabric ? $roll->fabric->fabric_code : '' }} ({{ $roll->shade }})</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold small text-slate-700">Start Time <span class="text-danger">*</span></label>
                            <input type="datetime-local" name="start_time" class="form-control form-control-ent" value="{{ date('Y-m-d\TH:i') }}" required>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label fw-semibold small text-slate-700">Required Hours <span class="text-danger">*</span></label>
                            <input type="number" min="1" name="required_hours" class="form-control form-control-ent" value="24" required>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label fw-semibold small text-slate-700">Shrinkage %</label>
                            <input type="number" step="0.01" min="0" name="shrinkage_pct" class="form-control form-control-ent" value="1.50">
                        </div>
                    </div>
                </div>
                <div class="modal-footer bg-slate-50 p-3">
                    <button type="button" class="btn-ent-outline" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn-ent-primary">Log Relaxation & Mark Ready</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
