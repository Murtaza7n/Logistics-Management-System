<?php $__env->startSection('title', 'System Optimization'); ?>
<?php $__env->startSection('page-title', 'System Optimization'); ?>

<?php $__env->startSection('content'); ?>
<div class="page-header">
    <h1 class="page-title">
        <i class="bi bi-speedometer"></i> System Optimization
    </h1>
    <p class="page-subtitle">Optimize system performance and database</p>
</div>

<div class="card">
    <div class="card-header">
        <h5 class="mb-0">Optimization Options</h5>
    </div>
    <div class="card-body">
        <form method="POST" action="<?php echo e(route('system.run-optimization')); ?>" onsubmit="return confirm('Are you sure you want to run system optimization?');">
            <?php echo csrf_field(); ?>
            <div class="mb-4">
                <h6>Select Optimization Tasks:</h6>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="optimize_database" id="optimize_database" value="1" checked>
                    <label class="form-check-label" for="optimize_database">
                        Optimize Database Tables
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="clear_cache" id="clear_cache" value="1" checked>
                    <label class="form-check-label" for="clear_cache">
                        Clear Application Cache
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="rebuild_indexes" id="rebuild_indexes" value="1">
                    <label class="form-check-label" for="rebuild_indexes">
                        Rebuild Database Indexes
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="cleanup_logs" id="cleanup_logs" value="1">
                    <label class="form-check-label" for="cleanup_logs">
                        Cleanup Old Log Files
                    </label>
                </div>
            </div>
            <div class="alert alert-info">
                <i class="bi bi-info-circle"></i> System optimization will improve performance by cleaning up temporary files and optimizing database structure.
            </div>
            <button type="submit" class="btn btn-primary">
                <i class="bi bi-lightning-charge"></i> Run Optimization
            </button>
        </form>
    </div>
</div>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/Logistics-Management-System/resources/views/system/optimization.blade.php ENDPATH**/ ?>