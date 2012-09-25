<h2><?php echo __('Edit item', 'menu'); ?></h2>
<br />

<?php echo (Form::open()); ?>

<?php echo (Form::hidden('csrf', Security::token())); ?>

<?php if (isset($errors['menu_item_name_empty'])) $error_class = ' error'; else $error_class = ''; ?>

<a href="javascript:;" style="text-decoration:none; color:#333; border-bottom:1px dashed #333;" data-toggle="modal" onclick="$('#addMenuPageModal').modal('show').width(270);" ><?php echo __('Add page', 'menu'); ?></a><br /><br />

<?php 

    echo Form::label('menu_item_name', __('Item name', 'menu'));
    echo Form::input('menu_item_name', $menu_item_name, array('class' => 'span6'.$error_class));

    if (isset($errors['menu_item_name_empty'])) echo Html::nbsp(4).'<span class="error">'.$errors['menu_item_name_empty'].'</span>';

    echo (
        Form::label('menu_item_link', __('Item link', 'menu')).
        Form::input('menu_item_link', $menu_item_link, array('class' => 'span6'))
    );
?>

<?php
    echo (
        Html::br().
        Form::label('menu_item_target', __('Item target', 'menu')).
        Form::select('menu_item_target', $menu_item_target_array, $menu_item_target)
    ); 

    echo (
        Html::br().
        Form::label('menu_item_order', __('Item order', 'menu')).
        Form::select('menu_item_order', $menu_item_order_array, $menu_item_order)
    ); 

    echo (
        Html::br(2).
        Form::submit('menu_add_item', __('Save', 'menu'), array('class' => 'btn')).        
        Form::close()
    );
?>

<div class="modal hide" id="addMenuPageModal">
    <div class="modal-header">
        <a class="close" data-dismiss="modal">×</a>
        <h3><?php echo __('Select page', 'menu'); ?></h3>
    </div>
    <div class="modal-body">
        <p>
            <ul class="unstyled">
            <?php if (count($pages_list) > 0) foreach($pages_list as $page) { ?>
                <li><a href="javascript:;" onclick="addMenuPage('<?php echo $page['slug']; ?>', '<?php echo $page['title']; ?>');"><?php echo $page['title']; ?></a></li>
            <?php } ?>
            <?php if (count($components_list) > 0) foreach($components_list as $component) { ?>
                <li><a href="javascript:;" onclick="addMenuPage('<?php echo Text::lowercase($component); ?>', '<?php echo __($component); ?>');"><?php echo __($component); ?></a></li>
            <?php } ?>
            </ul>
        </p>
    </div>
</div>