@extends('layouts.app')

@section('title', 'List of Missing C/N Nos.')
@section('page-title', 'List of Missing C/N Nos.')

@section('content')
<!-- Page Header -->
<div class="page-header">
    <h1 class="page-title">
        
        List of Missing C/N Nos.
    </h1>
    <p class="page-subtitle">Gaps in consignment note number sequence</p>
</div>

<div class="card">
    <div class="card-header">
        <h5 class="mb-0"> Missing CN Numbers</h5>
    </div>
    <div class="card-body">
        @if(count($missing) > 0)
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Missing CN Number</th>
                        <th>Expected Range</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($missing as $missingCn)
                    <tr>
                        <td><strong>{{ $missingCn['number'] }}</strong></td>
                        <td>{{ $missingCn['range'] ?? 'N/A' }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @else
        <div class="alert alert-info">
             No missing CN numbers found. All sequences are complete.
        </div>
        @endif
    </div>
</div>
@endsection

