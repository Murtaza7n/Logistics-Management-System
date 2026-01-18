<?php $__env->startSection('title', 'Monthly Deduction/Allowances'); ?>
<?php $__env->startSection('page-title', 'Monthly Deduction/Allowances'); ?>

<?php $__env->startSection('content'); ?>
<!-- Page Header -->
<div class="page-header">
    <h1 class="page-title">
        
        Monthly Deduction/Allowances
    </h1>
    <p class="page-subtitle">Manage monthly deductions and allowances for employees</p>
</div>

<div class="card">
    <div class="card-header">
        <div class="d-flex justify-content-between align-items-center">
            <h5 class="mb-0"> Monthly Deductions/Allowances</h5>
            <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#addDeductionAllowanceModal">
                 Add Entry
            </button>
        </div>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Employee</th>
                        <th>Month/Year</th>
                        <th>Deduction Type</th>
                        <th>Deduction Amount</th>
                        <th>Allowance Type</th>
                        <th>Allowance Amount</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__empty_1 = true; $__currentLoopData = $deductionsAllowances; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr>
                        <td><strong><?php echo e($item->employee->name ?? 'N/A'); ?></strong></td>
                        <td><?php echo e(date('F', mktime(0, 0, 0, $item->month, 1))); ?> <?php echo e($item->year); ?></td>
                        <td><?php echo e($item->deduction_type ?? 'N/A'); ?></td>
                        <td>Rs.<?php echo e(number_format($item->deduction_amount, 2)); ?></td>
                        <td><?php echo e($item->allowance_type ?? 'N/A'); ?></td>
                        <td>Rs.<?php echo e(number_format($item->allowance_amount, 2)); ?></td>
                        <td>
                            <button type="button" class="btn btn-sm btn-outline-primary">
                                
                            </button>
                        </td>
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

<!-- Add Deduction/Allowance Modal -->
<div class="modal fade" id="addDeductionAllowanceModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add Monthly Deduction/Allowance</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="<?php echo e(route('payroll.deductions-allowances.store')); ?>" method="POST">
                <?php echo csrf_field(); ?>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Employee <span class="text-danger">*</span></label>
                            <select class="form-select" name="employee_id" required>
                                <option value="">Select Employee</option>
                                <?php $__currentLoopData = $employees; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $employee): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($employee->emp_id); ?>"><?php echo e($employee->name); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>
                        <div class="col-md-3 mb-3">
                            <label class="form-label">Month <span class="text-danger">*</span></label>
                            <select class="form-select" name="month" required>
                                <?php for($i = 1; $i <= 12; $i++): ?>
                                <option value="<?php echo e($i); ?>" <?php echo e($i == date('n') ? 'selected' : ''); ?>><?php echo e(date('F', mktime(0, 0, 0, $i, 1))); ?></option>
                                <?php endfor; ?>
                            </select>
                        </div>
                        <div class="col-md-3 mb-3">
                            <label class="form-label">Year <span class="text-danger">*</span></label>
                            <input type="number" class="form-control" name="year" value="<?php echo e(date('Y')); ?>" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Deduction Type</label>
                            <select class="form-select" name="deduction_type">
                                <option value="">Select Type</option>
                                <option value="Tax">Tax</option>
                                <option value="PF">Provident Fund</option>
                                <option value="Insurance">Insurance</option>
                                <option value="Loan">Loan</option>
                                <option value="Other">Other</option>
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Deduction Amount</label>
                            <input type="number" step="0.01" class="form-control" name="deduction_amount" value="0">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Allowance Type</label>
                            <select class="form-select" name="allowance_type">
                                <option value="">Select Type</option>
                                <option value="Transport">Transport</option>
                                <option value="Medical">Medical</option>
                                <option value="Housing">Housing</option>
                                <option value="Food">Food</option>
                                <option value="Other">Other</option>
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Allowance Amount</label>
                            <input type="number" step="0.01" class="form-control" name="allowance_amount" value="0">
                        </div>
                        <div class="col-md-12 mb-3">
                            <label class="form-label">Description</label>
                            <textarea class="form-control" name="description" rows="3"></textarea>
                        </div>
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


<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/Logistics-Management-System/resources/views/payroll/deductions-allowances.blade.php ENDPATH**/ ?>