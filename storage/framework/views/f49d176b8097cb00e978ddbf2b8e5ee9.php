<?php $__env->startSection('title', '$(echo $report | tr "-" " " | sed "s/\b\(.\)/\u\1/g")'); ?>
<?php $__env->startSection('content'); ?>
<div class="page-header"><h1>$(echo $report | tr "-" " " | sed "s/\b\(.\)/\u\1/g")</h1></div>
<div class="card"><div class="card-body"><p>Report page. Under development.</p></div></div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/Logistics-Management-System/resources/views/reports/cn-detail-account-cod-status.blade.php ENDPATH**/ ?>