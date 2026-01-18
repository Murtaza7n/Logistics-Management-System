<?php $__env->startSection('title', '$(echo $method | tr "-" " " | sed "s/\b\(.\)/\u\1/g")'); ?>
<?php $__env->startSection('page-title', '$(echo $method | tr "-" " " | sed "s/\b\(.\)/\u\1/g")'); ?>

<?php $__env->startSection('content'); ?>
<div class="page-header">
    <h1 class="page-title">$(echo $method | tr "-" " " | sed "s/\b\(.\)/\u\1/g")</h1>
</div>
<div class="card">
    <div class="card-body">
        <p class="text-muted">This page is under development.</p>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/Logistics-Management-System/resources/views/finance/cn-wise-expenses-detail.blade.php ENDPATH**/ ?>