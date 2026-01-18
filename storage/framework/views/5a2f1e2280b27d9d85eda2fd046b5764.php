<?php $__env->startSection('title', 'List of Missing C/N Nos.'); ?>
<?php $__env->startSection('page-title', 'List of Missing C/N Nos.'); ?>

<?php $__env->startSection('content'); ?>
<!-- Page Header -->
<div class="page-header">
    <h1 class="page-title">
        
        List of Missing C/N Nos.
    </h1>
    <p class="page-subtitle">Gaps in consignment note number sequence</p>
</div>

<div class="card">
    <div class="card-header">
        <h5 class="mb-0"> Missing CN Numbers</h5>
    </div>
    <div class="card-body">
        <?php if(count($missing) > 0): ?>
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Missing CN Number</th>
                        <th>Expected Range</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__currentLoopData = $missing; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $missingCn): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr>
                        <td><strong><?php echo e($missingCn['number']); ?></strong></td>
                        <td><?php echo e($missingCn['range'] ?? 'N/A'); ?></td>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
            </table>
        </div>
        <?php else: ?>
        <div class="alert alert-info">
             No missing CN numbers found. All sequences are complete.
        </div>
        <?php endif; ?>
    </div>
</div>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/Logistics-Management-System/resources/views/reports/list_of_missing_cn_nos.blade.php ENDPATH**/ ?>