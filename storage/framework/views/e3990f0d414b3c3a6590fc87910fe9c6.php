<!DOCTYPE html>
<html>
<head>
    <title>Payslip - <?php echo e($payroll->employee->name); ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        @media print {
            .no-print { display: none; }
        }
        body { padding: 20px; }
    </style>
</head>
<body>
    <div class="container">
        <div class="card">
            <div class="card-header text-center">
                <h3>PAYSLIP</h3>
                <p class="mb-0">Logistics Management System</p>
            </div>
            <div class="card-body">
                <div class="row mb-4">
                    <div class="col-md-6">
                        <strong>Employee Information:</strong><br>
                        Name: <?php echo e($payroll->employee->name); ?><br>
                        Employee ID: <?php echo e($payroll->employee->emp_id); ?><br>
                        Contact: <?php echo e($payroll->employee->contact ?? 'N/A'); ?>

                    </div>
                    <div class="col-md-6 text-end">
                        <strong>Payroll Details:</strong><br>
                        Payroll ID: <?php echo e($payroll->payroll_id); ?><br>
                        Month: <?php echo e($payroll->month); ?><br>
                        Payment Date: <?php echo e($payroll->payment_date?->format('M d, Y') ?? 'N/A'); ?>

                    </div>
                </div>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Description</th>
                            <th class="text-end">Amount</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Basic Salary</td>
                            <td class="text-end">Rs.<?php echo e(number_format($payroll->basic_salary, 2)); ?></td>
                        </tr>
                        <?php if($payroll->overtime > 0): ?>
                        <tr>
                            <td>Overtime</td>
                            <td class="text-end">Rs.<?php echo e(number_format($payroll->overtime, 2)); ?></td>
                        </tr>
                        <?php endif; ?>
                        <?php if($payroll->bonus > 0): ?>
                        <tr>
                            <td>Bonus</td>
                            <td class="text-end">Rs.<?php echo e(number_format($payroll->bonus, 2)); ?></td>
                        </tr>
                        <?php endif; ?>
                        <?php if($payroll->deductions > 0): ?>
                        <tr>
                            <td>Deductions</td>
                            <td class="text-end">-Rs.<?php echo e(number_format($payroll->deductions, 2)); ?></td>
                        </tr>
                        <?php endif; ?>
                        <tr class="table-primary">
                            <td><strong>Net Salary</strong></td>
                            <td class="text-end"><strong>Rs.<?php echo e(number_format($payroll->net_salary, 2)); ?></strong></td>
                        </tr>
                    </tbody>
                </table>
                <?php if($payroll->deduction_details): ?>
                <p><strong>Deduction Details:</strong> <?php echo e($payroll->deduction_details); ?></p>
                <?php endif; ?>
                <?php if($payroll->notes): ?>
                <p><strong>Notes:</strong> <?php echo e($payroll->notes); ?></p>
                <?php endif; ?>
            </div>
        </div>
        <div class="text-center mt-3 no-print">
            <button onclick="window.print()" class="btn btn-primary">Print</button>
            <button onclick="window.close()" class="btn btn-secondary">Close</button>
        </div>
    </div>
</body>
</html>


<?php /**PATH /var/www/Logistics-Management-System/resources/views/payrolls/payslip.blade.php ENDPATH**/ ?>