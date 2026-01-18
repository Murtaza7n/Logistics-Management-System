<?php $__env->startSection('title', 'Data Processing'); ?>
<?php $__env->startSection('page-title', 'Data Processing'); ?>

<?php $__env->startSection('content'); ?>
<div class="page-header">
    <h1 class="page-title">
        <i class="bi bi-gear"></i> Data Processing
    </h1>
    <p class="page-subtitle">Process and update system data</p>
</div>

<div class="card">
    <div class="card-header">
        <h5 class="mb-0">Data Processing Options</h5>
    </div>
    <div class="card-body">
        <form method="POST" action="<?php echo e(route('system.process-data')); ?>" onsubmit="return confirm('Are you sure you want to process the data? This action cannot be undone.');">
            <?php echo csrf_field(); ?>
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">Processing Type</label>
                        <select class="form-select" name="processing_type" required>
                            <option value="">Select Processing Type</option>
                            <option value="update_statuses">Update Shipment Statuses</option>
                            <option value="recalculate_totals">Recalculate Totals</option>
                            <option value="sync_data">Sync Data Across Modules</option>
                            <option value="cleanup_old">Cleanup Old Records</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">Date Range (Optional)</label>
                        <div class="input-group">
                            <input type="date" class="form-control" name="date_from">
                            <span class="input-group-text">to</span>
                            <input type="date" class="form-control" name="date_to">
                        </div>
                    </div>
                </div>
            </div>
            <div class="alert alert-warning">
                <i class="bi bi-exclamation-triangle"></i> <strong>Warning:</strong> Data processing may take several minutes. Please do not close this page during processing.
            </div>
            <button type="submit" class="btn btn-primary">
                <i class="bi bi-play-circle"></i> Process Data
            </button>
        </form>
    </div>
</div>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/Logistics-Management-System/resources/views/system/data-processing.blade.php ENDPATH**/ ?>