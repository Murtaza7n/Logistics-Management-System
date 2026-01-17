@extends('layouts.app')

@section('title', 'System Users')
@section('page-title', 'SYSTEM USERS')

@section('content')
<style>
    .users-table-container {
        background: white;
        border-radius: 8px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.08);
        margin-top: 1rem;
    }
    
    .table-header-row {
        background: #f8f9fa;
        font-weight: 600;
    }
    
    .table-header-row th {
        cursor: pointer;
        user-select: none;
        position: relative;
        padding: 1rem;
        border-bottom: 2px solid #dee2e6;
    }
    
    .table-header-row th:hover {
        background: #e9ecef;
    }
    
    .sort-icon {
        margin-left: 0.5rem;
        font-size: 0.75rem;
        opacity: 0.5;
    }
    
    .sort-icon.active {
        opacity: 1;
        color: var(--orange-primary);
    }
    
    .action-icon {
        font-size: 1.2rem;
        text-decoration: none;
        margin: 0 0.25rem;
        display: inline-block;
    }
    
    .action-icon.view {
        color: #0d6efd;
    }
    
    .action-icon.edit {
        color: #198754;
    }
    
    .action-icon.delete {
        color: #dc3545;
    }
    
    .search-filter-bar {
        background: white;
        padding: 1rem;
        border-radius: 8px;
        margin-bottom: 1rem;
        box-shadow: 0 2px 8px rgba(0,0,0,0.05);
        display: flex;
        align-items: center;
        gap: 1rem;
        flex-wrap: wrap;
    }
    
    .users-table {
        margin: 0;
    }
    
    .users-table tbody tr {
        transition: background 0.2s ease;
    }
    
    .users-table tbody tr:hover {
        background: #f8f9fa;
    }
    
    .users-table td {
        vertical-align: middle;
        padding: 0.75rem 1rem;
    }
</style>

<div class="page-header mb-3">
    <h1 class="page-title" style="font-size: 1.8rem; font-weight: 700;">
        SYSTEM USERS
    </h1>
</div>

<!-- Search and Filter Bar -->
<div class="search-filter-bar">
    <div class="d-flex align-items-center gap-2">
        <label for="per_page" class="mb-0" style="white-space: nowrap;">Show:</label>
        <select class="form-select form-select-sm" id="per_page" name="per_page" style="width: auto;" onchange="updatePerPage(this.value)">
            <option value="15" {{ request('per_page', 15) == 15 ? 'selected' : '' }}>15</option>
            <option value="25" {{ request('per_page') == 25 ? 'selected' : '' }}>25</option>
            <option value="50" {{ request('per_page') == 50 ? 'selected' : '' }}>50</option>
            <option value="100" {{ request('per_page') == 100 ? 'selected' : '' }}>100</option>
            <option value="all" {{ request('per_page') == 'all' ? 'selected' : '' }}>All</option>
        </select>
    </div>
    <div class="d-flex align-items-center gap-2 flex-grow-1">
        <label for="search" class="mb-0" style="white-space: nowrap;">Search:</label>
        <form method="GET" action="{{ route('users.index') }}" class="d-flex gap-2 flex-grow-1">
            <input type="text" 
                   class="form-control form-control-sm" 
                   id="search" 
                   name="search" 
                   value="{{ request('search') }}" 
                   placeholder="Search users...">
            @if(request('role'))
            <input type="hidden" name="role" value="{{ request('role') }}">
            @endif
            @if(request('per_page'))
            <input type="hidden" name="per_page" value="{{ request('per_page') }}">
            @endif
            <button type="submit" class="btn btn-sm btn-primary">
                <i class="bi bi-search"></i>
            </button>
            @if(request('search') || request('role'))
            <a href="{{ route('users.index') }}" class="btn btn-sm btn-secondary">
                <i class="bi bi-x-circle"></i> Clear
            </a>
            @endif
        </form>
    </div>
    <div>
        <a href="{{ route('users.create') }}" class="btn btn-sm btn-primary">
            <i class="bi bi-plus-circle"></i> New User
        </a>
    </div>
</div>

