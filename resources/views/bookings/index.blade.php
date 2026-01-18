@extends('layouts.app')

@section('title', 'Bookings')
@section('page-title', 'Bookings Management')

@section('content')
<div class="page-header">
    <div class="d-flex justify-content-between align-items-center flex-wrap">
        <div>
            <h1 class="page-title">Bookings</h1>
            <p class="page-subtitle">View and manage all booking entries</p>
        </div>
        <div class="d-flex flex-wrap gap-2 mt-2 mt-md-0">
            <a href="{{ route('bookings.create') }}" class="btn btn-primary">
                New Booking
            </a>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <h5 class="mb-0">All Bookings</h5>
    </div>
    <div class="card-body">
        <form method="GET" class="mb-3">
            <div class="row g-2">
                <div class="col-md-2">
                    <input type="text" class="form-control" name="booking_number" value="{{ request('booking_number') }}" placeholder="Booking Number">
                </div>
                <div class="col-md-2">
                    <select class="form-select" name="status">
                        <option value="">All Status</option>
                        <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="confirmed" {{ request('status') === 'confirmed' ? 'selected' : '' }}>Confirmed</option>
                        <option value="cancelled" {{ request('status') === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <select class="form-select" name="pickup_city">
                        <option value="">All Pickup Cities</option>
                        @foreach($cities as $city)
                        <option value="{{ $city->name }}" {{ request('pickup_city') == $city->name ? 'selected' : '' }}>{{ $city->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <select class="form-select" name="delivery_city">
                        <option value="">All Delivery Cities</option>
                        @foreach($cities as $city)
                        <option value="{{ $city->name }}" {{ request('delivery_city') == $city->name ? 'selected' : '' }}>{{ $city->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <input type="date" class="form-control" name="date_from" value="{{ request('date_from') }}" placeholder="From Date">
                </div>
                <div class="col-md-2">
                    <input type="date" class="form-control" name="date_to" value="{{ request('date_to') }}" placeholder="To Date">
                </div>
                <div class="col-md-12 mt-2">
                    <button type="submit" class="btn btn-primary">Filter</button>
                    <a href="{{ route('bookings.index') }}" class="btn btn-secondary">Reset</a>
                </div>
            </div>
        </form>

        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Booking No.</th>
                        <th>Date</th>
                        <th>Shipper</th>
                        <th>Consignee</th>
                        <th>Pickup City</th>
                        <th>Delivery City</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($bookings as $booking)
                    <tr>
                        <td>{{ $booking->booking_number }}</td>
                        <td>{{ $booking->booking_date->format('Y-m-d') }}</td>
                        <td>{{ $booking->shipper_name }}</td>
                        <td>{{ $booking->consignee_name }}</td>
                        <td>{{ $booking->pickup_city }}</td>
                        <td>{{ $booking->delivery_city }}</td>
                        <td>
                            <span class="badge bg-{{ $booking->status === 'confirmed' ? 'success' : ($booking->status === 'cancelled' ? 'danger' : 'warning') }}">
                                {{ ucfirst($booking->status) }}
                            </span>
                        </td>
                        <td>
                            <a href="{{ route('bookings.show', $booking) }}" class="btn btn-sm btn-outline-info" title="View">
                                <i class="bi bi-eye"></i>
                            </a>
                            <a href="{{ route('bookings.edit', $booking) }}" class="btn btn-sm btn-outline-primary" title="Edit">
                                <i class="bi bi-pencil"></i>
                            </a>
                            <form action="{{ route('bookings.destroy', $booking) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this booking?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger" title="Delete">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="text-center">No bookings found</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="mt-3">
            {{ $bookings->links() }}
        </div>
    </div>
</div>
@endsection
