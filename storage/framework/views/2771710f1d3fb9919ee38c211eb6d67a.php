<?php $__env->startSection('title', 'Initial Setup'); ?>
<?php $__env->startSection('page-title', 'Initial Setup'); ?>

<?php $__env->startSection('content'); ?>
<style>
.initial-setup-container {
    display: flex;
    gap: 20px;
    margin-top: 20px;
}

.left-column, .right-column {
    flex: 1;
    background: #f8f9fa;
    border-radius: 8px;
    padding: 15px;
}

.menu-item {
    padding: 12px 15px;
    margin-bottom: 5px;
    background: #e9ecef;
    border-radius: 4px;
    cursor: pointer;
    transition: all 0.3s;
    color: #333;
    text-decoration: none;
    display: block;
}

.menu-item:hover {
    background: #dee2e6;
    transform: translateX(5px);
}

.menu-item.active {
    background: #ffc107;
    color: #000;
    font-weight: 600;
}

.menu-item.active:hover {
    background: #ffb300;
}

.right-column .menu-item {
    background: #e9ecef;
}

.right-column .menu-item:hover {
    background: #dee2e6;
}

.content-area {
    margin-top: 20px;
    padding: 20px;
    background: white;
    border-radius: 8px;
    min-height: 200px;
}

.reference-no-section {
    margin-top: 20px;
    padding: 15px;
    background: #f8f9fa;
    border-radius: 4px;
}

.reference-no-section label {
    font-weight: 600;
    margin-bottom: 5px;
    display: block;
}
</style>

<div class="page-header">
    <h1 class="page-title">Initial Setup</h1>
    <p class="page-subtitle">Configure system master data and settings</p>
</div>

<div class="initial-setup-container">
    <!-- Left Column: Operational Tasks -->
    <div class="left-column">
        <h5 class="mb-3" style="color: #333; font-weight: 600;">Operational Tasks</h5>
        <a href="<?php echo e(route('logistics.initial-setup')); ?>" class="menu-item <?php echo e(request()->routeIs('logistics.initial-setup') ? 'active' : ''); ?>">
            Initial Setup
        </a>
        <a href="<?php echo e(route('bookings.index')); ?>" class="menu-item <?php echo e(request()->routeIs('bookings.*') ? 'active' : ''); ?>">
            Booking
        </a>
        <a href="<?php echo e(route('shipments.index')); ?>" class="menu-item <?php echo e(request()->routeIs('shipments.*') ? 'active' : ''); ?>">
            C/N Entry
        </a>
        <a href="<?php echo e(route('vehicle-load-plans.index')); ?>" class="menu-item <?php echo e(request()->routeIs('vehicle-load-plans.*') ? 'active' : ''); ?>">
            Vehicle Load Plan
        </a>
        <a href="<?php echo e(route('vehicle-load-plans.received')); ?>" class="menu-item <?php echo e(request()->routeIs('vehicle-load-plans.received') ? 'active' : ''); ?>">
            Vehicle Load Plan Received
        </a>
        <a href="<?php echo e(route('delivery-sheets.index')); ?>" class="menu-item <?php echo e(request()->routeIs('delivery-sheets.*') ? 'active' : ''); ?>">
            Delivery Sheet
        </a>
        <a href="<?php echo e(route('invoices.index')); ?>" class="menu-item <?php echo e(request()->routeIs('invoices.*') ? 'active' : ''); ?>">
            Invoices
        </a>
        <a href="<?php echo e(route('pickup-sheets.index')); ?>" class="menu-item <?php echo e(request()->routeIs('pickup-sheets.*') ? 'active' : ''); ?>">
            Pickup Sheet
        </a>
        <a href="<?php echo e(route('logistics.other-cn-expense-sheet')); ?>" class="menu-item <?php echo e(request()->routeIs('logistics.other-cn-expense-sheet') ? 'active' : ''); ?>">
            Other C/N Expense Sheet
        </a>
        <a href="<?php echo e(route('logistics.cn-delivery-reference-no')); ?>" class="menu-item <?php echo e(request()->routeIs('logistics.cn-delivery-reference-no') ? 'active' : ''); ?>">
            C/N Delivery Reference No
        </a>
        <a href="<?php echo e(route('logistics.party-fuel-rates')); ?>" class="menu-item <?php echo e(request()->routeIs('logistics.party-fuel-rates') ? 'active' : ''); ?>">
            Party Fuel Rates for C/N
        </a>
    </div>

    <!-- Right Column: Master Data Setup -->
    <div class="right-column">
        <h5 class="mb-3" style="color: #333; font-weight: 600;">Master Data Setup</h5>
        <a href="<?php echo e(route('master-data.item-codes')); ?>" class="menu-item <?php echo e(request()->routeIs('master-data.item-codes') ? 'active' : ''); ?>">
            Item Codes
        </a>
        <a href="<?php echo e(route('master-data.container-sizes')); ?>" class="menu-item <?php echo e(request()->routeIs('master-data.container-sizes') ? 'active' : ''); ?>">
            Container Sizes
        </a>
        <a href="<?php echo e(route('master-data.invoice-charges')); ?>" class="menu-item <?php echo e(request()->routeIs('master-data.invoice-charges') ? 'active' : ''); ?>">
            Invoice Charges
        </a>
        <a href="<?php echo e(route('master-data.cargo-officers')); ?>" class="menu-item <?php echo e(request()->routeIs('master-data.cargo-officers') ? 'active' : ''); ?>">
            SPO/Cargo Officers
        </a>
        <a href="<?php echo e(route('master-data.cargo-officer-stock-issue')); ?>" class="menu-item <?php echo e(request()->routeIs('master-data.cargo-officer-stock-issue') ? 'active' : ''); ?>">
            Cargo Officer-wise CN Stock Issue
        </a>
        <a href="<?php echo e(route('reports.list-of-city-codes')); ?>" class="menu-item <?php echo e(request()->routeIs('reports.list-of-city-codes') ? 'active' : ''); ?>">
            City Codes
        </a>
        <a href="<?php echo e(route('master-data.zone-codes')); ?>" class="menu-item <?php echo e(request()->routeIs('master-data.zone-codes') ? 'active' : ''); ?>">
            Zone Codes
        </a>
        <a href="<?php echo e(route('master-data.party-area-rates')); ?>" class="menu-item <?php echo e(request()->routeIs('master-data.party-area-rates') ? 'active' : ''); ?>">
            Party or Area-wise Rate
        </a>

        <!-- Reference No Input Section -->
        <div class="reference-no-section mt-4">
            <label for="reference_no">Reference No.</label>
            <input type="text" 
                   class="form-control" 
                   id="reference_no" 
                   name="reference_no" 
                   placeholder="Enter reference number">
        </div>
    </div>
</div>

<!-- Content Area (for future use) -->
<div class="content-area" id="contentArea" style="display: none;">
    <!-- Dynamic content will be loaded here -->
</div>

<script>
// Handle menu item clicks
document.querySelectorAll('.menu-item').forEach(item => {
    item.addEventListener('click', function(e) {
        // Remove active class from all items
        document.querySelectorAll('.menu-item').forEach(mi => {
            mi.classList.remove('active');
        });
        // Add active class to clicked item
        this.classList.add('active');
    });
});
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/Logistics-Management-System/resources/views/logistics/initial-setup.blade.php ENDPATH**/ ?>