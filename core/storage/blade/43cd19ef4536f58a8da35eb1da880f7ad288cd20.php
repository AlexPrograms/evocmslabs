<div class="row form-row form-element-input">
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
        <input class="form-control" type="<?php echo e($type ?? 'text'); ?>"
            <?php if(!empty($id)): ?> id="<?php echo e($id); ?>" <?php elseif(!empty($name)): ?> id="<?php echo e($name); ?>" <?php endif; ?>
        <?php if(!empty($name)): ?> name="<?php echo e($name); ?>" <?php endif; ?>
        <?php if(isset($value)): ?> value="<?php echo e($value); ?>" <?php endif; ?>
        <?php if(isset($placeholder)): ?> placeholder="<?php echo e($placeholder); ?>" <?php endif; ?>
        <?php echo $attributes ?? ''; ?>

        <?php if(!empty($readonly)): ?> readonly <?php endif; ?>
        <?php if(!empty($disabled)): ?> disabled <?php endif; ?>
        />
        <?php if(!empty($comment)): ?>
            <small class="form-text text-muted"><?php echo $comment; ?></small>
        <?php endif; ?>
    </div>
</div>
<?php /**PATH C:/xampp/htdocs/test1/manager//views//form/input.blade.php ENDPATH**/ ?>