@extends('layouts.app')

@section('title', 'Vehicle Load Plans')
@section('page-title', 'Vehicle Load Plans Management')

@section('content')
<div class="page-header">
    <div class="d-flex justify-content-between align-items-center flex-wrap">
        <div>
            <h1 class="page-title">Vehicle Load Plans</h1>
            <p class="page-subtitle">View and manage vehicle load plans</p>
        </div>
        <div class="d-flex flex-wrap gap-2 mt-2 mt-md-0">
            <a href="{{ route('vehicle-load-plans.received') }}" class="btn btn-info">
                Received Plans
            </a>
            <a href="{{ route('vehicle-load-plans.create') }}" class="btn btn-primary">
                New Load Plan
            </a>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <h5 class="mb-0">All Vehicle Load Plans</h5>
    </div>
    <div class="card-body">
        <p class="text-muted">Vehicle Load Plans module is under development. This will allow you to manage vehicle load planning.</p>
    </div>
</div>
@endsection

