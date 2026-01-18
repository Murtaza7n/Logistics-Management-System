<?php $__env->startSection('title', 'Employee\'s Authorized Leaves Detail'); ?>
<?php $__env->startSection('page-title', 'Employee\'s Authorized Leaves Detail'); ?>

<?php $__env->startSection('content'); ?>
<!-- Page Header -->
<div class="page-header">
    <h1 class="page-title">
        
        Employee's Authorized Leaves Detail
    </h1>
    <p class="page-subtitle">Detailed authorized leaves information for employees</p>
</div>

<div class="card">
    <div class="card-header">
        <h5 class="mb-0"> Filters</h5>
    </div>
    <div class="card-body">
        <form method="GET" action="<?php echo e(route('reports.employees-authorized-leaves-detail')); ?>" class="row g-3">
            <div class="col-md-3">
                <label class="form-label">Employee</label>
                <select name="employee_id" class="form-select">
                    <option value="">All Employees</option>
                    <?php $__currentLoopData = $employees; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $employee): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($employee->emp_id); ?>" <?php echo e(request('employee_id') == $employee->emp_id ? 'selected' : ''); ?>><?php echo e($employee->name); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </div>
            <div class="col-md-3">
                <label class="form-label">Leave Type</label>
                <select name="leave_type" class="form-select">
                    <option value="">All Types</option>
                    <option value="Annual" <?php echo e(request('leave_type') == 'Annual' ? 'selected' : ''); ?>>Annual</option>
                    <option value="Sick" <?php echo e(request('leave_type') == 'Sick' ? 'selected' : ''); ?>>Sick</option>
                    <option value="Casual" <?php echo e(request('leave_type') == 'Casual' ? 'selected' : ''); ?>>Casual</option>
                    <option value="Unpaid" <?php echo e(request('leave_type') == 'Unpaid' ? 'selected' : ''); ?>>Unpaid</option>
                </select>
            </div>
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
        <h5 class="mb-0"> Authorized Leaves (<?php echo e($leaves->count()); ?> records)</h5>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Employee</th>
                        <th>Leave Type</th>
                        <th>Year</th>
                        <th>Total Leaves</th>
                        <th>Used Leaves</th>
                        <th>Remaining Leaves</th>
                        <th>Notes</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__empty_1 = true; $__currentLoopData = $leaves; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $leave): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr>
                        <td><strong><?php echo e($leave->employee->name ?? 'N/A'); ?></strong></td>
                        <td><?php echo e($leave->leave_type); ?></td>
                        <td><?php echo e($leave->year); ?></td>
                        <td><?php echo e($leave->total_leaves); ?></td>
                        <td><?php echo e($leave->used_leaves); ?></td>
                        <td>
                            <span class="badge badge-<?php echo e($leave->remaining_leaves > 0 ? 'primary' : 'dark'); ?>">
                                <?php echo e($leave->remaining_leaves); ?>

                            </span>
                        </td>
                        <td><?php echo e($leave->notes ?? 'N/A'); ?></td>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr>
                        <td colspan="7" class="text-center">No records found</td>
                    </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/Logistics-Management-System/resources/views/reports/employees_authorized_leaves_detail.blade.php ENDPATH**/ ?>