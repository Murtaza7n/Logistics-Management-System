@extends('layouts.app')

@section('title', 'Reports')
@section('page-title', 'Reports')

@section('content')
<div class="row">
    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0"><i class="bi bi-box-seam"></i> Shipment Reports</h5>
            </div>
            <div class="card-body">
                <p>Generate detailed shipment reports with filters.</p>
                <a href="{{ route('reports.shipments') }}" class="btn btn-primary">
                    <i class="bi bi-arrow-right"></i> View Report
                </a>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0"><i class="bi bi-cash-stack"></i> Revenue Reports</h5>
            </div>
            <div class="card-body">
                <p>View revenue and invoice reports.</p>
                <a href="{{ route('reports.revenue') }}" class="btn btn-primary">
                    <i class="bi bi-arrow-right"></i> View Report
                </a>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0"><i class="bi bi-person-badge"></i> Payroll Reports</h5>
            </div>
            <div class="card-body">
                <p>Generate payroll summary reports.</p>
                <a href="{{ route('reports.payroll') }}" class="btn btn-primary">
                    <i class="bi bi-arrow-right"></i> View Report
                </a>
            </div>
        </div>
    </div>
    <div class="col-md-4 mt-3">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0"><i class="bi bi-truck"></i> Vehicle Usage</h5>
            </div>
            <div class="card-body">
                <p>View vehicle usage statistics.</p>
                <a href="{{ route('reports.vehicle-usage') }}" class="btn btn-primary">
                    <i class="bi bi-arrow-right"></i> View Report
                </a>
            </div>
        </div>
    </div>
    <div class="col-md-4 mt-3">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0"><i class="bi bi-person-workspace"></i> Driver Performance</h5>
            </div>
            <div class="card-body">
                <p>View driver performance metrics.</p>
                <a href="{{ route('reports.driver-performance') }}" class="btn btn-primary">
                    <i class="bi bi-arrow-right"></i> View Report
                </a>
            </div>
        </div>
    </div>
    <div class="col-md-4 mt-3">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0"><i class="bi bi-people"></i> Customer Reports</h5>
            </div>
            <div class="card-body">
                <p>Customer-wise shipment and revenue reports.</p>
                <a href="{{ route('reports.customer-wise') }}" class="btn btn-primary">
                    <i class="bi bi-arrow-right"></i> View Report
                </a>
            </div>
        </div>
    </div>
    <div class="col-md-4 mt-3">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0"><i class="bi bi-building"></i> Vendor Reports</h5>
            </div>
            <div class="card-body">
                <p>Vendor-wise billing reports.</p>
                <a href="{{ route('reports.vendor-wise') }}" class="btn btn-primary">
                    <i class="bi bi-arrow-right"></i> View Report
                </a>
            </div>
        </div>
    </div>
</div>
@endsection


