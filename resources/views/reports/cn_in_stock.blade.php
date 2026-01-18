@extends('layouts.app')

@section('title', 'C/N In-Stock Report')
@section('page-title', 'C/N In-Stock Report')

@section('content')
<!-- Page Header -->
<div class="page-header">
    <h1 class="page-title">
        
        C/N In-Stock Report
    </h1>
    <p class="page-subtitle">Consignment notes currently in stock (booked or picked up)</p>
</div>

<div class="card">
    <div class="card-header">
        <h5 class="mb-0"> Filters</h5>
    </div>
    <div class="card-body">
        <form method="GET" action="{{ route('reports.cn-in-stock') }}" class="row g-3">
            <div class="col-md-3">
                <label class="form-label">City</label>
                <select name="city_id" class="form-select">
                    <option value="">All Cities</option>
                    @foreach(\App\Models\City::where('is_active', true)->orderBy('name')->get() as $city)
                    <option value="{{ $city->city_id }}" {{ request('city_id') == $city->city_id ? 'selected' : '' }}>
                        {{ $city->name }}
                    </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3">
                <label class="form-label">&nbsp;</label>
                <div>
                    <button type="submit" class="btn btn-primary w-100">
                         Filter
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <h5 class="mb-0"> C/N In-Stock ({{ $shipments->count() }} records)</h5>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>C/N No.</th>
                        <th>Entry City</th>
                        <th>Shipper</th>
                        <th>Consignee</th>
                        <th>Route</th>
                        <th>Status</th>
                        <th>Created Date</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($shipments as $shipment)
                    <tr>
                        <td><strong>{{ $shipment->shipment_number }}</strong></td>
                        <td>{{ $shipment->entryCity->name ?? 'N/A' }}</td>
                        <td>{{ $shipment->shipper_name ?? 'N/A' }}</td>
                        <td>{{ $shipment->consignee_name ?? 'N/A' }}</td>
                        <td>{{ $shipment->pickup_city }} → {{ $shipment->delivery_city }}</td>
                        <td>
                            <span class="badge badge-secondary">
                                {{ ucfirst(str_replace('-', ' ', $shipment->status)) }}
                            </span>
                        </td>
                        <td>{{ $shipment->created_at->format('Y-m-d') }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center">No records found</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

