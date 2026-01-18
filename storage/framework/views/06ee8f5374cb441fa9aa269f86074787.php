<?php $__env->startSection('title', 'Employee\'s Leaves Status'); ?>
<?php $__env->startSection('page-title', 'Employee\'s Leaves Status'); ?>

<?php $__env->startSection('content'); ?>
<!-- Page Header -->
<div class="page-header">
    <h1 class="page-title">
        
        Employee's Leaves Status
    </h1>
    <p class="page-subtitle">Current leave status for all employees</p>
</div>

<div class="card">
    <div class="card-header">
        <h5 class="mb-0"> Filters</h5>
    </div>
    <div class="card-body">
        <form method="GET" action="<?php echo e(route('reports.employees-leaves-status')); ?>" class="row g-3">
            <div class="col-md-3">
                <label class="form-label">Year</label>
                <input type="number" class="form-control" name="year" value="<?php echo e(request('year', date('Y'))); ?>">
            </div>
            <div class="col-md-3">
                <label class="form-label">&nbsp;</label>
                <div>
                    <button type="submit" class="btn btn-primary w-100">
                         Filter
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <h5 class="mb-0"> Employees Leaves Status (<?php echo e($employeeLeaves->count()); ?> employees)</h5>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Employee</th>
                        <th>Leave Type</th>
                        <th>Total</th>
                        <th>Used</th>
                        <th>Remaining</th>
                        <th>Year</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__empty_1 = true; $__currentLoopData = $employeeLeaves; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $employeeData): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <?php $__currentLoopData = $employeeData['leaves']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $leave): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr>
                        <td><strong><?php echo e($employeeData['employee']->name ?? 'N/A'); ?></strong></td>
                        <td><?php echo e($leave->leave_type); ?></td>
                        <td><?php echo e($leave->total_leaves); ?></td>
                        <td><?php echo e($leave->used_leaves); ?></td>
                        <td>
                            <span class="badge badge-<?php echo e($leave->remaining_leaves > 0 ? 'primary' : 'dark'); ?>">
                                <?php echo e($leave->remaining_leaves); ?>

                            </span>
                        </td>
                        <td><?php echo e($leave->year); ?></td>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr>
                        <td colspan="6" class="text-center">No records found</td>
                    </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/Logistics-Management-System/resources/views/reports/employees_leaves_status.blade.php ENDPATH**/ ?>