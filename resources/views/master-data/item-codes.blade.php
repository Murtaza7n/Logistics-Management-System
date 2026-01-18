@extends('layouts.app')

@section('title', 'Item Codes')
@section('page-title', 'Item Codes Management')

@section('content')
<div class="page-header">
    <div class="d-flex justify-content-between align-items-center flex-wrap">
        <div>
            <h1 class="page-title">Item Codes</h1>
            <p class="page-subtitle">Manage item codes and catalog</p>
        </div>
        <div class="d-flex flex-wrap gap-2 mt-2 mt-md-0">
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addItemCodeModal">
                Add Item Code
            </button>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <form method="GET" class="row g-2">
            <div class="col-md-4">
                <input type="text" class="form-control" name="search" value="{{ request('search') }}" placeholder="Search by code, name, category...">
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
                <a href="{{ route('master-data.item-codes') }}" class="btn btn-secondary w-100">Reset</a>
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
                        <th>Item Code</th>
                        <th>Item Name</th>
                        <th>Category</th>
                        <th>Unit Price</th>
                        <th>Unit</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($itemCodes as $item)
                    <tr>
                        <td><strong>{{ $item->item_code }}</strong></td>
                        <td>{{ $item->item_name }}</td>
                        <td>{{ $item->category ?? '-' }}</td>
                        <td>{{ number_format($item->unit_price, 2) }}</td>
                        <td>{{ $item->unit ?? '-' }}</td>
                        <td>
                            <span class="badge bg-{{ $item->is_active ? 'success' : 'secondary' }}">
                                {{ $item->is_active ? 'Active' : 'Inactive' }}
                            </span>
                        </td>
                        <td>
                            <button type="button" class="btn btn-sm btn-info" onclick="editItemCode({{ $item->id }})">Edit</button>
                            <form action="{{ route('master-data.item-codes.delete', $item->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center text-muted">No item codes found.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-3">
            {{ $itemCodes->links() }}
        </div>
    </div>
</div>

<!-- Add/Edit Modal -->
<div class="modal fade" id="addItemCodeModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="itemCodeForm" method="POST">
                @csrf
                <div id="formMethod"></div>
                <div class="modal-header">
                    <h5 class="modal-title" id="modalTitle">Add Item Code</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Item Code <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="item_code" id="item_code" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Item Name <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="item_name" id="item_name" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Category</label>
                        <input type="text" class="form-control" name="category" id="category">
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Unit Price</label>
                            <input type="number" step="0.01" class="form-control" name="unit_price" id="unit_price" value="0">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Unit</label>
                            <input type="text" class="form-control" name="unit" id="unit" placeholder="kg, piece, box, etc.">
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
let itemCodesData = @json($itemCodes->items());

function editItemCode(id) {
    const item = itemCodesData.find(i => i.id === id);
    if (!item) return;

    document.getElementById('modalTitle').textContent = 'Edit Item Code';
    document.getElementById('itemCodeForm').action = '{{ route("master-data.item-codes.update", ":id") }}'.replace(':id', id);
    document.getElementById('formMethod').innerHTML = '<input type="hidden" name="_method" value="PUT">';
    
    document.getElementById('item_code').value = item.item_code;
    document.getElementById('item_name').value = item.item_name;
    document.getElementById('category').value = item.category || '';
    document.getElementById('unit_price').value = item.unit_price;
    document.getElementById('unit').value = item.unit || '';
    document.getElementById('description').value = item.description || '';
    document.getElementById('is_active').checked = item.is_active;

    new bootstrap.Modal(document.getElementById('addItemCodeModal')).show();
}

document.getElementById('addItemCodeModal').addEventListener('hidden.bs.modal', function() {
    document.getElementById('itemCodeForm').reset();
    document.getElementById('itemCodeForm').action = '{{ route("master-data.item-codes.store") }}';
    document.getElementById('modalTitle').textContent = 'Add Item Code';
    document.getElementById('formMethod').innerHTML = '';
});
</script>
@endsection

