<?php $__env->startSection('title', 'Employee Master File'); ?>
<?php $__env->startSection('page-title', 'Employee Master File'); ?>

<?php $__env->startSection('content'); ?>
<!-- Page Header -->
<div class="page-header">
    <h1 class="page-title">
        
        Employee Master File
    </h1>
    <p class="page-subtitle">Complete employee information and management</p>
</div>

<div class="card">
    <div class="card-header">
        <h5 class="mb-0"> All Employees (<?php echo e($employees->count()); ?> records)</h5>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Employee ID</th>
                        <th>Name</th>
                        <th>Role</th>
                        <th>Contact</th>
                        <th>Email</th>
                        <th>Hire Date</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__empty_1 = true; $__currentLoopData = $employees; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $employee): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr>
                        <td><strong><?php echo e($employee->emp_id); ?></strong></td>
                        <td><?php echo e($employee->name); ?></td>
                        <td><?php echo e(ucfirst($employee->role)); ?></td>
                        <td><?php echo e($employee->contact ?? 'N/A'); ?></td>
                        <td><?php echo e($employee->email ?? 'N/A'); ?></td>
                        <td><?php echo e($employee->hire_date ? $employee->hire_date->format('Y-m-d') : 'N/A'); ?></td>
                        <td>
                            <span class="badge badge-<?php echo e($employee->status === 'active' ? 'primary' : 'secondary'); ?>">
                                <?php echo e(ucfirst($employee->status)); ?>

                            </span>
                        </td>
                        <td>
                            <a href="<?php echo e(route('employees.show', $employee)); ?>" class="btn btn-sm btn-outline-primary">
                                
                            </a>
                            <a href="<?php echo e(route('employees.edit', $employee)); ?>" class="btn btn-sm btn-outline-secondary">
                                
                            </a>
                        </td>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr>
                        <td colspan="8" class="text-center">No employees found</td>
                    </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/Logistics-Management-System/resources/views/payroll/employee-master.blade.php ENDPATH**/ ?>