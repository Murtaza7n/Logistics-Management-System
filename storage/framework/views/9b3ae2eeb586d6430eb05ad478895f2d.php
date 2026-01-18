<?php $__env->startSection('title', 'Invoice Details'); ?>
<?php $__env->startSection('page-title', 'Invoice Details'); ?>

<?php $__env->startSection('content'); ?>
<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0"> Invoice: <?php echo e($invoice->invoice_number); ?></h5>
            </div>
            <div class="card-body">
                <table class="table table-borderless">
                    <tr>
                        <th width="40%">Invoice Number:</th>
                        <td><?php echo e($invoice->invoice_number); ?></td>
                    </tr>
                    <tr>
                        <th>Type:</th>
                        <td><span class="badge bg-<?php echo e($invoice->invoice_type === 'customer' ? 'primary' : 'info'); ?>"><?php echo e(ucfirst($invoice->invoice_type)); ?></span></td>
                    </tr>
                    <tr>
                        <th><?php echo e($invoice->invoice_type === 'customer' ? 'Customer' : 'Vendor'); ?>:</th>
                        <td><?php echo e($invoice->customer->name ?? $invoice->vendor->name); ?></td>
                    </tr>
                    <tr>
                        <th>Invoice Date:</th>
                        <td><?php echo e($invoice->invoice_date->format('M d, Y')); ?></td>
                    </tr>
                    <tr>
                        <th>Due Date:</th>
                        <td><?php echo e($invoice->due_date?->format('M d, Y') ?? 'N/A'); ?></td>
                    </tr>
                    <tr>
                        <th>Subtotal:</th>
                        <td>Rs.<?php echo e(number_format($invoice->subtotal, 2)); ?></td>
                    </tr>
                    <tr>
                        <th>Tax (<?php echo e($invoice->tax_rate); ?>%):</th>
                        <td>Rs.<?php echo e(number_format($invoice->tax_amount, 2)); ?></td>
                    </tr>
                    <tr>
                        <th>Discount:</th>
                        <td>Rs.<?php echo e(number_format($invoice->discount, 2)); ?></td>
                    </tr>
                    <tr>
                        <th><strong>Total:</strong></th>
                        <td><strong>Rs.<?php echo e(number_format($invoice->total, 2)); ?></strong></td>
                    </tr>
                    <tr>
                        <th>Total Paid:</th>
                        <td>Rs.<?php echo e(number_format($invoice->total_paid, 2)); ?></td>
                    </tr>
                    <tr>
                        <th>Balance:</th>
                        <td><strong>Rs.<?php echo e(number_format($invoice->balance, 2)); ?></strong></td>
                    </tr>
                    <tr>
                        <th>Status:</th>
                        <td><span class="badge bg-<?php echo e($invoice->status === 'paid' ? 'success' : ($invoice->status === 'overdue' ? 'danger' : 'warning')); ?>"><?php echo e(ucfirst($invoice->status)); ?></span></td>
                    </tr>
                </table>
                
                <h6 class="mt-4">Shipments:</h6>
                <div class="table-responsive">
                    <table class="table table-sm">
                        <thead>
                            <tr>
                                <th>Shipment #</th>
                                <th>Amount</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__currentLoopData = $invoice->shipments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $shipment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <td><a href="<?php echo e(route('shipments.show', $shipment)); ?>"><?php echo e($shipment->shipment_number); ?></a></td>
                                <td>Rs.<?php echo e(number_format($shipment->pivot->amount, 2)); ?></td>
                            </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                </div>

                <h6 class="mt-4">Payments:</h6>
                <?php if($invoice->payments->count() > 0): ?>
                <div class="table-responsive">
                    <table class="table table-sm">
                        <thead>
                            <tr>
                                <th>Date</th>
                                <th>Amount</th>
                                <th>Method</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__currentLoopData = $invoice->payments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $payment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <td><?php echo e($payment->payment_date->format('M d, Y')); ?></td>
                                <td>Rs.<?php echo e(number_format($payment->amount_paid, 2)); ?></td>
                                <td><?php echo e(ucfirst(str_replace('_', ' ', $payment->method))); ?></td>
                            </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                </div>
                <?php else: ?>
                <p class="text-muted">No payments recorded yet.</p>
                <?php endif; ?>

                <div class="mt-3">
                    <a href="<?php echo e(route('payments.create', ['invoice_id' => $invoice->invoice_id])); ?>" class="btn btn-success">
                         Record Payment
                    </a>
                    <a href="<?php echo e(route('invoices.index')); ?>" class="btn btn-secondary">
                         Back
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>



<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/Logistics-Management-System/resources/views/invoices/show.blade.php ENDPATH**/ ?>