<?php $__env->startSection('title', 'Cargo Officer Stock Issue'); ?>
<?php $__env->startSection('page-title', 'Cargo Officer-wise CN Stock Issue'); ?>

<?php $__env->startSection('content'); ?>
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
                    <?php $__currentLoopData = $cargoOfficers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $officer): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($officer->id); ?>" <?php echo e(request('officer_id') == $officer->id ? 'selected' : ''); ?>>
                        <?php echo e($officer->officer_code); ?> - <?php echo e($officer->officer_name); ?>

                    </option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </div>
            <div class="col-md-2">
                <button type="submit" class="btn btn-primary w-100">Filter</button>
            </div>
            <div class="col-md-2">
                <a href="<?php echo e(route('master-data.cargo-officer-stock-issue')); ?>" class="btn btn-secondary w-100">Reset</a>
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
                    <?php $__empty_1 = true; $__currentLoopData = $stockIssues; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $issue): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr>
                        <td><strong><?php echo e($issue->book_number ?? '-'); ?></strong></td>
                        <td><?php echo e($issue->officer_code ?? '-'); ?></td>
                        <td><?php echo e($issue->officer_name ?? '-'); ?></td>
                        <td><?php echo e($issue->city_code ?? '-'); ?></td>
                        <td><?php echo e($issue->start_number ?? '-'); ?></td>
                        <td><?php echo e($issue->end_number ?? '-'); ?></td>
                        <td><?php echo e($issue->total_numbers ?? '-'); ?></td>
                        <td><?php echo e($issue->issued_count ?? 0); ?></td>
                        <td>
                            <span class="badge bg-<?php echo e(($issue->remaining_count ?? 0) > 0 ? 'success' : 'danger'); ?>">
                                <?php echo e($issue->remaining_count ?? 0); ?>

                            </span>
                        </td>
                        <td>
                            <span class="badge bg-<?php echo e($issue->status === 'active' ? 'success' : ($issue->status === 'exhausted' ? 'danger' : 'secondary')); ?>">
                                <?php echo e(ucfirst($issue->status ?? 'unknown')); ?>

                            </span>
                        </td>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr>
                        <td colspan="10" class="text-center text-muted">No CN stock issues found.</td>
                    </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <div class="mt-3">
            <?php echo e($stockIssues->links()); ?>

        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/Logistics-Management-System/resources/views/master-data/cargo-officer-stock-issue.blade.php ENDPATH**/ ?>