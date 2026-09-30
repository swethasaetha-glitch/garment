@extends('layouts.app')

@section('title', 'Fabrics')
@section('page_header_title', 'Fabric Master Catalog')
@section('page_header_subtitle', 'Stage 2: Digital Fabric Specification, GSM, Width & Material Store Catalog')

@section('top_header_action')
<a href="{{ route('fabrics.create') }}" class="btn-ent-primary">
    <i class="bi bi-plus-lg"></i> Add New Fabric
</a>
@endsection

@section('content')
<!-- Search Toolbar -->
<div class="card-ent mb-4">
    <div class="card-ent-body p-3">
        <form method="GET" action="{{ route('fabrics.index') }}">
            <div class="row g-2 align-items-center">
                <div class="col-lg-6">
                    <div class="position-relative">
                        <i class="bi bi-search position-absolute top-50 start-0 translate-middle-y ms-3 text-slate-400"></i>
                        <input type="text" name="search" class="form-control form-control-ent ps-5" placeholder="Search by fabric code, name, type, composition..." value="{{ request('search') }}">
                    </div>
                </div>
                <div class="col-lg-6 d-flex gap-2">
                    <button type="submit" class="btn-ent-primary">
                        <i class="bi bi-funnel"></i> Search & Filter
                    </button>
                    @if(request('search'))
                        <a href="{{ route('fabrics.index') }}" class="btn-ent-outline text-decoration-none">
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
                <h5 class="fw-bold text-slate-900 mb-0 fs-6">Fabric Catalog List</h5>
                <p class="text-slate-500 mb-0 small" style="font-size:0.75rem;">Registered textile specifications and store inventory</p>
            </div>
            <span class="badge-ent badge-ent-slate">{{ $fabrics->total() }} Fabric(s)</span>
        </div>

        <div class="table-responsive">
            <table class="table table-hover align-middle text-xs mb-0">
                <thead>
                    <tr class="text-slate-500 border-bottom">
                        <th class="fw-bold font-mono">CODE</th>
                        <th class="fw-bold">FABRIC NAME</th>
                        <th class="fw-bold">TYPE</th>
                        <th class="fw-bold">COMPOSITION</th>
                        <th class="fw-bold">GSM</th>
                        <th class="fw-bold">WIDTH</th>
                        <th class="fw-bold">STATUS</th>
                        <th class="text-end fw-bold">ACTIONS</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($fabrics as $fabric)
                    <tr>
                        <td class="fw-bold text-primary font-mono fs-6">{{ $fabric->fabric_code }}</td>
                        <td class="fw-bold text-slate-900">{{ $fabric->fabric_name }}</td>
                        <td><span class="badge-ent badge-ent-slate">{{ $fabric->fabric_type }}</span></td>
                        <td class="text-slate-700">{{ $fabric->composition ?: '-' }}</td>
                        <td class="font-mono-num fw-semibold text-slate-900">{{ $fabric->gsm ?: '-' }}</td>
                        <td class="font-mono-num text-slate-700">{{ $fabric->width ? $fabric->width . ' ' . ($fabric->unit ?: '') : '-' }}</td>
                        <td>
                            @if($fabric->status === 'Active')
                                <span class="badge-ent badge-ent-emerald">Active</span>
                            @else
                                <span class="badge-ent badge-ent-rose">Inactive</span>
                            @endif
                        </td>
                        <td class="text-end">
                            <div class="btn-group btn-group-sm">
                                <a href="{{ route('fabrics.show', $fabric) }}" class="btn btn-sm btn-outline-secondary py-0.5 px-2" title="View">
                                    <i class="bi bi-eye"></i>
                                </a>
                                <a href="{{ route('fabrics.edit', $fabric) }}" class="btn btn-sm btn-outline-secondary py-0.5 px-2" title="Edit">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <form action="{{ route('fabrics.destroy', $fabric) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete fabric {{ $fabric->fabric_code }}?');">
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
                        <td colspan="8" class="text-center py-4 text-slate-500">
                            No fabrics found in catalog.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-3">
            {{ $fabrics->links() }}
        </div>
    </div>
</div>
@endsection
