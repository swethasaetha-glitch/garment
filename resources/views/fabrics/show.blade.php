@extends('layouts.app')

@section('title', 'Fabric Details')

@section('content')
<div class="top-page-header mb-4">
    <div class="d-flex justify-content-between align-items-center">
        <div>
            <a href="{{ route('fabrics.index') }}" class="text-decoration-none text-muted small fw-semibold">
                <i class="bi bi-arrow-left"></i> BACK TO FABRIC STORE
            </a>
            <div class="d-flex align-items-center gap-2 mt-1">
                <h1 class="top-page-header-title mb-0">{{ $fabric->fabric_name }}</h1>
                <span class="badge-ent badge-ent-slate font-mono-num">{{ $fabric->fabric_code }}</span>
                @if($fabric->status === 'Active')
                    <span class="badge-ent badge-ent-emerald">Active</span>
                @else
                    <span class="badge-ent badge-ent-rose">Inactive</span>
                @endif
            </div>
            <p class="top-page-header-subtitle mt-1">Fabric SKU specifications and connected fabric groups.</p>
        </div>
        <div>
            <a href="{{ route('fabrics.edit', $fabric) }}" class="btn-ent-primary">
                <i class="bi bi-pencil"></i> Edit Fabric SKU
            </a>
        </div>
    </div>
</div>

<div class="row g-4">
    <div class="col-lg-8">
        <div class="card-ent mb-4">
            <div class="card-header bg-white py-3 border-bottom">
                <h6 class="fw-bold mb-0 text-dark"><i class="bi bi-info-circle text-primary me-2"></i> Specification Sheet</h6>
            </div>
            <div class="card-ent-body">
                <div class="row g-3">
                    <div class="col-sm-6">
                        <span class="text-muted d-block fs-7 text-uppercase fw-semibold">Fabric Code</span>
                        <span class="fw-bold font-mono-num text-dark fs-6">{{ $fabric->fabric_code }}</span>
                    </div>
                    <div class="col-sm-6">
                        <span class="text-muted d-block fs-7 text-uppercase fw-semibold">Fabric Name</span>
                        <span class="fw-bold text-dark fs-6">{{ $fabric->fabric_name }}</span>
                    </div>
                    <div class="col-sm-6">
                        <span class="text-muted d-block fs-7 text-uppercase fw-semibold">Type</span>
                        <span class="badge-ent badge-ent-blue">{{ $fabric->fabric_type }}</span>
                    </div>
                    <div class="col-sm-6">
                        <span class="text-muted d-block fs-7 text-uppercase fw-semibold">Composition</span>
                        <span class="text-dark font-mono-num">{{ $fabric->composition ?: '-' }}</span>
                    </div>
                    <div class="col-sm-4">
                        <span class="text-muted d-block fs-7 text-uppercase fw-semibold">Color / Shade</span>
                        <span class="text-dark fw-medium">{{ $fabric->color ?: '-' }}</span>
                    </div>
                    <div class="col-sm-4">
                        <span class="text-muted d-block fs-7 text-uppercase fw-semibold">GSM</span>
                        <span class="font-mono-num fw-bold text-dark">{{ $fabric->gsm ? $fabric->gsm . ' GSM' : '-' }}</span>
                    </div>
                    <div class="col-sm-4">
                        <span class="text-muted d-block fs-7 text-uppercase fw-semibold">Cuttable Width</span>
                        <span class="font-mono-num fw-bold text-dark">{{ $fabric->width ? $fabric->width . ' Inches' : '-' }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <!-- Associated Fabric Groups -->
        <div class="card-ent mb-4">
            <div class="card-header bg-white py-3 border-bottom">
                <h6 class="fw-bold mb-0 text-dark"><i class="bi bi-collection text-primary me-2"></i> Associated Fabric Groups</h6>
            </div>
            <div class="card-ent-body p-0">
                <div class="list-group list-group-flush">
                    @forelse($fabric->groups as $group)
                        <a href="{{ route('fabric-groups.show', $group) }}" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center py-3">
                            <div>
                                <span class="fw-bold text-dark d-block">{{ $group->group_name }}</span>
                                <span class="font-mono-num text-muted fs-7">{{ $group->group_code }}</span>
                            </div>
                            <span class="badge-ent badge-ent-slate">{{ $group->status }}</span>
                        </a>
                    @empty
                        <div class="text-muted text-center py-4 fs-7">Not assigned to any fabric group</div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
