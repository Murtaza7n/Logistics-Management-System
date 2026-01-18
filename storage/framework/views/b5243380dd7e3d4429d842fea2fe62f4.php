<?php $__env->startSection('title', 'List of Employees'); ?>
<?php $__env->startSection('page-title', 'List of Employees'); ?>

<?php $__env->startSection('content'); ?>
<!-- Page Header -->
<div class="page-header">
    <h1 class="page-title">
        
        List of Employees
    </h1>
    <p class="page-subtitle">Complete list of all employees</p>
</div>

<div class="card">
    <div class="card-header">
        <h5 class="mb-0"> Filters</h5>
    </div>
    <div class="card-body">
        <form method="GET" action="<?php echo e(route('reports.list-of-employees')); ?>" class="row g-3">
            <div class="col-md-3">
                <label class="form-label">Status</label>
                <select name="status" class="form-select">
                    <option value="">All Status</option>
                    <option value="active" <?php echo e(request('status') == 'active' ? 'selected' : ''); ?>>Active</option>
                    <option value="inactive" <?php echo e(request('status') == 'inactive' ? 'selected' : ''); ?>>Inactive</option>
                </select>
            </div>
            <div class="col-md-3">
                <label class="form-label">Department</label>
                <select name="department_id" class="form-select">
                    <option value="">All Departments</option>
                    <?php $__currentLoopData = $departments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $dept): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($dept->id); ?>" <?php echo e(request('department_id') == $dept->id ? 'selected' : ''); ?>><?php echo e($dept->name); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </div>
            <div class="col-md-3">
                <label class="form-label">Designation</label>
                <select name="designation_id" class="form-select">
                    <option value="">All Designations</option>
                    <?php $__currentLoopData = $designations; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $desig): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($desig->id); ?>" <?php echo e(request('designation_id') == $desig->id ? 'selected' : ''); ?>><?php echo e($desig->name); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
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
        <h5 class="mb-0"> Employees (<?php echo e($employees->count()); ?> records)</h5>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Employee ID</th>
                        <th>Name</th>
                        <th>Department</th>
                        <th>Designation</th>
                        <th>Contact</th>
                        <th>Email</th>
                        <th>Hire Date</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__empty_1 = true; $__currentLoopData = $employees; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $employee): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr>
                        <td><strong><?php echo e($employee->emp_id); ?></strong></td>
                        <td><?php echo e($employee->name); ?></td>
                        <td><?php echo e($employee->department->name ?? 'N/A'); ?></td>
                        <td><?php echo e($employee->designation->name ?? 'N/A'); ?></td>
                        <td><?php echo e($employee->contact ?? 'N/A'); ?></td>
                        <td><?php echo e($employee->email ?? 'N/A'); ?></td>
                        <td><?php echo e($employee->hire_date ? $employee->hire_date->format('Y-m-d') : 'N/A'); ?></td>
                        <td>
                            <span class="badge badge-<?php echo e($employee->status === 'active' ? 'primary' : 'secondary'); ?>">
                                <?php echo e(ucfirst($employee->status)); ?>

                            </span>
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


<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/Logistics-Management-System/resources/views/reports/list_of_employees.blade.php ENDPATH**/ ?>