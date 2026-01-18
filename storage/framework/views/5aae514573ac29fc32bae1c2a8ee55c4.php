<?php
    $structure = \App\Services\MenuPermissionService::getMenuStructure();
    $userPermissions = $user->dynamic_permissions ?? [];
?>

<style>
    .permission-tree {
        max-height: 600px;
        overflow-y: auto;
        border: 1px solid #dee2e6;
        border-radius: 8px;
        padding: 1rem;
        background: #f8f9fa;
    }
    
    .permission-menu {
        margin-bottom: 0.75rem;
        background: white;
        border-radius: 6px;
        border: 1px solid #dee2e6;
        overflow: hidden;
    }
    
    .permission-menu-header {
        padding: 0.75rem 1rem;
        background: linear-gradient(135deg, var(--orange-primary) 0%, #ff8c5a 100%);
        color: white;
        font-weight: 600;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: space-between;
        user-select: none;
    }
    
    .permission-menu-header:hover {
        background: linear-gradient(135deg, #ff8c5a 0%, var(--orange-primary) 100%);
    }
    
    .permission-menu-header i {
        transition: transform 0.3s ease;
    }
    
    .permission-menu-header.collapsed i {
        transform: rotate(-90deg);
    }
    
    .permission-menu-content {
        padding: 0.5rem;
        display: block;
    }
    
    .permission-menu-content.collapsed {
        display: none;
    }
    
    .permission-submenu {
        margin-left: 1.5rem;
        margin-top: 0.5rem;
        padding-left: 1rem;
        border-left: 2px solid #dee2e6;
    }
    
    .permission-route {
        padding: 0.5rem;
        margin-bottom: 0.25rem;
        background: #f8f9fa;
        border-radius: 4px;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }
    
    .permission-route-label {
        flex: 1;
        font-weight: 500;
        color: #495057;
    }
    
    .permission-actions {
        display: flex;
        gap: 0.5rem;
        align-items: center;
    }
    
    .permission-action-checkbox {
        display: flex;
        align-items: center;
        gap: 0.25rem;
        font-size: 0.85rem;
    }
    
    .permission-action-checkbox input[type="checkbox"] {
        margin: 0;
        cursor: pointer;
    }
    
    .permission-action-checkbox label {
        margin: 0;
        cursor: pointer;
        font-weight: normal;
        color: #6c757d;
    }
    
    .permission-select-all {
        padding: 0.5rem 1rem;
        background: #e9ecef;
        border-top: 1px solid #dee2e6;
        display: flex;
        gap: 0.5rem;
        justify-content: flex-end;
    }
</style>

<div class="permission-tree">
    <?php $__currentLoopData = $structure; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $menuKey => $menu): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <div class="permission-menu">
        <div class="permission-menu-header" onclick="toggleMenu('<?php echo e($menuKey); ?>')">
            <span>
                <?php echo e($menu['label']); ?>

            </span>
            <i class="bi bi-chevron-down"></i>
        </div>
        <div class="permission-menu-content" id="menu_<?php echo e($menuKey); ?>">
            <?php if(isset($menu['routes'])): ?>
                <?php $__currentLoopData = $menu['routes']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $routeName => $routeInfo): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="permission-route">
                    <div class="permission-route-label"><?php echo e($routeInfo['label']); ?></div>
                    <div class="permission-actions">
                        <?php $__currentLoopData = $routeInfo['actions']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $action): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="permission-action-checkbox">
                            <input type="checkbox" 
                                   name="dynamic_permissions[<?php echo e($menuKey); ?>.<?php echo e($routeName); ?>][<?php echo e($action); ?>]" 
                                   id="perm_<?php echo e($menuKey); ?>_<?php echo e($routeName); ?>_<?php echo e($action); ?>"
                                   value="1"
                                   <?php if(isset($userPermissions[$menuKey . '.' . $routeName]) && in_array($action, $userPermissions[$menuKey . '.' . $routeName])): ?>
                                   checked
                                   <?php endif; ?>
                                   onchange="updateParentCheckbox('<?php echo e($menuKey); ?>', '<?php echo e($routeName); ?>')">
                            <label for="perm_<?php echo e($menuKey); ?>_<?php echo e($routeName); ?>_<?php echo e($action); ?>"><?php echo e(ucfirst($action)); ?></label>
                        </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <?php endif; ?>
            
            <?php if(isset($menu['submenus'])): ?>
                <?php $__currentLoopData = $menu['submenus']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $submenuKey => $submenu): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="permission-submenu">
                    <div class="permission-route" style="background: #e9ecef; font-weight: 600;">
                        <div class="permission-route-label"><?php echo e($submenu['label']); ?></div>
                    </div>
                    <?php if(isset($submenu['routes'])): ?>
                        <?php $__currentLoopData = $submenu['routes']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $routeName => $routeInfo): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="permission-route">
                            <div class="permission-route-label"><?php echo e($routeInfo['label']); ?></div>
                            <div class="permission-actions">
                                <?php $__currentLoopData = $routeInfo['actions']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $action): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <div class="permission-action-checkbox">
                                    <input type="checkbox" 
                                           name="dynamic_permissions[<?php echo e($menuKey); ?>.<?php echo e($submenuKey); ?>.<?php echo e($routeName); ?>][<?php echo e($action); ?>]" 
                                           id="perm_<?php echo e($menuKey); ?>_<?php echo e($submenuKey); ?>_<?php echo e($routeName); ?>_<?php echo e($action); ?>"
                                           value="1"
                                           <?php if(isset($userPermissions[$menuKey . '.' . $submenuKey . '.' . $routeName]) && in_array($action, $userPermissions[$menuKey . '.' . $submenuKey . '.' . $routeName])): ?>
                                           checked
                                           <?php endif; ?>>
                                    <label for="perm_<?php echo e($menuKey); ?>_<?php echo e($submenuKey); ?>_<?php echo e($routeName); ?>_<?php echo e($action); ?>"><?php echo e(ucfirst($action)); ?></label>
                                </div>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </div>
                        </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <?php endif; ?>
                </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <?php endif; ?>
            
            <div class="permission-select-all">
                <button type="button" class="btn btn-sm btn-outline-primary" onclick="selectAllInMenu('<?php echo e($menuKey); ?>')">
                    <i class="bi bi-check-all"></i> Select All
                </button>
                <button type="button" class="btn btn-sm btn-outline-secondary" onclick="deselectAllInMenu('<?php echo e($menuKey); ?>')">
                    <i class="bi bi-x-square"></i> Deselect All
                </button>
            </div>
        </div>
    </div>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
