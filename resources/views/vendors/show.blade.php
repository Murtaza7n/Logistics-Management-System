@extends('layouts.app')

@section('title', 'Vendor Details')
@section('page-title', 'Vendor Details')

@section('content')
<div class="row">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0"> Vendor Information</h5>
            </div>
            <div class="card-body">
                <table class="table table-borderless">
                    <tr>
                        <th width="40%">Vendor ID:</th>
                        <td>{{ $vendor->vendor_id }}</td>
                    </tr>
                    <tr>
                        <th>Name:</th>
                        <td>{{ $vendor->name }}</td>
                    </tr>
                    <tr>
                        <th>Services:</th>
                        <td>{{ $vendor->services ?? 'N/A' }}</td>
                    </tr>
                    <tr>
                        <th>Contact:</th>
                        <td>{{ $vendor->contact ?? 'N/A' }}</td>
                    </tr>
                    <tr>
                        <th>Email:</th>
                        <td>{{ $vendor->email ?? 'N/A' }}</td>
                    </tr>
                    <tr>
                        <th>Address:</th>
                        <td>{{ $vendor->address ?? 'N/A' }}</td>
                    </tr>
                    <tr>
                        <th>Billing Terms:</th>
                        <td>{{ $vendor->billing_terms ?? 'N/A' }}</td>
                    </tr>
                    <tr>
                        <th>Tax ID:</th>
                        <td>{{ $vendor->tax_id ?? 'N/A' }}</td>
                    </tr>
                    <tr>
                        <th>Status:</th>
                        <td><span class="badge bg-{{ $vendor->status === 'active' ? 'success' : 'secondary' }}">{{ ucfirst($vendor->status) }}</span></td>
                    </tr>
                </table>
                <div class="mt-3">
                    <a href="{{ route('vendors.edit', $vendor) }}" class="btn btn-primary">
                         Edit
                    </a>
                    <a href="{{ route('vendors.index') }}" class="btn btn-secondary">
                         Back
                    </a>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0"> Shipments ({{ $vendor->shipments->count() }})</h5>
            </div>
            <div class="card-body">
                @if($vendor->shipments->count() > 0)
                <div class="table-responsive">
                    <table class="table table-sm">
                        <thead>
                            <tr>
                                <th>Shipment #</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($vendor->shipments->take(10) as $shipment)
                            <tr>
                                <td><a href="{{ route('shipments.show', $shipment) }}">{{ $shipment->shipment_number }}</a></td>
                                <td><span class="badge bg-{{ $shipment->status === 'delivered' ? 'success' : 'warning' }}">{{ ucfirst(str_replace('-', ' ', $shipment->status)) }}</span></td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @else
                <p class="text-muted">No shipments found.</p>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection


