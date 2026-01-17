@extends('layouts.app')

@section('title', 'Shipment Details')
@section('page-title', 'Shipment Details')

@section('content')
<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0"> Shipment Information</h5>
            </div>
            <div class="card-body">
                <table class="table table-borderless">
                    <tr>
                        <th width="40%">CN Number / Consignment Note:</th>
                        <td><strong>{{ $shipment->shipment_number }}</strong></td>
                    </tr>
                    <tr>
                        <th>Customer:</th>
                        <td>{{ $shipment->customer->name }}</td>
                    </tr>
                    <tr>
                        <th>Vendor:</th>
                        <td>{{ $shipment->vendor->name ?? 'N/A' }}</td>
                    </tr>
                    <tr>
                        <th>Sender:</th>
                        <td>{{ $shipment->sender }}</td>
                    </tr>
                    <tr>
                        <th>Receiver:</th>
                        <td>{{ $shipment->receiver }}</td>
                    </tr>
                    <tr>
                        <th>Route:</th>
                        <td>{{ $shipment->pickup_city }} → {{ $shipment->delivery_city }}</td>
                    </tr>
                    <tr>
                        <th>Cargo Type:</th>
                        <td>{{ $shipment->cargo_type }}</td>
                    </tr>
                    <tr>
                        <th>Weight:</th>
                        <td>{{ $shipment->weight ?? 'N/A' }} kg</td>
                    </tr>
                    <tr>
                        <th>Dimension:</th>
                        <td>{{ $shipment->dimension ?? 'N/A' }}</td>
                    </tr>
                    <tr>
                        <th>Vehicle:</th>
                        <td>{{ $shipment->vehicle->registration_no ?? 'N/A' }}</td>
                    </tr>
                    <tr>
                        <th>Driver:</th>
                        <td>{{ $shipment->driver->name ?? 'N/A' }}</td>
                    </tr>
                    <tr>
                        <th>Status:</th>
                        <td><span class="badge bg-{{ $shipment->status === 'delivered' ? 'success' : ($shipment->status === 'cancelled' ? 'danger' : 'warning') }}">{{ ucfirst(str_replace('-', ' ', $shipment->status)) }}</span></td>
                    </tr>
                    <tr>
                        <th>Total Charges:</th>
                        <td><strong>Rs.{{ number_format($shipment->total_charges, 2) }}</strong></td>
                    </tr>
                </table>
                <div class="mt-3">
                    <a href="{{ route('shipments.edit', $shipment) }}" class="btn btn-primary">
                         Edit
                    </a>
                    <a href="{{ route('shipments.index') }}" class="btn btn-secondary">
                         Back
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection


