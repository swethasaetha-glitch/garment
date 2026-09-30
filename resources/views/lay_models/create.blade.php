@extends('layouts.app')

@section('title', 'Create Lay Model')

@section('content')
<div class="top-page-header mb-4">
    <div class="d-flex justify-content-between align-items-center">
        <div>
            <a href="{{ route('lay-models.index') }}" class="text-decoration-none text-muted small fw-semibold">
                <i class="bi bi-arrow-left"></i> BACK TO LAY MODELS
            </a>
            <h1 class="top-page-header-title mt-1">Create Lay Model</h1>
            <p class="top-page-header-subtitle">Specify fabric group association, lay length/width, and marker parameters.</p>
        </div>
    </div>
</div>

<div class="card-ent">
    <div class="card-ent-body">
        <form action="{{ route('lay-models.store') }}" method="POST">
            @csrf
            <div class="row g-3">
                <div class="col-md-6">
                    <label for="lay_model_code" class="form-label fw-semibold fs-7 text-dark">Lay Model Code <span class="text-danger">*</span></label>
                    <input type="text" name="lay_model_code" id="lay_model_code" class="form-control-ent w-100 font-mono-num @error('lay_model_code') is-invalid @enderror" value="{{ old('lay_model_code') }}" required placeholder="e.g. LM-TSHIRT-001">
                    @error('lay_model_code')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6">
                    <label for="lay_model_name" class="form-label fw-semibold fs-7 text-dark">Lay Model Name <span class="text-danger">*</span></label>
                    <input type="text" name="lay_model_name" id="lay_model_name" class="form-control-ent w-100 @error('lay_model_name') is-invalid @enderror" value="{{ old('lay_model_name') }}" required placeholder="e.g. Men's Crew Neck T-Shirt Lay">
                    @error('lay_model_name')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6">
                    <label for="fabric_group_id" class="form-label fw-semibold fs-7 text-dark">Fabric Group <span class="text-danger">*</span></label>
                    <select name="fabric_group_id" id="fabric_group_id" class="form-select-ent w-100 @error('fabric_group_id') is-invalid @enderror" required>
                        <option value="">-- Select Fabric Group --</option>
                        @foreach($fabricGroups as $group)
                            <option value="{{ $group->id }}" {{ old('fabric_group_id') == $group->id ? 'selected' : '' }}>
                                {{ $group->group_code }} - {{ $group->group_name }}
                            </option>
                        @endforeach
                    </select>
                    @error('fabric_group_id')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6">
                    <label for="fabric_id" class="form-label fw-semibold fs-7 text-dark">Fabric SKU <span class="text-danger">*</span></label>
                    <select name="fabric_id" id="fabric_id" class="form-select-ent w-100 @error('fabric_id') is-invalid @enderror" required>
                        <option value="">-- Select Fabric Group First --</option>
                    </select>
                    @error('fabric_id')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-4">
                    <label for="lay_length" class="form-label fw-semibold fs-7 text-dark">Lay Length (Meters) <span class="text-danger">*</span></label>
                    <input type="number" step="0.01" min="0" name="lay_length" id="lay_length" class="form-control-ent w-100 font-mono-num @error('lay_length') is-invalid @enderror" value="{{ old('lay_length') }}" required placeholder="e.g. 12.50">
                    @error('lay_length')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-4">
                    <label for="lay_width" class="form-label fw-semibold fs-7 text-dark">Lay Width (Inches) <span class="text-danger">*</span></label>
                    <input type="number" step="0.01" min="0" name="lay_width" id="lay_width" class="form-control-ent w-100 font-mono-num @error('lay_width') is-invalid @enderror" value="{{ old('lay_width') }}" required placeholder="e.g. 72">
                    @error('lay_width')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-4">
                    <label for="number_of_plies" class="form-label fw-semibold fs-7 text-dark">Number of Plies <span class="text-danger">*</span></label>
                    <input type="number" min="0" name="number_of_plies" id="number_of_plies" class="form-control-ent w-100 font-mono-num @error('number_of_plies') is-invalid @enderror" value="{{ old('number_of_plies') }}" required placeholder="e.g. 50">
                    @error('number_of_plies')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-4">
                    <label for="garment_size" class="form-label fw-semibold fs-7 text-dark">Garment Size Ratio</label>
                    <input type="text" name="garment_size" id="garment_size" class="form-control-ent w-100 font-mono-num @error('garment_size') is-invalid @enderror" value="{{ old('garment_size') }}" placeholder="e.g. S-1, M-2, L-2, XL-1">
                    @error('garment_size')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-4">
                    <label for="marker_length" class="form-label fw-semibold fs-7 text-dark">Marker Length (Meters)</label>
                    <input type="number" step="0.01" min="0" name="marker_length" id="marker_length" class="form-control-ent w-100 font-mono-num @error('marker_length') is-invalid @enderror" value="{{ old('marker_length') }}" placeholder="e.g. 11.80">
                    @error('marker_length')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-4">
                    <label for="marker_width" class="form-label fw-semibold fs-7 text-dark">Marker Width (Inches)</label>
                    <input type="number" step="0.01" min="0" name="marker_width" id="marker_width" class="form-control-ent w-100 font-mono-num @error('marker_width') is-invalid @enderror" value="{{ old('marker_width') }}" placeholder="e.g. 68">
                    @error('marker_width')
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

                <div class="col-12">
                    <label for="description" class="form-label fw-semibold fs-7 text-dark">Laying Instructions & Remarks</label>
                    <textarea name="description" id="description" rows="2" class="form-control-ent w-100 @error('description') is-invalid @enderror" placeholder="Laying sequence and cutting notes...">{{ old('description') }}</textarea>
                    @error('description')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="mt-4 pt-3 border-top d-flex justify-content-end gap-2">
                <a href="{{ route('lay-models.index') }}" class="btn-ent-outline">Cancel</a>
                <button type="submit" class="btn-ent-primary">
                    <i class="bi bi-check-lg"></i> Save Lay Model
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const groupsData = @json($fabricGroups);
        const groupSelect = document.getElementById('fabric_group_id');
        const fabricSelect = document.getElementById('fabric_id');
        const selectedFabricId = @json(old('fabric_id'));

        function updateFabricOptions(groupId, selectedId = null) {
            fabricSelect.innerHTML = '<option value="">-- Select Fabric SKU --</option>';

            if (!groupId) {
                fabricSelect.innerHTML = '<option value="">-- Select Fabric Group First --</option>';
                return;
            }

            const group = groupsData.find(g => g.id == groupId);
            if (group && group.fabrics && group.fabrics.length > 0) {
                group.fabrics.forEach(fabric => {
                    const option = document.createElement('option');
                    option.value = fabric.id;
                    option.textContent = `${fabric.fabric_code} - ${fabric.fabric_name}`;
                    if (selectedId && fabric.id == selectedId) {
                        option.selected = true;
                    }
                    fabricSelect.appendChild(option);
                });
            } else {
                fabricSelect.innerHTML = '<option value="">-- No fabrics found in this group --</option>';
            }
        }

        groupSelect.addEventListener('change', function () {
            updateFabricOptions(this.value);
        });

        if (groupSelect.value) {
            updateFabricOptions(groupSelect.value, selectedFabricId);
        }
    });
</script>
@endpush
