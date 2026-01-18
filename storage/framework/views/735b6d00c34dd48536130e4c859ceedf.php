<?php $__env->startSection('title', 'Vendors'); ?>
<?php $__env->startSection('page-title', 'Vendors Management'); ?>

<?php $__env->startSection('content'); ?>
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0"> Vendors</h5>
        <a href="<?php echo e(route('vendors.create')); ?>" class="btn btn-primary btn-sm">
             Add Vendor
        </a>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Services</th>
                        <th>Contact</th>
                        <th>Billing Terms</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__empty_1 = true; $__currentLoopData = $vendors; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $vendor): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr>
                        <td><?php echo e($vendor->vendor_id); ?></td>
                        <td><?php echo e($vendor->name); ?></td>
                        <td><?php echo e(Str::limit($vendor->services, 30) ?? 'N/A'); ?></td>
                        <td><?php echo e($vendor->contact ?? 'N/A'); ?></td>
                        <td><?php echo e($vendor->billing_terms ?? 'N/A'); ?></td>
                        <td><span class="badge bg-<?php echo e($vendor->status === 'active' ? 'success' : 'secondary'); ?>"><?php echo e(ucfirst($vendor->status)); ?></span></td>
                        <td>
                            <a href="<?php echo e(route('vendors.show', $vendor)); ?>" class="btn btn-sm btn-outline-info">
                                
                            </a>
                            <a href="<?php echo e(route('vendors.edit', $vendor)); ?>" class="btn btn-sm btn-outline-primary">
                                
                            </a>
                            <form action="<?php echo e(route('vendors.destroy', $vendor)); ?>" method="POST" class="d-inline" onsubmit="return confirm('Are you sure?')">
                                <?php echo csrf_field(); ?>
                                <?php echo method_field('DELETE'); ?>
                                <button type="submit" class="btn btn-sm btn-outline-danger">
                                    
                                </button>
                            </form>
                        </td>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr>
                        <td colspan="7" class="text-center">No vendors found</td>
                    </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
        <div class="mt-3">
            <?php echo e($vendors->links()); ?>

        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>



<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/Logistics-Management-System/resources/views/vendors/index.blade.php ENDPATH**/ ?>