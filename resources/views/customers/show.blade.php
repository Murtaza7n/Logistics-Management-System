@extends('layouts.app')

@section('title', 'Customer Details')
@section('page-title', 'Customer Details')

@section('content')
<div class="row">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0"> Customer Information</h5>
            </div>
            <div class="card-body">
                <table class="table table-borderless">
                    <tr>
                        <th width="40%">Customer ID:</th>
                        <td>{{ $customer->customer_id }}</td>
                    </tr>
                    <tr>
                        <th>Name:</th>
                        <td>{{ $customer->name }}</td>
                    </tr>
                    <tr>
                        <th>Contact:</th>
                        <td>{{ $customer->contact ?? 'N/A' }}</td>
                    </tr>
                    <tr>
                        <th>Email:</th>
                        <td>{{ $customer->email ?? 'N/A' }}</td>
                    </tr>
                    <tr>
                        <th>Address:</th>
                        <td>{{ $customer->address ?? 'N/A' }}</td>
                    </tr>
                    <tr>
                        <th>City:</th>
                        <td>{{ $customer->city ?? 'N/A' }}</td>
                    </tr>
                    <tr>
                        <th>State:</th>
                        <td>{{ $customer->state ?? 'N/A' }}</td>
                    </tr>
                    <tr>
                        <th>Country:</th>
                        <td>{{ $customer->country ?? 'N/A' }}</td>
                    </tr>
                    <tr>
                        <th>Tax ID:</th>
                        <td>{{ $customer->tax_id ?? 'N/A' }}</td>
                    </tr>
                    <tr>
                        <th>Status:</th>
                        <td><span class="badge bg-{{ $customer->status === 'active' ? 'success' : 'secondary' }}">{{ ucfirst($customer->status) }}</span></td>
                    </tr>
                </table>
                <div class="mt-3">
                    <a href="{{ route('customers.edit', $customer) }}" class="btn btn-primary">
                         Edit
                    </a>
                    <a href="{{ route('customers.index') }}" class="btn btn-secondary">
                         Back
                    </a>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0"> Shipments ({{ $customer->shipments->count() }})</h5>
            </div>
            <div class="card-body">
                @if($customer->shipments->count() > 0)
                <div class="table-responsive">
                    <table class="table table-sm">
                        <thead>
                            <tr>
                                <th>Shipment #</th>
                                <th>Status</th>
                                <th>Amount</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($customer->shipments->take(10) as $shipment)
                            <tr>
                                <td><a href="{{ route('shipments.show', $shipment) }}">{{ $shipment->shipment_number }}</a></td>
                                <td><span class="badge bg-{{ $shipment->status === 'delivered' ? 'success' : 'warning' }}">{{ ucfirst(str_replace('-', ' ', $shipment->status)) }}</span></td>
                                <td>Rs.{{ number_format($shipment->total_charges, 2) }}</td>
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


