@extends('layouts.app')

@section('title', 'Fabric Receiving & GRN')
@section('page_header_title', 'Fabric Receiving & GRN')
@section('page_header_subtitle', 'Stage 5: Goods Receipt Note & Store Roll Registration')

@section('top_header_action')
<button type="button" class="btn-ent-primary" data-bs-toggle="modal" data-bs-target="#addGrnModal">
    <i class="bi bi-box-arrow-in-down"></i> Receive Fabric (GRN)
</button>
@endsection

@section('content')
<!-- High Precision Enterprise Table -->
<div class="card-ent">
    <div class="card-ent-body p-3">
        <div class="d-flex justify-content-between align-items-center mb-3 pb-2 border-bottom">
            <div>
                <h5 class="fw-bold text-slate-900 mb-0 fs-6">Goods Receipt Notes (GRN)</h5>
                <p class="text-slate-500 mb-0 small" style="font-size:0.75rem;">Received fabric roll receipts and warehouse store logs</p>
            </div>
            <span class="badge-ent badge-ent-slate">{{ $grns->count() }} GRN(s)</span>
        </div>

        <div class="table-responsive">
            <table class="table table-hover align-middle text-xs mb-0">
                <thead>
                    <tr class="text-slate-500 border-bottom">
                        <th class="fw-bold font-mono">GRN NO</th>
                        <th class="fw-bold">FABRIC PO NO</th>
                        <th class="fw-bold">SUPPLIER INVOICE</th>
                        <th class="fw-bold">RECEIVED DATE</th>
                        <th class="fw-bold">TOTAL ROLLS</th>
                        <th class="fw-bold">RECEIVED QTY</th>
                        <th class="text-end fw-bold">STATUS</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($grns as $grn)
                    <tr>
                        <td class="fw-bold text-primary font-mono fs-6">{{ $grn->grn_no }}</td>
                        <td class="font-mono text-slate-900">{{ $grn->fabricPo ? $grn->fabricPo->po_no : '-' }}</td>
                        <td class="font-mono text-slate-700">{{ $grn->supplier_invoice_no }}</td>
                        <td class="font-mono-num text-slate-700">{{ \Carbon\Carbon::parse($grn->received_date)->format('M d, Y') }}</td>
                        <td><span class="badge-ent badge-ent-blue font-mono">{{ $grn->total_rolls_received }} Roll(s)</span></td>
                        <td class="fw-bold font-mono-num text-emerald-700">{{ number_format($grn->received_qty, 2) }} {{ $grn->fabricPo ? $grn->fabricPo->unit : 'KG' }}</td>
                        <td class="text-end">
                            <span class="badge-ent badge-ent-emerald">
                                {{ $grn->status }}
                            </span>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center py-4 text-slate-500">No GRN receipts registered yet. Click <strong>+ Receive Fabric (GRN)</strong> to log store entry.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal: Create GRN -->
<div class="modal fade" id="addGrnModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content rounded border-0 shadow-lg">
            <div class="modal-header bg-slate-900 text-white p-3">
                <h6 class="modal-title fw-bold text-white mb-0"><i class="bi bi-box-arrow-in-down me-2"></i> Create GRN (Goods Receipt Note)</h6>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('fabric-grns.store') }}" method="POST">
                @csrf
                <div class="modal-body p-4">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label fw-semibold small text-slate-700">GRN No <span class="text-danger">*</span></label>
                            <input type="text" name="grn_no" class="form-control form-control-ent" required placeholder="e.g. GRN-2026-001">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold small text-slate-700">Fabric PO <span class="text-danger">*</span></label>
                            <select name="fabric_po_id" class="form-select form-select-ent" required>
                                <option value="">-- Select Fabric PO --</option>
                                @foreach($pos as $po)
                                    <option value="{{ $po->id }}">{{ $po->po_no }} - {{ $po->supplier_name }} ({{ $po->required_qty }} {{ $po->unit }})</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold small text-slate-700">Supplier Invoice No <span class="text-danger">*</span></label>
                            <input type="text" name="supplier_invoice_no" class="form-control form-control-ent" required placeholder="e.g. INV-98765">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold small text-slate-700">Received Date <span class="text-danger">*</span></label>
                            <input type="date" name="received_date" class="form-control form-control-ent" value="{{ date('Y-m-d') }}" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold small text-slate-700">Total Rolls Received <span class="text-danger">*</span></label>
                            <input type="number" min="1" name="total_rolls_received" class="form-control form-control-ent" required placeholder="e.g. 10">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold small text-slate-700">Received Qty (Net Weight) <span class="text-danger">*</span></label>
                            <input type="number" step="0.01" min="0.1" name="received_qty" class="form-control form-control-ent" required placeholder="e.g. 1250.00">
                        </div>
                        <div class="col-md-12">
                            <label class="form-label fw-semibold small text-slate-700">Status <span class="text-danger">*</span></label>
                            <select name="status" class="form-select form-select-ent" required>
                                <option value="Received" selected>Received & Store Stored</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer bg-slate-50 p-3">
                    <button type="button" class="btn-ent-outline" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn-ent-primary">Receive & Generate Roll Tags</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
