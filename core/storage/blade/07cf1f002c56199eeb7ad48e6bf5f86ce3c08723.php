<?php $__env->startSection('content'); ?>
    <?php $__env->startPush('scripts.top'); ?>
        <script>

          var actions = {
            save: function() {
              documentDirty = false;
              form_save = true;
              document.mutate.save.click();
              saveWait('mutate');
            }, duplicate: function() {
              if (confirm('<?php echo e(ManagerTheme::getLexicon('confirm_duplicate_record')); ?>') === true) {
                documentDirty = false;
                document.location.href = "index.php?id=<?php echo e($data->getKey()); ?>&a=98";
              }
            }, delete: function() {
              if (confirm('<?php echo e(ManagerTheme::getLexicon('confirm_delete_snippet')); ?>') === true) {
                documentDirty = false;
                document.location.href = 'index.php?id=<?php echo e($data->getKey()); ?>&a=25';
              }
            }, cancel: function() {
              documentDirty = false;
              document.location.href = 'index.php?a=76&tab=3';
            }
          };

          function setTextWrap(ctrl, b)
          {
            if (!ctrl) {
              return;
            }
            ctrl.wrap = (b) ? 'soft' : 'off';
          }

          // Current Params/Configurations
          var currentParams = {};
          var snippetConfig = {};
          var first = true;

          function showParameters(ctrl)
          {
            var c, p, df, cp;
            var ar, label, value, key, dt, defaultVal, tr;

            currentParams = {}; // reset;

            if (ctrl && ctrl.form) {
              f = ctrl.form;
            } else {
              f = document.forms['mutate'];
              if (!f) {
                return;
              }
            }

            tr = document.getElementById('displayparamrow');

            // check if codemirror is used
            var props = typeof myCodeMirrors != 'undefined' && typeof myCodeMirrors['properties'] != 'undefined' ? myCodeMirrors['properties'].getValue() : f.properties.value, t, td, dp, desc;

            // convert old schemed setup parameters
            if (!IsJsonString(props)) {
              dp = props ? props.match(/([^&=]+)=(.*?)(?=&[^&=]+=|$)/g) : ''; // match &paramname=
              if (!dp) {
                tr.style.display = 'none';
              } else {
                for (p = 0; p < dp.length; p++) {
                  dp[p] = (dp[p] + '').replace(/^\s|\s$/, ''); // trim
                  ar = dp[p].match(/(?:[^\=]|==)+/g); // split by =, not by ==
                  key = ar[0];        // param
                  ar = (ar[1] + '').split(';');
                  label = ar[0];	// label
                  dt = ar[1];		// data type
                  value = decode((ar[2]) ? ar[2] : '');

                  // convert values to new json-format
                  if (key && (dt === 'menu' || dt === 'list' || dt === 'list-multi' || dt === 'checkbox' || dt === 'radio')) {
                    defaultVal = decode((ar[4]) ? ar[4] : ar[3]);
                    desc = decode((ar[5]) ? ar[5] : '');
                    currentParams[key] = [];
                    currentParams[key][0] = {'label': label, 'type': dt, 'value': ar[3], 'options': value, 'default': defaultVal, 'desc': desc};
                  } else if (key) {
                    defaultVal = decode((ar[3]) ? ar[3] : ar[2]);
                    desc = decode((ar[4]) ? ar[4] : '');
                    currentParams[key] = [];
                    currentParams[key][0] = {'label': label, 'type': dt, 'value': value, 'default': defaultVal, 'desc': desc};
                  }
                }
              }
            } else {
              currentParams = JSON.parse(props);
            }

            t = '<table width="100%" class="displayparams grid"><thead><tr><td><?php echo e(ManagerTheme::getLexicon('parameter')); ?></td><td><?php echo e(ManagerTheme::getLexicon('value')); ?></td><td style="text-align:right;white-space:nowrap"><?php echo e(ManagerTheme::getLexicon('set_default')); ?> </td></tr></thead>';

            try {
              var type, options, found, info, sd;
              var ll, ls, sets = [], lv, arrValue, split;

              for (var key in currentParams) {

                if (key === 'internal' || currentParams[key][0]['label'] == undefined) {
                  return;
                }

                cp = currentParams[key][0];
                type = cp['type'];
                value = cp['value'];
                defaultVal = cp['default'];
                label = cp['label'] != undefined ? cp['label'] : key;
                desc = cp['desc'] + '';
                options = cp['options'] != undefined ? cp['options'] : '';

                ll = [];
                ls = [];
                if (options.indexOf('==') > -1) {
                  // option-format: label==value||label==value
                  sets = options.split('||');
                  for (i = 0; i < sets.length; i++) {
                    split = sets[i].split('==');
                    ll[i] = split[0];
                    ls[i] = split[1] != undefined ? split[1] : split[0];
                  }
                } else {
                  // option-format: value,value
                  ls = options.split(',');
                  ll = ls;
                }

                key   = key.replace(/\"/g, '&quot;');
                value = value.replace(/\"/g, '&quot;');

                switch (type) {
                  case 'int':
                    c = '<input type="text" name="prop_' + key + '" value="' + value + '" onchange="setParameter(\'' + key + '\',\'' + type + '\',this)" />';
                    break;
                  case 'menu':
                    c = '<select name="prop_' + key + '" onchange="setParameter(\'' + key + '\',\'' + type + '\',this)">';
                    if (currentParams[key] === options) {
                      currentParams[key] = ls[0];
                    } // use first list item as default
                    for (i = 0; i < ls.length; i++) {
                      c += '<option value="' + ls[i] + '"' + ((ls[i] === value) ? ' selected="selected"' : '') + '>' + ll[i] + '</option>';
                    }
                    c += '</select>';
                    break;
                  case 'list':
                    if (currentParams[key] === options) {
                      currentParams[key] = ls[0];
                    } // use first list item as default
                    c = '<select name="prop_' + key + '" onchange="setParameter(\'' + key + '\',\'' + type + '\',this)">';
                    for (i = 0; i < ls.length; i++) {
                      c += '<option value="' + ls[i] + '"' + ((ls[i] === value) ? ' selected="selected"' : '') + '>' + ll[i] + '</option>';
                    }
                    c += '</select>';
                    break;
                  case 'list-multi':
                    // value = typeof ar[3] !== 'undefined' ? (ar[3] + '').replace(/^\s|\s$/, "") : '';
                    arrValue = value.split(',');
                    if (currentParams[key] === options) {
                      currentParams[key] = ls[0];
                    } // use first list item as default
                    c = '<select name="prop_' + key + '" size="' + ls.length + '" multiple="multiple" onchange="setParameter(\'' + key + '\',\'' + type + '\',this)">';
                    for (i = 0; i < ls.length; i++) {
                      if (arrValue.length) {
                        found = false;
                        for (j = 0; j < arrValue.length; j++) {
                          if (ls[i] === arrValue[j]) {
                            found = true;
                          }
                        }
                        if (found === true) {
                          c += '<option value="' + ls[i] + '" selected="selected">' + ll[i] + '</option>';
                        } else {
                          c += '<option value="' + ls[i] + '">' + ll[i] + '</option>';
                        }
                      } else {
                        c += '<option value="' + ls[i] + '">' + ll[i] + '</option>';
                      }
                    }
                    c += '</select>';
                    break;
                  case 'checkbox':
                    lv = (value + '').split(',');
                    c = '';
                    for (i = 0; i < ls.length; i++) {
                      c += '<label><input type="checkbox" name="prop_' + key + '[]" value="' + ls[i] + '"' + ((contains(lv, ls[i]) === true) ? ' checked="checked"' : '') + ' onchange="setParameter(\'' + key + '\',\'' + type + '\',this)" /> ' + ll[i] + '</label>&nbsp;';
                    }
                    break;
                  case 'radio':
                    c = '';
                    for (i = 0; i < ls.length; i++) {
                      c += '<label><input type="radio" name="prop_' + key + '" value="' + ls[i] + '"' + ((ls[i] === value) ? ' checked="checked"' : '') + ' onchange="setParameter(\'' + key + '\',\'' + type + '\',this)" /> ' + ll[i] + '</label>&nbsp;';
                    }
                    break;
                  case 'textarea':
                    c = '<textarea name="prop_' + key + '" rows="4" onchange="setParameter(\'' + key + '\',\'' + type + '\',this)">' + value + '</textarea>';
                    break;
                  default:  // string
                    c = '<input type="text" name="prop_' + key + '" value="' + value + '" onchange="setParameter(\'' + key + '\',\'' + type + '\',this)" />';
                    break;
                }

                info = '';
                info += desc ? '<br/><small>' + desc + '</small>' : '';
                sd = defaultVal != undefined ? '<a title="<?php echo e(ManagerTheme::getLexicon('set_default')); ?>" href="javascript:;" class="btn btn-primary" onclick="setDefaultParam(\'' + key + '\',1);return false;"><i class="<?php echo e($_style['icon_refresh']); ?>"></i></a>' : '';

                t += '<tr><td class="labelCell" width="20%"><span class="paramLabel">' + label + '</span><span class="paramDesc">' + info + '</span></td><td class="inputCell relative" width="74%">' + c + '</td><td style="text-align: center">' + sd + '</td></tr>';
              }

              t += '</table>';

            } catch (e) {
              t = e + '\n\n' + props;
            }

            td = document.getElementById('displayparams');
            td.innerHTML = t;
            tr.style.display = '';

            implodeParameters();
          }

          function setParameter(key, dt, ctrl)
          {
            var v;
            var arrValues, cboxes = [];
            if (!ctrl) {
              return null;
            }
            switch (dt) {
              case 'int':
                ctrl.value = parseInt(ctrl.value);
                if (isNaN(ctrl.value)) {
                  ctrl.value = 0;
                }
                v = ctrl.value;
                break;
              case 'menu':
              case 'list':
                v = ctrl.options[ctrl.selectedIndex].value;
                break;
              case 'list-multi':
                arrValues = [];
                for (var i = 0; i < ctrl.options.length; i++) {
                  if (ctrl.options[i].selected) {
                    arrValues.push(ctrl.options[i].value);
                  }
                }
                v = arrValues.toString();
                break;
              case 'checkbox':
                arrValues = [];
                cboxes = document.getElementsByName(ctrl.name);
                for (var i = 0; i < cboxes.length; i++) {
                  if (cboxes[i].checked) {
                    arrValues.push(cboxes[i].value);
                  }
                }
                v = arrValues.toString();
                break;
              default:
                v = ctrl.value + '';
                break;
            }
            currentParams[key][0]['value'] = v;
            implodeParameters();
          }

          // implode parameters
          function implodeParameters()
          {
            var stringified = JSON.stringify(currentParams, null, 2);
            if (typeof myCodeMirrors !== 'undefined') {
              myCodeMirrors['properties'].setValue(stringified);
            } else {
              f.properties.value = stringified;
            }
            if (first) {
              documentDirty = false;
              first = false;
            }
            ;
          }

          function encode(s)
          {
            s = s + '';
            s = s.replace(/\=/g, '%3D'); // =
            s = s.replace(/\&/g, '%26'); // &
            return s;
          }

          function decode(s)
          {
            s = s + '';
            s = s.replace(/\%3D/g, '='); // =
            s = s.replace(/\%26/g, '&'); // &
            return s;
          }

          /**
           * @return  {boolean}
           */
          function IsJsonString(str)
          {
            try {
              JSON.parse(str);
            } catch (e) {
              return false;
            }
            return true;
          }

          function setDefaultParam(key, show)
          {
            if (typeof currentParams[key][0]['default'] !== 'undefined') {
              currentParams[key][0]['value'] = currentParams[key][0]['default'];
              if (show) {
                implodeParameters();
                showParameters();
              }
            }
          }

          function setDefaults()
          {
            var keys = Object.keys(currentParams);
            var last = keys[keys.length - 1], show;
            Object.keys(currentParams).forEach(function(key) {
              show = key === last ? 1 : 0;
              setDefaultParam(key, show);
            });
          }

          function contains(a, obj)
          {
            var i = a.length;
            while (i--) {
              if (a[i] === obj) {
                return true;
              }
            }
            return false;
          }

          document.addEventListener('DOMContentLoaded', function() {
            var h1help = document.querySelector('h1 > .help');
            h1help.onclick = function() {
              document.querySelector('.element-edit-message').classList.toggle('show');
            };
          });

        </script>
    <?php $__env->stopPush(); ?>

    <form name="mutate" method="post" action="index.php">
        <?php echo get_by_key($events, 'OnSnipFormPrerender'); ?>

        <input type="hidden" name="a" value="24">
        <input type="hidden" name="id" value="<?php echo e($data->getKey()); ?>">
        <input type="hidden" name="mode" value="<?php echo e($action); ?>">

        <h1>
            <i class="<?php echo e($_style['icon_code']); ?>"></i>
            <?php if($data->name): ?>
                <?php echo e($data->name); ?>

                <small>(<?php echo e($data->getKey()); ?>)</small>
            <?php else: ?>
                <?php echo e(ManagerTheme::getLexicon('new_snippet')); ?>

            <?php endif; ?>
            <i class="<?php echo e($_style['icon_question_circle']); ?> help"></i>
        </h1>

        <?php echo $__env->make('manager::partials.actionButtons', $actionButtons, \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

        <div class="container element-edit-message">
            <div class="alert alert-info"><?php echo ManagerTheme::getLexicon('snippet_msg'); ?></div>
        </div>

        <div class="tab-pane" id="snipetPane">
            <script>
              var tpSnippet = new WebFXTabPane(document.getElementById('snipetPane'), <?php echo e(get_by_key($modx->config, 'remember_last_tab') ? 1 : 0); ?>);
            </script>

            <!-- General -->
            <div class="tab-page" id="tabSnippet">
                <h2 class="tab"><?php echo e(ManagerTheme::getLexicon('settings_general')); ?></h2>
                <script>tpSnippet.addTabPage(document.getElementById('tabSnippet'));</script>

                <div class="container container-body">
                    <?php echo $__env->make('manager::form.row', [
                        'for' => 'name',
                        'label' => ManagerTheme::getLexicon('snippet_name'),
                        'element' => '<div class="form-control-name clearfix">' .
                            ManagerTheme::view('form.inputElement', [
                                'name' => 'name',
                                'value' => $data->name,
                                'class' => 'form-control-lg',
                                'attributes' => 'onchange="documentDirty=true;" maxlength="100"'
                            ]) .
                            ($modx->hasPermission('save_role')
                            ? '<label class="custom-control" data-tooltip="' . ManagerTheme::getLexicon('lock_snippet') . "\n" . ManagerTheme::getLexicon('lock_snippet_msg') .'">' .
                             ManagerTheme::view('form.inputElement', [
                                'type' => 'checkbox',
                                'name' => 'locked',
                                'checked' => ($data->locked == 1)
                             ]) .
                             '<i class="' . $_style['icon_lock'] . '"></i>
                             </label>
                             <small class="form-text text-danger hide" id="savingMessage"></small>
                             <script>if (!document.getElementsByName(\'name\')[0].value) document.getElementsByName(\'name\')[0].focus();</script>'
                            : '') .
                            '</div>'
                    ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

                    <?php echo $__env->make('manager::form.input', [
                        'name' => 'description',
                        'id' => 'description',
                        'label' => ManagerTheme::getLexicon('snippet_desc'),
                        'value' => $data->description,
                        'attributes' => 'onchange="documentDirty=true;" maxlength="255"'
                    ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

                    <?php echo $__env->make('manager::form.select', [
                        'name' => 'categoryid',
                        'id' => 'categoryid',
                        'label' => ManagerTheme::getLexicon('existing_category'),
                        'value' => $data->category,
                        'first' => [
                            'text' => ''
                        ],
                        'options' => $categories->pluck('category', 'id'),
                        'attributes' => 'onchange="documentDirty=true;"'
                    ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

                    <?php echo $__env->make('manager::form.input', [
                        'name' => 'newcategory',
                        'id' => 'newcategory',
                        'label' => ManagerTheme::getLexicon('new_category'),
                        'value' => (isset($data->newcategory) ? $data->newcategory : ''),
                        'attributes' => 'onchange="documentDirty=true;" maxlength="45"'
                    ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

                    <?php if($modx->hasPermission('save_role')): ?>
                        <?php if($_SESSION['mgrRole'] === 1): ?>
                            <div class="form-row">
                                <label for="disabled">
                                    <?php echo $__env->make('manager::form.inputElement', [
                                        'type' => 'checkbox',
                                        'name' => 'disabled',
                                        'value' => 'on',
                                        'checked' => ($data->disabled === 1)
                                    ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                    <?php if($data->disabled == 1): ?>
                                        <span class="text-danger"><?php echo e(ManagerTheme::getLexicon('disabled')); ?></span>
                                    <?php else: ?>
                                        <?php echo e(ManagerTheme::getLexicon('disabled')); ?>

                                    <?php endif; ?>
                                </label>
                            </div>
                        <?php endif; ?>

                        <div class="form-row">
                            <label>
                                <?php echo $__env->make('manager::form.inputElement', [
                                    'type' => 'checkbox',
                                    'name' => 'parse_docblock',
                                    'value' => 1,
                                    'checked' => ($action == 23)
                                ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                <?php echo e(ManagerTheme::getLexicon('parse_docblock')); ?>

                            </label>
                            <small class="form-text text-muted"><?php echo ManagerTheme::getLexicon('parse_docblock_msg'); ?></small>
                        </div>

                    <?php endif; ?>
                </div>

                <!-- PHP text editor start -->
                <div class="navbar navbar-editor">
                    <span><?php echo e(ManagerTheme::getLexicon('snippet_code')); ?></span>
                </div>
                <div class="section-editor clearfix">
                    <?php echo $__env->make('manager::form.textareaElement', [
                        'name' => 'post',
                        'value' => (isset($data->post) ? $data->post : $data->sourceCode),
                        'class' => 'phptextarea',
                        'rows' => 20,
                        'attributes' => 'onChange="documentDirty=true;" wrap="soft"'
                    ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                </div>
                <!-- PHP text editor end -->
            </div>

            <!-- Config -->
            <div class="tab-page" id="tabConfig">
                <h2 class="tab"><?php echo e(ManagerTheme::getLexicon('settings_config')); ?></h2>
                <script>tpSnippet.addTabPage(document.getElementById('tabConfig'));</script>

                <div class="container container-body">
                    <div class="form-group">
                        <a href="javascript:;" class="btn btn-primary" onclick="setDefaults(this);return false;"><?php echo e(ManagerTheme::getLexicon('set_default_all')); ?></a>
                    </div>
                    <div id="displayparamrow">
                        <div id="displayparams"></div>
                    </div>
                </div>
            </div>

            <!-- Properties -->
            <div class="tab-page" id="tabProps">
                <h2 class="tab"><?php echo e(ManagerTheme::getLexicon('settings_properties')); ?></h2>
                <script>tpSnippet.addTabPage(document.getElementById('tabProps'));</script>

                <div class="container container-body">
                    <div class="form-group">
                        <?php echo $__env->make('manager::form.select', [
                            'name' => 'moduleguid',
                            'label' => ManagerTheme::getLexicon('import_params'),
                            'value' => $data->moduleguid,
                            'first' => [
                                'text' => ''
                            ],
                            'options' => $importParams,
                            'attributes' => 'onchange="documentDirty=true;"',
                            'comment' => ManagerTheme::getLexicon('import_params_msg')
                        ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                    </div>
                    <div class="form-group">
                        <a href="javascript:;" class="btn btn-primary" onclick='tpSnippet.pages[1].select();showParameters(this);return false;'><?php echo e(ManagerTheme::getLexicon('update_params')); ?></a>
                    </div>
                </div>

                <!-- HTML text editor start -->
                <div class="section-editor clearfix">
                    <?php echo $__env->make('manager::form.textareaElement', [
                        'name' => 'properties',
                        'value' => $data->properties,
                        'class' => 'phptextarea',
                        'rows' => 20,
                        'attributes' => 'onChange="documentDirty=true;showParameters(this);"'
                    ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                </div>
                <!-- HTML text editor end -->
            </div>

            <!-- docBlock Info -->
            <div class="tab-page" id="tabDocBlock">
                <h2 class="tab"><?php echo e(ManagerTheme::getLexicon('information')); ?></h2>
                <script>tpSnippet.addTabPage(document.getElementById('tabDocBlock'));</script>

                <div class="container container-body">
                    <?php echo $docBlockList; ?>

                </div>
            </div>

            <input type="submit" name="save" style="display:none">

            <?php echo get_by_key($events, 'OnSnipFormRender'); ?>

        </div>
    </form>
    <script>setTimeout('showParameters();', 10);</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('manager::template.page', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:/xampp/htdocs/test1/manager//views//page/snippet.blade.php ENDPATH**/ ?>