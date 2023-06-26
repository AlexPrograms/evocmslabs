<?php /** @var EvolutionCMS\Models\SitePlugin $item */ ?>
<li>
    <div class="rTable">
        <div class="rTableRow">
            <?php if(!empty($item->isAlreadyEdit)): ?>
                <div class="lockCell">
                    <?php $rowLock = $item->alreadyEditInfo; ?>
                    <span title="<?php echo e(str_replace(['[+lasthit_df+]', '[+element_type+]'], [$rowLock['lasthit_df'], ManagerTheme::getLexicon('lock_element_type_2')], ManagerTheme::getLexicon('lock_element_editing'))); ?>" class="editResource" style="cursor:context-menu;">
                        <i class="<?php echo e($_style['icon_eye']); ?>"></i>
                    </span>&nbsp;
                </div>
            <?php endif; ?>
            <div class="mainCell elements_description">
                <span <?php if($item->disabled): ?>class="disabledPlugin" <?php endif; ?>>
                    <a class="man_el_name site_plugins" target="main" data-type="site_plugins" data-id="<?php echo e($item->id); ?>" data-catid="<?php echo e($item->category); ?>" href="<?php echo e($item->makeUrl('actions.edit')); ?>">
                        <i class="<?php echo e($_style['icon_plugin']); ?>"></i>
                        <?php if($item->locked): ?>
                            <i class="<?php echo e($_style['icon_lock']); ?>"></i>
                        <?php endif; ?>
                        <?php echo e($item->name); ?>

                        <small>(<?php echo e($item->id); ?>)</small>
                        <span class="elements_descr">
                            <?php echo e($item->caption); ?>

                            <?php echo $item->description; ?>

                        </span>
                    </a>
                    <?php if(ManagerTheme::getTextDir() !== 'ltr'): ?>
                    &rlm;
                    <?php endif; ?>
                </span>
            </div>
            <div class="btnCell">
                <ul class="elements_buttonbar">
                    <li>
                        <a href="<?php echo e($item->makeUrl('actions.edit')); ?>" title="<?php echo e(ManagerTheme::getLexicon('edit_resource')); ?>">
                            <i class="<?php echo e($_style['icon_edit']); ?>"></i>
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo e($item->makeUrl('actions.duplicate')); ?>" title="<?php echo e(ManagerTheme::getLexicon('resource_duplicate')); ?>" onclick="return confirm('<?php echo e(ManagerTheme::getLexicon('confirm_duplicate_record')); ?>')">
                            <i class="<?php echo e($_style['icon_clone']); ?>"></i>
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo e($item->makeUrl('actions.delete')); ?>" title="<?php echo e(ManagerTheme::getLexicon('delete')); ?>" onclick="return confirm('<?php echo e(ManagerTheme::getLexicon('confirm_delete_plugin')); ?>')">
                            <i class="<?php echo e($_style['icon_trash']); ?>"></i>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</li>
<?php /**PATH C:/xampp/htdocs/test1/manager//views//page/resources/elements/plugin.blade.php ENDPATH**/ ?>