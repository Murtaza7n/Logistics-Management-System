@extends('layouts.app')

@section('title', 'Shipper-wise Profit Loss Report')
@section('page-title', 'Shipper-wise Profit Loss Report')

@section('content')
<!-- Page Header -->
<div class="page-header">
    <h1 class="page-title">
        
        Shipper-wise Profit Loss Report
    </h1>
    <p class="page-subtitle">Profit and loss breakdown by shipper</p>
</div>

<div class="card">
    <div class="card-header">
        <h5 class="mb-0"> Filters</h5>
    </div>
    <div class="card-body">
        <form method="GET" action="{{ route('reports.shipper-wise-profit-loss') }}" class="row g-3">
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
        <h5 class="mb-0"> Shipper-wise Summary</h5>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Shipper</th>
                        <th>Total CNs</th>
                        <th>Total Revenue</th>
                        <th>Average per CN</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($shipperWise as $shipperData)
                    <tr>
                        <td><strong>{{ $shipperData['shipper'] }}</strong></td>
                        <td>{{ $shipperData['count'] }}</td>
                        <td>Rs.{{ number_format($shipperData['revenue'], 2) }}</td>
                        <td>Rs.{{ $shipperData['count'] > 0 ? number_format($shipperData['revenue'] / $shipperData['count'], 2) : '0.00' }}</td>
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

