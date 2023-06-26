<div class="tab-page <?php echo e($tabPageName); ?>" id="<?php echo e($tabIndexPageName); ?>">
    <h2 class="tab">
        <a href="?a=76&tab=<?php echo e($index); ?>"><i class="<?php echo e($_style['icon_code']); ?>"></i><?php echo e(ManagerTheme::getLexicon('manage_snippets')); ?></a>
    </h2>
    <script>tpResources.addTabPage(document.getElementById('<?php echo e($tabIndexPageName); ?>'));</script>

    <div id="<?php echo e($tabIndexPageName); ?>-info" class="msg-container" style="display:none">
        <div class="element-edit-message-tab"><?php echo ManagerTheme::getLexicon('snippet_management_msg'); ?></div>
        <p class="viewoptions-message"><?php echo e(ManagerTheme::getLexicon('view_options_msg')); ?></p>
    </div>

    <div id="_actions">
        <form class="btn-group form-group form-inline">
            <div class="input-group input-group-sm">
                <input class="form-control filterElements-form" type="text" id="<?php echo e($tabIndexPageName); ?>_search" size="30" placeholder="<?php echo e(ManagerTheme::getLexicon('element_filter_msg')); ?>" />
                <div class="input-group-btn">
                    <a class="btn btn-success" target="main" href="<?php echo e((new EvolutionCMS\Models\SiteSnippet)->makeUrl('actions.new')); ?>">
                        <i class="<?php echo e($_style['icon_add']); ?>"></i>
                        <span><?php echo e(ManagerTheme::getLexicon('new_snippet')); ?></span>
                    </a>
                    <a class="btn btn-secondary" href="javascript:;" id="<?php echo e($tabIndexPageName); ?>-help">
                        <i class="<?php echo e($_style['icon_question_circle']); ?>"></i>
                        <span><?php echo e(ManagerTheme::getLexicon('help')); ?></span>
                    </a>
                    <a class="btn btn-secondary switchform-btn" href="javascript:;" data-target="switchForm_<?php echo e($tabIndexPageName); ?>">
                        <i class="<?php echo e($_style['icon_bars']); ?>"></i>
                        <span><?php echo e(ManagerTheme::getLexicon('btn_view_options')); ?></span>
                    </a>
                </div>
            </div>
        </form>
    </div>

    <?php echo $__env->make('manager::page.resources.helper.switchButtons', ['id' => $tabIndexPageName], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

    <div class="clearfix"></div>
    <div class="panel-group no-transition">
        <div id="<?php echo e($tabIndexPageName); ?>_content" class="resourceTable panel panel-default">
            <?php if(isset($outCategory) && $outCategory->count() > 0): ?>
                <?php $__env->startComponent('manager::partials.panelCollapse', ['name' => $tabIndexPageName . '_content', 'id' => 0, 'title' => ManagerTheme::getLexicon('no_category')]); ?>
                    <ul class="elements">
                        <?php $__currentLoopData = $outCategory; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php echo $__env->make('manager::page.resources.elements.snippet', compact('item', 'tabIndexPageName'), \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </ul>
                <?php echo $__env->renderComponent(); ?>
            <?php endif; ?>

            <?php if(isset($categories)): ?>
                <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php $__env->startComponent('manager::partials.panelCollapse', ['name' => $tabIndexPageName . '_content', 'id' => $cat->id, 'title' => $cat->name]); ?>
                        <ul class="elements">
                            <?php $__currentLoopData = $cat->snippets; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php echo $__env->make('manager::page.resources.elements.snippet', compact('item', 'tabIndexPageName'), \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </ul>
                    <?php echo $__env->renderComponent(); ?>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <?php endif; ?>
        </div>
    </div>
    <div class="clearfix"></div>
</div>

<?php $__env->startPush('scripts.bot'); ?>
    <script>
        initQuicksearch('<?php echo e($tabIndexPageName); ?>_search', '<?php echo e($tabIndexPageName); ?>_content');
      initViews('sn', '<?php echo e($tabIndexPageName); ?>', '<?php echo e($tabIndexPageName); ?>_content');
    </script>
<?php $__env->stopPush(); ?>
<?php /**PATH C:/xampp/htdocs/test1/manager//views//page/resources/snippets.blade.php ENDPATH**/ ?>