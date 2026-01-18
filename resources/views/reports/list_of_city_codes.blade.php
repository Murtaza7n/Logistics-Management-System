@extends('layouts.app')

@section('title', 'List of City Codes')
@section('page-title', 'List of City Codes')

@section('content')
<!-- Page Header -->
<div class="page-header">
    <h1 class="page-title">
        
        List of City Codes
    </h1>
    <p class="page-subtitle">Master list of all cities and their codes</p>
</div>

<!-- Success/Error Messages -->
@if(session('success'))
<div class="alert alert-success alert-dismissible fade show" role="alert">
    {{ session('success') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>
@endif

@if(session('error'))
<div class="alert alert-danger alert-dismissible fade show" role="alert">
    {{ session('error') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>
@endif

<!-- Add City Card -->
<div class="card mb-4">
    <div class="card-header">
        <h5 class="mb-0"> Add New City</h5>
    </div>
    <div class="card-body">
        <form action="{{ route('cities.store') }}" method="POST" id="addCityForm">
            @csrf
            <div class="row g-3">
                <div class="col-md-4">
                    <label for="name" class="form-label">City Name <span class="text-danger">*</span></label>
                    <input type="text" 
                           class="form-control @error('name') is-invalid @enderror" 
                           id="name" 
                           name="name" 
                           value="{{ old('name') }}" 
                           required 
                           placeholder="e.g., Karachi">
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-3">
                    <label for="code" class="form-label">City Code</label>
                    <input type="text" 
                           class="form-control @error('code') is-invalid @enderror" 
                           id="code" 
                           name="code" 
                           value="{{ old('code') }}" 
                           maxlength="10"
                           placeholder="e.g., KHI"
                           style="text-transform: uppercase;">
                    @error('code')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                    <small class="text-muted">Optional: 3-letter code</small>
                </div>
                <div class="col-md-3">
                    <label for="state" class="form-label">State/Province</label>
                    <input type="text" 
                           class="form-control @error('state') is-invalid @enderror" 
                           id="state" 
                           name="state" 
                           value="{{ old('state') }}" 
                           placeholder="e.g., Sindh">
                    @error('state')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-2">
                    <label for="is_active" class="form-label">Status</label>
                    <select class="form-select" id="is_active" name="is_active">
                        <option value="1" {{ old('is_active', '1') == '1' ? 'selected' : '' }}>Active</option>
                        <option value="0" {{ old('is_active') == '0' ? 'selected' : '' }}>Inactive</option>
                    </select>
                </div>
            </div>
            <div class="mt-3">
                <button type="submit" class="btn btn-primary">
                     Add City
                </button>
                <button type="reset" class="btn btn-secondary">
                     Clear
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Cities List Card -->
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0"> Cities ({{ $cities->count() }} records)</h5>
        <div class="d-flex gap-2">
            <!-- Search Form -->
            <form method="GET" action="{{ route('cities.index') }}" class="d-flex gap-2">
                <input type="text" 
                       class="form-control form-control-sm" 
                       name="search" 
                       value="{{ request('search') }}" 
                       placeholder="Search cities..." 
                       style="width: 200px;">
                <select class="form-select form-select-sm" name="status" style="width: 120px;">
                    <option value="">All Status</option>
                    <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>Active</option>
                    <option value="inactive" {{ request('status') === 'inactive' ? 'selected' : '' }}>Inactive</option>
                </select>
                <button type="submit" class="btn btn-sm btn-primary">
                     Filter
                </button>
                @if(request()->hasAny(['search', 'status']))
                <a href="{{ route('cities.index') }}" class="btn btn-sm btn-secondary">
                     Clear
                </a>
                @endif
            </form>
        </div>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>City ID</th>
                        <th>City Name</th>
                        <th>Code</th>
                        <th>State/Province</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($cities as $city)
                    <tr>
                        <td>{{ $city->city_id }}</td>
                        <td><strong>{{ $city->name }}</strong></td>
                        <td>
                            @if($city->code)
                                <span class="badge bg-info">{{ $city->code }}</span>
                            @else
                                <span class="text-muted">N/A</span>
                            @endif
                        </td>
                        <td>{{ $city->state ?? 'N/A' }}</td>
                        <td>
                            <span class="badge bg-{{ $city->is_active ? 'success' : 'secondary' }}">
                                {{ $city->is_active ? 'Active' : 'Inactive' }}
                            </span>
                        </td>
                        <td>
                            <div class="btn-group btn-group-sm" role="group">
                                <form action="{{ route('cities.toggle-status', $city->city_id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" 
                                            class="btn btn-sm btn-{{ $city->is_active ? 'warning' : 'success' }}"
                                            title="{{ $city->is_active ? 'Deactivate' : 'Activate' }}">
                                        
                                    </button>
                                </form>
                                <form action="{{ route('cities.destroy', $city->city_id) }}" 
                                      method="POST" 
                                      class="d-inline delete-city-form"
                                      data-city-name="{{ $city->name }}"
                                      data-shipments-count="{{ $city->shipments()->count() }}">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" 
                                            class="btn btn-sm btn-danger"
                                            title="Delete City">
                                        
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center">
                            @if(request()->hasAny(['search', 'status']))
                                No cities found matching your search criteria.
                            @else
                                No cities found. Add your first city above.
                            @endif
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Auto-uppercase city code
    const codeInput = document.getElementById('code');
    if (codeInput) {
        codeInput.addEventListener('input', function() {
            this.value = this.value.toUpperCase();
        });
    }

    // Delete confirmation with shipment check
    const deleteForms = document.querySelectorAll('.delete-city-form');
    deleteForms.forEach(form => {
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            
            const cityName = this.getAttribute('data-city-name');
            const shipmentsCount = parseInt(this.getAttribute('data-shipments-count')) || 0;
            
            let message = `Are you sure you want to delete the city "${cityName}"?`;
            
            if (shipmentsCount > 0) {
                message += `\n\nWARNING: This city is currently used in ${shipmentsCount} shipment(s). Deleting it may cause data inconsistencies.`;
                message += `\n\nIt is recommended to deactivate the city instead of deleting it.`;
                
                if (!confirm(message)) {
                    return;
                }
                
                // Double confirmation for cities in use
                if (!confirm('This action cannot be undone. Are you absolutely sure?')) {
                    return;
                }
            } else {
                if (!confirm(message + '\n\nThis action cannot be undone.')) {
                    return;
                }
            }
            
            this.submit();
        });
    });
});
</script>
@endpush
@endsection
