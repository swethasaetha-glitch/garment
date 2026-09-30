@extends('layouts.app')

@section('title', 'Packing & Dispatch')
@section('page_header_title', 'Packing & Export Finishing')
@section('page_header_subtitle', 'Stage 7: Final Poly-Bagging, Carton Packing, Barcoding & Export Shipment')

@section('content')
<!-- Summary Metrics Bar (3 Enterprise KPI Cards) -->
<div class="row g-3 mb-4">
    <div class="col-md-4 col-sm-6">
        <div class="card-ent h-100 p-3">
            <div class="d-flex justify-content-between align-items-center mb-1">
                <span class="text-uppercase fw-bold text-slate-500 font-mono" style="font-size:0.65rem;">Cartons Packed</span>
                <span class="badge-ent badge-ent-blue">Cartons</span>
            </div>
            <div class="fw-bold text-slate-900 font-mono-num mb-1" style="font-size: 1.85rem; line-height: 1;">142</div>
            <div class="text-slate-500 small" style="font-size:0.72rem;">Packed today</div>
        </div>
    </div>

    <div class="col-md-4 col-sm-6">
        <div class="card-ent h-100 p-3">
            <div class="d-flex justify-content-between align-items-center mb-1">
                <span class="text-uppercase fw-bold text-slate-500 font-mono" style="font-size:0.65rem;">Total Pieces Packed</span>
                <span class="badge-ent badge-ent-emerald">Export Ready</span>
            </div>
            <div class="fw-bold text-emerald-600 font-mono-num mb-1" style="font-size: 1.85rem; line-height: 1;">2,840</div>
            <div class="text-slate-500 small" style="font-size:0.72rem;">Ready for shipment</div>
        </div>
    </div>

    <div class="col-md-4 col-sm-12">
        <div class="card-ent h-100 p-3">
            <div class="d-flex justify-content-between align-items-center mb-1">
                <span class="text-uppercase fw-bold text-slate-500 font-mono" style="font-size:0.65rem;">Orders Ready for Dispatch</span>
                <span class="badge-ent badge-ent-amber">Dispatch</span>
            </div>
            <div class="fw-bold text-amber-600 font-mono-num mb-1" style="font-size: 1.85rem; line-height: 1;">3</div>
            <div class="text-slate-500 small" style="font-size:0.72rem;">Awaiting export dispatch</div>
        </div>
    </div>
</div>

<!-- Packing Operations Panel -->
<div class="card-ent">
    <div class="card-ent-body p-3">
        <div class="d-flex justify-content-between align-items-center mb-3 pb-2 border-bottom">
            <div>
                <h5 class="fw-bold text-slate-900 mb-0 fs-6">Packing & Shipment Dispatch</h5>
                <p class="text-slate-500 mb-0 small" style="font-size:0.75rem;">Garment poly-bagging, ratio carton packing, and barcode dispatch labeling</p>
            </div>
            <span class="badge-ent badge-ent-blue"><i class="bi bi-box-seam me-1"></i> Stage 07 Active</span>
        </div>

        <div class="p-4 bg-slate-50 rounded text-center border">
            <i class="bi bi-box-seam text-primary fs-1 d-block mb-2"></i>
            <h6 class="fw-bold text-slate-900 mb-1">Export Packing & Barcode Scan Active</h6>
            <p class="text-slate-500 small mb-0">Final stage of garment production workflow. Tracks carton gross weight, ratio packing, and shipping manifest generation.</p>
        </div>
    </div>
</div>
@endsection
