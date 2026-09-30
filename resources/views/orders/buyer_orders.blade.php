@extends('layouts.app')

@section('title', 'Buyer Orders')
@section('page_header_title', 'Buyer Orders (PO Master)')
@section('page_header_subtitle', 'Stage 1: Garment Manufacturing Buyer Purchase Order Management')

@section('top_header_action')
<button type="button" class="btn-ent-primary" data-bs-toggle="modal" data-bs-target="#addBuyerOrderModal">
    <i class="bi bi-plus-lg"></i> Create Buyer Order
</button>
@endsection

@section('content')
<!-- Summary Metrics Bar (4 Enterprise KPI Cards) -->
<div class="row g-3 mb-4">
    <div class="col-md-3 col-sm-6">
        <div class="card-ent h-100 p-3">
            <div class="d-flex justify-content-between align-items-center mb-1">
                <span class="text-uppercase fw-bold text-slate-500 font-mono" style="font-size:0.65rem;">Total Buyer POs</span>
                <span class="badge-ent badge-ent-blue">Master</span>
            </div>
            <div class="fw-bold text-slate-900 font-mono-num mb-1" style="font-size: 1.75rem; line-height: 1;">{{ $buyerOrders->count() }}</div>
            <div class="text-slate-500 small" style="font-size:0.72rem;">Registered PO contracts</div>
        </div>
    </div>

    <div class="col-md-3 col-sm-6">
        <div class="card-ent h-100 p-3">
            <div class="d-flex justify-content-between align-items-center mb-1">
                <span class="text-uppercase fw-bold text-slate-500 font-mono" style="font-size:0.65rem;">Total Order Qty</span>
                <span class="badge-ent badge-ent-emerald">Garments</span>
            </div>
            <div class="fw-bold text-emerald-600 font-mono-num mb-1" style="font-size: 1.75rem; line-height: 1;">
                {{ number_format($buyerOrders->sum('total_garment_qty')) }}
            </div>
            <div class="text-slate-500 small" style="font-size:0.72rem;">Total committed pcs</div>
        </div>
    </div>

    <div class="col-md-3 col-sm-6">
        <div class="card-ent h-100 p-3">
            <div class="d-flex justify-content-between align-items-center mb-1">
                <span class="text-uppercase fw-bold text-slate-500 font-mono" style="font-size:0.65rem;">Active Buyers</span>
                <span class="badge-ent badge-ent-blue">Clients</span>
            </div>
            <div class="fw-bold text-sky-600 font-mono-num mb-1" style="font-size: 1.75rem; line-height: 1;">
                {{ $buyerOrders->pluck('buyer_name')->unique()->count() }}
            </div>
            <div class="text-slate-500 small" style="font-size:0.72rem;">Unique buying houses</div>
        </div>
    </div>

    <div class="col-md-3 col-sm-6">
        <div class="card-ent h-100 p-3">
            <div class="d-flex justify-content-between align-items-center mb-1">
                <span class="text-uppercase fw-bold text-slate-500 font-mono" style="font-size:0.65rem;">Confirmed Rate</span>
                <span class="badge-ent badge-ent-emerald">Status</span>
            </div>
            <div class="fw-bold text-indigo-600 font-mono-num mb-1" style="font-size: 1.75rem; line-height: 1;">100%</div>
            <div class="text-slate-500 small" style="font-size:0.72rem;">Confirmed order ratio</div>
        </div>
    </div>
</div>

<!-- High Precision Enterprise Table -->
<div class="card-ent">
    <div class="card-ent-body p-3">
        <div class="d-flex justify-content-between align-items-center mb-3 pb-2 border-bottom">
            <div>
                <h5 class="fw-bold text-slate-900 mb-0 fs-6">Buyer Orders (PO Master)</h5>
                <p class="text-slate-500 mb-0 small" style="font-size:0.75rem;">Garment buyer purchase orders and delivery timelines</p>
            </div>
            <span class="badge-ent badge-ent-slate">{{ $buyerOrders->count() }} Order(s)</span>
        </div>

        <div class="table-responsive">
            <table class="table table-hover align-middle text-xs mb-0">
                <thead>
                    <tr class="text-slate-500 border-bottom">
                        <th class="fw-bold font-mono">PO NUMBER</th>
                        <th class="fw-bold">BUYER NAME</th>
                        <th class="fw-bold">ORDER DATE</th>
                        <th class="fw-bold">DELIVERY DATE</th>
                        <th class="fw-bold">TOTAL QTY (PCS)</th>
                        <th class="fw-bold">CONNECTED SALES ORDERS</th>
                        <th class="text-end fw-bold">STATUS</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($buyerOrders as $order)
                    <tr>
                        <td class="fw-bold text-primary font-mono fs-6">{{ $order->po_number }}</td>
                        <td class="fw-semibold text-slate-900">{{ $order->buyer_name }}</td>
                        <td class="font-mono-num text-slate-700">{{ \Carbon\Carbon::parse($order->order_date)->format('M d, Y') }}</td>
                        <td class="font-mono-num text-slate-700">{{ \Carbon\Carbon::parse($order->delivery_date)->format('M d, Y') }}</td>
                        <td class="fw-bold font-mono-num text-slate-900">{{ number_format($order->total_garment_qty) }}</td>
                        <td>
                            <span class="badge-ent badge-ent-slate">
                                {{ $order->salesOrders->count() }} Sales Order(s)
                            </span>
                        </td>
                        <td class="text-end">
                            <span class="badge-ent badge-ent-emerald">
                                {{ $order->status }}
                            </span>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center py-4 text-slate-500">
                            No buyer orders created yet. Click <strong>+ Create Buyer Order</strong> to get started.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal: Create Buyer Order -->
<div class="modal fade" id="addBuyerOrderModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content rounded border-0 shadow-lg">
            <div class="modal-header bg-slate-900 text-white p-3">
                <h6 class="modal-title fw-bold text-white mb-0"><i class="bi bi-cart-check me-2"></i> Add Buyer Order (PO Master)</h6>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('buyer-orders.store') }}" method="POST">
                @csrf
                <div class="modal-body p-4">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label fw-semibold small text-slate-700">Buyer Name <span class="text-danger">*</span></label>
                            <input type="text" name="buyer_name" class="form-control form-control-ent" required placeholder="e.g. Nike International">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold small text-slate-700">PO Number <span class="text-danger">*</span></label>
                            <input type="text" name="po_number" class="form-control form-control-ent" required placeholder="e.g. PO-NK-2026-001">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold small text-slate-700">Order Date <span class="text-danger">*</span></label>
                            <input type="date" name="order_date" class="form-control form-control-ent" value="{{ date('Y-m-d') }}" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold small text-slate-700">Delivery Date <span class="text-danger">*</span></label>
                            <input type="date" name="delivery_date" class="form-control form-control-ent" value="{{ date('Y-m-d', strtotime('+30 days')) }}" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold small text-slate-700">Total Garment Qty (Pcs) <span class="text-danger">*</span></label>
                            <input type="number" min="1" name="total_garment_qty" class="form-control form-control-ent" required placeholder="e.g. 5000">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold small text-slate-700">Status <span class="text-danger">*</span></label>
                            <select name="status" class="form-select form-select-ent" required>
                                <option value="Confirmed" selected>Confirmed</option>
                                <option value="Pending">Pending</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer bg-slate-50 p-3">
                    <button type="button" class="btn-ent-outline" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn-ent-primary">Save Buyer Order</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
