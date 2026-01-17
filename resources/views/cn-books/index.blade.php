@extends('layouts.app')

@section('title', 'CN Books Management')
@section('page-title', 'CN Books Management')

@section('content')
<!-- Page Header -->
<div class="page-header">
    <h1 class="page-title">
        CN Books Management
    </h1>
    <p class="page-subtitle">Manage CN number books and track usage</p>
</div>

@if($lowStockBooks->count() > 0)
<div class="alert alert-warning alert-dismissible fade show" role="alert">
    <strong><i class="bi bi-exclamation-triangle me-2"></i>Low Stock Warning:</strong> 
    {{ $lowStockBooks->count() }} CN book(s) have less than 10% numbers remaining.
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>
@endif

<!-- Filters -->
<div class="card mb-4">
    <div class="card-body">
        <form method="GET" action="{{ route('cn-books.index') }}" class="row g-3">
            <div class="col-md-3">
                <label for="search" class="form-label">Search</label>
                <input type="text" name="search" class="form-control" id="search" 
                       value="{{ request('search') }}" placeholder="Book number or name">
            </div>
            <div class="col-md-2">
                <label for="status" class="form-label">Status</label>
                <select name="status" class="form-select" id="status">
                    <option value="">All Status</option>
                    <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Active</option>
                    <option value="exhausted" {{ request('status') == 'exhausted' ? 'selected' : '' }}>Exhausted</option>
                    <option value="archived" {{ request('status') == 'archived' ? 'selected' : '' }}>Archived</option>
                </select>
            </div>
            <div class="col-md-2">
                <label for="city_code" class="form-label">City Code</label>
                <select name="city_code" class="form-select" id="city_code">
                    <option value="">All Cities</option>
                    @foreach($cities as $city)
                        <option value="{{ $city->code }}" {{ request('city_code') == $city->code ? 'selected' : '' }}>
                            {{ $city->code }} - {{ $city->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2">
                <label for="system_year" class="form-label">System Year</label>
                <input type="text" name="system_year" class="form-control" id="system_year" 
                       value="{{ request('system_year') }}" placeholder="e.g., 2526">
            </div>
            <div class="col-md-3 d-flex align-items-end">
                <button type="submit" class="btn btn-primary me-2">
                    Filter
                </button>
                <a href="{{ route('cn-books.index') }}" class="btn btn-secondary">
                    Reset
                </a>
            </div>
        </form>
    </div>
</div>

<!-- CN Books List -->
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">CN Books ({{ $books->total() }} records)</h5>
        <a href="{{ route('cn-books.create') }}" class="btn btn-primary btn-sm">
            Add New CN Book
        </a>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Book Number</th>
                        <th>Book Name</th>
                        <th>City Code</th>
                        <th>System Year</th>
                        <th>Range</th>
                        <th>Total</th>
                        <th>Issued</th>
                        <th>Remaining</th>
                        <th>Usage %</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($books as $book)
                    <tr class="{{ $book->isLowStock() ? 'table-warning' : '' }}">
                        <td><strong>{{ $book->book_number }}</strong></td>
                        <td>{{ $book->book_name ?? 'N/A' }}</td>
                        <td>{{ $book->city_code ?? 'N/A' }}</td>
                        <td>{{ $book->system_year ?? 'N/A' }}</td>
                        <td>{{ $book->start_number }} - {{ $book->end_number }}</td>
                        <td>{{ $book->total_numbers }}</td>
                        <td>{{ $book->issued_count }}</td>
                        <td>
                            <strong class="{{ $book->remaining_count <= 10 ? 'text-danger' : '' }}">
                                {{ $book->remaining_count }}
                            </strong>
                        </td>
                        <td>
                            @php
                                $percentage = $book->total_numbers > 0 
                                    ? round(($book->issued_count / $book->total_numbers) * 100, 1) 
                                    : 0;
                            @endphp
                            <div class="progress" style="height: 20px;">
                                <div class="progress-bar {{ $percentage >= 90 ? 'bg-danger' : ($percentage >= 70 ? 'bg-warning' : 'bg-success') }}" 
                                     role="progressbar" 
                                     style="width: {{ $percentage }}%">
                                    {{ $percentage }}%
                                </div>
                            </div>
                        </td>
                        <td>
                            <span class="badge bg-{{ $book->status === 'active' ? 'success' : ($book->status === 'exhausted' ? 'danger' : 'secondary') }}">
                                {{ ucfirst($book->status) }}
                            </span>
                            @if($book->isLowStock())
                                <span class="badge bg-warning">Low Stock</span>
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('cn-books.show', $book) }}" class="btn btn-sm btn-info" title="View Details">
                                View
                            </a>
                            <a href="{{ route('cn-books.edit', $book) }}" class="btn btn-sm btn-primary" title="Edit">
                                Edit
                            </a>
                            <form action="{{ route('cn-books.refresh-counts', $book) }}" method="POST" class="d-inline">
                                @csrf
                                <button type="submit" class="btn btn-sm btn-secondary" title="Refresh Counts">
                                    Refresh
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="11" class="text-center">No CN books found</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="mt-3">
            {{ $books->links() }}
        </div>
    </div>
</div>
@endsection

