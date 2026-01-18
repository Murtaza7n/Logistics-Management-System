@extends('layouts.app')

@section('title', 'C/N Profit Loss Report')
@section('page-title', 'C/N Profit Loss Report')

@section('content')
<!-- Page Header -->
<div class="page-header">
    <h1 class="page-title">
        
        C/N Profit Loss Report
    </h1>
    <p class="page-subtitle">Profit and loss analysis for consignment notes</p>
</div>

<div class="card">
    <div class="card-header">
        <h5 class="mb-0"> Filters</h5>
    </div>
    <div class="card-body">
        <form method="GET" action="{{ route('reports.cn-profit-loss') }}" class="row g-3">
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

<!-- Summary Cards -->
<div class="row mb-4">
    <div class="col-md-3 mb-3">
        <div class="stat-card">
            <h3>{{ $summary['total_cns'] }}</h3>
            <p> Total CNs</p>
        </div>
    </div>
    <div class="col-md-3 mb-3">
        <div class="stat-card stat-card-silver">
            <h3>Rs.{{ number_format($summary['total_revenue'], 2) }}</h3>
            <p> Total Revenue</p>
        </div>
    </div>
    <div class="col-md-3 mb-3">
        <div class="stat-card stat-card-dark">
            <h3>Rs.{{ number_format($summary['total_cost'], 2) }}</h3>
            <p> Total Cost</p>
        </div>
    </div>
    <div class="col-md-3 mb-3">
        <div class="stat-card stat-card-silver">
            <h3>Rs.{{ number_format($summary['total_profit'], 2) }}</h3>
            <p> Total Profit</p>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <h5 class="mb-0"> C/N Profit Loss Details</h5>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>C/N No.</th>
                        <th>Shipper</th>
                        <th>Consignee</th>
                        <th>Revenue</th>
                        <th>Cost</th>
                        <th>Profit</th>
                        <th>Date</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($shipments as $shipment)
                    @php
                        $revenue = $shipment->freight_charges + $shipment->labor_charges + $shipment->other_charges;
                        $cost = 0; // Can be calculated based on vehicle/driver costs
                        $profit = $revenue - $cost;
                    @endphp
                    <tr>
                        <td><strong>{{ $shipment->shipment_number }}</strong></td>
                        <td>{{ $shipment->shipper_name ?? 'N/A' }}</td>
                        <td>{{ $shipment->consignee_name ?? 'N/A' }}</td>
                        <td>Rs.{{ number_format($revenue, 2) }}</td>
                        <td>Rs.{{ number_format($cost, 2) }}</td>
                        <td>
                            <span class="badge badge-{{ $profit >= 0 ? 'primary' : 'dark' }}">
                                Rs.{{ number_format($profit, 2) }}
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

