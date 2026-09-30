@extends('layouts.app')

@section('title', 'Production Bundles')
@section('page_header_title', 'Production Bundles')
@section('page_header_subtitle', 'Manage lot bundle tickets, garment quantities, completed output, and stage progress')

@section('top_header_action')
<button type="button" class="btn-ent-primary" data-bs-toggle="modal" data-bs-target="#addBundleModal">
    <i class="bi bi-plus-lg"></i> Add Production Bundle
</button>
@endsection

@section('content')
<!-- Summary Metrics Bar (5 Enterprise KPI Cards) -->
<div class="row g-3 mb-4">
    <div class="col-xl col-md-4 col-sm-6">
        <div class="card-ent h-100 p-3">
            <div class="d-flex justify-content-between align-items-center mb-1">
                <span class="text-uppercase fw-bold text-slate-500 font-mono" style="font-size:0.65rem;">Total Bundles</span>
                <span class="badge-ent badge-ent-blue">Total</span>
            </div>
            <div class="fw-bold text-slate-900 font-mono-num mb-1" style="font-size: 1.75rem; line-height: 1;">{{ number_format($totalBundles) }}</div>
            <div class="text-slate-500 small" style="font-size:0.72rem;">Active lot tickets</div>
        </div>
    </div>
    
    <div class="col-xl col-md-4 col-sm-6">
        <div class="card-ent h-100 p-3">
            <div class="d-flex justify-content-between align-items-center mb-1">
                <span class="text-uppercase fw-bold text-slate-500 font-mono" style="font-size:0.65rem;">Total Pieces</span>
                <span class="badge-ent badge-ent-blue">Garments</span>
            </div>
            <div class="fw-bold text-sky-600 font-mono-num mb-1" style="font-size: 1.75rem; line-height: 1;">{{ number_format($totalQuantity) }}</div>
            <div class="text-slate-500 small" style="font-size:0.72rem;">Total quantity on page</div>
        </div>
    </div>

    <div class="col-xl col-md-4 col-sm-6">
        <div class="card-ent h-100 p-3">
            <div class="d-flex justify-content-between align-items-center mb-1">
                <span class="text-uppercase fw-bold text-slate-500 font-mono" style="font-size:0.65rem;">Completed Output</span>
                <span class="badge-ent badge-ent-emerald">Finished</span>
            </div>
            <div class="fw-bold text-emerald-600 font-mono-num mb-1" style="font-size: 1.75rem; line-height: 1;">{{ number_format($completedQuantity) }}</div>
            <div class="text-slate-500 small" style="font-size:0.72rem;">Finished garment pieces</div>
        </div>
    </div>

    <div class="col-xl col-md-4 col-sm-6">
        <div class="card-ent h-100 p-3">
            <div class="d-flex justify-content-between align-items-center mb-1">
                <span class="text-uppercase fw-bold text-slate-500 font-mono" style="font-size:0.65rem;">Rejected Pieces</span>
                <span class="badge-ent badge-ent-rose">Rejects</span>
            </div>
            <div class="fw-bold text-rose-600 font-mono-num mb-1" style="font-size: 1.75rem; line-height: 1;">{{ number_format($rejectedQuantity) }}</div>
            <div class="text-slate-500 small" style="font-size:0.72rem;">Quality reject pieces</div>
        </div>
    </div>

    <div class="col-xl col-md-4 col-sm-12">
        <div class="card-ent h-100 p-3">
            <div class="d-flex justify-content-between align-items-center mb-1">
                <span class="text-uppercase fw-bold text-slate-500 font-mono" style="font-size:0.65rem;">Completion Rate</span>
                <span class="badge-ent badge-ent-amber">Progress</span>
            </div>
            <div class="fw-bold text-amber-600 font-mono-num mb-1" style="font-size: 1.75rem; line-height: 1;">
                {{ $totalQuantity > 0 ? number_format(($completedQuantity / $totalQuantity) * 100, 1) : 0 }}%
            </div>
            <div class="text-slate-500 small" style="font-size:0.72rem;">Active bundle progress</div>
        </div>
    </div>
</div>

