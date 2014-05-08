<h2 class="margin-bottom-1"><?php echo __('Edit item', 'menu'); ?></h2>

<div class="row">
    <div class="col-md-6">

        <?php echo (Form::open()); ?>

        <?php echo (Form::hidden('csrf', Security::token())); ?>

        <?php if (isset($errors['menu_item_name_empty'])) $error_class = ' error'; else $error_class = ''; ?>

        <a href="#" class="btn btn-phone btn-default" data-toggle="modal" data-toggle="modal" data-target="#selectPageModal"><?php echo __('Select page', 'menu'); ?></a>
        <?php echo Html::nbsp(2); ?>
        <a href="#" class="btn btn-phone btn-default" data-toggle="modal" data-toggle="modal" data-target="#selectCategoryModal"><?php echo __('Select category', 'menu'); ?></a>
    
        <div class="form-group margin-top-2">
        <?php
            echo Form::label('menu_item_name', __('Item name', 'menu'));
            echo Form::input('menu_item_name', $menu_item_name, array('class' => (isset($errors['menu_item_name_empty']) || isset($errors['menu_item_name_empty'])) ? 'form-control error-field' : 'form-control'));
        ?>
        </div>

        <div class="form-group">
        <?php
            if (isset($errors['menu_item_name_empty'])) echo Html::nbsp(4).'<span style="color:red;">'.$errors['menu_item_name_empty'].'</span>';
            echo (
                Form::label('menu_item_link', __('Item link', 'menu')).
                Form::input('menu_item_link', $menu_item_link, array('class' => 'form-control'))
            );
        ?>
        </div>
        <div class="form-group">
        <?php
            echo (
                Form::label('menu_item_category', __('Item category', 'menu')).
                Form::input('menu_item_category', $menu_item_category, array('class' => 'form-control'))
            );
        ?>
        </div>
        <div class="form-group">
        <?php
            echo (
                Form::label('menu_item_target', __('Item target', 'menu')).
                Form::select('menu_item_target', $menu_item_target_array, $menu_item_target, array('class' => 'form-control'))
            );
        ?>
        </div>
        <div class="form-group">
        <?php
            echo (
                Form::label('menu_item_order', __('Item order', 'menu')).
                Form::select('menu_item_order', $menu_item_order_array, $menu_item_order, array('class' => 'form-control'))
            );
        ?>
        </div>    
        <?php
            echo (
                Form::submit('menu_add_item', __('Save', 'menu'), array('class' => 'btn btn-phone btn-primary')).Html::nbsp(2).
                Html::anchor(__('Cancel', 'menu'), 'index.php?id=menu', array('title' => __('Cancel', 'menu'), 'class' => 'btn btn-phone btn-default')).
                Form::close()
            );
        ?>
    </div>
</div>

<div class="modal fade" id="selectPageModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <div class="close" data-dismiss="modal">&times;</div>
                <h4 class="modal-title"><?php echo __('Select page', 'menu'); ?></h4>
            </div>
            <div class="modal-body">
                <ul class="list-unstyled">
                <?php if (count($pages_list) > 0) foreach ($pages_list as $page) { ?>
                    <li><?php echo (!empty($page['parent'])) ? Html::nbsp().Html::arrow('right').Html::nbsp(2) : '' ; ?><a href="javascript:;" onclick="$.monstra.menu.selectPage('<?php echo (empty($page['parent'])) ? $page['slug'] : $page['parent'].'/'.$page['slug'] ; ?>', '<?php echo $page['title']; ?>');"><?php echo $page['title']; ?></a></li>
                <?php } ?>
                <?php if (count($components_list) > 0) foreach ($components_list as $component) { ?>
                    <li><a href="javascript:;" onclick="$.monstra.menu.selectPage('<?php echo $component; ?>', '<?php echo __(ucfirst($component), $component); ?>');"><?php echo __(ucfirst($component), $component); ?></a></li>
                <?php } ?>
                </ul>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="selectCategoryModal"> 
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <div class="close" data-dismiss="modal">&times;</div>
                <h4 class="modal-title"><?php echo __('Select category', 'menu'); ?></h4>
            </div>
            <div class="modal-body">
                <ul class="list-unstyled">
                <?php if (count($categories) > 0) foreach ($categories as $category) { ?>
                    <li><a href="javascript:;" onclick="$.monstra.menu.selectCategory('<?php echo $category; ?>');"><?php echo $category; ?></a></li>
                <?php } ?>
                </ul>
            </div>
        </div>
    </div>
</div>