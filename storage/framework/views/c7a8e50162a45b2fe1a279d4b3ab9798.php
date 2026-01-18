<?php $__env->startSection('title', 'System Users'); ?>
<?php $__env->startSection('page-title', 'SYSTEM USERS'); ?>

<?php $__env->startSection('content'); ?>
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
                <option value="15" <?php echo e(request('per_page', 15) == 15 ? 'selected' : ''); ?>>15</option>
                <option value="25" <?php echo e(request('per_page') == 25 ? 'selected' : ''); ?>>25</option>
                <option value="50" <?php echo e(request('per_page') == 50 ? 'selected' : ''); ?>>50</option>
                <option value="100" <?php echo e(request('per_page') == 100 ? 'selected' : ''); ?>>100</option>
                <option value="all" <?php echo e(request('per_page') == 'all' ? 'selected' : ''); ?>>All</option>
            </select>
        </div>
    <div class="d-flex align-items-center gap-2 flex-grow-1">
        <label for="search" class="mb-0" style="white-space: nowrap;">Search:</label>
        <form method="GET" action="<?php echo e(route('users.index')); ?>" class="d-flex gap-2 flex-grow-1">
            <input type="text" 
                   class="form-control form-control-sm" 
                   id="search" 
                   name="search" 
                   value="<?php echo e(request('search')); ?>" 
                   placeholder="Search users...">
            <?php if(request('role')): ?>
            <input type="hidden" name="role" value="<?php echo e(request('role')); ?>">
            <?php endif; ?>
            <?php if(request('per_page')): ?>
            <input type="hidden" name="per_page" value="<?php echo e(request('per_page')); ?>">
            <?php endif; ?>
            <button type="submit" class="btn btn-sm btn-primary">
                <i class="bi bi-search"></i>
            </button>
            <?php if(request('search') || request('role')): ?>
            <a href="<?php echo e(route('users.index')); ?>" class="btn btn-sm btn-secondary">
                <i class="bi bi-x-circle"></i> Clear
            </a>
            <?php endif; ?>
        </form>
        </div>
    <div>
        <a href="<?php echo e(route('users.create')); ?>" class="btn btn-sm btn-primary">
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
                        <span class="sort-icon <?php echo e(request('sort_by') == 'name' ? 'active' : ''); ?>">
                            <?php if(request('sort_by') == 'name'): ?>
                                <i class="bi bi-arrow-<?php echo e(request('sort_order') == 'asc' ? 'up' : 'down'); ?>"></i>
                            <?php else: ?>
                                <i class="bi bi-arrow-down-up"></i>
                            <?php endif; ?>
                        </span>
                    </th>
                    <th onclick="sortTable('email')" title="Click to sort" style="min-width: 120px;">
                        User Name
                        <span class="sort-icon <?php echo e(request('sort_by') == 'email' ? 'active' : ''); ?>">
                            <?php if(request('sort_by') == 'email'): ?>
                                <i class="bi bi-arrow-<?php echo e(request('sort_order') == 'asc' ? 'up' : 'down'); ?>"></i>
                            <?php else: ?>
                                <i class="bi bi-arrow-down-up"></i>
                            <?php endif; ?>
                        </span>
                    </th>
                    <th onclick="sortTable('email')" title="Click to sort" style="min-width: 200px;">
                        Email
                        <span class="sort-icon <?php echo e(request('sort_by') == 'email' ? 'active' : ''); ?>">
                            <?php if(request('sort_by') == 'email'): ?>
                                <i class="bi bi-arrow-<?php echo e(request('sort_order') == 'asc' ? 'up' : 'down'); ?>"></i>
                            <?php else: ?>
                                <i class="bi bi-arrow-down-up"></i>
                            <?php endif; ?>
                        </span>
                    </th>
                    <th style="min-width: 100px;">Role</th>
                    <th style="min-width: 120px;">Contact</th>
                </tr>
            </thead>
            <tbody>
                <?php $__empty_1 = true; $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <tr>
                    <td class="text-center">
                        <a href="<?php echo e(route('users.show', $user)); ?>" class="action-icon view" title="View User">
                            <i class="bi bi-grid-3x3-gap" style="color: #0d6efd; font-size: 1.3rem;"></i>
                        </a>
                    </td>
                    <td class="text-center">
                        <a href="<?php echo e(route('users.edit', $user)); ?>" class="action-icon edit" title="Edit User">
                            <i class="bi bi-file-earmark-text" style="color: #198754; font-size: 1.3rem;"></i>
                        </a>
                    </td>
                    <td class="text-center">
                        <form action="<?php echo e(route('users.destroy', $user)); ?>" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this user?');">
                            <?php echo csrf_field(); ?>
                            <?php echo method_field('DELETE'); ?>
                            <button type="submit" class="btn btn-link p-0 action-icon delete" title="Delete User" style="border: none; background: none; cursor: pointer;">
                                <i class="bi bi-x-circle-fill" style="color: #dc3545; font-size: 1.3rem;"></i>
                            </button>
                        </form>
                    </td>
                    <td>
                        <strong><?php echo e($user->name); ?></strong>
                    </td>
                    <td>
                        <code style="background: #f8f9fa; padding: 0.25rem 0.5rem; border-radius: 4px; font-size: 0.9rem;"><?php echo e($user->email); ?></code>
                    </td>
                    <td><?php echo e($user->email); ?></td>
                    <td>
                        <span class="badge bg-<?php echo e($user->role === 'admin' ? 'danger' : ($user->role === 'staff' ? 'primary' : 'info')); ?>">
                            <?php echo e(ucfirst($user->role)); ?>

                        </span>
                    </td>
                    <td><?php echo e($user->contact ?? 'N/A'); ?></td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <tr>
                    <td colspan="8" class="text-center py-5">
                        <i class="bi bi-inbox" style="font-size: 3rem; opacity: 0.3; color: #6c757d;"></i>
                        <p class="text-muted mt-3 mb-2">No users found</p>
                        <a href="<?php echo e(route('users.create')); ?>" class="btn btn-primary btn-sm">
                            <i class="bi bi-plus-circle"></i> Create First User
                        </a>
                    </td>
                </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
    
    <!-- Pagination -->
    <?php if(method_exists($users, 'hasPages') && $users->hasPages()): ?>
    <div class="card-footer d-flex justify-content-between align-items-center py-2">
        <div>
            <small class="text-muted">
                Showing <?php echo e($users->firstItem() ?? 0); ?> to <?php echo e($users->lastItem() ?? 0); ?> of <?php echo e($users->total()); ?> users
            </small>
        </div>
        <div>
            <?php echo e($users->appends(request()->query())->links()); ?>

        </div>
    </div>
    <?php endif; ?>
</div>

<script>
    function sortTable(column) {
        const currentSort = '<?php echo e(request('sort_by', 'created_at')); ?>';
        const currentOrder = '<?php echo e(request('sort_order', 'desc')); ?>';
        
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
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/Logistics-Management-System/resources/views/users/index.blade.php ENDPATH**/ ?>