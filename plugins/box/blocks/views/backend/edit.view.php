<h2 class="margin-bottom-1"><?php echo __('Edit Block', 'blocks'); ?></h2>

<?php
    if ($content !== null) {

        if (isset($errors['blocks_empty_name']) or isset($errors['blocks_exists'])) $error_class = 'error'; else $error_class = '';

        echo (Form::open());
        echo (Form::hidden('csrf', Security::token()));
        echo (Form::hidden('blocks_old_name', Request::get('filename')));

?>

        <div class="form-group margin-bottom-1">
        <?php echo (Form::label('name', __('Name', 'blocks'))); ?>
        <?php echo (Form::input('name', $name, array('class' => (isset($errors['blocks_empty_name']) || isset($errors['blocks_exists'])) ? 'form-control error-field' : 'form-control'))); ?>
        <?php
            if (isset($errors['blocks_empty_name'])) echo '<span class="error-message">'.$errors['blocks_empty_name'].'</span>';
            if (isset($errors['blocks_exists'])) echo '<span class="error-message">'.$errors['blocks_exists'].'</span>';
        ?>
        </div>


<div class="row margin-bottom-1">
    <div class="col-xs-12">
        <?php Action::run('admin_editor', array(Html::toText($content))); ?>
    </div>
</div>

<?php      
        echo (
           Form::submit('edit_blocks_and_exit', __('Save and Exit', 'blocks'), array('class' => 'btn btn-info')).Html::nbsp(2).
           Form::submit('edit_blocks', __('Save', 'blocks'), array('class' => 'btn btn-phone btn-success')). Html::nbsp(2).
           Html::anchor(__('Cancel', 'blocks'), 'index.php?id=blocks', array('title' => __('Cancel', 'blocks'), 'class' => 'btn btn-phone btn-default')).
           Form::close()
        );

    } else {
        echo '<div class="message-error">'.__('This block does not exist', 'blocks').'</div>';
    }
?>
