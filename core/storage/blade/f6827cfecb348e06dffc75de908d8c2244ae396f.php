<?php $__env->startSection('content'); ?>
    <h1>
        <i class="<?= ManagerTheme::getStyle('icon_modules') ?>"></i><?php echo e(__('global.module_management')); ?><i
                class="<?= ManagerTheme::getStyle('icon_question_circle') ?> help"></i>
    </h1>

    <?php echo ManagerTheme::getStyle('actionbuttons.dynamic.newmodule'); ?>


    <div class="container element-edit-message">
        <div class="alert alert-info"><?php echo __('global.module_management_msg'); ?></div>
    </div>

    <div class="tab-page">
        <div class="table-responsive">
            <table class="table data">
                <thead>
                <tr>
                    <td class="tableHeader" style="width: 34px;"><?php echo e(__('global.icon')); ?></td>
                    <td class="tableHeader"><?php echo e(__('global.name')); ?></td>
                    <td class="tableHeader"><?php echo e(__('global.description')); ?></td>
                    <td class="tableHeader" style="width: 60px;"><?php echo e(__('global.locked')); ?></td>
                    <td class="tableHeader" style="width: 60px;"><?php echo e(__('global.disabled')); ?></td>
                </tr>
                </thead>
                <tbody>
                <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php $__currentLoopData = $cat->modules; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $module): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                            <td class="tableItem text-center" style="width: 34px;">
                                <?php if(evo()->hasAnyPermissions(['edit_module', 'exec_module'])): ?>
                                    <a class="tableRowIcon" href="javascript:;" onclick="return showContentMenu(<?php echo e($module->getKey()); ?>, event);" title="<?php echo e(__('global.click_to_context')); ?>">
                                        <i class="fa fa-cube"></i>
                                    </a>
                                <?php else: ?>
                                    <i class="fa fa-cube"></i>
                                <?php endif; ?>
                            </td>
                            <td class="tableItem">
                                <?php if(evo()->hasAnyPermissions(['edit_module'])): ?>
                                    <a href="index.php?a=108&id=<?php echo e($module->getKey()); ?>" title="<?php echo e(__('global.module_edit_click_title')); ?>"><?php echo e($module->name); ?></a>
                                <?php else: ?>
                                    <?php echo e($module->name); ?>

                                <?php endif; ?>
                            </td>
                            <td class="tableItem"><?php echo $module->description; ?></td>
                            <td class="tableItem text-center" style="width: 60px;">
                                <?php if($module->locked): ?>
                                    <?php echo e(__('global.yes')); ?>

                                <?php else: ?>
                                    -
                                <?php endif; ?>
                            </td>
                            <td class="tableItem text-center" style="width: 60px;">
                                <?php if($module->disabled): ?>
                                    <?php echo e(__('global.yes')); ?>

                                <?php else: ?>
                                    -
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
            </table>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts.bot'); ?>
    <?php echo $contextMenu['menu']; ?>


    <script>
      var selectedItem;
      var contextm = <?php echo $contextMenu['script']; ?>;

      function showContentMenu(id, e) {
        selectedItem = id;
        contextm.style.left = (e.pageX || (e.clientX + (document.documentElement.scrollLeft || document.body.scrollLeft))) <?php echo e(ManagerTheme::getTextDir('+10')); ?> + 'px'; //offset menu if RTL is selected
        contextm.style.top = (e.pageY || (e.clientY + (document.documentElement.scrollTop || document.body.scrollTop))) + 'px';
        contextm.style.visibility = 'visible';
        e.cancelBubble = true;
        return false;
      };

      function menuAction(a) {
        var id = selectedItem;
        switch (a) {
          case 1:		// run module
            dontShowWorker = true; // prevent worker from being displayed
            window.location.href = 'index.php?a=112&id=' + id;
            break;
          case 2:		// edit
            window.location.href = 'index.php?a=108&id=' + id;
            break;
          case 3:		// duplicate
            if (confirm('<?php echo e(__('global.confirm_duplicate_record')); ?>') === true) {
              window.location.href = 'index.php?a=111&id=' + id;
            }
            break;
          case 4:		// delete
            if (confirm('<?php echo e(__('global.confirm_delete_module')); ?>') === true) {
              window.location.href = 'index.php?a=110&id=' + id;
            }
            break;
        }
      }

      document.addEventListener('click', function() {
        contextm.style.visibility = 'hidden';
      });

      var actions = {
        new: function() {
          document.location.href = 'index.php?a=107';
        },
      };

      document.querySelector('h1 > .help').onclick = function() {
        document.querySelector('.element-edit-message').classList.toggle('show');
      };

    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('manager::template.page', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:/xampp/htdocs/test1/manager//views//page/modules.blade.php ENDPATH**/ ?>