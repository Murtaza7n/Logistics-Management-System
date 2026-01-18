<?php $__env->startSection('title', 'View User'); ?>
<?php $__env->startSection('page-title', 'SYSTEM USERS - View User'); ?>

<?php $__env->startSection('content'); ?>
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">User Details: <?php echo e($user->name); ?></h5>
        <div>
            <a href="<?php echo e(route('users.edit', $user)); ?>" class="btn btn-sm btn-primary">
                <i class="bi bi-pencil"></i> Edit
            </a>
            <a href="<?php echo e(route('users.index')); ?>" class="btn btn-sm btn-secondary">
                <i class="bi bi-arrow-left"></i> Back
            </a>
        </div>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-6">
                <table class="table table-bordered">
                    <tr>
                        <th style="width: 40%;">Name:</th>
                        <td><?php echo e($user->name); ?></td>
                    </tr>
                    <tr>
                        <th>User Name:</th>
                        <td><code><?php echo e($user->email); ?></code></td>
                    </tr>
                    <tr>
                        <th>Email:</th>
                        <td><?php echo e($user->email); ?></td>
                    </tr>
                    <tr>
                        <th>Contact:</th>
                        <td><?php echo e($user->contact ?? 'N/A'); ?></td>
                    </tr>
                    <tr>
                        <th>Role:</th>
                        <td>
                            <span class="badge bg-<?php echo e($user->role === 'admin' ? 'danger' : ($user->role === 'staff' ? 'primary' : 'info')); ?>">
                                <?php echo e(ucfirst($user->role)); ?>

                            </span>
                        </td>
                    </tr>
                    <tr>
                        <th>Primary City:</th>
                        <td><?php echo e($user->primaryCity->name ?? 'N/A'); ?></td>
                    </tr>
                    <tr>
                        <th>Created At:</th>
                        <td><?php echo e($user->created_at->format('M d, Y h:i A')); ?></td>
                    </tr>
                </table>
            </div>
            <div class="col-md-6">
                <h6>Menu Permissions</h6>
                <div class="list-group">
                    <?php
                        $menuPermissions = $user->menu_permissions ?? [];
                        $menus = [
                            'logistics' => 'Logistics',
                            'logistics_reports' => 'Logistics Reports',
                            'finance' => 'Finance',
                            'finance_reports' => 'Finance Reports',
                            'payroll' => 'Payroll',
                            'payroll_reports' => 'Payroll Reports',
                            'system' => 'System',
                        ];
                    ?>
                    <?php $__currentLoopData = $menus; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="list-group-item d-flex justify-content-between align-items-center">
                        <span><?php echo e($label); ?></span>
                        <?php if(isset($menuPermissions[$key]) && $menuPermissions[$key]): ?>
                            <span class="badge bg-success">Allowed</span>
                        <?php else: ?>
                            <span class="badge bg-danger">Denied</span>
                        <?php endif; ?>
                    </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
                
                <h6 class="mt-4">City Permissions</h6>
                <?php if($userPermissions->count() > 0): ?>
                <div class="table-responsive">
                    <table class="table table-sm table-bordered">
                        <thead>
                            <tr>
                                <th>City</th>
                                <th>View</th>
                                <th>Create</th>
                                <th>Edit</th>
                                <th>Delete</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__currentLoopData = $userPermissions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $permission): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <td><?php echo e($permission->city->name); ?></td>
                                <td class="text-center">
                                    <?php if($permission->can_view): ?>
                                        <i class="bi bi-check-circle-fill text-success"></i>
                                    <?php else: ?>
                                        <i class="bi bi-x-circle-fill text-danger"></i>
                                    <?php endif; ?>
                                </td>
                                <td class="text-center">
                                    <?php if($permission->can_create): ?>
                                        <i class="bi bi-check-circle-fill text-success"></i>
                                    <?php else: ?>
                                        <i class="bi bi-x-circle-fill text-danger"></i>
                                    <?php endif; ?>
                                </td>
                                <td class="text-center">
                                    <?php if($permission->can_edit): ?>
                                        <i class="bi bi-check-circle-fill text-success"></i>
                                    <?php else: ?>
                                        <i class="bi bi-x-circle-fill text-danger"></i>
                                    <?php endif; ?>
                                </td>
                                <td class="text-center">
                                    <?php if($permission->can_delete): ?>
                                        <i class="bi bi-check-circle-fill text-success"></i>
                                    <?php else: ?>
                                        <i class="bi bi-x-circle-fill text-danger"></i>
                                    <?php endif; ?>
                                </td>
                            </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                </div>
                <?php else: ?>
                <p class="text-muted">No city permissions assigned</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/Logistics-Management-System/resources/views/users/show.blade.php ENDPATH**/ ?>