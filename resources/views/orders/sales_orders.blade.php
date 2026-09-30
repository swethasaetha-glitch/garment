@extends('layouts.app')

@section('title', 'Sales Orders')
@section('page_header_title', 'Sales Orders (ERP Entry)')
@section('page_header_subtitle', 'Stage 2: Garment Manufacturing Sales Order Breakdown')

@section('top_header_action')
<button type="button" class="btn-ent-primary" data-bs-toggle="modal" data-bs-target="#addSalesOrderModal">
    <i class="bi bi-plus-lg"></i> Create Sales Order
</button>
@endsection

@section('content')
<!-- Summary Metrics Bar (4 Enterprise KPI Cards) -->
<div class="row g-3 mb-4">
    <div class="col-md-3 col-sm-6">
        <div class="card-ent h-100 p-3">
            <div class="d-flex justify-content-between align-items-center mb-1">
                <span class="text-uppercase fw-bold text-slate-500 font-mono" style="font-size:0.65rem;">Total Sales Orders</span>
                <span class="badge-ent badge-ent-blue">ERP</span>
            </div>
            <div class="fw-bold text-slate-900 font-mono-num mb-1" style="font-size: 1.75rem; line-height: 1;">{{ $salesOrders->count() }}</div>
            <div class="text-slate-500 small" style="font-size:0.72rem;">Active ERP sales entries</div>
        </div>
    </div>

    <div class="col-md-3 col-sm-6">
        <div class="card-ent h-100 p-3">
            <div class="d-flex justify-content-between align-items-center mb-1">
                <span class="text-uppercase fw-bold text-slate-500 font-mono" style="font-size:0.65rem;">Total Garment Qty</span>
                <span class="badge-ent badge-ent-emerald">Pieces</span>
            </div>
            <div class="fw-bold text-emerald-600 font-mono-num mb-1" style="font-size: 1.75rem; line-height: 1;">
                {{ number_format($salesOrders->sum('order_qty')) }}
            </div>
            <div class="text-slate-500 small" style="font-size:0.72rem;">Scheduled production pcs</div>
        </div>
    </div>

    <div class="col-md-3 col-sm-6">
        <div class="card-ent h-100 p-3">
            <div class="d-flex justify-content-between align-items-center mb-1">
                <span class="text-uppercase fw-bold text-slate-500 font-mono" style="font-size:0.65rem;">In Production</span>
                <span class="badge-ent badge-ent-amber">Active</span>
            </div>
            <div class="fw-bold text-amber-600 font-mono-num mb-1" style="font-size: 1.75rem; line-height: 1;">
                {{ $salesOrders->where('status', 'In Production')->count() }}
            </div>
            <div class="text-slate-500 small" style="font-size:0.72rem;">Live shopfloor orders</div>
        </div>
    </div>

    <div class="col-md-3 col-sm-6">
        <div class="card-ent h-100 p-3">
            <div class="d-flex justify-content-between align-items-center mb-1">
                <span class="text-uppercase fw-bold text-slate-500 font-mono" style="font-size:0.65rem;">Linked Buyer POs</span>
                <span class="badge-ent badge-ent-blue">PO Link</span>
            </div>
            <div class="fw-bold text-indigo-600 font-mono-num mb-1" style="font-size: 1.75rem; line-height: 1;">
                {{ $buyerOrders->count() }}
            </div>
            <div class="text-slate-500 small" style="font-size:0.72rem;">Available buyer PO links</div>
        </div>
    </div>
</div>

