@extends('layouts.app')

@section('title', 'Initialize Data')
@section('page-title', 'Initialize Data for re-processing')

@section('content')
<div class="page-header">
    <h1 class="page-title">
        <i class="bi bi-arrow-clockwise"></i> Initialize Data for re-processing
    </h1>
    <p class="page-subtitle">Initialize system data for reprocessing</p>
</div>

<div class="card">
    <div class="card-header">
        <h5 class="mb-0">Data Initialization</h5>
    </div>
    <div class="card-body">
        <form method="POST" action="{{ route('system.process-initialize-data') }}" onsubmit="return confirm('Are you sure you want to initialize data? This will reset processing flags.');">
            @csrf
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">Initialization Type</label>
                        <select class="form-select" name="init_type" required>
                            <option value="">Select Type</option>
                            <option value="shipments">Shipments Processing</option>
                            <option value="payroll">Payroll Processing</option>
                            <option value="invoices">Invoice Processing</option>
                            <option value="all">All Modules</option>
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
            <div class="alert alert-info">
                <i class="bi bi-info-circle"></i> Initializing data will reset processing flags and allow you to reprocess the selected data.
            </div>
            <button type="submit" class="btn btn-primary">
                <i class="bi bi-arrow-repeat"></i> Initialize Data
            </button>
        </form>
    </div>
</div>
@endsection

