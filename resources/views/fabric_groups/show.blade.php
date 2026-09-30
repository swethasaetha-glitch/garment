@extends('layouts.app')

@section('title', 'Fabric Group Details')

@section('content')
<div class="top-page-header mb-4">
    <div class="d-flex justify-content-between align-items-center">
        <div>
            <a href="{{ route('fabric-groups.index') }}" class="text-decoration-none text-muted small fw-semibold">
                <i class="bi bi-arrow-left"></i> BACK TO FABRIC GROUPS
            </a>
            <div class="d-flex align-items-center gap-2 mt-1">
                <h1 class="top-page-header-title mb-0">{{ $fabricGroup->group_name }}</h1>
                <span class="badge-ent badge-ent-slate font-mono-num">{{ $fabricGroup->group_code }}</span>
                @if($fabricGroup->status === 'Active')
                    <span class="badge-ent badge-ent-emerald">Active</span>
                @else
                    <span class="badge-ent badge-ent-rose">Inactive</span>
                @endif
            </div>
            <p class="top-page-header-subtitle mt-1">{{ $fabricGroup->description ?: 'No description specified for this fabric group.' }}</p>
        </div>
        <div>
            <a href="{{ route('fabric-groups.edit', $fabricGroup) }}" class="btn-ent-primary">
                <i class="bi bi-pencil"></i> Edit Group
            </a>
        </div>
    </div>
</div>

<div class="row g-4">
    <!-- Assigned Fabrics Table -->
    <div class="col-lg-8">
        <div class="card-ent">
            <div class="card-header bg-white py-3 border-bottom d-flex justify-content-between align-items-center">
                <h6 class="fw-bold mb-0 text-dark"><i class="bi bi-layers text-primary me-2"></i> Fabrics in this Group</h6>
                <span class="badge-ent badge-ent-blue font-mono-num">{{ $fabricGroup->fabrics->count() }} Fabrics</span>
            </div>
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light">
                        <tr class="text-muted fs-7 text-uppercase">
                            <th class="ps-3">Code</th>
                            <th>Fabric Name</th>
                            <th>GSM</th>
                            <th>Width</th>
                            <th>Status</th>
                            <th class="text-end pe-3">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($fabricGroup->fabrics as $fabric)
                            <tr>
                                <td class="ps-3 font-mono-num fw-bold text-dark">{{ $fabric->fabric_code }}</td>
                                <td>{{ $fabric->fabric_name }}</td>
                                <td class="font-mono-num">{{ $fabric->gsm ?: '-' }}</td>
                                <td class="font-mono-num">{{ $fabric->width ?: '-' }}</td>
                                <td>
                                    @if($fabric->status === 'Active')
                                        <span class="badge-ent badge-ent-emerald">Active</span>
                                    @else
                                        <span class="badge-ent badge-ent-rose">Inactive</span>
                                    @endif
                                </td>
                                <td class="text-end pe-3">
                                    <form action="{{ route('fabric-groups.remove-fabric', [$fabricGroup, $fabric]) }}" method="POST" class="d-inline" onsubmit="return confirm('Remove {{ $fabric->fabric_code }} from this group?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn-ent-outline text-danger btn-sm py-1 px-2 fs-7" title="Remove from Group">
                                            <i class="bi bi-x-circle me-1"></i> Remove
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-4 text-muted">
                                    No fabrics connected to this group yet.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Quick Add Fabrics Form -->
    <div class="col-lg-4">
        <div class="card-ent">
            <div class="card-header bg-white py-3 border-bottom">
                <h6 class="fw-bold mb-0 text-dark"><i class="bi bi-plus-circle text-primary me-2"></i> Add Fabrics to Group</h6>
            </div>
            <div class="card-ent-body">
                <form action="{{ route('fabric-groups.add-fabrics', $fabricGroup) }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label fw-semibold fs-7 text-dark">Available Fabrics</label>
                        <select name="fabrics[]" class="form-select-ent w-100" multiple style="height: 180px;">
                            @forelse($allFabrics as $avail)
                                <option value="{{ $avail->id }}">
                                    {{ $avail->fabric_code }} - {{ $avail->fabric_name }} ({{ $avail->gsm }} GSM)
                                </option>
                            @empty
                                <option disabled>No fabrics available</option>
                            @endforelse
                        </select>
                        <span class="text-muted fs-7 mt-1 d-block">Hold Ctrl/Cmd to select multiple fabrics.</span>
                    </div>
                    <button type="submit" class="btn-ent-primary w-100 justify-content-center" {{ $allFabrics->isEmpty() ? 'disabled' : '' }}>
                        <i class="bi bi-plus-lg"></i> Add Selected Fabrics
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
