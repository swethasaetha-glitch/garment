@extends('layouts.app')

@section('title', 'Cut Room Planner')
@section('page_header_title', 'Cut Room Planner & CAD Layouts')
@section('page_header_subtitle', 'Configure CAD Markers, Cut Plan Types, Plies & Fabric Group Allocations')

@section('content')
<!-- Metric Summary Cards -->
<div class="row g-3 mb-4">
    <div class="col-md-3 col-sm-6">
        <div class="card-ent h-100 p-3">
            <div class="d-flex justify-content-between align-items-center mb-1">
                <span class="text-uppercase fw-bold text-slate-500 font-mono" style="font-size:0.65rem;">Total Cut Plans</span>
                <span class="badge-ent badge-ent-blue">Plans</span>
            </div>
            <div class="fw-bold text-slate-900 font-mono-num mb-1" style="font-size: 1.75rem; line-height: 1;">{{ $cutPlans->total() }}</div>
            <div class="text-slate-500 small" style="font-size:0.72rem;">Active cut room plans</div>
        </div>
    </div>
    
    <div class="col-md-3 col-sm-6">
        <div class="card-ent h-100 p-3">
            <div class="d-flex justify-content-between align-items-center mb-1">
                <span class="text-uppercase fw-bold text-slate-500 font-mono" style="font-size:0.65rem;">CAD Markers</span>
                <span class="badge-ent badge-ent-blue">Marker</span>
            </div>
            <div class="fw-bold text-sky-600 font-mono-num mb-1" style="font-size: 1.75rem; line-height: 1;">
                {{ \App\Models\CutPlan::where('cad_type', 'Marker')->count() }}
            </div>
            <div class="text-slate-500 small" style="font-size:0.72rem;">Active CAD layout markers</div>
        </div>
    </div>

    <div class="col-md-3 col-sm-6">
        <div class="card-ent h-100 p-3">
            <div class="d-flex justify-content-between align-items-center mb-1">
                <span class="text-uppercase fw-bold text-slate-500 font-mono" style="font-size:0.65rem;">Total Plies Planned</span>
                <span class="badge-ent badge-ent-emerald">Plies</span>
            </div>
            <div class="fw-bold text-emerald-600 font-mono-num mb-1" style="font-size: 1.75rem; line-height: 1;">
                {{ number_format(\App\Models\CutPlan::sum('no_of_piles')) }}
            </div>
            <div class="text-slate-500 small" style="font-size:0.72rem;">Cumulative plies across lays</div>
        </div>
    </div>

    <div class="col-md-3 col-sm-6">
        <div class="card-ent h-100 p-3">
            <div class="d-flex justify-content-between align-items-center mb-1">
                <span class="text-uppercase fw-bold text-slate-500 font-mono" style="font-size:0.65rem;">Generated QR Bundles</span>
                <span class="badge-ent badge-ent-amber">QR Tickets</span>
            </div>
            <div class="fw-bold text-amber-600 font-mono-num mb-1" style="font-size: 1.75rem; line-height: 1;">
                {{ \App\Models\LotBundle::count() }}
            </div>
            <div class="text-slate-500 small" style="font-size:0.72rem;">Bundle QR tickets generated</div>
        </div>
    </div>
</div>

