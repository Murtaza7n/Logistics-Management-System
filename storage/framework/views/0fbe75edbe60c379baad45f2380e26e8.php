<?php $__env->startSection('title', 'Delivery Sheets'); ?>
<?php $__env->startSection('page-title', 'Delivery Sheets Management'); ?>

<?php $__env->startSection('content'); ?>
<div class="page-header">
    <div class="d-flex justify-content-between align-items-center flex-wrap">
        <div>
            <h1 class="page-title">Delivery Sheets</h1>
            <p class="page-subtitle">View and manage delivery sheets</p>
        </div>
        <div class="d-flex flex-wrap gap-2 mt-2 mt-md-0">
            <a href="<?php echo e(route('delivery-sheets.create')); ?>" class="btn btn-primary">
                New Delivery Sheet
            </a>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <h5 class="mb-0">All Delivery Sheets</h5>
    </div>
    <div class="card-body">
        <p class="text-muted">Delivery Sheets module is under development. This will allow you to manage delivery sheets.</p>
    </div>
</div>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/Logistics-Management-System/resources/views/delivery-sheets/index.blade.php ENDPATH**/ ?>