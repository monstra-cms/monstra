<?php if ($action == 'chunk') { ?><h2><?php echo __('Edit Chunk', 'themes'); ?></h2><?php } ?>
<?php if ($action == 'template') { ?><h2><?php echo __('Edit Template', 'themes'); ?></h2><?php } ?>
<?php if ($action == 'styles') { ?><h2><?php echo __('Edit Styles', 'themes'); ?></h2><?php } ?>
<?php if ($action == 'script') { ?><h2><?php echo __('Edit Script', 'themes'); ?></h2><?php } ?>
<br />

<?php if (Notification::get('success')) Alert::success(Notification::get('success')); ?>

<?php
    if ($content !== null) {

        if (isset($errors['file_empty_name']) or isset($errors['file_exists'])) $error_class = 'error'; else $error_class = '';

        echo (Form::open(null, array('class' => 'form-horizontal')));
        echo (Form::hidden('csrf', Security::token()));

?>

<?php if ($action == 'chunk') { echo (Form::hidden('chunk_old_name', Request::get('filename'))); } ?>
<?php if ($action == 'template') { echo (Form::hidden('template_old_name', Request::get('filename'))); } ?>
<?php if ($action == 'styles') { echo (Form::hidden('styles_old_name', Request::get('filename'))); } ?>
<?php if ($action == 'script') { echo (Form::hidden('script_old_name', Request::get('filename'))); } ?>

<?php echo (Form::label('name', __('Name', 'themes'))); ?>

<div class="input-append">
    <?php echo (Form::input('name', $name, array('class' => (isset($errors['file_empty_name']) || isset($errors['file_exists'])) ? 'input-xxlarge error-field' : 'input-xxlarge'))); ?>
    <?php if ($action == 'chunk') { ?><span class="add-on">.chunk.php</span><?php } ?>
    <?php if ($action == 'template') { ?><span class="add-on">.template.php</span><?php } ?>
    <?php if ($action == 'styles') { ?><span class="add-on">.css</span><?php } ?>
    <?php if ($action == 'script') { ?><span class="add-on">.js</span><?php } ?>
</div>

<?php
    if (isset($errors['file_empty_name'])) echo '&nbsp;&nbsp;&nbsp;<span style="color:red">'.$errors['file_empty_name'].'</span>';
    if (isset($errors['file_exists'])) echo '&nbsp;&nbsp;&nbsp;<span style="color:red">'.$errors['file_exists'].'</span>';
?>

<br><br>

<?php

    if ($action == 'chunk') { echo Form::label('content', __('Chunk content', 'themes')); }
    if ($action == 'template') { echo Form::label('content', __('Template content', 'themes')); }
    if ($action == 'styles') { echo Form::label('content', __('Styles content', 'themes')); }
    if ($action == 'script') { echo Form::label('content', __('Script content', 'themes')); }

    echo (
       Form::textarea('content', Html::toText($content), array('style' => 'width:100%;height:400px;', 'class' => 'source-editor')).
       Html::br(2).
       Form::submit('edit_file_and_exit', __('Save and Exit', 'themes'), array('class' => 'btn')).Html::nbsp(2).
       Form::submit('edit_file', __('Save', 'themes'), array('class' => 'btn')). Html::nbsp().
       Form::close()
    );

    } else {
        if ($action == 'chunk') { echo '<div class="message-error">'.__('This chunk does not exist', 'themes').'</div>'; }
        if ($action == 'template') { echo '<div class="message-error">'.__('This template does not exist', 'themes').'</div>'; }
        if ($action == 'styles') { echo '<div class="message-error">'.__('This styles does not exist', 'themes').'</div>'; }
        if ($action == 'script') { echo '<div class="message-error">'.__('This script does not exist', 'themes').'</div>'; }
    }
