@extends('layouts.app')

@section('title', 'Cutting Management & Operations')
@section('page_header_title', 'Cutting Operations & Floor Execution')
@section('page_header_subtitle', 'Track Tech Solutions | Fabric Spreading, Lay Cutting & Bundle QR Tickets')

@section('top_header_action')
<button type="button" class="btn-ent-primary" data-bs-toggle="modal" data-bs-target="#startCutModal">
    <i class="bi bi-scissors"></i> Start New Cut Order
</button>
@endsection

@section('content')
<!-- Metric Summary Cards -->
<div class="row g-3 mb-4">
    <div class="col-md-3 col-sm-6">
        <div class="card-ent h-100 p-3">
            <div class="d-flex justify-content-between align-items-center mb-1">
                <span class="text-uppercase fw-bold text-slate-500 font-mono" style="font-size:0.65rem;">Active Lay Orders</span>
                <span class="badge-ent badge-ent-blue">Cutting</span>
            </div>
            <div class="fw-bold text-slate-900 font-mono-num mb-1" style="font-size: 1.75rem; line-height: 1;">{{ $cutPlans->count() }}</div>
            <div class="text-slate-500 small" style="font-size:0.72rem;">Orders currently on cutting tables</div>
        </div>
    </div>

    <div class="col-md-3 col-sm-6">
        <div class="card-ent h-100 p-3">
            <div class="d-flex justify-content-between align-items-center mb-1">
                <span class="text-uppercase fw-bold text-slate-500 font-mono" style="font-size:0.65rem;">Total Plies Cut</span>
                <span class="badge-ent badge-ent-emerald">Plies</span>
            </div>
            <div class="fw-bold text-emerald-600 font-mono-num mb-1" style="font-size: 1.75rem; line-height: 1;">{{ number_format($cutPlans->sum('no_of_piles')) }}</div>
            <div class="text-slate-500 small" style="font-size:0.72rem;">Plies processed across lays</div>
        </div>
    </div>

    <div class="col-md-3 col-sm-6">
        <div class="card-ent h-100 p-3">
            <div class="d-flex justify-content-between align-items-center mb-1">
                <span class="text-uppercase fw-bold text-slate-500 font-mono" style="font-size:0.65rem;">Cutting Machines</span>
                <span class="badge-ent badge-ent-blue">Online</span>
            </div>
            <div class="fw-bold text-sky-600 font-mono-num mb-1" style="font-size: 1.75rem; line-height: 1;">{{ $cuttingMachines->count() }}</div>
            <div class="text-slate-500 small" style="font-size:0.72rem;">Auto Cutters & Knife machines</div>
        </div>
    </div>

    <div class="col-md-3 col-sm-6">
        <div class="card-ent h-100 p-3">
            <div class="d-flex justify-content-between align-items-center mb-1">
                <span class="text-uppercase fw-bold text-slate-500 font-mono" style="font-size:0.65rem;">Bundle QR Tickets</span>
                <span class="badge-ent badge-ent-amber">QR Tickets</span>
            </div>
            <div class="fw-bold text-amber-600 font-mono-num mb-1" style="font-size: 1.75rem; line-height: 1;">{{ $lotBundles->count() }}</div>
            <div class="text-slate-500 small" style="font-size:0.72rem;">Numbering & bundling complete</div>
        </div>
    </div>
</div>

