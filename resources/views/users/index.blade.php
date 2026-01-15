@extends('layouts.app')

@section('title', 'Users')
@section('page-title', 'Users Management')

@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0"><i class="bi bi-people"></i> Users</h5>
        <a href="{{ route('users.create') }}" class="btn btn-primary btn-sm">
            <i class="bi bi-plus-circle"></i> Add User
        </a>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Created</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($users as $user)
                    <tr>
                        <td>{{ $user->id }}</td>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td><span class="badge bg-{{ $user->role === 'admin' ? 'danger' : ($user->role === 'staff' ? 'primary' : 'info') }}">{{ ucfirst($user->role) }}</span></td>
                        <td>{{ $user->created_at->format('M d, Y') }}</td>
                        <td>
                            <a href="{{ route('users.edit', $user) }}" class="btn btn-sm btn-outline-primary">
                                <i class="bi bi-pencil"></i>
                            </a>
                            <form action="{{ route('users.destroy', $user) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure?')">
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
                        <td colspan="6" class="text-center">No users found</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="mt-3">
            {{ $users->links() }}
        </div>
    </div>
</div>
@endsection