</div>

<div class="mt-3">
    <button type="button" class="btn btn-sm btn-primary" onclick="selectAllPermissions()">
        <i class="bi bi-check-all"></i> Select All Permissions
    </button>
    <button type="button" class="btn btn-sm btn-secondary" onclick="deselectAllPermissions()">
        <i class="bi bi-x-square"></i> Deselect All Permissions
    </button>
</div>

<script>
    function toggleMenu(menuKey) {
        const header = event.currentTarget;
        const content = document.getElementById('menu_' + menuKey);
        header.classList.toggle('collapsed');
        content.classList.toggle('collapsed');
    }
    
    function selectAllInMenu(menuKey) {
        const menuContent = document.getElementById('menu_' + menuKey);
        menuContent.querySelectorAll('input[type="checkbox"]').forEach(cb => {
            cb.checked = true;
        });
    }
    
    function deselectAllInMenu(menuKey) {
        const menuContent = document.getElementById('menu_' + menuKey);
        menuContent.querySelectorAll('input[type="checkbox"]').forEach(cb => {
            cb.checked = false;
        });
    }
    
    function selectAllPermissions() {
        document.querySelectorAll('.permission-tree input[type="checkbox"]').forEach(cb => {
            cb.checked = true;
        });
    }
    
    function deselectAllPermissions() {
        document.querySelectorAll('.permission-tree input[type="checkbox"]').forEach(cb => {
            cb.checked = false;
        });
    }
    
    function updateParentCheckbox(menuKey, routeName) {
        // This can be used to update parent checkboxes when all children are selected
    }
</script>

<?php /**PATH /var/www/Logistics-Management-System/resources/views/users/partials/dynamic-permissions-tree.blade.php ENDPATH**/ ?>