<?php $__env->startSection('title', 'Customers'); ?>
<?php $__env->startSection('page-title', 'Customers Management'); ?>

<?php $__env->startSection('content'); ?>
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0"> Customers</h5>
        <a href="<?php echo e(route('customers.create')); ?>" class="btn btn-primary btn-sm">
             Add Customer
        </a>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Contact</th>
                        <th>Email</th>
                        <th>City</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__empty_1 = true; $__currentLoopData = $customers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $customer): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr>
                        <td><?php echo e($customer->customer_id); ?></td>
                        <td><?php echo e($customer->name); ?></td>
                        <td><?php echo e($customer->contact ?? 'N/A'); ?></td>
                        <td><?php echo e($customer->email ?? 'N/A'); ?></td>
                        <td><?php echo e($customer->city ?? 'N/A'); ?></td>
                        <td><span class="badge bg-<?php echo e($customer->status === 'active' ? 'success' : 'secondary'); ?>"><?php echo e(ucfirst($customer->status)); ?></span></td>
                        <td>
                            <a href="<?php echo e(route('customers.show', $customer)); ?>" class="btn btn-sm btn-outline-info">
                                
                            </a>
                            <a href="<?php echo e(route('customers.edit', $customer)); ?>" class="btn btn-sm btn-outline-primary">
                                
                            </a>
                            <form action="<?php echo e(route('customers.destroy', $customer)); ?>" method="POST" class="d-inline" onsubmit="return confirm('Are you sure?')">
                                <?php echo csrf_field(); ?>
                                <?php echo method_field('DELETE'); ?>
                                <button type="submit" class="btn btn-sm btn-outline-danger">
                                    
                                </button>
                            </form>
                        </td>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr>
                        <td colspan="7" class="text-center">No customers found</td>
                    </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
        <div class="mt-3">
            <?php echo e($customers->links()); ?>

        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>



<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/Logistics-Management-System/resources/views/customers/index.blade.php ENDPATH**/ ?>