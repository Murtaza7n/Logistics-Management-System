@extends('layouts.app')

@section('title', 'Detail Search - CN Entries')
@section('page-title', 'Detail Search - CN Entries')

@section('content')
<!-- Page Header -->
<div class="page-header">
    <h1 class="page-title">
        
        Detail Search - CN Entries
    </h1>
    <p class="page-subtitle">Search and filter consignment notes with advanced criteria</p>
</div>

<div class="card">
    <div class="card-header">
        <h5 class="mb-0"> Search Filters</h5>
    </div>
    <div class="card-body">
        <form method="GET" action="{{ route('shipments.detail-search') }}" id="searchForm">
            <div class="row mb-4">
                <div class="col-md-3 mb-3">
                    <label for="cn_number" class="form-label">CN Number</label>
                    <input type="text" 
                           class="form-control" 
                           id="cn_number" 
                           name="cn_number" 
                           value="{{ request('cn_number') }}" 
                           placeholder="Enter CN Number">
                </div>
                <div class="col-md-3 mb-3">
                    <label for="shipper_name" class="form-label">Shipper Name</label>
                    <input type="text" 
                           class="form-control" 
                           id="shipper_name" 
                           name="shipper_name" 
                           value="{{ request('shipper_name') }}" 
                           placeholder="Enter Shipper Name">
                </div>
                <div class="col-md-3 mb-3">
                    <label for="consignee_name" class="form-label">Consignee Name</label>
                    <input type="text" 
                           class="form-control" 
                           id="consignee_name" 
                           name="consignee_name" 
                           value="{{ request('consignee_name') }}" 
                           placeholder="Enter Consignee Name">
                </div>
                <div class="col-md-3 mb-3">
                    <label for="status" class="form-label">Status</label>
                    <select class="form-select" id="status" name="status">
                        <option value="">All Status</option>
                        @foreach($statuses as $status)
                        <option value="{{ $status }}" {{ request('status') == $status ? 'selected' : '' }}>
                            {{ ucfirst(str_replace('-', ' ', $status)) }}
                        </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3 mb-3">
                    <label for="city" class="form-label">Entry City</label>
                    <select class="form-select" id="city" name="city">
                        <option value="">All Cities</option>
                        @foreach($cities as $city)
                        <option value="{{ $city->city_id }}" {{ request('city') == $city->city_id ? 'selected' : '' }}>
                            {{ $city->name }}
                        </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3 mb-3">
                    <label for="vehicle_id" class="form-label">Vehicle</label>
                    <select class="form-select" id="vehicle_id" name="vehicle_id">
                        <option value="">All Vehicles</option>
                        @foreach($vehicles as $vehicle)
                        <option value="{{ $vehicle->vehicle_id }}" {{ request('vehicle_id') == $vehicle->vehicle_id ? 'selected' : '' }}>
                            {{ $vehicle->registration_no }} ({{ $vehicle->type }})
                        </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3 mb-3">
                    <label for="driver_id" class="form-label">Driver</label>
                    <select class="form-select" id="driver_id" name="driver_id">
                        <option value="">All Drivers</option>
                        @foreach($drivers as $driver)
                        <option value="{{ $driver->driver_id }}" {{ request('driver_id') == $driver->driver_id ? 'selected' : '' }}>
                            {{ $driver->name }}
                        </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3 mb-3">
                    <label for="date_from" class="form-label">Date From</label>
                    <input type="date" 
                           class="form-control" 
                           id="date_from" 
                           name="date_from" 
                           value="{{ request('date_from') }}">
                </div>
                <div class="col-md-3 mb-3">
                    <label for="date_to" class="form-label">Date To</label>
                    <input type="date" 
                           class="form-control" 
                           id="date_to" 
                           name="date_to" 
                           value="{{ request('date_to') }}">
                </div>
            </div>
            <div class="mb-3">
                <button type="submit" class="btn btn-primary">
                     Search
                </button>
                <a href="{{ route('shipments.detail-search') }}" class="btn btn-secondary">
                     Reset
                </a>
                @if(request()->hasAny(['cn_number', 'shipper_name', 'consignee_name', 'status', 'city', 'vehicle_id', 'driver_id', 'date_from', 'date_to']))
                <a href="{{ route('shipments.detail-search', request()->all()) }}&export=excel" class="btn btn-success">
                     Export Excel
                </a>
                @endif
            </div>
        </form>

        @if($shipments->count() > 0)
        <div class="table-responsive">
            <table class="table table-hover table-striped">
                <thead class="table-dark">
                    <tr>
                        <th>CN Number</th>
                        <th>Entry City</th>
                        <th>Shipper</th>
                        <th>Consignee</th>
                        <th>Pickup → Delivery</th>
                        <th>Vehicle</th>
                        <th>Driver</th>
                        <th>Status</th>
                        <th>Total Charges</th>
                        <th>Created Date</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($shipments as $shipment)
                    <tr>
                        <td><strong>{{ $shipment->shipment_number }}</strong></td>
                        <td>{{ $shipment->entryCity->name ?? 'N/A' }}</td>
                        <td>{{ $shipment->shipper_name }}</td>
                        <td>{{ $shipment->consignee_name }}</td>
                        <td>{{ $shipment->pickup_city }} → {{ $shipment->delivery_city }}</td>
                        <td>{{ $shipment->vehicle->registration_no ?? 'N/A' }}</td>
                        <td>{{ $shipment->driver->name ?? 'N/A' }}</td>
                        <td>
                            <span class="badge bg-{{ $shipment->status === 'delivered' ? 'success' : ($shipment->status === 'cancelled' ? 'danger' : 'warning') }}">
                                {{ ucfirst(str_replace('-', ' ', $shipment->status)) }}
                            </span>
                        </td>
                        <td>Rs.{{ number_format($shipment->total_charges, 2) }}</td>
                        <td>{{ $shipment->created_at->format('Y-m-d') }}</td>
                        <td>
                            <a href="{{ route('shipments.show', $shipment) }}" class="btn btn-sm btn-outline-info" title="View">
                                
                            </a>
                            <a href="{{ route('shipments.edit', $shipment) }}" class="btn btn-sm btn-outline-primary" title="Edit">
                                
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="mt-3">
            {{ $shipments->links() }}
        </div>
        <div class="mt-2">
            <p class="text-muted">Found <strong>{{ $shipments->total() }}</strong> CN entries matching your criteria.</p>
        </div>
        @elseif(request()->hasAny(['cn_number', 'shipper_name', 'consignee_name', 'status', 'city', 'vehicle_id', 'driver_id', 'date_from', 'date_to']))
        <div class="alert alert-info mt-3">
             No CN entries found matching your search criteria.
        </div>
        @else
        <div class="alert alert-secondary mt-3">
             Enter search criteria above to find CN entries.
        </div>
        @endif
    </div>
</div>
@endsection

