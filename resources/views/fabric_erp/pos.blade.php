@extends('layouts.app')

@section('title', 'Fabric Procurement')
@section('page_header_title', 'Fabric Procurement (PO)')
@section('page_header_subtitle', 'Stage 4: Fabric Requirement Calculation & Vendor Purchase Orders')

@section('top_header_action')
<button type="button" class="btn-ent-primary" data-bs-toggle="modal" data-bs-target="#addFabricPoModal">
    <i class="bi bi-plus-lg"></i> Issue Fabric PO
</button>
@endsection

@section('content')
<!-- High Precision Enterprise Table -->
<div class="card-ent">
    <div class="card-ent-body p-3">
        <div class="d-flex justify-content-between align-items-center mb-3 pb-2 border-bottom">
            <div>
                <h5 class="fw-bold text-slate-900 mb-0 fs-6">Fabric Purchase Orders</h5>
                <p class="text-slate-500 mb-0 small" style="font-size:0.75rem;">Textile vendor purchase orders and delivery timelines</p>
            </div>
            <span class="badge-ent badge-ent-slate">{{ $pos->count() }} PO(s)</span>
        </div>

        <div class="table-responsive">
            <table class="table table-hover align-middle text-xs mb-0">
                <thead>
                    <tr class="text-slate-500 border-bottom">
                        <th class="fw-bold font-mono">FABRIC PO NO</th>
                        <th class="fw-bold">SALES ORDER</th>
                        <th class="fw-bold">FABRIC MASTER</th>
                        <th class="fw-bold">SUPPLIER NAME</th>
                        <th class="fw-bold">REQUIRED QTY</th>
                        <th class="fw-bold">EXPECTED DELIVERY</th>
                        <th class="text-end fw-bold">STATUS</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($pos as $po)
                    <tr>
                        <td class="fw-bold text-primary font-mono fs-6">{{ $po->po_no }}</td>
                        <td class="font-mono text-slate-900">{{ $po->salesOrder ? $po->salesOrder->sales_order_no : '-' }}</td>
                        <td>
                            <div class="fw-bold text-slate-900 font-mono">{{ $po->fabric ? $po->fabric->fabric_code : '-' }}</div>
                            <div class="text-slate-500" style="font-size:0.7rem;">{{ $po->fabric ? $po->fabric->fabric_name : '' }}</div>
                        </td>
                        <td class="fw-semibold text-slate-800">{{ $po->supplier_name }}</td>
                        <td class="fw-bold font-mono-num text-emerald-700">{{ number_format($po->required_qty, 2) }} {{ $po->unit }}</td>
                        <td class="font-mono-num text-slate-700">{{ \Carbon\Carbon::parse($po->delivery_date)->format('M d, Y') }}</td>
                        <td class="text-end">
                            <span class="badge-ent badge-ent-emerald">
                                {{ $po->status }}
                            </span>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center py-4 text-slate-500">No fabric purchase orders issued yet. Click <strong>+ Issue Fabric PO</strong> to create one.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal: Issue Fabric Purchase Order -->
<div class="modal fade" id="addFabricPoModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content rounded border-0 shadow-lg">
            <div class="modal-header bg-slate-900 text-white p-3">
                <h6 class="modal-title fw-bold text-white mb-0"><i class="bi bi-bag-plus me-2"></i> Issue Fabric Purchase Order</h6>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('fabric-pos.store') }}" method="POST">
                @csrf
                <div class="modal-body p-4">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label fw-semibold small text-slate-700">PO Number <span class="text-danger">*</span></label>
                            <input type="text" name="po_no" class="form-control form-control-ent" required placeholder="e.g. FPO-2026-001">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold small text-slate-700">Sales Order <span class="text-danger">*</span></label>
                            <select name="sales_order_id" class="form-select form-select-ent" required>
                                <option value="">-- Select Sales Order --</option>
                                @foreach($salesOrders as $so)
                                    <option value="{{ $so->id }}">{{ $so->sales_order_no }} - {{ $so->style_no }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold small text-slate-700">Fabric Master <span class="text-danger">*</span></label>
                            <select name="fabric_id" class="form-select form-select-ent" required>
                                <option value="">-- Select Fabric --</option>
                                @foreach($fabrics as $fab)
                                    <option value="{{ $fab->id }}">{{ $fab->fabric_code }} - {{ $fab->fabric_name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold small text-slate-700">Supplier Name <span class="text-danger">*</span></label>
                            <input type="text" name="supplier_name" class="form-control form-control-ent" required placeholder="e.g. Acme Textile Mills">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-semibold small text-slate-700">Required Quantity <span class="text-danger">*</span></label>
                            <input type="number" step="0.01" min="0.1" name="required_qty" class="form-control form-control-ent" required placeholder="e.g. 1250.50">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-semibold small text-slate-700">Unit <span class="text-danger">*</span></label>
                            <select name="unit" class="form-select form-select-ent" required>
                                <option value="KG" selected>KG</option>
                                <option value="Meter">Meter</option>
                                <option value="Yard">Yard</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-semibold small text-slate-700">Delivery Date <span class="text-danger">*</span></label>
                            <input type="date" name="delivery_date" class="form-control form-control-ent" value="{{ date('Y-m-d', strtotime('+10 days')) }}" required>
                        </div>
                        <div class="col-md-12">
                            <label class="form-label fw-semibold small text-slate-700">Status <span class="text-danger">*</span></label>
                            <select name="status" class="form-select form-select-ent" required>
                                <option value="Ordered" selected>Ordered</option>
                                <option value="Pending">Pending</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer bg-slate-50 p-3">
                    <button type="button" class="btn-ent-outline" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn-ent-primary">Issue Fabric PO</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
