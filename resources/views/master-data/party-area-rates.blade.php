@extends('layouts.app')

@section('title', 'Party/Area Rates')
@section('page-title', 'Party or Area-wise Rate Management')

@section('content')
<div class="page-header">
    <div class="d-flex justify-content-between align-items-center flex-wrap">
        <div>
            <h1 class="page-title">Party or Area-wise Rate</h1>
            <p class="page-subtitle">Manage party and area-specific freight rates</p>
        </div>
        <div class="d-flex flex-wrap gap-2 mt-2 mt-md-0">
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addPartyAreaRateModal">
                Add Party/Area Rate
            </button>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <form method="GET" class="row g-2">
            <div class="col-md-2">
                <input type="text" class="form-control" name="search" value="{{ request('search') }}" placeholder="Search...">
            </div>
            <div class="col-md-2">
                <select class="form-select" name="party_type">
                    <option value="">All Types</option>
                    <option value="Customer" {{ request('party_type') === 'Customer' ? 'selected' : '' }}>Customer</option>
                    <option value="Vendor" {{ request('party_type') === 'Vendor' ? 'selected' : '' }}>Vendor</option>
                    <option value="Area" {{ request('party_type') === 'Area' ? 'selected' : '' }}>Area</option>
                </select>
            </div>
            <div class="col-md-2">
                <select class="form-select" name="from_city">
                    <option value="">From City</option>
                    @foreach($cities as $city)
                    <option value="{{ $city->name }}" {{ request('from_city') == $city->name ? 'selected' : '' }}>{{ $city->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2">
                <select class="form-select" name="to_city">
                    <option value="">To City</option>
                    @foreach($cities as $city)
                    <option value="{{ $city->name }}" {{ request('to_city') == $city->name ? 'selected' : '' }}>{{ $city->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-1">
                <select class="form-select" name="status">
                    <option value="">All</option>
                    <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>Active</option>
                    <option value="inactive" {{ request('status') === 'inactive' ? 'selected' : '' }}>Inactive</option>
                </select>
            </div>
            <div class="col-md-1">
                <button type="submit" class="btn btn-primary w-100">Filter</button>
            </div>
            <div class="col-md-1">
                <a href="{{ route('master-data.party-area-rates') }}" class="btn btn-secondary w-100">Reset</a>
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
                        <th>Party Type</th>
                        <th>Party Name</th>
                        <th>From City</th>
                        <th>To City</th>
                        <th>Rate/KG</th>
                        <th>Rate/Piece</th>
                        <th>Min Charge</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($partyAreaRates as $rate)
                    <tr>
                        <td><span class="badge bg-info">{{ $rate->party_type ?? 'Area' }}</span></td>
                        <td>{{ $rate->party_name }}</td>
                        <td>{{ $rate->from_city ?? '-' }}</td>
                        <td>{{ $rate->to_city ?? '-' }}</td>
                        <td>{{ $rate->rate_per_kg ? number_format($rate->rate_per_kg, 2) : '-' }}</td>
                        <td>{{ $rate->rate_per_piece ? number_format($rate->rate_per_piece, 2) : '-' }}</td>
                        <td>{{ $rate->minimum_charge ? number_format($rate->minimum_charge, 2) : '-' }}</td>
                        <td>
                            <span class="badge bg-{{ $rate->is_active ? 'success' : 'secondary' }}">
                                {{ $rate->is_active ? 'Active' : 'Inactive' }}
                            </span>
                        </td>
                        <td>
                            <button type="button" class="btn btn-sm btn-info" onclick="editPartyAreaRate({{ $rate->id }})">Edit</button>
                            <form action="{{ route('master-data.party-area-rates.delete', $rate->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="9" class="text-center text-muted">No party/area rates found.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-3">
            {{ $partyAreaRates->links() }}
        </div>
    </div>
</div>

<!-- Add/Edit Modal -->
<div class="modal fade" id="addPartyAreaRateModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form id="partyAreaRateForm" method="POST">
                @csrf
                <div id="formMethod"></div>
                <div class="modal-header">
                    <h5 class="modal-title" id="modalTitle">Add Party/Area Rate</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Party Type</label>
                            <select class="form-select" name="party_type" id="party_type">
                                <option value="">Select Type</option>
                                <option value="Customer">Customer</option>
                                <option value="Vendor">Vendor</option>
                                <option value="Area">Area</option>
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Party Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="party_name" id="party_name" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label class="form-label">From City</label>
                            <select class="form-select" name="from_city" id="from_city">
                                <option value="">Select City</option>
                                @foreach($cities as $city)
                                <option value="{{ $city->name }}">{{ $city->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">To City</label>
                            <select class="form-select" name="to_city" id="to_city">
                                <option value="">Select City</option>
                                @foreach($cities as $city)
                                <option value="{{ $city->name }}">{{ $city->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Vehicle Type</label>
                            <input type="text" class="form-control" name="vehicle_type" id="vehicle_type">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Rate per KG</label>
                            <input type="number" step="0.01" class="form-control" name="rate_per_kg" id="rate_per_kg" value="0">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Rate per Piece</label>
                            <input type="number" step="0.01" class="form-control" name="rate_per_piece" id="rate_per_piece" value="0">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Minimum Charge</label>
                            <input type="number" step="0.01" class="form-control" name="minimum_charge" id="minimum_charge" value="0">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Effective From</label>
                            <input type="date" class="form-control" name="effective_from" id="effective_from">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Effective To</label>
                            <input type="date" class="form-control" name="effective_to" id="effective_to">
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Area Name (if Area type)</label>
                        <input type="text" class="form-control" name="area_name" id="area_name">
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
let partyAreaRatesData = @json($partyAreaRates->items());

function editPartyAreaRate(id) {
    const rate = partyAreaRatesData.find(r => r.id === id);
    if (!rate) return;

    document.getElementById('modalTitle').textContent = 'Edit Party/Area Rate';
    document.getElementById('partyAreaRateForm').action = '{{ route("master-data.party-area-rates.update", ":id") }}'.replace(':id', id);
    document.getElementById('formMethod').innerHTML = '<input type="hidden" name="_method" value="PUT">';
    
    document.getElementById('party_type').value = rate.party_type || '';
    document.getElementById('party_name').value = rate.party_name;
    document.getElementById('from_city').value = rate.from_city || '';
    document.getElementById('to_city').value = rate.to_city || '';
    document.getElementById('vehicle_type').value = rate.vehicle_type || '';
    document.getElementById('rate_per_kg').value = rate.rate_per_kg || 0;
    document.getElementById('rate_per_piece').value = rate.rate_per_piece || 0;
    document.getElementById('minimum_charge').value = rate.minimum_charge || 0;
    document.getElementById('effective_from').value = rate.effective_from || '';
    document.getElementById('effective_to').value = rate.effective_to || '';
    document.getElementById('area_name').value = rate.area_name || '';
    document.getElementById('is_active').checked = rate.is_active;

    new bootstrap.Modal(document.getElementById('addPartyAreaRateModal')).show();
}

document.getElementById('addPartyAreaRateModal').addEventListener('hidden.bs.modal', function() {
    document.getElementById('partyAreaRateForm').reset();
    document.getElementById('partyAreaRateForm').action = '{{ route("master-data.party-area-rates.store") }}';
    document.getElementById('modalTitle').textContent = 'Add Party/Area Rate';
    document.getElementById('formMethod').innerHTML = '';
});
</script>
@endsection

