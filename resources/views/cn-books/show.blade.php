@extends('layouts.app')

@section('title', 'CN Book Details')
@section('page-title', 'CN Book Details')

@section('content')
<div class="row">
    <div class="col-md-4">
        <!-- Book Information -->
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="mb-0">Book Information</h5>
            </div>
            <div class="card-body">
                <table class="table table-sm">
                    <tr>
                        <th>Book Number:</th>
                        <td><strong>{{ $cnBook->book_number }}</strong></td>
                    </tr>
                    <tr>
                        <th>Book Name:</th>
                        <td>{{ $cnBook->book_name ?? 'N/A' }}</td>
                    </tr>
                    <tr>
                        <th>City Code:</th>
                        <td>{{ $cnBook->city_code ?? 'N/A' }}</td>
                    </tr>
                    <tr>
                        <th>System Year:</th>
                        <td>{{ $cnBook->system_year ?? 'N/A' }}</td>
                    </tr>
                    <tr>
                        <th>Number Range:</th>
                        <td>{{ $cnBook->start_number }} - {{ $cnBook->end_number }}</td>
                    </tr>
                    <tr>
                        <th>Status:</th>
                        <td>
                            <span class="badge bg-{{ $cnBook->status === 'active' ? 'success' : ($cnBook->status === 'exhausted' ? 'danger' : 'secondary') }}">
                                {{ ucfirst($cnBook->status) }}
                            </span>
                        </td>
                    </tr>
                    <tr>
                        <th>Issue Date:</th>
                        <td>{{ $cnBook->issue_date ? $cnBook->issue_date->format('M d, Y') : 'N/A' }}</td>
                    </tr>
                    @if($cnBook->expiry_date)
                    <tr>
                        <th>Expiry Date:</th>
                        <td>{{ $cnBook->expiry_date->format('M d, Y') }}</td>
                    </tr>
                    @endif
                </table>
            </div>
        </div>

        <!-- Statistics -->
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Statistics</h5>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <label class="form-label">Total Numbers</label>
                    <h4>{{ $stats['total_numbers'] }}</h4>
                </div>
                <div class="mb-3">
                    <label class="form-label">Issued</label>
                    <h4 class="text-primary">{{ $stats['issued_count'] }}</h4>
                </div>
                <div class="mb-3">
                    <label class="form-label">Remaining</label>
                    <h4 class="{{ $stats['remaining_count'] <= 10 ? 'text-danger' : 'text-success' }}">
                        {{ $stats['remaining_count'] }}
                    </h4>
                </div>
                <div class="mb-3">
                    <label class="form-label">Usage</label>
                    <div class="progress" style="height: 30px;">
                        <div class="progress-bar {{ $stats['usage_percentage'] >= 90 ? 'bg-danger' : ($stats['usage_percentage'] >= 70 ? 'bg-warning' : 'bg-success') }}" 
                             role="progressbar" 
                             style="width: {{ $stats['usage_percentage'] }}%">
                            {{ $stats['usage_percentage'] }}%
                        </div>
                    </div>
                </div>
                @if($stats['is_low_stock'])
                <div class="alert alert-warning">
                    Low Stock Warning
                </div>
                @endif
                @if($stats['is_exhausted'])
                <div class="alert alert-danger">
                    Book Exhausted
                </div>
                @endif
            </div>
        </div>
    </div>

    <div class="col-md-8">
        <!-- Actions -->
        <div class="card mb-4">
            <div class="card-body">
                <a href="{{ route('cn-books.edit', $cnBook) }}" class="btn btn-primary">
                    Edit Book
                </a>
                <form action="{{ route('cn-books.refresh-counts', $cnBook) }}" method="POST" class="d-inline">
                    @csrf
                    <button type="submit" class="btn btn-secondary">
                        Refresh Counts
                    </button>
                </form>
                <a href="{{ route('cn-books.remaining-numbers', $cnBook) }}" class="btn btn-info" target="_blank">
                    View Remaining Numbers
                </a>
                <a href="{{ route('cn-books.index') }}" class="btn btn-secondary">
                    Back to List
                </a>
            </div>
        </div>

        <!-- Issued CN Numbers -->
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Issued CN Numbers ({{ $issuedNumbers->total() }})</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-sm table-hover">
                        <thead>
                            <tr>
                                <th>CN Number</th>
                                <th>Shipment</th>
                                <th>Issued By</th>
                                <th>Issued At</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($issuedNumbers as $usage)
                            <tr>
                                <td><strong>{{ $usage->cn_number }}</strong></td>
                                <td>
                                    @if($usage->shipment)
                                        <a href="{{ route('shipments.show', $usage->shipment) }}">
                                            {{ $usage->shipment->shipment_number }}
                                        </a>
                                    @else
                                        <span class="text-muted">N/A</span>
                                    @endif
                                </td>
                                <td>{{ $usage->issuedBy->name ?? 'N/A' }}</td>
                                <td>{{ $usage->issued_at->format('M d, Y H:i') }}</td>
                                <td>
                                    <span class="badge bg-{{ $usage->status === 'issued' ? 'success' : 'secondary' }}">
                                        {{ ucfirst($usage->status) }}
                                    </span>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="text-center">No CN numbers issued yet</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="mt-3">
                    {{ $issuedNumbers->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

