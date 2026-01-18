<?php $__env->startSection('title', 'Authorized Leaves'); ?>
<?php $__env->startSection('page-title', 'Authorized Leaves'); ?>

<?php $__env->startSection('content'); ?>
<!-- Page Header -->
<div class="page-header">
    <h1 class="page-title">
        
        Authorized Leaves
    </h1>
    <p class="page-subtitle">Manage authorized leaves for employees</p>
</div>

<div class="card">
    <div class="card-header">
        <div class="d-flex justify-content-between align-items-center">
            <h5 class="mb-0"> Authorized Leaves</h5>
            <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#addLeaveModal">
                 Add Leave Allocation
            </button>
        </div>
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
                        <th>Remaining</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__empty_1 = true; $__currentLoopData = $authorizedLeaves; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $leave): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
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
                        <td>
                            <button type="button" class="btn btn-sm btn-outline-primary">
                                
                            </button>
                        </td>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr>
                        <td colspan="7" class="text-center">No authorized leaves found</td>
                    </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Add Leave Modal -->
<div class="modal fade" id="addLeaveModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add Authorized Leave</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="<?php echo e(route('payroll.authorized-leaves.store')); ?>" method="POST">
                <?php echo csrf_field(); ?>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Employee <span class="text-danger">*</span></label>
                        <select class="form-select" name="employee_id" required>
                            <option value="">Select Employee</option>
                            <?php $__currentLoopData = $employees; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $employee): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($employee->emp_id); ?>"><?php echo e($employee->name); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Leave Type <span class="text-danger">*</span></label>
                        <select class="form-select" name="leave_type" required>
                            <option value="Annual">Annual</option>
                            <option value="Sick">Sick</option>
                            <option value="Casual">Casual</option>
                            <option value="Unpaid">Unpaid</option>
                            <option value="Other">Other</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Year <span class="text-danger">*</span></label>
                        <input type="number" class="form-control" name="year" value="<?php echo e(date('Y')); ?>" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Total Leaves <span class="text-danger">*</span></label>
                        <input type="number" class="form-control" name="total_leaves" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Used Leaves</label>
                        <input type="number" class="form-control" name="used_leaves" value="0">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Notes</label>
                        <textarea class="form-control" name="notes" rows="3"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/Logistics-Management-System/resources/views/payroll/authorized-leaves.blade.php ENDPATH**/ ?>