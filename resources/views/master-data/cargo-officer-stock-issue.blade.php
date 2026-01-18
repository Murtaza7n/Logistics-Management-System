@extends('layouts.app')

@section('title', 'Cargo Officer Stock Issue')
@section('page-title', 'Cargo Officer-wise CN Stock Issue')

@section('content')
<div class="page-header">
    <div class="d-flex justify-content-between align-items-center flex-wrap">
        <div>
            <h1 class="page-title">Cargo Officer-wise CN Stock Issue</h1>
            <p class="page-subtitle">View CN books issued to cargo officers</p>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <form method="GET" class="row g-2">
            <div class="col-md-3">
                <select class="form-select" name="officer_id">
                    <option value="">All Officers</option>
                    @foreach($cargoOfficers as $officer)
                    <option value="{{ $officer->id }}" {{ request('officer_id') == $officer->id ? 'selected' : '' }}>
                        {{ $officer->officer_code }} - {{ $officer->officer_name }}
                    </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2">
                <button type="submit" class="btn btn-primary w-100">Filter</button>
            </div>
            <div class="col-md-2">
                <a href="{{ route('master-data.cargo-officer-stock-issue') }}" class="btn btn-secondary w-100">Reset</a>
            </div>
        </form>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th>Book Number</th>
                        <th>Officer Code</th>
                        <th>Officer Name</th>
                        <th>City Code</th>
                        <th>Start Number</th>
                        <th>End Number</th>
                        <th>Total Numbers</th>
                        <th>Issued Count</th>
                        <th>Remaining</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($stockIssues as $issue)
                    <tr>
                        <td><strong>{{ $issue->book_number ?? '-' }}</strong></td>
                        <td>{{ $issue->officer_code ?? '-' }}</td>
                        <td>{{ $issue->officer_name ?? '-' }}</td>
                        <td>{{ $issue->city_code ?? '-' }}</td>
                        <td>{{ $issue->start_number ?? '-' }}</td>
                        <td>{{ $issue->end_number ?? '-' }}</td>
                        <td>{{ $issue->total_numbers ?? '-' }}</td>
                        <td>{{ $issue->issued_count ?? 0 }}</td>
                        <td>
                            <span class="badge bg-{{ ($issue->remaining_count ?? 0) > 0 ? 'success' : 'danger' }}">
                                {{ $issue->remaining_count ?? 0 }}
                            </span>
                        </td>
                        <td>
                            <span class="badge bg-{{ $issue->status === 'active' ? 'success' : ($issue->status === 'exhausted' ? 'danger' : 'secondary') }}">
                                {{ ucfirst($issue->status ?? 'unknown') }}
                            </span>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="10" class="text-center text-muted">No CN stock issues found.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-3">
            {{ $stockIssues->links() }}
        </div>
    </div>
</div>
@endsection

