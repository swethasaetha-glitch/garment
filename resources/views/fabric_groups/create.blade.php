@extends('layouts.app')

@section('title', 'Create Fabric Group')

@section('content')
<div class="top-page-header mb-4">
    <div class="d-flex justify-content-between align-items-center">
        <div>
            <a href="{{ route('fabric-groups.index') }}" class="text-decoration-none text-muted small fw-semibold">
                <i class="bi bi-arrow-left"></i> BACK TO FABRIC GROUPS
            </a>
            <h1 class="top-page-header-title mt-1">Create Fabric Group</h1>
            <p class="top-page-header-subtitle">Group multiple fabric SKUs together for Lay Models, CAD & Cut Planning.</p>
        </div>
    </div>
</div>

<div class="card-ent">
    <div class="card-ent-body">
        <form action="{{ route('fabric-groups.store') }}" method="POST">
            @csrf
            <div class="row g-3">
                <div class="col-md-6">
                    <label for="group_code" class="form-label fw-semibold fs-7 text-dark">Group Code <span class="text-danger">*</span></label>
                    <input type="text" name="group_code" id="group_code" class="form-control-ent w-100 @error('group_code') is-invalid @enderror" value="{{ old('group_code') }}" required placeholder="e.g. FG-COT-001">
                    @error('group_code')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6">
                    <label for="group_name" class="form-label fw-semibold fs-7 text-dark">Group Name <span class="text-danger">*</span></label>
                    <input type="text" name="group_name" id="group_name" class="form-control-ent w-100 @error('group_name') is-invalid @enderror" value="{{ old('group_name') }}" required placeholder="e.g. Cotton Knitted Fabrics">
                    @error('group_name')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-12">
                    <label for="description" class="form-label fw-semibold fs-7 text-dark">Description</label>
                    <textarea name="description" id="description" rows="2" class="form-control-ent w-100 @error('description') is-invalid @enderror" placeholder="e.g. Standard 180 GSM single jersey cotton fabrics for T-Shirt production">{{ old('description') }}</textarea>
                    @error('description')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-12">
                    <label class="form-label fw-semibold fs-7 text-dark">Assign Fabrics to Group <span class="text-danger">*</span></label>
                    <p class="text-muted small mb-2">Check all fabrics that belong to this group (at least 1 required).</p>
                    <div class="border rounded p-3 bg-light" style="max-height: 280px; overflow-y: auto;">
                        <div class="row g-2">
                            @forelse($fabrics as $fabric)
                                <div class="col-md-6 col-lg-4">
                                    <div class="card-ent p-2.5 bg-white h-100">
                                        <div class="form-check m-0 d-flex align-items-center gap-2">
                                            <input class="form-check-input" type="checkbox" name="fabrics[]" value="{{ $fabric->id }}" id="fabric_{{ $fabric->id }}" {{ is_array(old('fabrics')) && in_array($fabric->id, old('fabrics')) ? 'checked' : '' }}>
                                            <label class="form-check-label w-100 text-truncate cursor-pointer" for="fabric_{{ $fabric->id }}">
                                                <span class="fw-bold font-mono-num text-dark">{{ $fabric->fabric_code }}</span>
                                                <span class="text-muted"> - {{ $fabric->fabric_name }}</span>
                                                <span class="badge-ent badge-ent-slate ms-1">{{ $fabric->gsm ? $fabric->gsm . ' GSM' : $fabric->fabric_type }}</span>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <div class="col-12 text-center text-muted py-4">
                                    No active fabrics found. <a href="{{ route('fabrics.create') }}" class="text-primary text-decoration-none fw-semibold">Add a fabric first</a>.
                                </div>
                            @endforelse
                        </div>
                    </div>
                    @error('fabrics')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6">
                    <label for="status" class="form-label fw-semibold fs-7 text-dark">Group Status <span class="text-danger">*</span></label>
                    <select name="status" id="status" class="form-select-ent w-100 @error('status') is-invalid @enderror" required>
                        <option value="Active" {{ old('status', 'Active') == 'Active' ? 'selected' : '' }}>Active</option>
                        <option value="Inactive" {{ old('status') == 'Inactive' ? 'selected' : '' }}>Inactive</option>
                    </select>
                    @error('status')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="mt-4 pt-3 border-top d-flex justify-content-end gap-2">
                <a href="{{ route('fabric-groups.index') }}" class="btn-ent-outline">Cancel</a>
                <button type="submit" class="btn-ent-primary">
                    <i class="bi bi-check-lg"></i> Save Fabric Group
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
