<?php if ($action == 'chunk') { ?><h2><?php echo __('New Chunk', 'themes'); ?></h2><?php } ?>
<?php if ($action == 'template') { ?><h2><?php echo __('New Template', 'themes'); ?></h2><?php } ?>
<?php if ($action == 'styles') { ?><h2><?php echo __('New Styles', 'themes'); ?></h2><?php } ?>
<?php if ($action == 'script') { ?><h2><?php echo __('New Script', 'themes'); ?></h2><?php } ?>
<br />

<?php if (Notification::get('success')) Alert::success(Notification::get('success')); ?>

<?php if (isset($errors['file_empty_name']) || isset($errors['file_exists'])) $error_class = 'error'; else $error_class = ''; ?>

<?php echo (Form::open(null, array('class' => 'form-horizontal'))); ?>

<?php echo (Form::hidden('csrf', Security::token())); ?>

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

    echo Form::textarea('content', $content, array('style' => 'width:100%;height:400px;', 'class' => 'source-editor'));

    echo (
        Html::br(2).
        Form::submit('add_file_and_exit', __('Save and Exit', 'themes'), array('class' => 'btn')).Html::nbsp(2).
        Form::submit('add_file', __('Save', 'themes'), array('class' => 'btn')).
        Form::close()
    );
