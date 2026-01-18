@extends('layouts.app')

@section('title', 'Container Sizes')
@section('page-title', 'Container Sizes Management')

@section('content')
<div class="page-header">
    <div class="d-flex justify-content-between align-items-center flex-wrap">
        <div>
            <h1 class="page-title">Container Sizes</h1>
            <p class="page-subtitle">Manage container sizes and specifications</p>
        </div>
        <div class="d-flex flex-wrap gap-2 mt-2 mt-md-0">
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addContainerSizeModal">
                Add Container Size
            </button>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <form method="GET" class="row g-2">
            <div class="col-md-4">
                <input type="text" class="form-control" name="search" value="{{ request('search') }}" placeholder="Search by code, name...">
            </div>
            <div class="col-md-2">
                <select class="form-select" name="status">
                    <option value="">All Status</option>
                    <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>Active</option>
                    <option value="inactive" {{ request('status') === 'inactive' ? 'selected' : '' }}>Inactive</option>
                </select>
            </div>
            <div class="col-md-2">
                <button type="submit" class="btn btn-primary w-100">Filter</button>
            </div>
            <div class="col-md-2">
                <a href="{{ route('master-data.container-sizes') }}" class="btn btn-secondary w-100">Reset</a>
            </div>
        </form>
    </div>
    <div class="card-body">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <div class="table-responsive">
            <table class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th>Size Code</th>
                        <th>Size Name</th>
                        <th>Dimensions (L×W×H)</th>
                        <th>Max Weight</th>
                        <th>Max Volume</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($containerSizes as $size)
                    <tr>
                        <td><strong>{{ $size->size_code }}</strong></td>
                        <td>{{ $size->size_name }}</td>
                        <td>
                            @if($size->length && $size->width && $size->height)
                                {{ $size->length }}×{{ $size->width }}×{{ $size->height }}
                            @else
                                -
                            @endif
                        </td>
                        <td>{{ $size->max_weight ? number_format($size->max_weight, 2) . ' kg' : '-' }}</td>
                        <td>{{ $size->max_volume ? number_format($size->max_volume, 2) . ' m³' : '-' }}</td>
                        <td>
                            <span class="badge bg-{{ $size->is_active ? 'success' : 'secondary' }}">
                                {{ $size->is_active ? 'Active' : 'Inactive' }}
                            </span>
                        </td>
                        <td>
                            <button type="button" class="btn btn-sm btn-info" onclick="editContainerSize({{ $size->id }})">Edit</button>
                            <form action="{{ route('master-data.container-sizes.delete', $size->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center text-muted">No container sizes found.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-3">
            {{ $containerSizes->links() }}
        </div>
    </div>
</div>

<!-- Add/Edit Modal -->
<div class="modal fade" id="addContainerSizeModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form id="containerSizeForm" method="POST">
                @csrf
                <div id="formMethod"></div>
                <div class="modal-header">
                    <h5 class="modal-title" id="modalTitle">Add Container Size</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Size Code <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="size_code" id="size_code" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Size Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="size_name" id="size_name" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Length (m)</label>
                            <input type="number" step="0.01" class="form-control" name="length" id="length">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Width (m)</label>
                            <input type="number" step="0.01" class="form-control" name="width" id="width">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Height (m)</label>
                            <input type="number" step="0.01" class="form-control" name="height" id="height">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Max Weight (kg)</label>
                            <input type="number" step="0.01" class="form-control" name="max_weight" id="max_weight">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Max Volume (m³)</label>
                            <input type="number" step="0.01" class="form-control" name="max_volume" id="max_volume">
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Description</label>
                        <textarea class="form-control" name="description" id="description" rows="2"></textarea>
                    </div>
                    <div class="mb-3">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="is_active" id="is_active" value="1" checked>
                            <label class="form-check-label" for="is_active">Active</label>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
let containerSizesData = @json($containerSizes->items());

function editContainerSize(id) {
    const size = containerSizesData.find(s => s.id === id);
    if (!size) return;

    document.getElementById('modalTitle').textContent = 'Edit Container Size';
    document.getElementById('containerSizeForm').action = '{{ route("master-data.container-sizes.update", ":id") }}'.replace(':id', id);
    document.getElementById('formMethod').innerHTML = '<input type="hidden" name="_method" value="PUT">';
    
    document.getElementById('size_code').value = size.size_code;
    document.getElementById('size_name').value = size.size_name;
    document.getElementById('length').value = size.length || '';
    document.getElementById('width').value = size.width || '';
    document.getElementById('height').value = size.height || '';
    document.getElementById('max_weight').value = size.max_weight || '';
    document.getElementById('max_volume').value = size.max_volume || '';
    document.getElementById('description').value = size.description || '';
    document.getElementById('is_active').checked = size.is_active;

    new bootstrap.Modal(document.getElementById('addContainerSizeModal')).show();
}

document.getElementById('addContainerSizeModal').addEventListener('hidden.bs.modal', function() {
    document.getElementById('containerSizeForm').reset();
    document.getElementById('containerSizeForm').action = '{{ route("master-data.container-sizes.store") }}';
    document.getElementById('modalTitle').textContent = 'Add Container Size';
    document.getElementById('formMethod').innerHTML = '';
});
</script>
@endsection

