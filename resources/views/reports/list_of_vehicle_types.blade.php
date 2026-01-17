@extends('layouts.app')

@section('title', 'List of Vehicle Types')
@section('page-title', 'List of Vehicle Types')

@section('content')
<!-- Page Header -->
<div class="page-header">
    <h1 class="page-title">
        
        List of Vehicle Types
    </h1>
    <p class="page-subtitle">Master list of all vehicle types and their counts</p>
</div>

<div class="card">
    <div class="card-header">
        <h5 class="mb-0"> Vehicle Types ({{ $vehicleTypes->count() }} records)</h5>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Vehicle Type</th>
                        <th>Count</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($vehicleTypes as $type)
                    <tr>
                        <td><strong>{{ $type->type ?? 'N/A' }}</strong></td>
                        <td>
                            <span class="badge badge-primary">{{ $type->count }}</span>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="2" class="text-center">No vehicle types found</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

