@extends('layouts.app')

@section('title', 'Fabric Reservation')
@section('page_header_title', 'Fabric Roll Reservation & Store Allocation')
@section('page_header_subtitle', 'Reserve & Assign Fabric Rolls to Production Orders & Cut Rooms')

@section('top_header_action')
<button type="button" class="btn-ent-primary" data-bs-toggle="modal" data-bs-target="#addReservationModal">
    <i class="bi bi-bookmark-check"></i> Reserve Fabric Roll
</button>
@endsection

@section('content')
<!-- High Precision Enterprise Table -->
<div class="card-ent">
    <div class="card-ent-body p-3">
        <div class="d-flex justify-content-between align-items-center mb-3 pb-2 border-bottom">
            <div>
                <h5 class="fw-bold text-slate-900 mb-0 fs-6">Fabric Roll Reservation Log</h5>
                <p class="text-slate-500 mb-0 small" style="font-size:0.75rem;">Fabric roll pre-allocations and bin storage locations</p>
            </div>
            <span class="badge-ent badge-ent-slate">{{ $reservations->count() }} Reservation(s)</span>
        </div>

        <div class="table-responsive">
            <table class="table table-hover align-middle text-xs mb-0">
                <thead>
                    <tr class="text-slate-500 border-bottom">
                        <th class="fw-bold font-mono">RESERVATION NO</th>
                        <th class="fw-bold">ROLL NO</th>
                        <th class="fw-bold">FABRIC CODE & NAME</th>
                        <th class="fw-bold">REQUESTED BY DEPT</th>
                        <th class="fw-bold">BIN / LOCATION</th>
                        <th class="text-end fw-bold">STATUS</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($reservations as $res)
                    <tr>
                        <td class="fw-bold text-primary font-mono fs-6">{{ $res->reservation_no }}</td>
                        <td class="fw-bold font-mono text-slate-900">{{ $res->fabricRoll ? $res->fabricRoll->roll_no : '-' }}</td>
                        <td>
                            <div class="fw-bold text-slate-900 font-mono">{{ $res->fabricRoll && $res->fabricRoll->fabric ? $res->fabricRoll->fabric->fabric_code : '-' }}</div>
                            <div class="text-slate-500" style="font-size:0.7rem;">{{ $res->fabricRoll && $res->fabricRoll->fabric ? $res->fabricRoll->fabric->fabric_name : '' }}</div>
                        </td>
                        <td class="fw-semibold text-slate-800">{{ $res->requested_by_dept }}</td>
                        <td><span class="badge-ent badge-ent-blue font-mono">{{ $res->storage_location }}</span></td>
                        <td class="text-end">
                            <span class="badge-ent badge-ent-emerald">
                                {{ $res->status }}
                            </span>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center py-4 text-slate-500">No fabric roll reservations logged yet. Click <strong>+ Reserve Fabric Roll</strong> to create one.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal: Reserve Fabric Roll -->
<div class="modal fade" id="addReservationModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content rounded border-0 shadow-lg">
            <div class="modal-header bg-slate-900 text-white p-3">
                <h6 class="modal-title fw-bold text-white mb-0"><i class="bi bi-bookmark-check me-2"></i> Reserve Fabric Roll for Production Order</h6>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('fabric-reservations.store') }}" method="POST">
                @csrf
                <div class="modal-body p-4">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label fw-semibold small text-slate-700">Reservation No <span class="text-danger">*</span></label>
                            <input type="text" name="reservation_no" class="form-control form-control-ent" required placeholder="e.g. RES-2026-001">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold small text-slate-700">Select Fabric Roll <span class="text-danger">*</span></label>
                            <select name="fabric_roll_id" class="form-select form-select-ent" required>
                                <option value="">-- Select Fabric Roll --</option>
                                @foreach($passedRolls as $roll)
                                    <option value="{{ $roll->id }}">{{ $roll->roll_no }} - {{ $roll->fabric ? $roll->fabric->fabric_code : '' }} ({{ $roll->shade }})</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold small text-slate-700">Requesting Department <span class="text-danger">*</span></label>
                            <input type="text" name="requested_by_dept" class="form-control form-control-ent" required value="Cut Room Spreading">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold small text-slate-700">Storage Location Bin <span class="text-danger">*</span></label>
                            <input type="text" name="storage_location" class="form-control form-control-ent" required placeholder="e.g. BIN-A-12">
                        </div>
                    </div>
                </div>
                <div class="modal-footer bg-slate-50 p-3">
                    <button type="button" class="btn-ent-outline" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn-ent-primary">Reserve Roll</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
