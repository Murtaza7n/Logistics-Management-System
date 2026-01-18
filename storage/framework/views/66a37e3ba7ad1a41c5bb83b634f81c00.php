<?php $__env->startSection('title', 'CN Book Details'); ?>
<?php $__env->startSection('page-title', 'CN Book Details'); ?>

<?php $__env->startSection('content'); ?>
<div class="row">
    <div class="col-md-4">
        <!-- Book Information -->
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="mb-0">Book Information</h5>
            </div>
            <div class="card-body">
                <table class="table table-sm">
                    <tr>
                        <th>Book Number:</th>
                        <td><strong><?php echo e($cnBook->book_number); ?></strong></td>
                    </tr>
                    <tr>
                        <th>Book Name:</th>
                        <td><?php echo e($cnBook->book_name ?? 'N/A'); ?></td>
                    </tr>
                    <tr>
                        <th>City Code:</th>
                        <td><?php echo e($cnBook->city_code ?? 'N/A'); ?></td>
                    </tr>
                    <tr>
                        <th>System Year:</th>
                        <td><?php echo e($cnBook->system_year ?? 'N/A'); ?></td>
                    </tr>
                    <tr>
                        <th>Number Range:</th>
                        <td><?php echo e($cnBook->start_number); ?> - <?php echo e($cnBook->end_number); ?></td>
                    </tr>
                    <tr>
                        <th>Status:</th>
                        <td>
                            <span class="badge bg-<?php echo e($cnBook->status === 'active' ? 'success' : ($cnBook->status === 'exhausted' ? 'danger' : 'secondary')); ?>">
                                <?php echo e(ucfirst($cnBook->status)); ?>

                            </span>
                        </td>
                    </tr>
                    <tr>
                        <th>Issue Date:</th>
                        <td><?php echo e($cnBook->issue_date ? $cnBook->issue_date->format('M d, Y') : 'N/A'); ?></td>
                    </tr>
                    <?php if($cnBook->expiry_date): ?>
                    <tr>
                        <th>Expiry Date:</th>
                        <td><?php echo e($cnBook->expiry_date->format('M d, Y')); ?></td>
                    </tr>
                    <?php endif; ?>
                </table>
            </div>
        </div>

        <!-- Statistics -->
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Statistics</h5>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <label class="form-label">Total Numbers</label>
                    <h4><?php echo e($stats['total_numbers']); ?></h4>
                </div>
                <div class="mb-3">
                    <label class="form-label">Issued</label>
                    <h4 class="text-primary"><?php echo e($stats['issued_count']); ?></h4>
                </div>
                <div class="mb-3">
                    <label class="form-label">Remaining</label>
                    <h4 class="<?php echo e($stats['remaining_count'] <= 10 ? 'text-danger' : 'text-success'); ?>">
                        <?php echo e($stats['remaining_count']); ?>

                    </h4>
                </div>
                <div class="mb-3">
                    <label class="form-label">Usage</label>
                    <div class="progress" style="height: 30px;">
                        <div class="progress-bar <?php echo e($stats['usage_percentage'] >= 90 ? 'bg-danger' : ($stats['usage_percentage'] >= 70 ? 'bg-warning' : 'bg-success')); ?>" 
                             role="progressbar" 
                             style="width: <?php echo e($stats['usage_percentage']); ?>%">
                            <?php echo e($stats['usage_percentage']); ?>%
                        </div>
                    </div>
                </div>
                <?php if($stats['is_low_stock']): ?>
                <div class="alert alert-warning">
                    Low Stock Warning
                </div>
                <?php endif; ?>
                <?php if($stats['is_exhausted']): ?>
                <div class="alert alert-danger">
                    Book Exhausted
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <div class="col-md-8">
        <!-- Actions -->
        <div class="card mb-4">
            <div class="card-body">
                <a href="<?php echo e(route('cn-books.edit', $cnBook)); ?>" class="btn btn-primary">
                    Edit Book
                </a>
                <form action="<?php echo e(route('cn-books.refresh-counts', $cnBook)); ?>" method="POST" class="d-inline">
                    <?php echo csrf_field(); ?>
                    <button type="submit" class="btn btn-secondary">
                        Refresh Counts
                    </button>
                </form>
                <a href="<?php echo e(route('cn-books.remaining-numbers', $cnBook)); ?>" class="btn btn-info" target="_blank">
                    View Remaining Numbers
                </a>
                <a href="<?php echo e(route('cn-books.index')); ?>" class="btn btn-secondary">
                    Back to List
                </a>
            </div>
        </div>

        <!-- Issued CN Numbers -->
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Issued CN Numbers (<?php echo e($issuedNumbers->total()); ?>)</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-sm table-hover">
                        <thead>
                            <tr>
                                <th>CN Number</th>
                                <th>Shipment</th>
                                <th>Issued By</th>
                                <th>Issued At</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__empty_1 = true; $__currentLoopData = $issuedNumbers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $usage): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <tr>
                                <td><strong><?php echo e($usage->cn_number); ?></strong></td>
                                <td>
                                    <?php if($usage->shipment): ?>
                                        <a href="<?php echo e(route('shipments.show', $usage->shipment)); ?>">
                                            <?php echo e($usage->shipment->shipment_number); ?>

                                        </a>
                                    <?php else: ?>
                                        <span class="text-muted">N/A</span>
                                    <?php endif; ?>
                                </td>
                                <td><?php echo e($usage->issuedBy->name ?? 'N/A'); ?></td>
                                <td><?php echo e($usage->issued_at->format('M d, Y H:i')); ?></td>
                                <td>
                                    <span class="badge bg-<?php echo e($usage->status === 'issued' ? 'success' : 'secondary'); ?>">
                                        <?php echo e(ucfirst($usage->status)); ?>

                                    </span>
                                </td>
                            </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <tr>
                                <td colspan="5" class="text-center">No CN numbers issued yet</td>
                            </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>

                <div class="mt-3">
                    <?php echo e($issuedNumbers->links()); ?>

                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/Logistics-Management-System/resources/views/cn-books/show.blade.php ENDPATH**/ ?>