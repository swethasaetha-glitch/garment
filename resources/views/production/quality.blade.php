@extends('layouts.app')

@section('title', 'Quality Control')
@section('page_header_title', 'Quality Control & Audit')
@section('page_header_subtitle', 'Track Tech Solutions | First Time Pass Rate & DHU Defect Analytics')

@section('content')
<!-- Summary Metrics Bar (3 Enterprise KPI Cards) -->
<div class="row g-3 mb-4">
    <div class="col-md-4 col-sm-6">
        <div class="card-ent h-100 p-3">
            <div class="d-flex justify-content-between align-items-center mb-1">
                <span class="text-uppercase fw-bold text-slate-500 font-mono" style="font-size:0.65rem;">First Time Pass Rate</span>
                <span class="badge-ent badge-ent-emerald">Passed</span>
            </div>
            <div class="fw-bold text-emerald-600 font-mono-num mb-1" style="font-size: 1.85rem; line-height: 1;">98.4%</div>
            <div class="text-slate-500 small" style="font-size:0.72rem;">First time pass rate</div>
        </div>
    </div>

    <div class="col-md-4 col-sm-6">
        <div class="card-ent h-100 p-3">
            <div class="d-flex justify-content-between align-items-center mb-1">
                <span class="text-uppercase fw-bold text-slate-500 font-mono" style="font-size:0.65rem;">Inspected Pieces</span>
                <span class="badge-ent badge-ent-blue">Audited</span>
            </div>
            <div class="fw-bold text-slate-900 font-mono-num mb-1" style="font-size: 1.85rem; line-height: 1;">2,850</div>
            <div class="text-slate-500 small" style="font-size:0.72rem;">Garments checked today</div>
        </div>
    </div>

    <div class="col-md-4 col-sm-12">
        <div class="card-ent h-100 p-3">
            <div class="d-flex justify-content-between align-items-center mb-1">
                <span class="text-uppercase fw-bold text-slate-500 font-mono" style="font-size:0.65rem;">Defects Sent to Alteration</span>
                <span class="badge-ent badge-ent-rose">Rework</span>
            </div>
            <div class="fw-bold text-rose-600 font-mono-num mb-1" style="font-size: 1.85rem; line-height: 1;">46</div>
            <div class="text-slate-500 small" style="font-size:0.72rem;">Sent for alteration line</div>
        </div>
    </div>
</div>

<!-- Quality Control Panel -->
<div class="card-ent">
    <div class="card-ent-body p-3">
        <div class="d-flex justify-content-between align-items-center mb-3 pb-2 border-bottom">
            <div>
                <h5 class="fw-bold text-slate-900 mb-0 fs-6">Quality Assurance & Audit Stream</h5>
                <p class="text-slate-500 mb-0 small" style="font-size:0.75rem;">Inline, end-of-line, and 4-point fabric quality standards</p>
            </div>
            <span class="badge-ent badge-ent-emerald"><i class="bi bi-shield-check me-1"></i> Quality Module Active</span>
        </div>

        <div class="p-4 bg-slate-50 rounded text-center border">
            <i class="bi bi-patch-check-fill text-emerald-600 fs-1 d-block mb-2"></i>
            <h6 class="fw-bold text-slate-900 mb-1">Quality Control Inspection Active</h6>
            <p class="text-slate-500 small mb-0">Live defect classification, DHU tracking, and AQL 2.5 garment audit standards active across all lines.</p>
        </div>
    </div>
</div>
@endsection
