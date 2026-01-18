<?php $__env->startSection('title', 'Employees'); ?>
<?php $__env->startSection('page-title', 'Employees Management'); ?>

<?php $__env->startSection('content'); ?>
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0"> Employees</h5>
        <a href="<?php echo e(route('employees.create')); ?>" class="btn btn-primary btn-sm">
             Add Employee
        </a>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Department</th>
                        <th>Designation</th>
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
                        <td><?php echo e($employee->department->name ?? 'N/A'); ?></td>
                        <td><?php echo e($employee->designation->name ?? 'N/A'); ?></td>
                        <td><?php echo e($employee->contact ?? 'N/A'); ?></td>
                        <td><?php echo e($employee->email ?? 'N/A'); ?></td>
                        <td><?php echo e($employee->hire_date ? \Carbon\Carbon::parse($employee->hire_date)->format('Y-m-d') : 'N/A'); ?></td>
                        <td>
                            <span class="badge bg-<?php echo e($employee->status === 'active' ? 'success' : 'secondary'); ?>">
                                <?php echo e(ucfirst($employee->status)); ?>

                            </span>
                        </td>
                        <td>
                            <a href="<?php echo e(route('employees.show', $employee)); ?>" class="btn btn-sm btn-outline-info" title="View">
                                <i class="bi bi-eye"></i>
                            </a>
                            <a href="<?php echo e(route('employees.edit', $employee)); ?>" class="btn btn-sm btn-outline-primary" title="Edit">
                                <i class="bi bi-pencil"></i>
                            </a>
                            <form action="<?php echo e(route('employees.destroy', $employee)); ?>" method="POST" class="d-inline" onsubmit="return confirm('Are you sure?')">
                                <?php echo csrf_field(); ?>
                                <?php echo method_field('DELETE'); ?>
                                <button type="submit" class="btn btn-sm btn-outline-danger" title="Delete">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr>
                        <td colspan="7" class="text-center">No employees found</td>
                    </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
        <div class="mt-3">
            <?php echo e($employees->links()); ?>

        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>



<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/Logistics-Management-System/resources/views/employees/index.blade.php ENDPATH**/ ?>