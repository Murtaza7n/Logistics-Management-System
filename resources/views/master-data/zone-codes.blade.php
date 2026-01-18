@extends('layouts.app')

@section('title', 'Zone Codes')
@section('page-title', 'Zone Codes Management')

@section('content')
<div class="page-header">
    <div class="d-flex justify-content-between align-items-center flex-wrap">
        <div>
            <h1 class="page-title">Zone Codes</h1>
            <p class="page-subtitle">Manage zone codes and base rates</p>
        </div>
        <div class="d-flex flex-wrap gap-2 mt-2 mt-md-0">
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addZoneCodeModal">
                Add Zone Code
            </button>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <form method="GET" class="row g-2">
            <div class="col-md-3">
                <input type="text" class="form-control" name="search" value="{{ request('search') }}" placeholder="Search...">
            </div>
            <div class="col-md-2">
                <select class="form-select" name="city">
                    <option value="">All Cities</option>
                    @foreach($cities as $city)
                    <option value="{{ $city->name }}" {{ request('city') == $city->name ? 'selected' : '' }}>{{ $city->name }}</option>
                    @endforeach
                </select>
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
                <a href="{{ route('master-data.zone-codes') }}" class="btn btn-secondary w-100">Reset</a>
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
                        <th>Zone Code</th>
                        <th>Zone Name</th>
                        <th>City</th>
                        <th>State</th>
                        <th>Base Rate</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($zoneCodes as $zone)
                    <tr>
                        <td><strong>{{ $zone->zone_code }}</strong></td>
                        <td>{{ $zone->zone_name }}</td>
                        <td>{{ $zone->city ?? '-' }}</td>
                        <td>{{ $zone->state ?? '-' }}</td>
                        <td>{{ $zone->base_rate ? number_format($zone->base_rate, 2) : '-' }}</td>
                        <td>
                            <span class="badge bg-{{ $zone->is_active ? 'success' : 'secondary' }}">
                                {{ $zone->is_active ? 'Active' : 'Inactive' }}
                            </span>
                        </td>
                        <td>
                            <button type="button" class="btn btn-sm btn-info" onclick="editZoneCode({{ $zone->id }})">Edit</button>
                            <form action="{{ route('master-data.zone-codes.delete', $zone->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center text-muted">No zone codes found.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-3">
            {{ $zoneCodes->links() }}
        </div>
    </div>
</div>

<!-- Add/Edit Modal -->
<div class="modal fade" id="addZoneCodeModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form id="zoneCodeForm" method="POST">
                @csrf
                <div id="formMethod"></div>
                <div class="modal-header">
                    <h5 class="modal-title" id="modalTitle">Add Zone Code</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Zone Code <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="zone_code" id="zone_code" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Zone Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="zone_name" id="zone_name" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">City</label>
                            <select class="form-select" name="city" id="city">
                                <option value="">Select City</option>
                                @foreach($cities as $city)
                                <option value="{{ $city->name }}">{{ $city->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">State</label>
                            <input type="text" class="form-control" name="state" id="state">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Base Rate</label>
                            <input type="number" step="0.01" class="form-control" name="base_rate" id="base_rate" value="0">
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
let zoneCodesData = @json($zoneCodes->items());

function editZoneCode(id) {
    const zone = zoneCodesData.find(z => z.id === id);
    if (!zone) return;

    document.getElementById('modalTitle').textContent = 'Edit Zone Code';
    document.getElementById('zoneCodeForm').action = '{{ route("master-data.zone-codes.update", ":id") }}'.replace(':id', id);
    document.getElementById('formMethod').innerHTML = '<input type="hidden" name="_method" value="PUT">';
    
    document.getElementById('zone_code').value = zone.zone_code;
    document.getElementById('zone_name').value = zone.zone_name;
    document.getElementById('city').value = zone.city || '';
    document.getElementById('state').value = zone.state || '';
    document.getElementById('base_rate').value = zone.base_rate || 0;
    document.getElementById('description').value = zone.description || '';
    document.getElementById('is_active').checked = zone.is_active;

    new bootstrap.Modal(document.getElementById('addZoneCodeModal')).show();
}

document.getElementById('addZoneCodeModal').addEventListener('hidden.bs.modal', function() {
    document.getElementById('zoneCodeForm').reset();
    document.getElementById('zoneCodeForm').action = '{{ route("master-data.zone-codes.store") }}';
    document.getElementById('modalTitle').textContent = 'Add Zone Code';
    document.getElementById('formMethod').innerHTML = '';
});
</script>
@endsection

