<?php if ($action == 'chunk') { ?><h2 class="margin-bottom-1"><?php echo __('New Chunk', 'themes'); ?></h2><?php } ?>
<?php if ($action == 'template') { ?><h2 class="margin-bottom-1"><?php echo __('New Template', 'themes'); ?></h2><?php } ?>
<?php if ($action == 'styles') { ?><h2 class="margin-bottom-1"><?php echo __('New Styles', 'themes'); ?></h2><?php } ?>
<?php if ($action == 'script') { ?><h2 class="margin-bottom-1"><?php echo __('New Script', 'themes'); ?></h2><?php } ?>
<br>

<?php if (isset($errors['file_empty_name']) || isset($errors['file_exists'])) $error_class = 'error'; else $error_class = ''; ?>

<?php echo (Form::open(null, array('class' => 'form-horizontal'))); ?>

<?php echo (Form::hidden('csrf', Security::token())); ?>

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

    echo Form::textarea('content', $content, array('style' => 'width:100%;height:400px;', 'class' => 'source-editor')); 
?>
</div>

<?php
    echo (
        Form::submit('add_file_and_exit', __('Save and Exit', 'themes'), array('class' => 'btn btn-primary')).Html::nbsp(2).
        Form::submit('add_file', __('Save', 'themes'), array('class' => 'btn btn-default')).Html::nbsp(2).
        Html::anchor(__('Cancel', 'themes'), 'index.php?id=themes', array('title' => __('Cancel', 'themes'), 'class' => 'btn btn-default')).
        Form::close()
    );
?>