<!-- Users Table -->
<div class="users-table-container">
    <div class="table-responsive" style="max-height: 600px; overflow-y: auto;">
        <table class="table table-hover users-table mb-0">
            <thead class="table-header-row sticky-top">
                <tr>
                    <th class="text-center" style="width: 60px;">View</th>
                    <th class="text-center" style="width: 60px;">Edit</th>
                    <th class="text-center" style="width: 60px;">Delete</th>
                    <th onclick="sortTable('name')" title="Click to sort" style="min-width: 150px;">
                        User
                        <span class="sort-icon {{ request('sort_by') == 'name' ? 'active' : '' }}">
                            @if(request('sort_by') == 'name')
                                <i class="bi bi-arrow-{{ request('sort_order') == 'asc' ? 'up' : 'down' }}"></i>
                            @else
                                <i class="bi bi-arrow-down-up"></i>
                            @endif
                        </span>
                    </th>
                    <th onclick="sortTable('email')" title="Click to sort" style="min-width: 120px;">
                        User Name
                        <span class="sort-icon {{ request('sort_by') == 'email' ? 'active' : '' }}">
                            @if(request('sort_by') == 'email')
                                <i class="bi bi-arrow-{{ request('sort_order') == 'asc' ? 'up' : 'down' }}"></i>
                            @else
                                <i class="bi bi-arrow-down-up"></i>
                            @endif
                        </span>
                    </th>
                    <th onclick="sortTable('email')" title="Click to sort" style="min-width: 200px;">
                        Email
                        <span class="sort-icon {{ request('sort_by') == 'email' ? 'active' : '' }}">
                            @if(request('sort_by') == 'email')
                                <i class="bi bi-arrow-{{ request('sort_order') == 'asc' ? 'up' : 'down' }}"></i>
                            @else
                                <i class="bi bi-arrow-down-up"></i>
                            @endif
                        </span>
                    </th>
                    <th style="min-width: 100px;">Role</th>
                    <th style="min-width: 120px;">Contact</th>
                </tr>
            </thead>
            <tbody>
                @forelse($users as $user)
                <tr>
                    <td class="text-center">
                        <a href="{{ route('users.show', $user) }}" class="action-icon view" title="View User">
                            <i class="bi bi-grid-3x3-gap" style="color: #0d6efd; font-size: 1.3rem;"></i>
                        </a>
                    </td>
                    <td class="text-center">
                        <a href="{{ route('users.edit', $user) }}" class="action-icon edit" title="Edit User">
                            <i class="bi bi-file-earmark-text" style="color: #198754; font-size: 1.3rem;"></i>
                        </a>
                    </td>
                    <td class="text-center">
                        <form action="{{ route('users.destroy', $user) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this user?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-link p-0 action-icon delete" title="Delete User" style="border: none; background: none; cursor: pointer;">
                                <i class="bi bi-x-circle-fill" style="color: #dc3545; font-size: 1.3rem;"></i>
                            </button>
                        </form>
                    </td>
                    <td>
                        <strong>{{ $user->name }}</strong>
                    </td>
                    <td>
                        <code style="background: #f8f9fa; padding: 0.25rem 0.5rem; border-radius: 4px; font-size: 0.9rem;">{{ $user->email }}</code>
                    </td>
                    <td>{{ $user->email }}</td>
                    <td>
                        <span class="badge bg-{{ $user->role === 'admin' ? 'danger' : ($user->role === 'staff' ? 'primary' : 'info') }}">
                            {{ ucfirst($user->role) }}
                        </span>
                    </td>
                    <td>{{ $user->contact ?? 'N/A' }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" class="text-center py-5">
                        <i class="bi bi-inbox" style="font-size: 3rem; opacity: 0.3; color: #6c757d;"></i>
                        <p class="text-muted mt-3 mb-2">No users found</p>
                        <a href="{{ route('users.create') }}" class="btn btn-primary btn-sm">
                            <i class="bi bi-plus-circle"></i> Create First User
                        </a>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    <!-- Pagination -->
    @if(method_exists($users, 'hasPages') && $users->hasPages())
    <div class="card-footer d-flex justify-content-between align-items-center py-2">
        <div>
            <small class="text-muted">
                Showing {{ $users->firstItem() ?? 0 }} to {{ $users->lastItem() ?? 0 }} of {{ $users->total() }} users
            </small>
        </div>
        <div>
            {{ $users->appends(request()->query())->links() }}
        </div>
    </div>
    @endif
</div>

<script>
    function sortTable(column) {
        const currentSort = '{{ request('sort_by', 'created_at') }}';
        const currentOrder = '{{ request('sort_order', 'desc') }}';
        
        let newOrder = 'asc';
        if (currentSort === column && currentOrder === 'asc') {
            newOrder = 'desc';
        }
        
        const url = new URL(window.location.href);
        url.searchParams.set('sort_by', column);
        url.searchParams.set('sort_order', newOrder);
        
        window.location.href = url.toString();
    }

    function updatePerPage(value) {
        const url = new URL(window.location.href);
        if (value === 'all') {
            url.searchParams.set('per_page', '9999');
        } else {
            url.searchParams.set('per_page', value);
        }
        window.location.href = url.toString();
    }
</script>
@endsection
