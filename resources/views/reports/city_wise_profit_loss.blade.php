@extends('layouts.app')

@section('title', 'City-wise Profit Loss Report')
@section('page-title', 'City-wise Profit Loss Report')

@section('content')
<!-- Page Header -->
<div class="page-header">
    <h1 class="page-title">
        
        City-wise Profit Loss Report
    </h1>
    <p class="page-subtitle">Profit and loss breakdown by city</p>
</div>

<div class="card">
    <div class="card-header">
        <h5 class="mb-0"> Filters</h5>
    </div>
    <div class="card-body">
        <form method="GET" action="{{ route('reports.city-wise-profit-loss') }}" class="row g-3">
            <div class="col-md-3">
                <label class="form-label">From Date</label>
                <input type="date" name="from_date" class="form-control" value="{{ request('from_date') }}">
            </div>
            <div class="col-md-3">
                <label class="form-label">To Date</label>
                <input type="date" name="to_date" class="form-control" value="{{ request('to_date') }}">
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
        <h5 class="mb-0"> City-wise Summary</h5>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>City</th>
                        <th>Total CNs</th>
                        <th>Total Revenue</th>
                        <th>Average per CN</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($cityWise as $cityData)
                    <tr>
                        <td><strong>{{ $cityData['city'] }}</strong></td>
                        <td>{{ $cityData['count'] }}</td>
                        <td>Rs.{{ number_format($cityData['revenue'], 2) }}</td>
                        <td>Rs.{{ $cityData['count'] > 0 ? number_format($cityData['revenue'] / $cityData['count'], 2) : '0.00' }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="text-center">No records found</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

