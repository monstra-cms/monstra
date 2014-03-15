<?php if ($action == 'chunk') { ?><h2 class="margin-bottom-1"><?php echo __('Edit Chunk', 'themes'); ?></h2><?php } ?>
<?php if ($action == 'template') { ?><h2 class="margin-bottom-1"><?php echo __('Edit Template', 'themes'); ?></h2><?php } ?>
<?php if ($action == 'styles') { ?><h2 class="margin-bottom-1"><?php echo __('Edit Styles', 'themes'); ?></h2><?php } ?>
<?php if ($action == 'script') { ?><h2 class="margin-bottom-1"><?php echo __('Edit Script', 'themes'); ?></h2><?php } ?>

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

<div class="input-group">
    <?php echo (Form::input('name', $name, array('class' => (isset($errors['file_empty_name']) || isset($errors['file_exists'])) ? 'form-control error-field' : 'form-control'))); ?>    
    <?php if ($action == 'chunk') { ?><span class="input-group-addon">.chunk.php</span><?php } ?>
    <?php if ($action == 'template') { ?><span class="input-group-addon">.template.php</span><?php } ?>
    <?php if ($action == 'styles') { ?><span class="input-group-addon">.css</span><?php } ?>
    <?php if ($action == 'script') { ?><span class="input-group-addon">.js</span><?php } ?>
</div>

<?php
    if (isset($errors['file_empty_name'])) echo '<span class="error-message">'.$errors['file_empty_name'].'</span>';
    if (isset($errors['file_exists'])) echo '<span class="error-message">'.$errors['file_exists'].'</span>';
?>

<div class="margin-top-2 margin-bottom-2">
<?php
    if ($action == 'chunk') { echo Form::label('content', __('Chunk content', 'themes')); }
    if ($action == 'template') { echo Form::label('content', __('Template content', 'themes')); }
    if ($action == 'styles') { echo Form::label('content', __('Styles content', 'themes')); }
    if ($action == 'script') { echo Form::label('content', __('Script content', 'themes')); }
    echo (
       Form::textarea('content', Html::toText($content), array('style' => 'width:100%;height:400px;', 'class' => 'source-editor'))
    );
?>
</div>

<?php
    echo (
       Form::submit('edit_file_and_exit', __('Save and Exit', 'themes'), array('class' => 'btn btn-primary')).Html::nbsp(2).
       Form::submit('edit_file', __('Save', 'themes'), array('class' => 'btn btn-default')).Html::nbsp(2).
       Html::anchor(__('Cancel', 'themes'), 'index.php?id=themes', array('title' => __('Cancel', 'themes'), 'class' => 'btn btn-default')).
       Form::close()
    );

    } else {
        if ($action == 'chunk') { echo '<div class="message-error">'.__('This chunk does not exist', 'themes').'</div>'; }
        if ($action == 'template') { echo '<div class="message-error">'.__('This template does not exist', 'themes').'</div>'; }
        if ($action == 'styles') { echo '<div class="message-error">'.__('This styles does not exist', 'themes').'</div>'; }
        if ($action == 'script') { echo '<div class="message-error">'.__('This script does not exist', 'themes').'</div>'; }
    }
?>