@extends('layouts.app')

@section('title', 'Lay Model Details')

@section('content')
<div class="top-page-header mb-4">
    <div class="d-flex justify-content-between align-items-center">
        <div>
            <a href="{{ route('lay-models.index') }}" class="text-decoration-none text-muted small fw-semibold">
                <i class="bi bi-arrow-left"></i> BACK TO LAY MODELS
            </a>
            <div class="d-flex align-items-center gap-2 mt-1">
                <h1 class="top-page-header-title mb-0">{{ $layModel->lay_model_name }}</h1>
                <span class="badge-ent badge-ent-slate font-mono-num">{{ $layModel->lay_model_code }}</span>
                @if($layModel->status === 'Active')
                    <span class="badge-ent badge-ent-emerald">Active</span>
                @else
                    <span class="badge-ent badge-ent-rose">Inactive</span>
                @endif
            </div>
            <p class="top-page-header-subtitle mt-1">Lay parameters, ply counts, marker dimensions, and fabric group linkage.</p>
        </div>
        <div>
            <a href="{{ route('lay-models.edit', $layModel) }}" class="btn-ent-primary">
                <i class="bi bi-pencil"></i> Edit Lay Model
            </a>
        </div>
    </div>
</div>

<div class="row g-4">
    <div class="col-lg-8">
        <div class="card-ent mb-4">
            <div class="card-header bg-white py-3 border-bottom">
                <h6 class="fw-bold mb-0 text-dark"><i class="bi bi-grid-3x3-gap text-primary me-2"></i> Lay Parameters & Marker Specifications</h6>
            </div>
            <div class="card-ent-body">
                <div class="row g-3">
                    <div class="col-sm-6">
                        <span class="text-muted d-block fs-7 text-uppercase fw-semibold">Lay Model Code</span>
                        <span class="fw-bold font-mono-num text-dark fs-6">{{ $layModel->lay_model_code }}</span>
                    </div>
                    <div class="col-sm-6">
                        <span class="text-muted d-block fs-7 text-uppercase fw-semibold">Lay Model Name</span>
                        <span class="fw-bold text-dark fs-6">{{ $layModel->lay_model_name }}</span>
                    </div>

                    <div class="col-sm-4">
                        <span class="text-muted d-block fs-7 text-uppercase fw-semibold">Lay Length</span>
                        <span class="font-mono-num fw-bold text-dark fs-6">{{ $layModel->lay_length }} M</span>
                    </div>
                    <div class="col-sm-4">
                        <span class="text-muted d-block fs-7 text-uppercase fw-semibold">Lay Width</span>
                        <span class="font-mono-num fw-bold text-dark fs-6">{{ $layModel->lay_width }} In</span>
                    </div>
                    <div class="col-sm-4">
                        <span class="text-muted d-block fs-7 text-uppercase fw-semibold">Number of Plies</span>
                        <span class="badge-ent badge-ent-blue font-mono-num fs-6">{{ $layModel->number_of_plies }} Plies</span>
                    </div>

                    <div class="col-sm-4">
                        <span class="text-muted d-block fs-7 text-uppercase fw-semibold">Garment Size Ratio</span>
                        <span class="font-mono-num text-dark fw-medium">{{ $layModel->garment_size ?: '-' }}</span>
                    </div>
                    <div class="col-sm-4">
                        <span class="text-muted d-block fs-7 text-uppercase fw-semibold">Marker Length</span>
                        <span class="font-mono-num text-dark fw-medium">{{ $layModel->marker_length ? $layModel->marker_length . ' M' : '-' }}</span>
                    </div>
                    <div class="col-sm-4">
                        <span class="text-muted d-block fs-7 text-uppercase fw-semibold">Marker Width</span>
                        <span class="font-mono-num text-dark fw-medium">{{ $layModel->marker_width ? $layModel->marker_width . ' In' : '-' }}</span>
                    </div>

                    <div class="col-12 border-top pt-3">
                        <span class="text-muted d-block fs-7 text-uppercase fw-semibold">Laying Instructions</span>
                        <p class="mb-0 text-dark">{{ $layModel->description ?: 'No specific laying instructions provided.' }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <!-- Relationship Hierarchy -->
        <div class="card-ent mb-4">
            <div class="card-header bg-white py-3 border-bottom">
                <h6 class="fw-bold mb-0 text-dark"><i class="bi bi-diagram-3 text-primary me-2"></i> Relationship Hierarchy</h6>
            </div>
            <div class="card-ent-body">
                <div class="p-3 bg-light rounded border mb-3">
                    <span class="badge-ent badge-ent-emerald text-uppercase">1. Fabric Group</span>
                    <h6 class="fw-bold mt-2 mb-0">
                        @if($layModel->fabricGroup)
                            <a href="{{ route('fabric-groups.show', $layModel->fabricGroup) }}" class="text-decoration-none text-dark font-mono-num">
                                {{ $layModel->fabricGroup->group_name }} ({{ $layModel->fabricGroup->group_code }})
                            </a>
                        @else
                            <span class="text-muted">Unassigned</span>
                        @endif
                    </h6>
                </div>
                <div class="text-center my-1 text-muted">
                    <i class="bi bi-arrow-down fs-5"></i>
                </div>
                <div class="p-3 bg-light rounded border">
                    <span class="badge-ent badge-ent-blue text-uppercase">2. Fabric SKU</span>
                    <h6 class="fw-bold mt-2 mb-0">
                        @if($layModel->fabric)
                            <a href="{{ route('fabrics.show', $layModel->fabric) }}" class="text-decoration-none text-dark font-mono-num">
                                {{ $layModel->fabric->fabric_name }} ({{ $layModel->fabric->fabric_code }})
                            </a>
                        @else
                            <span class="text-muted">Unassigned</span>
                        @endif
                    </h6>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
