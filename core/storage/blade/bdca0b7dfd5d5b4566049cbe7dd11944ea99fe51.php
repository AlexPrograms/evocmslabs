<div class="row form-row <?php if(isset($type)): ?>form-element-<?php echo e($type); ?><?php endif; ?>">
    <label for="<?php echo e($for ?? $name); ?>" class="control-label col-5 col-md-3 col-lg-2">
        <?php echo $label ?? ''; ?>

        <?php if(!empty($required)): ?>
            <span class="form-element-required">*</span>
        <?php endif; ?>
        <?php if(!empty($small)): ?>
            <small class="form-text text-muted"><?php echo $small; ?></small>
        <?php endif; ?>
    </label>
    <div class="col-7 col-md-9 col-lg-10">
        <div class="clearfix">
            <?php echo $element ?? ''; ?>

        </div>
        <?php if(!empty($comment)): ?>
            <small class="form-text text-muted"><?php echo $comment; ?></small>
        <?php endif; ?>
    </div>
</div>
<?php /**PATH C:/xampp/htdocs/test1/manager//views//form/row.blade.php ENDPATH**/ ?>