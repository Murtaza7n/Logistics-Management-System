@extends('layouts.app')

@section('title', 'Pickup Sheets')
@section('page-title', 'Pickup Sheets Management')

@section('content')
<div class="page-header">
    <div class="d-flex justify-content-between align-items-center flex-wrap">
        <div>
            <h1 class="page-title">Pickup Sheets</h1>
            <p class="page-subtitle">View and manage pickup sheets</p>
        </div>
        <div class="d-flex flex-wrap gap-2 mt-2 mt-md-0">
            <a href="{{ route('pickup-sheets.create') }}" class="btn btn-primary">
                New Pickup Sheet
            </a>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <h5 class="mb-0">All Pickup Sheets</h5>
    </div>
    <div class="card-body">
        <p class="text-muted">Pickup Sheets module is under development. This will allow you to manage pickup sheets.</p>
    </div>
</div>
@endsection

