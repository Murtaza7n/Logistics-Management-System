@extends('layouts.app')

@section('title', 'Vendors')
@section('page-title', 'Vendors Management')

@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0"><i class="bi bi-building"></i> Vendors</h5>
        <a href="{{ route('vendors.create') }}" class="btn btn-primary btn-sm">
            <i class="bi bi-plus-circle"></i> Add Vendor
        </a>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Services</th>
                        <th>Contact</th>
                        <th>Billing Terms</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($vendors as $vendor)
                    <tr>
                        <td>{{ $vendor->vendor_id }}</td>
                        <td>{{ $vendor->name }}</td>
                        <td>{{ Str::limit($vendor->services, 30) ?? 'N/A' }}</td>
                        <td>{{ $vendor->contact ?? 'N/A' }}</td>
                        <td>{{ $vendor->billing_terms ?? 'N/A' }}</td>
                        <td><span class="badge bg-{{ $vendor->status === 'active' ? 'success' : 'secondary' }}">{{ ucfirst($vendor->status) }}</span></td>
                        <td>
                            <a href="{{ route('vendors.show', $vendor) }}" class="btn btn-sm btn-outline-info">
                                <i class="bi bi-eye"></i>
                            </a>
                            <a href="{{ route('vendors.edit', $vendor) }}" class="btn btn-sm btn-outline-primary">
                                <i class="bi bi-pencil"></i>
                            </a>
                            <form action="{{ route('vendors.destroy', $vendor) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center">No vendors found</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="mt-3">
            {{ $vendors->links() }}
        </div>
    </div>
</div>
@endsection


