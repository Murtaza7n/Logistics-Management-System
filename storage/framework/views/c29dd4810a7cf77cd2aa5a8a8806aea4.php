<?php $__env->startSection('title', 'Reports'); ?>
<?php $__env->startSection('page-title', 'Reports'); ?>

<?php $__env->startSection('content'); ?>
<!-- Page Header -->
<div class="page-header">
    <h1 class="page-title">
        
        Reports & Analytics
    </h1>
    <p class="page-subtitle">Generate comprehensive reports for logistics and finance operations</p>
</div>

<div class="row">
    <!-- Logistics Reports -->
    <div class="col-md-6 mb-4">
        <div class="card">
            <div class="card-header" style="background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-dark) 100%);">
                <h5 class="mb-0"> Logistics Reports</h5>
            </div>
            <div class="card-body">
                <div class="list-group list-group-flush">
                    <a href="<?php echo e(route('reports.cn-detail')); ?>" class="list-group-item list-group-item-action">
                         C/Ns Detail
                    </a>
                    <a href="<?php echo e(route('reports.list-of-invoices')); ?>" class="list-group-item list-group-item-action">
                         List of Invoices
                    </a>
                    <a href="<?php echo e(route('reports.cn-status')); ?>" class="list-group-item list-group-item-action">
                         C/N Status (Detail)
                    </a>
                    <a href="<?php echo e(route('reports.cn-status')); ?>" class="list-group-item list-group-item-action">
                         C/N Status
                    </a>
                    <a href="<?php echo e(route('reports.cn-profit-loss')); ?>" class="list-group-item list-group-item-action">
                         C/N Profit Loss
                    </a>
                    <a href="<?php echo e(route('reports.city-wise-profit-loss')); ?>" class="list-group-item list-group-item-action">
                         City-wise Profit Loss
                    </a>
                    <a href="<?php echo e(route('reports.shipper-wise-profit-loss')); ?>" class="list-group-item list-group-item-action">
                         Shipper-wise Profit Loss
                    </a>
                    <a href="<?php echo e(route('reports.delivery-cn-detail')); ?>" class="list-group-item list-group-item-action">
                         Delivery CN Detail
                    </a>
                    <a href="<?php echo e(route('reports.stock-in-transit')); ?>" class="list-group-item list-group-item-action">
                         Stock in Transit
                    </a>
                    <a href="<?php echo e(route('reports.cn-in-stock')); ?>" class="list-group-item list-group-item-action">
                         C/N In-Stock
                    </a>
                    <a href="<?php echo e(route('reports.vehicle-usage')); ?>" class="list-group-item list-group-item-action">
                         Vehicle Usage Report
                    </a>
                    <a href="<?php echo e(route('reports.driver-performance')); ?>" class="list-group-item list-group-item-action">
                         Driver Performance
                    </a>
                    <a href="<?php echo e(route('reports.customer-wise')); ?>" class="list-group-item list-group-item-action">
                         Customer-wise Reports
                    </a>
                    <a href="<?php echo e(route('reports.vendor-wise')); ?>" class="list-group-item list-group-item-action">
                         Vendor-wise Reports
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Finance Reports -->
    <div class="col-md-6 mb-4">
        <div class="card">
            <div class="card-header" style="background: linear-gradient(135deg, var(--success-color) 0%, #059669 100%);">
                <h5 class="mb-0"> Finance Reports</h5>
            </div>
            <div class="card-body">
                <div class="list-group list-group-flush">
                    <a href="<?php echo e(route('reports.revenue')); ?>" class="list-group-item list-group-item-action">
                         Revenue Report
                    </a>
                    <a href="<?php echo e(route('reports.list-of-invoices')); ?>" class="list-group-item list-group-item-action">
                         List of Invoices
                    </a>
                    <a href="<?php echo e(route('reports.list-of-pending-invoices')); ?>" class="list-group-item list-group-item-action">
                         List of Pending Invoices
                    </a>
                    <a href="<?php echo e(route('reports.list-of-missing-cn-nos')); ?>" class="list-group-item list-group-item-action">
                         List of Missing C/N Nos.
                    </a>
                    <a href="<?php echo e(route('reports.group-party-outstanding')); ?>" class="list-group-item list-group-item-action">
                         Group/Party Outstanding with S/Tax
                    </a>
                    <a href="<?php echo e(route('reports.payroll')); ?>" class="list-group-item list-group-item-action">
                         Payroll Reports
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Master Lists -->
    <div class="col-md-6 mb-4">
        <div class="card">
            <div class="card-header" style="background: linear-gradient(135deg, var(--info-color) 0%, #0891b2 100%);">
                <h5 class="mb-0"> Master Lists</h5>
            </div>
            <div class="card-body">
                <div class="list-group list-group-flush">
                    <a href="<?php echo e(route('reports.list-of-city-codes')); ?>" class="list-group-item list-group-item-action">
                         List of City Codes
                    </a>
                    <a href="<?php echo e(route('reports.list-of-vehicle-types')); ?>" class="list-group-item list-group-item-action">
                         List of Vehicle Types
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Payroll Reports -->
    <div class="col-md-6 mb-4">
        <div class="card">
            <div class="card-header" style="background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-dark) 100%);">
                <h5 class="mb-0"> Payroll Reports</h5>
            </div>
            <div class="card-body">
                <div class="list-group list-group-flush">
                    <a href="<?php echo e(route('reports.list-of-employees')); ?>" class="list-group-item list-group-item-action">
                         List of Employees
                    </a>
                    <a href="<?php echo e(route('reports.list-of-monthly-deduction-allowances')); ?>" class="list-group-item list-group-item-action">
                         List of Monthly Deduction/Allowances
                    </a>
                    <a href="<?php echo e(route('reports.employees-authorized-leaves-detail')); ?>" class="list-group-item list-group-item-action">
                         Employee's Authorized Leaves Detail
                    </a>
                    <a href="<?php echo e(route('reports.employees-leaves-status')); ?>" class="list-group-item list-group-item-action">
                         Employee's Leaves Status
                    </a>
                    <a href="<?php echo e(route('reports.department-wise-monthly-payroll-register')); ?>" class="list-group-item list-group-item-action">
                         Department-wise Monthly Payroll Register
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/Logistics-Management-System/resources/views/reports/index.blade.php ENDPATH**/ ?>