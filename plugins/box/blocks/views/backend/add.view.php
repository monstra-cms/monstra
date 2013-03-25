<h2><?php echo __('New Block', 'blocks'); ?></h2>
<br />

<?php if (Notification::get('success')) Alert::success(Notification::get('success')); ?>

<?php if (isset($errors['blocks_empty_name']) or isset($errors['blocks_exists'])) $error_class = 'error'; else $error_class = ''; ?>

<?php echo (Form::open()); ?>

<?php echo (Form::hidden('csrf', Security::token())); ?>

    <?php echo (Form::label('name', __('Name', 'blocks'))); ?>

    <?php echo (Form::input('name', $name, array('class' => (isset($errors['blocks_empty_name']) || isset($errors['blocks_exists'])) ? 'input-xxlarge error-field' : 'input-xxlarge'))); ?>

    <?php
        if (isset($errors['blocks_empty_name'])) echo '&nbsp;&nbsp;&nbsp;<span style="color:red">'.$errors['blocks_empty_name'].'</span>';
        if (isset($errors['blocks_exists'])) echo '&nbsp;&nbsp;&nbsp;<span style="color:red">'.$errors['blocks_exists'].'</span>';
    ?>

<br /><br />
<?php

    Action::run('admin_editor', array(Html::toText($content)));

    echo (
       Html::br().
       Form::submit('add_blocks_and_exit', __('Save and Exit', 'blocks'), array('class' => 'btn')).Html::nbsp(2).
       Form::submit('add_blocks', __('Save', 'blocks'), array('class' => 'btn')).
       Form::close()
    );

?>