<!-- Active Cutting Floor Operations Table -->
<div class="card-ent mb-4">
    <div class="card-ent-body p-3">
        <div class="d-flex justify-content-between align-items-center mb-3 pb-2 border-bottom">
            <div>
                <h5 class="fw-bold text-slate-900 mb-0 fs-6">Active Cutting Orders & Lay Tables</h5>
                <p class="text-slate-500 mb-0 small" style="font-size:0.75rem;">Real-time execution status on cutting tables</p>
            </div>
            <span class="badge-ent badge-ent-blue">{{ $cutPlans->count() }} Lays Active</span>
        </div>

        <div class="table-responsive">
            <table class="table table-hover align-middle text-xs mb-0">
                <thead>
                    <tr class="text-slate-500 border-bottom">
                        <th class="fw-bold font-mono">CUT PLAN NO</th>
                        <th class="fw-bold">SALES ORDER / STYLE</th>
                        <th class="fw-bold">CAD TYPE</th>
                        <th class="fw-bold">PLIES COUNT</th>
                        <th class="fw-bold">CUT TYPE</th>
                        <th class="fw-bold">ALLOCATION MODE</th>
                        <th class="text-end fw-bold">STATUS</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($cutPlans as $cp)
                    <tr>
                        <td class="fw-bold text-primary font-mono fs-6">{{ $cp->cut_plan_no }}</td>
                        <td>
                            <div class="fw-bold text-slate-900 font-mono">{{ $cp->salesOrder?->sales_order_no }}</div>
                            <div class="text-slate-500" style="font-size:0.7rem;">Style: {{ $cp->salesOrder?->style_no }}</div>
                        </td>
                        <td><span class="badge-ent badge-ent-slate">{{ $cp->cad_type }} ({{ $cp->unit_of_measure }})</span></td>
                        <td class="fw-bold font-mono-num text-emerald-700">{{ number_format($cp->no_of_piles) }} Plies</td>
                        <td class="capitalize text-slate-700">{{ str_replace('_', ' ', $cp->cut_plan_type) }}</td>
                        <td class="capitalize text-slate-500">{{ str_replace('_', ' ', $cp->group_allocation) }}</td>
                        <td class="text-end">
                            <span class="badge-ent badge-ent-emerald capitalize">
                                {{ str_replace('_', ' ', $cp->status) }}
                            </span>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center py-4 text-slate-500">No cutting orders active. Click "Start New Cut Order" above to begin.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Numbering & Bundle QR Code Station -->
<div class="card-ent mb-4">
    <div class="card-ent-body p-3">
        <div class="d-flex justify-content-between align-items-center mb-3 pb-2 border-bottom">
            <div>
                <h5 class="fw-bold text-slate-900 mb-0 fs-6">Numbering & Bundle QR Code Station</h5>
                <p class="text-slate-500 mb-0 small" style="font-size:0.75rem;">Generated Lot Bundle Tickets ready for Supermarket / Sewing Issue</p>
            </div>
            <span class="badge-ent badge-ent-amber">{{ $lotBundles->count() }} QR Bundles</span>
        </div>

        <div class="table-responsive">
            <table class="table table-hover align-middle text-xs mb-0">
                <thead>
                    <tr class="text-slate-500 border-bottom">
                        <th class="fw-bold font-mono">BUNDLE TICKET NO</th>
                        <th class="fw-bold">QR CODE HASH</th>
                        <th class="fw-bold">SIZE</th>
                        <th class="fw-bold">SHADE GROUP</th>
                        <th class="fw-bold">GARMENT QTY</th>
                        <th class="fw-bold">OPERATOR / SUPERVISOR</th>
                        <th class="text-end fw-bold">ROUTING STAGE</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($lotBundles as $bnd)
                    <tr>
                        <td class="fw-bold text-primary font-mono fs-6">{{ $bnd->bundle_no }}</td>
                        <td>
                            <code class="text-slate-700 bg-slate-100 px-2 py-0.5 rounded font-mono" style="font-size:0.7rem;">
                                <i class="bi bi-qr-code text-primary me-1"></i> {{ substr($bnd->qr_code_hash, 0, 16) }}...
                            </code>
                        </td>
                        <td><span class="badge-ent badge-ent-slate font-mono">{{ $bnd->size }}</span></td>
                        <td class="text-sky-700 fw-semibold font-mono">{{ $bnd->shade_group }}</td>
                        <td class="fw-bold font-mono-num text-emerald-700">{{ number_format($bnd->garment_qty) }} Pcs</td>
                        <td>
                            <div class="fw-semibold text-slate-900">{{ $bnd->operator?->name ?? 'Cutter 01' }}</div>
                            <div class="text-slate-500" style="font-size:0.7rem;">Sup: {{ $bnd->supervisor?->name ?? 'Murugan V' }}</div>
                        </td>
                        <td class="text-end">
                            <span class="badge-ent badge-ent-blue uppercase">
                                {{ str_replace('_', ' ', $bnd->stage) }}
                            </span>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal: Start New Cut Order -->
