@extends('layouts.app')

@section('title', 'Production Planning')
@section('page_header_title', 'Production Planning & Allocation')
@section('page_header_subtitle', 'Stage 3: Garment Manufacturing Production Scheduling & Line Allocation')

@section('top_header_action')
<button type="button" class="btn-ent-primary" data-bs-toggle="modal" data-bs-target="#addPlanModal">
    <i class="bi bi-plus-lg"></i> Generate Production Plan
</button>
@endsection

@section('content')
<!-- Summary Metrics Bar (4 Enterprise KPI Cards) -->
<div class="row g-3 mb-4">
    <div class="col-md-3 col-sm-6">
        <div class="card-ent h-100 p-3">
            <div class="d-flex justify-content-between align-items-center mb-1">
                <span class="text-uppercase fw-bold text-slate-500 font-mono" style="font-size:0.65rem;">Total Plans</span>
                <span class="badge-ent badge-ent-blue">Plans</span>
            </div>
            <div class="fw-bold text-slate-900 font-mono-num mb-1" style="font-size: 1.75rem; line-height: 1;">{{ $plans->count() }}</div>
            <div class="text-slate-500 small" style="font-size:0.72rem;">Generated master plans</div>
        </div>
    </div>

    <div class="col-md-3 col-sm-6">
        <div class="card-ent h-100 p-3">
            <div class="d-flex justify-content-between align-items-center mb-1">
                <span class="text-uppercase fw-bold text-slate-500 font-mono" style="font-size:0.65rem;">Daily Target</span>
                <span class="badge-ent badge-ent-emerald">Pcs/Day</span>
            </div>
            <div class="fw-bold text-emerald-600 font-mono-num mb-1" style="font-size: 1.75rem; line-height: 1;">
                {{ number_format($plans->sum('target_daily_qty')) }}
            </div>
            <div class="text-slate-500 small" style="font-size:0.72rem;">Target shopfloor capacity</div>
        </div>
    </div>

    <div class="col-md-3 col-sm-6">
        <div class="card-ent h-100 p-3">
            <div class="d-flex justify-content-between align-items-center mb-1">
                <span class="text-uppercase fw-bold text-slate-500 font-mono" style="font-size:0.65rem;">Active Lines</span>
                <span class="badge-ent badge-ent-blue">Sewing</span>
            </div>
            <div class="fw-bold text-sky-600 font-mono-num mb-1" style="font-size: 1.75rem; line-height: 1;">Line 1 & 2</div>
            <div class="text-slate-500 small" style="font-size:0.72rem;">Allocated assembly lines</div>
        </div>
    </div>

    <div class="col-md-3 col-sm-6">
        <div class="card-ent h-100 p-3">
            <div class="d-flex justify-content-between align-items-center mb-1">
                <span class="text-uppercase fw-bold text-slate-500 font-mono" style="font-size:0.65rem;">Approved Rate</span>
                <span class="badge-ent badge-ent-emerald">Status</span>
            </div>
            <div class="fw-bold text-indigo-600 font-mono-num mb-1" style="font-size: 1.75rem; line-height: 1;">100%</div>
            <div class="text-slate-500 small" style="font-size:0.72rem;">Approved plan ratio</div>
        </div>
    </div>
</div>