<!-- Modern Enterprise Search & Filter Toolbar -->
<div class="card-ent mb-4">
    <div class="card-ent-body p-3">
        <form method="GET" action="{{ route('production.bundles') }}">
            <div class="row g-2 align-items-center">
                <div class="col-lg-5">
                    <div class="position-relative">
                        <i class="bi bi-search position-absolute top-50 start-0 translate-middle-y ms-3 text-slate-400"></i>
                        <input type="text" name="search" class="form-control form-control-ent ps-5" placeholder="Search Bundle Ticket, Buyer, Style No, Order No..." value="{{ request('search') }}">
                    </div>
                </div>

                <div class="col-md-3 col-lg-2">
                    <select name="status" class="form-select form-select-ent">
                        <option value="">Filter Status</option>
                        <option value="Active" {{ request('status') == 'Active' ? 'selected' : '' }}>Active</option>
                        <option value="Completed" {{ request('status') == 'Completed' ? 'selected' : '' }}>Completed</option>
                        <option value="Pending" {{ request('status') == 'Pending' ? 'selected' : '' }}>Pending</option>
                    </select>
                </div>

                <div class="col-md-3 col-lg-2">
                    <select name="garment" class="form-select form-select-ent">
                        <option value="">Garment Type</option>
                        <option value="Men's Polo" {{ request('garment') == "Men's Polo" ? 'selected' : '' }}>Men's Polo</option>
                        <option value="T-Shirt" {{ request('garment') == 'T-Shirt' ? 'selected' : '' }}>T-Shirt</option>
                        <option value="Jacket" {{ request('garment') == 'Jacket' ? 'selected' : '' }}>Jacket</option>
                    </select>
                </div>

                <div class="col-md-3 col-lg-3 d-flex gap-2">
                    <button type="submit" class="btn-ent-primary w-100 justify-content-center">
                        <i class="bi bi-funnel"></i> Filter
                    </button>
                    @if(request('search') || request('status') || request('garment') || request('quantity'))
                        <a href="{{ route('production.bundles') }}" class="btn-ent-outline text-decoration-none">
                            Clear
                        </a>
                    @endif
                </div>
            </div>
        </form>
    </div>
</div>

<!-- High Precision Enterprise Table List -->
<div class="card-ent">
    <div class="card-ent-body p-3">
        <div class="d-flex justify-content-between align-items-center mb-3 pb-2 border-bottom">
            <div>
                <h5 class="fw-bold text-slate-900 mb-0 fs-6">Production Bundle Tickets</h5>
                <p class="text-slate-500 mb-0 small" style="font-size:0.75rem;">Garment lot ticket records, completed counts, and rejection status</p>
            </div>
            <span class="badge-ent badge-ent-slate">{{ $bundles->count() }} Lot Ticket(s)</span>
        </div>

        <div class="table-responsive">
            <table class="table table-hover align-middle text-xs mb-0">
                <thead>
                    <tr class="text-slate-500 border-bottom">
                        <th class="fw-bold font-mono">BUNDLE NO</th>
                        <th class="fw-bold">BUYER / STYLE</th>
                        <th class="fw-bold">ORDER NO</th>
                        <th class="fw-bold">GARMENT / COLOR / SIZE</th>
                        <th class="fw-bold">PROGRESS (PCS)</th>
                        <th class="text-center fw-bold">STATUS</th>
                        <th class="text-end fw-bold">ACTION</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($bundles as $bundle)
                    @php
                        $pct = $bundle->total_qty > 0 ? round(($bundle->completed_qty / $bundle->total_qty) * 100, 1) : 0;
                    @endphp
                    <tr>
                        <td class="fw-bold text-primary font-mono fs-6">{{ $bundle->bundle_no }}</td>
                        <td>
                            <div class="fw-bold text-slate-900">{{ $bundle->buyer }}</div>
                            <div class="text-slate-500 font-mono">{{ $bundle->style_no }}</div>
                        </td>
                        <td class="font-mono text-slate-700">{{ $bundle->order_no }}</td>
                        <td>
                            <div class="fw-semibold text-slate-800">{{ $bundle->garment }}</div>
                            <div class="text-slate-500" style="font-size: 0.7rem;">
                                {{ $bundle->color ?: 'Standard' }} • Size: {{ $bundle->size ?: 'N/A' }}
                            </div>
                        </td>
                        <td style="min-width: 180px;">
                            <div class="d-flex justify-content-between align-items-center mb-1 font-mono-num" style="font-size: 0.72rem;">
                                <span class="text-slate-600"><strong>{{ number_format($bundle->completed_qty) }}</strong> / {{ number_format($bundle->total_qty) }}</span>
                                <span class="fw-bold text-emerald-700">{{ $pct }}%</span>
                            </div>
                            <div class="progress" style="height: 5px; border-radius: 2px; background: #e2e8f0;">
                                <div class="progress-bar bg-emerald-600" role="progressbar" style="width: {{ $pct }}%; border-radius: 2px;"></div>
                            </div>
                        </td>
                        <td class="text-center">
                            @if($bundle->status === 'Active')
                                <span class="badge-ent badge-ent-emerald">Active</span>
                            @elseif($bundle->status === 'Completed')
                                <span class="badge-ent badge-ent-blue">Completed</span>
                            @else
                                <span class="badge-ent badge-ent-slate">Pending</span>
                            @endif
                        </td>
                        <td class="text-end">
                            <form action="{{ route('production.bundles.destroy', $bundle) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete bundle {{ $bundle->bundle_no }}?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger rounded px-2 py-0.5 fw-semibold" style="font-size:0.7rem;" title="Delete Bundle Ticket">
                                    Delete
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center py-4 text-slate-500">
                            <i class="bi bi-inbox fs-4 d-block mb-1 text-slate-400"></i>
                            No production bundles found. Click <strong>+ Add Production Bundle</strong> to create one.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal: Add Production Bundle -->
