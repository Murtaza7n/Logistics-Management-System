<?php $__env->startSection('title', 'CN Books Management'); ?>
<?php $__env->startSection('page-title', 'CN Books Management'); ?>

<?php $__env->startSection('content'); ?>
<!-- Page Header -->
<div class="page-header">
    <h1 class="page-title">
        CN Books Management
    </h1>
    <p class="page-subtitle">Manage CN number books and track usage</p>
</div>

<?php if($lowStockBooks->count() > 0): ?>
<div class="alert alert-warning alert-dismissible fade show" role="alert">
    <strong><i class="bi bi-exclamation-triangle me-2"></i>Low Stock Warning:</strong> 
    <?php echo e($lowStockBooks->count()); ?> CN book(s) have less than 10% numbers remaining.
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>
<?php endif; ?>

<!-- Filters -->
<div class="card mb-4">
    <div class="card-body">
        <form method="GET" action="<?php echo e(route('cn-books.index')); ?>" class="row g-3">
            <div class="col-md-3">
                <label for="search" class="form-label">Search</label>
                <input type="text" name="search" class="form-control" id="search" 
                       value="<?php echo e(request('search')); ?>" placeholder="Book number or name">
            </div>
            <div class="col-md-2">
                <label for="status" class="form-label">Status</label>
                <select name="status" class="form-select" id="status">
                    <option value="">All Status</option>
                    <option value="active" <?php echo e(request('status') == 'active' ? 'selected' : ''); ?>>Active</option>
                    <option value="exhausted" <?php echo e(request('status') == 'exhausted' ? 'selected' : ''); ?>>Exhausted</option>
                    <option value="archived" <?php echo e(request('status') == 'archived' ? 'selected' : ''); ?>>Archived</option>
                </select>
            </div>
            <div class="col-md-2">
                <label for="city_code" class="form-label">City Code</label>
                <select name="city_code" class="form-select" id="city_code">
                    <option value="">All Cities</option>
                    <?php $__currentLoopData = $cities; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $city): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($city->code); ?>" <?php echo e(request('city_code') == $city->code ? 'selected' : ''); ?>>
                            <?php echo e($city->code); ?> - <?php echo e($city->name); ?>

                        </option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </div>
            <div class="col-md-2">
                <label for="system_year" class="form-label">System Year</label>
                <input type="text" name="system_year" class="form-control" id="system_year" 
                       value="<?php echo e(request('system_year')); ?>" placeholder="e.g., 2526">
            </div>
            <div class="col-md-3 d-flex align-items-end">
                <button type="submit" class="btn btn-primary me-2">
                    Filter
                </button>
                <a href="<?php echo e(route('cn-books.index')); ?>" class="btn btn-secondary">
                    Reset
                </a>
            </div>
        </form>
    </div>
</div>

<!-- CN Books List -->
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">CN Books (<?php echo e($books->total()); ?> records)</h5>
        <a href="<?php echo e(route('cn-books.create')); ?>" class="btn btn-primary btn-sm">
            Add New CN Book
        </a>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Book Number</th>
                        <th>Book Name</th>
                        <th>City Code</th>
                        <th>System Year</th>
                        <th>Range</th>
                        <th>Total</th>
                        <th>Issued</th>
                        <th>Remaining</th>
                        <th>Usage %</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__empty_1 = true; $__currentLoopData = $books; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $book): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr class="<?php echo e($book->isLowStock() ? 'table-warning' : ''); ?>">
                        <td><strong><?php echo e($book->book_number); ?></strong></td>
                        <td><?php echo e($book->book_name ?? 'N/A'); ?></td>
                        <td><?php echo e($book->city_code ?? 'N/A'); ?></td>
                        <td><?php echo e($book->system_year ?? 'N/A'); ?></td>
                        <td><?php echo e($book->start_number); ?> - <?php echo e($book->end_number); ?></td>
                        <td><?php echo e($book->total_numbers); ?></td>
                        <td><?php echo e($book->issued_count); ?></td>
                        <td>
                            <strong class="<?php echo e($book->remaining_count <= 10 ? 'text-danger' : ''); ?>">
                                <?php echo e($book->remaining_count); ?>

                            </strong>
                        </td>
                        <td>
                            <?php
                                $percentage = $book->total_numbers > 0 
                                    ? round(($book->issued_count / $book->total_numbers) * 100, 1) 
                                    : 0;
                            ?>
                            <div class="progress" style="height: 20px;">
                                <div class="progress-bar <?php echo e($percentage >= 90 ? 'bg-danger' : ($percentage >= 70 ? 'bg-warning' : 'bg-success')); ?>" 
                                     role="progressbar" 
                                     style="width: <?php echo e($percentage); ?>%">
                                    <?php echo e($percentage); ?>%
                                </div>
                            </div>
                        </td>
                        <td>
                            <span class="badge bg-<?php echo e($book->status === 'active' ? 'success' : ($book->status === 'exhausted' ? 'danger' : 'secondary')); ?>">
                                <?php echo e(ucfirst($book->status)); ?>

                            </span>
                            <?php if($book->isLowStock()): ?>
                                <span class="badge bg-warning">Low Stock</span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <a href="<?php echo e(route('cn-books.show', $book)); ?>" class="btn btn-sm btn-info" title="View Details">
                                View
                            </a>
                            <a href="<?php echo e(route('cn-books.edit', $book)); ?>" class="btn btn-sm btn-primary" title="Edit">
                                Edit
                            </a>
                            <form action="<?php echo e(route('cn-books.refresh-counts', $book)); ?>" method="POST" class="d-inline">
                                <?php echo csrf_field(); ?>
                                <button type="submit" class="btn btn-sm btn-secondary" title="Refresh Counts">
                                    Refresh
                                </button>
                            </form>
                        </td>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr>
                        <td colspan="11" class="text-center">No CN books found</td>
                    </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="mt-3">
            <?php echo e($books->links()); ?>

        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/Logistics-Management-System/resources/views/cn-books/index.blade.php ENDPATH**/ ?>