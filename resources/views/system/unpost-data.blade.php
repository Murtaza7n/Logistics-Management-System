@extends('layouts.app')

@section('title', 'Un-Post Data')
@section('page-title', 'Un-Post Data with Date Range')

@section('content')
<div class="page-header">
    <h1 class="page-title">
        <i class="bi bi-x-circle"></i> Un-Post Data with Date Range
    </h1>
    <p class="page-subtitle">Un-post posted data within a specific date range</p>
</div>

<div class="card">
    <div class="card-header">
        <h5 class="mb-0">Un-Post Data</h5>
    </div>
    <div class="card-body">
        <form method="POST" action="{{ route('system.process-unpost-data') }}" onsubmit="return confirm('Are you sure you want to un-post data? This action cannot be undone.');">
            @csrf
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="date_from" class="form-label">From Date</label>
                        <input type="date" class="form-control @error('date_from') is-invalid @enderror" 
                               id="date_from" name="date_from" required>
                        @error('date_from')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="date_to" class="form-label">To Date</label>
                        <input type="date" class="form-control @error('date_to') is-invalid @enderror" 
                               id="date_to" name="date_to" required>
                        @error('date_to')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">Data Type</label>
                        <select class="form-select" name="data_type" required>
                            <option value="">Select Data Type</option>
                            <option value="shipments">Shipments</option>
                            <option value="invoices">Invoices</option>
                            <option value="payments">Payments</option>
                            <option value="payrolls">Payrolls</option>
                            <option value="all">All Data Types</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="reason" class="form-label">Reason</label>
                        <textarea class="form-control @error('reason') is-invalid @enderror" 
                                  id="reason" name="reason" rows="3" 
                                  placeholder="Enter reason for un-posting" required></textarea>
                        @error('reason')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>
            <div class="alert alert-danger">
                <i class="bi bi-exclamation-triangle-fill"></i> <strong>Warning:</strong> Un-posting data will reverse all posted transactions within the selected date range. This is a critical operation and should be performed with caution.
            </div>
            <button type="submit" class="btn btn-danger">
                <i class="bi bi-x-octagon"></i> Un-Post Data
            </button>
        </form>
    </div>
</div>
@endsection