<!-- High Precision Enterprise Table -->
<div class="card-ent">
    <div class="card-ent-body p-3">
        <div class="d-flex justify-content-between align-items-center mb-3 pb-2 border-bottom">
            <div>
                <h5 class="fw-bold text-slate-900 mb-0 fs-6">Production Planning Catalog</h5>
                <p class="text-slate-500 mb-0 small" style="font-size:0.75rem;">Garment production schedules, start/end dates, daily targets, and line allocations</p>
            </div>
            <span class="badge-ent badge-ent-slate">{{ $plans->count() }} Plan(s)</span>
        </div>

        <div class="table-responsive">
            <table class="table table-hover align-middle text-xs mb-0">
                <thead>
                    <tr class="text-slate-500 border-bottom">
                        <th class="fw-bold font-mono">PLAN NO</th>
                        <th class="fw-bold">SALES ORDER</th>
                        <th class="fw-bold">BUYER / STYLE</th>
                        <th class="fw-bold">START DATE</th>
                        <th class="fw-bold">END DATE</th>
                        <th class="fw-bold">DAILY TARGET</th>
                        <th class="fw-bold">LINE ALLOCATION</th>
                        <th class="text-end fw-bold">STATUS</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($plans as $plan)
                    <tr>
                        <td class="fw-bold text-primary font-mono fs-6">{{ $plan->plan_no }}</td>
                        <td class="font-mono text-slate-900">{{ $plan->salesOrder ? $plan->salesOrder->sales_order_no : '-' }}</td>
                        <td>
                            <div class="fw-bold text-slate-900">{{ $plan->salesOrder && $plan->salesOrder->buyerOrder ? $plan->salesOrder->buyerOrder->buyer_name : '-' }}</div>
                            <div class="text-slate-500 font-mono" style="font-size:0.7rem;">{{ $plan->salesOrder ? $plan->salesOrder->style_no : '' }}</div>
                        </td>
                        <td class="font-mono-num text-slate-700">{{ \Carbon\Carbon::parse($plan->planned_start_date)->format('M d, Y') }}</td>
                        <td class="font-mono-num text-slate-700">{{ \Carbon\Carbon::parse($plan->planned_end_date)->format('M d, Y') }}</td>
                        <td class="fw-bold font-mono-num text-emerald-700">{{ number_format($plan->target_daily_qty) }} pcs/day</td>
                        <td>
                            <span class="badge-ent badge-ent-blue">
                                {{ $plan->line_allocation ?: 'Line 1 & 2' }}
                            </span>
                        </td>
                        <td class="text-end">
                            <span class="badge-ent badge-ent-emerald">
                                {{ $plan->status }}
                            </span>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="text-center py-4 text-slate-500">
                            No production plans generated yet. Click <strong>+ Generate Production Plan</strong> to get started.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal: Generate Production Plan -->
<div class="modal fade" id="addPlanModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content rounded border-0 shadow-lg">
            <div class="modal-header bg-slate-900 text-white p-3">
                <h6 class="modal-title fw-bold text-white mb-0"><i class="bi bi-calendar-event me-2"></i> Generate Production Plan & Line Allocation</h6>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('production-plans.store') }}" method="POST">
                @csrf
                <div class="modal-body p-4">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label fw-semibold small text-slate-700">Plan No <span class="text-danger">*</span></label>
                            <input type="text" name="plan_no" class="form-control form-control-ent" required placeholder="e.g. PP-2026-001">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold small text-slate-700">Sales Order <span class="text-danger">*</span></label>
                            <select name="sales_order_id" class="form-select form-select-ent" required>
                                <option value="">-- Select Sales Order --</option>
                                @foreach($salesOrders as $so)
                                    <option value="{{ $so->id }}">{{ $so->sales_order_no }} - {{ $so->style_no }} ({{ number_format($so->order_qty) }} pcs)</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold small text-slate-700">Planned Start Date <span class="text-danger">*</span></label>
                            <input type="date" name="planned_start_date" class="form-control form-control-ent" value="{{ date('Y-m-d') }}" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold small text-slate-700">Planned End Date <span class="text-danger">*</span></label>
                            <input type="date" name="planned_end_date" class="form-control form-control-ent" value="{{ date('Y-m-d', strtotime('+15 days')) }}" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold small text-slate-700">Target Daily Qty (Pcs) <span class="text-danger">*</span></label>
                            <input type="number" min="1" name="target_daily_qty" class="form-control form-control-ent" required placeholder="e.g. 500">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold small text-slate-700">Line Allocation</label>
                            <input type="text" name="line_allocation" class="form-control form-control-ent" placeholder="e.g. Sewing Line 1 & Line 2">
                        </div>
                        <div class="col-md-12">
                            <label class="form-label fw-semibold small text-slate-700">Status <span class="text-danger">*</span></label>
                            <select name="status" class="form-select form-select-ent" required>
                                <option value="Approved" selected>Approved</option>
                                <option value="Draft">Draft</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer bg-slate-50 p-3">
                    <button type="button" class="btn-ent-outline" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn-ent-primary">Save & Approve Plan</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
