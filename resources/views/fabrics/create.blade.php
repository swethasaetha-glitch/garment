@extends('layouts.app')

@section('title', 'Add New Fabric')

@section('content')
<div class="top-page-header mb-4">
    <div class="d-flex justify-content-between align-items-center">
        <div>
            <a href="{{ route('fabrics.index') }}" class="text-decoration-none text-muted small fw-semibold">
                <i class="bi bi-arrow-left"></i> BACK TO FABRIC STORE
            </a>
            <h1 class="top-page-header-title mt-1">Add New Fabric SKU</h1>
            <p class="top-page-header-subtitle">Define fabric specifications, GSM, width, composition, and inventory unit.</p>
        </div>
    </div>
</div>

<div class="card-ent">
    <div class="card-ent-body">
        <form action="{{ route('fabrics.store') }}" method="POST">
            @csrf
            <div class="row g-3">
                <div class="col-md-6">
                    <label for="fabric_code" class="form-label fw-semibold fs-7 text-dark">Fabric Code <span class="text-danger">*</span></label>
                    <input type="text" name="fabric_code" id="fabric_code" class="form-control-ent w-100 font-mono-num @error('fabric_code') is-invalid @enderror" value="{{ old('fabric_code') }}" required placeholder="e.g. FAB-SJ-180">
                    @error('fabric_code')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6">
                    <label for="fabric_name" class="form-label fw-semibold fs-7 text-dark">Fabric Name <span class="text-danger">*</span></label>
                    <input type="text" name="fabric_name" id="fabric_name" class="form-control-ent w-100 @error('fabric_name') is-invalid @enderror" value="{{ old('fabric_name') }}" required placeholder="e.g. Cotton Single Jersey">
                    @error('fabric_name')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6">
                    <label for="fabric_type" class="form-label fw-semibold fs-7 text-dark">Fabric Type <span class="text-danger">*</span></label>
                    <select name="fabric_type" id="fabric_type" class="form-select-ent w-100 @error('fabric_type') is-invalid @enderror" required>
                        <option value="">-- Select Type --</option>
                        <option value="Knitted" {{ old('fabric_type') == 'Knitted' ? 'selected' : '' }}>Knitted</option>
                        <option value="Woven" {{ old('fabric_type') == 'Woven' ? 'selected' : '' }}>Woven</option>
                        <option value="Non-Woven" {{ old('fabric_type') == 'Non-Woven' ? 'selected' : '' }}>Non-Woven</option>
                    </select>
                    @error('fabric_type')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6">
                    <label for="composition" class="form-label fw-semibold fs-7 text-dark">Composition</label>
                    <input type="text" name="composition" id="composition" class="form-control-ent w-100 @error('composition') is-invalid @enderror" value="{{ old('composition') }}" placeholder="e.g. 100% Combed Cotton">
                    @error('composition')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-4">
                    <label for="color" class="form-label fw-semibold fs-7 text-dark">Color / Shade</label>
                    <input type="text" name="color" id="color" class="form-control-ent w-100 @error('color') is-invalid @enderror" value="{{ old('color') }}" placeholder="e.g. Navy Blue / Shade A">
                    @error('color')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-4">
                    <label for="gsm" class="form-label fw-semibold fs-7 text-dark">GSM</label>
                    <input type="number" step="0.01" min="0" name="gsm" id="gsm" class="form-control-ent w-100 font-mono-num @error('gsm') is-invalid @enderror" value="{{ old('gsm') }}" placeholder="e.g. 180">
                    @error('gsm')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-4">
                    <label for="width" class="form-label fw-semibold fs-7 text-dark">Cuttable Width (Inches)</label>
                    <input type="number" step="0.01" min="0" name="width" id="width" class="form-control-ent w-100 font-mono-num @error('width') is-invalid @enderror" value="{{ old('width') }}" placeholder="e.g. 72">
                    @error('width')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6">
                    <label for="unit" class="form-label fw-semibold fs-7 text-dark">Unit of Measurement</label>
                    <select name="unit" id="unit" class="form-select-ent w-100 @error('unit') is-invalid @enderror">
                        <option value="KG" {{ old('unit', 'KG') == 'KG' ? 'selected' : '' }}>KG</option>
                        <option value="Meter" {{ old('unit') == 'Meter' ? 'selected' : '' }}>Meter</option>
                        <option value="Yard" {{ old('unit') == 'Yard' ? 'selected' : '' }}>Yard</option>
                    </select>
                    @error('unit')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6">
                    <label for="status" class="form-label fw-semibold fs-7 text-dark">Status <span class="text-danger">*</span></label>
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
                <a href="{{ route('fabrics.index') }}" class="btn-ent-outline">Cancel</a>
                <button type="submit" class="btn-ent-primary">
                    <i class="bi bi-check-lg"></i> Save Fabric SKU
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