<div class="row g-3">
    <!-- Cut Plan Creation Panel -->
    <div class="col-lg-5">
        <div class="card-ent">
            <div class="card-ent-body p-3">
                <div class="d-flex align-items-center gap-2 mb-3 pb-2 border-bottom">
                    <i class="bi bi-scissors text-primary fs-5"></i>
                    <div>
                        <h5 class="fw-bold text-slate-900 mb-0 fs-6">Create New Cut Plan</h5>
                        <p class="text-slate-500 mb-0 small" style="font-size:0.75rem;">Configure CAD settings & ply allocations</p>
                    </div>
                </div>

                <form action="{{ route('cut-planning.store') }}" method="POST">
                    @csrf

                    <div class="mb-2">
                        <label class="form-label fw-semibold small text-slate-700">Sales Order & Style</label>
                        <select name="sales_order_id" required class="form-select form-select-ent">
                            <option value="" disabled selected>Select Sales Order...</option>
                            @foreach($salesOrders as $so)
                                <option value="{{ $so->id }}">{{ $so->sales_order_no }} — Style: {{ $so->style_no }} ({{ $so->garment_type }})</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-2">
                        <label class="form-label fw-semibold small text-slate-700">Fabric Material</label>
                        <select name="fabric_id" required class="form-select form-select-ent">
                            <option value="" disabled selected>Select Fabric Roll...</option>
                            @foreach($fabrics as $fab)
                                <option value="{{ $fab->id }}">{{ $fab->fabric_code }} — {{ $fab->fabric_name }} ({{ $fab->color }}, {{ $fab->gsm }} GSM)</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="row g-2 mb-2">
                        <div class="col-6">
                            <label class="form-label fw-semibold small text-slate-700">CAD Type</label>
                            <select name="cad_type" class="form-select form-select-ent">
                                <option value="Marker">Marker</option>
                                <option value="Pattern">Pattern</option>
                            </select>
                        </div>
                        <div class="col-6">
                            <label class="form-label fw-semibold small text-slate-700">Unit of Measure</label>
                            <select name="unit_of_measure" class="form-select form-select-ent">
                                <option value="Metres">Metres (Shirts/Denim)</option>
                                <option value="Kg">Kg (Knits)</option>
                            </select>
                        </div>
                    </div>

                    <div class="mb-2">
                        <label class="form-label fw-semibold small text-slate-700">Cut Plan Type</label>
                        <select name="cut_plan_type" class="form-select form-select-ent">
                            <option value="selected_ratio">Selected Ratio Cut Plan</option>
                            <option value="step_down">Step Down</option>
                            <option value="mini_marker">Mini Marker</option>
                            <option value="selected_size">Selected Size Cut Plan</option>
                            <option value="piles_multiples">Piles Multiples</option>
                            <option value="partial_cut">Partial Cut Plan</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold small text-slate-700">Group Allocation Mode</label>
                        <select name="group_allocation" class="form-select form-select-ent">
                            <option value="automatic">Automatic</option>
                            <option value="factory_cut_plan">Factory Cut Plan</option>
                            <option value="fit_mode">Fit Mode</option>
                            <option value="max_pcs">Max Pcs Cut Plan</option>
                            <option value="piles_adjust">Piles Adjust</option>
                            <option value="equal_size">Equal Size</option>
                            <option value="auto_endbit">Auto Endbit Allocation</option>
                        </select>
                    </div>

                    <div class="p-3 bg-slate-50 rounded border mb-3">
                        <div class="row g-2">
                            <div class="col-4">
                                <label class="form-label fw-bold text-slate-500 font-mono" style="font-size:0.65rem;">NO OF PLIES</label>
                                <input type="number" name="no_of_piles" value="100" min="1" required class="form-control form-control-ent font-mono-num fw-bold text-primary">
                            </div>
                            <div class="col-4">
                                <label class="form-label fw-bold text-slate-500 font-mono" style="font-size:0.65rem;">ORDER QTY</label>
                                <input type="number" name="order_qty" value="1500" min="1" required class="form-control form-control-ent font-mono-num fw-bold">
                            </div>
                            <div class="col-4">
                                <label class="form-label fw-bold text-slate-500 font-mono" style="font-size:0.65rem;">EXTRA QTY</label>
                                <input type="number" name="extra_qty" value="50" min="0" required class="form-control form-control-ent font-mono-num fw-bold text-emerald-600">
                            </div>
                        </div>
                    </div>

                    <button type="submit" class="btn-ent-primary w-100 justify-content-center">
                        <i class="bi bi-check-lg"></i> Save Cut Plan & Auto-Generate Bundles
                    </button>
                </form>
            </div>
        </div>
    </div>

    <!-- Cut Plan Catalog Table -->
    <div class="col-lg-7">
        <div class="card-ent">
            <div class="card-ent-body p-3">
                <div class="d-flex justify-content-between align-items-center mb-3 pb-2 border-bottom">
                    <div>
                        <h5 class="fw-bold text-slate-900 mb-0 fs-6">Active Cut Plans Catalog</h5>
                        <p class="text-slate-500 mb-0 small" style="font-size:0.75rem;">Planned and active cutting layouts</p>
                    </div>
                    <span class="badge-ent badge-ent-slate">{{ $cutPlans->total() }} Records</span>
                </div>

                <div class="table-responsive">
                    <table class="table table-hover align-middle text-xs mb-0">
                        <thead>
                            <tr class="text-slate-500 border-bottom">
                                <th class="fw-bold font-mono">CUT PLAN NO</th>
                                <th class="fw-bold">SALES ORDER</th>
                                <th class="fw-bold">PLIES</th>
                                <th class="fw-bold">CUT TYPE</th>
                                <th class="fw-bold">ALLOCATION MODE</th>
                                <th class="text-end fw-bold">STATUS</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($cutPlans as $cp)
                            <tr>
                                <td class="fw-bold text-primary font-mono">
                                    {{ $cp->cut_plan_no }}
                                    <div class="text-slate-400 font-mono" style="font-size:0.68rem;">{{ $cp->cad_type }} ({{ $cp->unit_of_measure }})</div>
                                </td>
                                <td>
                                    <div class="fw-bold text-slate-900 font-mono">{{ $cp->salesOrder?->sales_order_no }}</div>
                                    <div class="text-slate-500" style="font-size:0.7rem;">Style: {{ $cp->salesOrder?->style_no }}</div>
                                </td>
                                <td class="fw-bold font-mono-num text-emerald-700">
                                    {{ $cp->no_of_piles }} Plies
                                </td>
                                <td>
                                    <span class="badge-ent badge-ent-slate capitalize">
                                        {{ str_replace('_', ' ', $cp->cut_plan_type) }}
                                    </span>
                                </td>
                                <td>
                                    <span class="badge-ent badge-ent-blue capitalize">
                                        {{ str_replace('_', ' ', $cp->group_allocation) }}
                                    </span>
                                </td>
                                <td class="text-end">
                                    <span class="badge-ent badge-ent-emerald capitalize">
                                        {{ str_replace('_', ' ', $cp->status) }}
                                    </span>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="text-center py-4 text-slate-500">No cut plans created yet.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="mt-3">
                    {{ $cutPlans->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