<div class="modal fade" id="addBundleModal" tabindex="-1" aria-labelledby="addBundleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content rounded border-0 shadow-lg">
            <div class="modal-header bg-slate-900 text-white p-3">
                <h6 class="modal-title fw-bold text-white mb-0" id="addBundleModalLabel">Add Production Bundle Ticket</h6>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            
            <form action="{{ route('production.bundles.store') }}" method="POST">
                @csrf
                <div class="modal-body p-4">
                    <!-- Section 1 -->
                    <div class="mb-3">
                        <div class="fw-bold text-uppercase text-slate-400 font-mono mb-2" style="font-size:0.68rem;">1. Order Specs</div>
                        <div class="row g-2">
                            <div class="col-md-4">
                                <label for="bundle_no" class="form-label fw-semibold small">Bundle No <span class="text-danger">*</span></label>
                                <input type="text" name="bundle_no" id="bundle_no" class="form-control form-control-ent" required placeholder="e.g. BND-003">
                            </div>
                            <div class="col-md-4">
                                <label for="buyer" class="form-label fw-semibold small">Buyer Name <span class="text-danger">*</span></label>
                                <input type="text" name="buyer" id="buyer" class="form-control form-control-ent" required placeholder="e.g. Puma">
                            </div>
                            <div class="col-md-4">
                                <label for="style_no" class="form-label fw-semibold small">Style No <span class="text-danger">*</span></label>
                                <input type="text" name="style_no" id="style_no" class="form-control form-control-ent" required placeholder="e.g. ST-123">
                            </div>
                        </div>
                    </div>

                    <!-- Section 2 -->
                    <div class="mb-3">
                        <div class="fw-bold text-uppercase text-slate-400 font-mono mb-2" style="font-size:0.68rem;">2. Garment Specs</div>
                        <div class="row g-2">
                            <div class="col-md-4">
                                <label for="order_no" class="form-label fw-semibold small">Order No <span class="text-danger">*</span></label>
                                <input type="text" name="order_no" id="order_no" class="form-control form-control-ent" required placeholder="e.g. ORD-103">
                            </div>
                            <div class="col-md-4">
                                <label for="garment" class="form-label fw-semibold small">Garment Type <span class="text-danger">*</span></label>
                                <input type="text" name="garment" id="garment" class="form-control form-control-ent" required placeholder="e.g. Men's Polo">
                            </div>
                            <div class="col-md-4">
                                <label for="color" class="form-label fw-semibold small">Color</label>
                                <input type="text" name="color" id="color" class="form-control form-control-ent" placeholder="e.g. Navy Blue">
                            </div>
                        </div>
                    </div>

                    <!-- Section 3 -->
                    <div>
                        <div class="fw-bold text-uppercase text-slate-400 font-mono mb-2" style="font-size:0.68rem;">3. Quantities & Status</div>
                        <div class="row g-2">
                            <div class="col-md-3">
                                <label for="size" class="form-label fw-semibold small">Size</label>
                                <input type="text" name="size" id="size" class="form-control form-control-ent" placeholder="e.g. XL">
                            </div>
                            <div class="col-md-3">
                                <label for="total_qty" class="form-label fw-semibold small">Total Qty <span class="text-danger">*</span></label>
                                <input type="number" min="1" name="total_qty" id="total_qty" class="form-control form-control-ent" required placeholder="500">
                            </div>
                            <div class="col-md-3">
                                <label for="completed_qty" class="form-label fw-semibold small">Completed Qty</label>
                                <input type="number" min="0" name="completed_qty" id="completed_qty" class="form-control form-control-ent" value="0">
                            </div>
                            <div class="col-md-3">
                                <label for="rejected_qty" class="form-label fw-semibold small">Rejected Qty</label>
                                <input type="number" min="0" name="rejected_qty" id="rejected_qty" class="form-control form-control-ent" value="0">
                            </div>
                            <div class="col-12 mt-2">
                                <label for="status" class="form-label fw-semibold small">Status <span class="text-danger">*</span></label>
                                <select name="status" id="status" class="form-select form-select-ent" required>
                                    <option value="Active" selected>Active</option>
                                    <option value="Completed">Completed</option>
                                    <option value="Pending">Pending</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer bg-slate-50 p-3">
                    <button type="button" class="btn-ent-outline" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn-ent-primary">
                        Save Bundle Ticket
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