<div class="modal fade" id="startCutModal" tabindex="-1" aria-labelledby="startCutModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content rounded border-0 shadow-lg">
            <div class="modal-header bg-slate-900 text-white p-3">
                <h6 class="modal-title fw-bold text-white mb-0" id="startCutModalLabel">
                    <i class="bi bi-scissors me-2"></i> Start New Cut Order & Spreading Lay
                </h6>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('production.cutting.store') }}" method="POST">
                @csrf
                <div class="modal-body p-4">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label fw-semibold small text-slate-700">Sales Order & Style</label>
                            <select name="sales_order_id" required class="form-select form-select-ent">
                                <option value="" disabled selected>Select Sales Order...</option>
                                @foreach($salesOrders as $so)
                                    <option value="{{ $so->id }}">{{ $so->sales_order_no }} — Style: {{ $so->style_no }} ({{ $so->garment_type }})</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-semibold small text-slate-700">Fabric Material</label>
                            <select name="fabric_id" required class="form-select form-select-ent">
                                <option value="" disabled selected>Select Fabric Roll...</option>
                                @foreach($fabrics as $fab)
                                    <option value="{{ $fab->id }}">{{ $fab->fabric_code }} — {{ $fab->fabric_name }} ({{ $fab->color }}, {{ $fab->gsm }} GSM)</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-semibold small text-slate-700">Cutting Method & Machine</label>
                            <select name="cutting_method" required class="form-select form-select-ent">
                                <option value="Gerber Auto Cutter">Gerber Auto Cutter</option>
                                <option value="Straight Knife">Straight Knife</option>
                                <option value="Band Knife">Band Knife</option>
                                <option value="Manual Cutting">Manual Cutting</option>
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-semibold small text-slate-700">Lay Table Assignment</label>
                            <select name="table_no" required class="form-select form-select-ent">
                                <option value="Table 01 (Auto Spreader)">Table 01 (Auto Spreader)</option>
                                <option value="Table 02 (Manual Lay)">Table 02 (Manual Lay)</option>
                                <option value="Table 03 (High Density)">Table 03 (High Density)</option>
                                <option value="Table 04 (Gerber System)">Table 04 (Gerber System)</option>
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-semibold small text-slate-700">Layman Cutter Operator</label>
                            <select name="operator_id" class="form-select form-select-ent">
                                <option value="">Auto Assign Lead Cutter</option>
                                @foreach($operators as $op)
                                    <option value="{{ $op->id }}">{{ $op->operator_code }} — {{ $op->name }} ({{ $op->department }})</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-semibold small text-slate-700">Cutting Supervisor</label>
                            <select name="supervisor_id" class="form-select form-select-ent">
                                <option value="">Select Supervisor...</option>
                                @foreach($supervisors as $sup)
                                    <option value="{{ $sup->id }}">{{ $sup->supervisor_code }} — {{ $sup->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-semibold small text-slate-700">Number of Plies</label>
                            <input type="number" name="no_of_piles" value="100" min="1" required class="form-control form-control-ent font-mono-num fw-bold text-primary">
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-semibold small text-slate-700">Extra Qty Allowance</label>
                            <input type="number" name="extra_qty" value="50" min="0" required class="form-control form-control-ent font-mono-num fw-bold text-emerald-600">
                        </div>
                    </div>
                </div>
                <div class="modal-footer bg-slate-50 p-3">
                    <button type="button" class="btn-ent-outline" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn-ent-primary">
                        <i class="bi bi-play-circle me-1"></i> Start Laying & Execute Cut Order
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
