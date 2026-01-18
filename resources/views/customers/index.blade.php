@extends('layouts.app')

@section('title', 'Customers')
@section('page-title', 'Customers Management')

@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0"> Customers</h5>
        <a href="{{ route('customers.create') }}" class="btn btn-primary btn-sm">
             Add Customer
        </a>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Contact</th>
                        <th>Email</th>
                        <th>City</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($customers as $customer)
                    <tr>
                        <td>{{ $customer->customer_id }}</td>
                        <td>{{ $customer->name }}</td>
                        <td>{{ $customer->contact ?? 'N/A' }}</td>
                        <td>{{ $customer->email ?? 'N/A' }}</td>
                        <td>{{ $customer->city ?? 'N/A' }}</td>
                        <td><span class="badge bg-{{ $customer->status === 'active' ? 'success' : 'secondary' }}">{{ ucfirst($customer->status) }}</span></td>
                        <td>
                            <a href="{{ route('customers.show', $customer) }}" class="btn btn-sm btn-outline-info">
                                
                            </a>
                            <a href="{{ route('customers.edit', $customer) }}" class="btn btn-sm btn-outline-primary">
                                
                            </a>
                            <form action="{{ route('customers.destroy', $customer) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger">
                                    
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center">No customers found</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="mt-3">
            {{ $customers->links() }}
        </div>
    </div>
</div>
@endsection


