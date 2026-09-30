@extends('layouts.app')

@section('title', 'Lay Models')
@section('page_header_title', 'Lay Models Master')
@section('page_header_subtitle', 'Configure Fabric Laying Dimensions, Plies & Pattern Model Specifications')

@section('top_header_action')
<a href="{{ route('lay-models.create') }}" class="btn-ent-primary">
    <i class="bi bi-plus-lg"></i> Create Lay Model
</a>
@endsection

@section('content')
<!-- Search Toolbar -->
<div class="card-ent mb-4">
    <div class="card-ent-body p-3">
        <form method="GET" action="{{ route('lay-models.index') }}">
            <div class="row g-2 align-items-center">
                <div class="col-lg-6">
                    <div class="position-relative">
                        <i class="bi bi-search position-absolute top-50 start-0 translate-middle-y ms-3 text-slate-400"></i>
                        <input type="text" name="search" class="form-control form-control-ent ps-5" placeholder="Search code, name, garment size, fabric..." value="{{ request('search') }}">
                    </div>
                </div>
                <div class="col-lg-6 d-flex gap-2">
                    <button type="submit" class="btn-ent-primary">
                        <i class="bi bi-funnel"></i> Search & Filter
                    </button>
                    @if(request('search'))
                        <a href="{{ route('lay-models.index') }}" class="btn-ent-outline text-decoration-none">
                            Clear Filters
                        </a>
                    @endif
                </div>
            </div>
        </form>
    </div>
</div>

<!-- High Precision Enterprise Table -->
<div class="card-ent">
    <div class="card-ent-body p-3">
        <div class="d-flex justify-content-between align-items-center mb-3 pb-2 border-bottom">
            <div>
                <h5 class="fw-bold text-slate-900 mb-0 fs-6">Lay Model Catalog</h5>
                <p class="text-slate-500 mb-0 small" style="font-size:0.75rem;">Registered lay models, pile allocations, and cutting table specs</p>
            </div>
            <span class="badge-ent badge-ent-slate">{{ $layModels->total() }} Model(s)</span>
        </div>

        <div class="table-responsive">
            <table class="table table-hover align-middle text-xs mb-0">
                <thead>
                    <tr class="text-slate-500 border-bottom">
                        <th class="fw-bold font-mono">CODE</th>
                        <th class="fw-bold">LAY MODEL NAME</th>
                        <th class="fw-bold">FABRIC GROUP</th>
                        <th class="fw-bold">FABRIC</th>
                        <th class="fw-bold">PLIES</th>
                        <th class="fw-bold">LAY DIMENSIONS</th>
                        <th class="fw-bold">GARMENT SIZE</th>
                        <th class="fw-bold">STATUS</th>
                        <th class="text-end fw-bold">ACTIONS</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($layModels as $layModel)
                    <tr>
                        <td class="fw-bold text-primary font-mono fs-6">{{ $layModel->lay_model_code }}</td>
                        <td class="fw-bold text-slate-900">{{ $layModel->lay_model_name }}</td>
                        <td>
                            <span class="badge-ent badge-ent-slate">
                                {{ $layModel->fabricGroup ? $layModel->fabricGroup->group_name : '-' }}
                            </span>
                        </td>
                        <td>
                            <div class="fw-bold text-slate-900 font-mono">{{ $layModel->fabric ? $layModel->fabric->fabric_code : '-' }}</div>
                            <div class="text-slate-500" style="font-size:0.7rem;">{{ $layModel->fabric ? $layModel->fabric->fabric_name : '' }}</div>
                        </td>
                        <td><span class="badge-ent badge-ent-blue font-mono">{{ $layModel->number_of_plies }} plies</span></td>
                        <td class="font-mono-num text-slate-700">{{ $layModel->lay_length }} &times; {{ $layModel->lay_width }}</td>
                        <td class="font-mono text-slate-800">{{ $layModel->garment_size ?: '-' }}</td>
                        <td>
                            @if($layModel->status === 'Active')
                                <span class="badge-ent badge-ent-emerald">Active</span>
                            @else
                                <span class="badge-ent badge-ent-rose">Inactive</span>
                            @endif
                        </td>
                        <td class="text-end">
                            <div class="btn-group btn-group-sm">
                                <a href="{{ route('lay-models.show', $layModel) }}" class="btn btn-sm btn-outline-secondary py-0.5 px-2" title="View Details">
                                    <i class="bi bi-eye"></i>
                                </a>
                                <a href="{{ route('lay-models.edit', $layModel) }}" class="btn btn-sm btn-outline-secondary py-0.5 px-2" title="Edit">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <form action="{{ route('lay-models.destroy', $layModel) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete Lay Model {{ $layModel->lay_model_code }}?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger py-0.5 px-2" title="Delete">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="9" class="text-center py-4 text-slate-500">
                            No lay models found.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-3">
            {{ $layModels->links() }}
        </div>
    </div>
</div>
@endsection
