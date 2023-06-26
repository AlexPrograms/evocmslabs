<?php $__env->startSection('head'); ?>
    <?php echo $__env->make('manager::partials.header', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php echo $__env->yieldSection(); ?>

<?php $__env->startSection('content'); ?>
<?php echo $__env->yieldSection(); ?>

<?php $__env->startSection('footer'); ?>
    <?php echo $__env->make('manager::partials.footer', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php echo $__env->yieldSection(); ?>
<?php /**PATH C:/xampp/htdocs/test1/manager//views//template/page.blade.php ENDPATH**/ ?>