<!-- High Precision Enterprise Table -->
<div class="card-ent">
    <div class="card-ent-body p-3">
        <div class="d-flex justify-content-between align-items-center mb-3 pb-2 border-bottom">
            <div>
                <h5 class="fw-bold text-slate-900 mb-0 fs-6">Sales Orders (ERP Entry)</h5>
                <p class="text-slate-500 mb-0 small" style="font-size:0.75rem;">Garment style breakdowns, colorways, size ratios, and quantities</p>
            </div>
            <span class="badge-ent badge-ent-slate">{{ $salesOrders->count() }} Order(s)</span>
        </div>

        <div class="table-responsive">
            <table class="table table-hover align-middle text-xs mb-0">
                <thead>
                    <tr class="text-slate-500 border-bottom">
                        <th class="fw-bold font-mono">SALES ORDER NO</th>
                        <th class="fw-bold">BUYER PO</th>
                        <th class="fw-bold">STYLE NO</th>
                        <th class="fw-bold">GARMENT TYPE</th>
                        <th class="fw-bold">COLORWAY</th>
                        <th class="fw-bold">SIZE RATIO</th>
                        <th class="fw-bold">ORDER QTY</th>
                        <th class="text-end fw-bold">STATUS</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($salesOrders as $so)
                    <tr>
                        <td class="fw-bold text-primary font-mono fs-6">{{ $so->sales_order_no }}</td>
                        <td>
                            @if($so->buyerOrder)
                                <div class="fw-bold text-slate-900 font-mono">{{ $so->buyerOrder->po_number }}</div>
                                <div class="text-slate-500" style="font-size:0.7rem;">{{ $so->buyerOrder->buyer_name }}</div>
                            @else
                                <span class="text-slate-400">-</span>
                            @endif
                        </td>
                        <td class="fw-bold text-slate-900 font-mono">{{ $so->style_no }}</td>
                        <td class="fw-semibold text-slate-800">{{ $so->garment_type }}</td>
                        <td class="text-slate-700">{{ $so->colorway }}</td>
                        <td><code class="text-primary bg-blue-50 px-2 py-0.5 rounded">{{ $so->size_ratio ?: 'S:1 M:2 L:2 XL:1' }}</code></td>
                        <td class="fw-bold font-mono-num text-slate-900">{{ number_format($so->order_qty) }}</td>
                        <td class="text-end">
                            <span class="badge-ent {{ $so->status === 'In Production' ? 'badge-ent-emerald' : 'badge-ent-amber' }}">
                                {{ $so->status }}
                            </span>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="text-center py-4 text-slate-500">
                            No sales orders created yet. Click <strong>+ Create Sales Order</strong> to get started.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal: Create Sales Order -->
<div class="modal fade" id="addSalesOrderModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content rounded border-0 shadow-lg">
            <div class="modal-header bg-slate-900 text-white p-3">
                <h6 class="modal-title fw-bold text-white mb-0"><i class="bi bi-receipt me-2"></i> Add Sales Order (ERP Entry)</h6>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('sales-orders.store') }}" method="POST">
                @csrf
                <div class="modal-body p-4">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label fw-semibold small text-slate-700">Sales Order No <span class="text-danger">*</span></label>
                            <input type="text" name="sales_order_no" class="form-control form-control-ent" required placeholder="e.g. SO-2026-101">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold small text-slate-700">Buyer PO <span class="text-danger">*</span></label>
                            <select name="buyer_order_id" class="form-select form-select-ent" required>
                                <option value="">-- Select Buyer PO --</option>
                                @foreach($buyerOrders as $bOrder)
                                    <option value="{{ $bOrder->id }}">{{ $bOrder->po_number }} - {{ $bOrder->buyer_name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-semibold small text-slate-700">Style No <span class="text-danger">*</span></label>
                            <input type="text" name="style_no" class="form-control form-control-ent" required placeholder="e.g. ST-789">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-semibold small text-slate-700">Garment Type <span class="text-danger">*</span></label>
                            <input type="text" name="garment_type" class="form-control form-control-ent" required placeholder="e.g. Men's Polo">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-semibold small text-slate-700">Colorway <span class="text-danger">*</span></label>
                            <input type="text" name="colorway" class="form-control form-control-ent" required placeholder="e.g. Black / White">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold small text-slate-700">Size Ratio Breakdown</label>
                            <input type="text" name="size_ratio" class="form-control form-control-ent" placeholder="e.g. S:1, M:2, L:2, XL:1">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label fw-semibold small text-slate-700">Order Qty (Pcs) <span class="text-danger">*</span></label>
                            <input type="number" min="1" name="order_qty" class="form-control form-control-ent" required placeholder="e.g. 2500">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label fw-semibold small text-slate-700">Status <span class="text-danger">*</span></label>
                            <select name="status" class="form-select form-select-ent" required>
                                <option value="In Production" selected>In Production</option>
                                <option value="Planned">Planned</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer bg-slate-50 p-3">
                    <button type="button" class="btn-ent-outline" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn-ent-primary">Save Sales Order</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
