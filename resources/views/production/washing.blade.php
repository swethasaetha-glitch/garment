@extends('layouts.app')

@section('title', 'Washing & Laser Stream')
@section('page_header_title', 'Washing & Laser Distressing Stream')
@section('page_header_subtitle', 'Garment Laundry Treatment, Washing Batches & Laser Processing Logs')

@section('top_header_action')
<button type="button" class="btn-ent-primary" data-bs-toggle="modal" data-bs-target="#addWashingModal">
    <i class="bi bi-droplet"></i> Create Wash Batch
</button>
@endsection

@section('content')
<!-- High Precision Enterprise Table -->
<div class="card-ent">
    <div class="card-ent-body p-3">
        <div class="d-flex justify-content-between align-items-center mb-3 pb-2 border-bottom">
            <div>
                <h5 class="fw-bold text-slate-900 mb-0 fs-6">Washing & Laundry Batch Records</h5>
                <p class="text-slate-500 mb-0 small" style="font-size:0.75rem;">Enzyme wash, stone wash, laser distressing, and laundry treatment batch routing</p>
            </div>
            <span class="badge-ent badge-ent-slate">{{ $laundryRecords->count() }} Batch(es)</span>
        </div>

        <div class="table-responsive">
            <table class="table table-hover align-middle text-xs mb-0">
                <thead>
                    <tr class="text-slate-500 border-bottom">
                        <th class="fw-bold font-mono">WASH BATCH NO</th>
                        <th class="fw-bold">BUNDLE TICKET</th>
                        <th class="fw-bold">WASH TREATMENT</th>
                        <th class="fw-bold">RECEIVED TIMESTAMP</th>
                        <th class="text-end fw-bold">STATUS</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($laundryRecords as $rec)
                    <tr>
                        <td class="fw-bold text-primary font-mono fs-6">{{ $rec->wash_batch_no }}</td>
                        <td class="fw-bold font-mono text-slate-900">{{ $rec->lotBundle ? $rec->lotBundle->bundle_no : '-' }}</td>
                        <td class="fw-semibold text-slate-800">{{ $rec->wash_type }}</td>
                        <td class="font-mono-num text-slate-700">{{ $rec->received_at ? $rec->received_at->format('H:i, d M Y') : '-' }}</td>
                        <td class="text-end">
                            <span class="badge-ent badge-ent-amber uppercase">
                                {{ str_replace('_', ' ', $rec->status) }}
                            </span>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center py-4 text-slate-500">No washing batch logs recorded yet. Click <strong>+ Create Wash Batch</strong> to log.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal: Create Wash Batch -->
<div class="modal fade" id="addWashingModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content rounded border-0 shadow-lg">
            <div class="modal-header bg-slate-900 text-white p-3">
                <h6 class="modal-title fw-bold text-white mb-0"><i class="bi bi-droplet me-2"></i> Create Washing / Laundry Batch Record</h6>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('production.washing.store') }}" method="POST">
                @csrf
                <div class="modal-body p-4">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label fw-semibold small text-slate-700">Wash Batch No <span class="text-danger">*</span></label>
                            <input type="text" name="wash_batch_no" class="form-control form-control-ent" required placeholder="e.g. WB-2026-001">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold small text-slate-700">Select Lot Bundle <span class="text-danger">*</span></label>
                            <select name="lot_bundle_id" class="form-select form-select-ent" required>
                                <option value="">-- Select Lot Bundle --</option>
                                @foreach($bundles as $bnd)
                                    <option value="{{ $bnd->id }}">{{ $bnd->bundle_no }} (Size {{ $bnd->size }}, {{ $bnd->garment_qty }} Pcs)</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold small text-slate-700">Type of Wash <span class="text-danger">*</span></label>
                            <select name="wash_type" class="form-select form-select-ent" required>
                                <option value="">-- Select Type of Wash --</option>
                                <option value="Semi">Semi Wash</option>
                                <option value="Final">Final Wash</option>
                                <option value="Direct">Direct Wash</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold small text-slate-700">Batch Status <span class="text-danger">*</span></label>
                            <select name="status" class="form-select form-select-ent" required>
                                <option value="In_Washing" selected>In Washing</option>
                                <option value="Completed">Completed</option>
                                <option value="Pending">Pending</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer bg-slate-50 p-3">
                    <button type="button" class="btn-ent-outline" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn-ent-primary">Create Wash Batch</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
