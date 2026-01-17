@extends('layouts.app')

@section('title', 'Data Processing')
@section('page-title', 'Data Processing')

@section('content')
<div class="page-header">
    <h1 class="page-title">
        <i class="bi bi-gear"></i> Data Processing
    </h1>
    <p class="page-subtitle">Process and update system data</p>
</div>

<div class="card">
    <div class="card-header">
        <h5 class="mb-0">Data Processing Options</h5>
    </div>
    <div class="card-body">
        <form method="POST" action="{{ route('system.process-data') }}" onsubmit="return confirm('Are you sure you want to process the data? This action cannot be undone.');">
            @csrf
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">Processing Type</label>
                        <select class="form-select" name="processing_type" required>
                            <option value="">Select Processing Type</option>
                            <option value="update_statuses">Update Shipment Statuses</option>
                            <option value="recalculate_totals">Recalculate Totals</option>
                            <option value="sync_data">Sync Data Across Modules</option>
                            <option value="cleanup_old">Cleanup Old Records</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">Date Range (Optional)</label>
                        <div class="input-group">
                            <input type="date" class="form-control" name="date_from">
                            <span class="input-group-text">to</span>
                            <input type="date" class="form-control" name="date_to">
                        </div>
                    </div>
                </div>
            </div>
            <div class="alert alert-warning">
                <i class="bi bi-exclamation-triangle"></i> <strong>Warning:</strong> Data processing may take several minutes. Please do not close this page during processing.
            </div>
            <button type="submit" class="btn btn-primary">
                <i class="bi bi-play-circle"></i> Process Data
            </button>
        </form>
    </div>
</div>
@endsection

