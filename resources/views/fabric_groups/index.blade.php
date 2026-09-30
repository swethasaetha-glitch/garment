@extends('layouts.app')

@section('title', 'Fabric Groups')
@section('page_header_title', 'Fabric Groups')
@section('page_header_subtitle', 'Group Fabric Categories for Optimized Cut Room Planning & Shading')

@section('top_header_action')
<a href="{{ route('fabric-groups.create') }}" class="btn-ent-primary">
    <i class="bi bi-plus-lg"></i> Create Fabric Group
</a>
@endsection

@section('content')
<!-- Search Toolbar -->
<div class="card-ent mb-4">
    <div class="card-ent-body p-3">
        <form method="GET" action="{{ route('fabric-groups.index') }}">
            <div class="row g-2 align-items-center">
                <div class="col-lg-6">
                    <div class="position-relative">
                        <i class="bi bi-search position-absolute top-50 start-0 translate-middle-y ms-3 text-slate-400"></i>
                        <input type="text" name="search" class="form-control form-control-ent ps-5" placeholder="Search group code, name, description..." value="{{ request('search') }}">
                    </div>
                </div>
                <div class="col-lg-6 d-flex gap-2">
                    <button type="submit" class="btn-ent-primary">
                        <i class="bi bi-funnel"></i> Search & Filter
                    </button>
                    @if(request('search'))
                        <a href="{{ route('fabric-groups.index') }}" class="btn-ent-outline text-decoration-none">
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
                <h5 class="fw-bold text-slate-900 mb-0 fs-6">Fabric Group List</h5>
                <p class="text-slate-500 mb-0 small" style="font-size:0.75rem;">Textile category groupings for marker layouts</p>
            </div>
            <span class="badge-ent badge-ent-slate">{{ $fabricGroups->total() }} Group(s)</span>
        </div>

        <div class="table-responsive">
            <table class="table table-hover align-middle text-xs mb-0">
                <thead>
                    <tr class="text-slate-500 border-bottom">
                        <th class="fw-bold font-mono">GROUP CODE</th>
                        <th class="fw-bold">GROUP NAME</th>
                        <th class="fw-bold">DESCRIPTION</th>
                        <th class="fw-bold">ASSIGNED FABRICS</th>
                        <th class="fw-bold">STATUS</th>
                        <th class="text-end fw-bold">ACTIONS</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($fabricGroups as $group)
                    <tr>
                        <td class="fw-bold text-primary font-mono fs-6">{{ $group->group_code }}</td>
                        <td class="fw-bold text-slate-900">{{ $group->group_name }}</td>
                        <td class="text-slate-600">{{ Str::limit($group->description, 50) ?: '-' }}</td>
                        <td>
                            <span class="badge-ent badge-ent-blue font-mono">{{ $group->fabrics_count }} fabrics</span>
                        </td>
                        <td>
                            @if($group->status === 'Active')
                                <span class="badge-ent badge-ent-emerald">Active</span>
                            @else
                                <span class="badge-ent badge-ent-rose">Inactive</span>
                            @endif
                        </td>
                        <td class="text-end">
                            <div class="btn-group btn-group-sm">
                                <a href="{{ route('fabric-groups.show', $group) }}" class="btn btn-sm btn-outline-secondary py-0.5 px-2" title="View Details">
                                    <i class="bi bi-eye"></i>
                                </a>
                                <a href="{{ route('fabric-groups.edit', $group) }}" class="btn btn-sm btn-outline-secondary py-0.5 px-2" title="Edit">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <form action="{{ route('fabric-groups.destroy', $group) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete fabric group {{ $group->group_code }}?');">
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
                        <td colspan="6" class="text-center py-4 text-slate-500">
                            No fabric groups found.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-3">
            {{ $fabricGroups->links() }}
        </div>
    </div>
</div>
@endsection
