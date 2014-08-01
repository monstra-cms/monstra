<h2 class="margin-bottom-1"><?php echo __('New Snippet', 'snippets'); ?></h2>

<?php if (isset($errors['snippets_empty_name']) or isset($errors['snippets_exists'])) $error_class = 'error'; else $error_class = ''; ?>

<?php echo (Form::open(null, array('class' => 'form-horizontal'))); ?>

<?php echo (Form::hidden('csrf', Security::token())); ?>

<?php echo (Form::label('name', __('Name', 'snippets'))); ?>
<div class="input-group">
    <?php echo (Form::input('name', $name, array('class' => (isset($errors['snippets_empty_name']) || isset($errors['snippets_exists'])) ? 'form-control error-field' : 'form-control'))); ?><span class="input-group-addon">.snippet.php</span>
</div>

<?php
    if (isset($errors['snippets_empty_name'])) echo '<span class="error-message">'.$errors['snippets_empty_name'].'</span>';
    if (isset($errors['snippets_exists'])) echo '<span class="error-message">'.$errors['snippets_exists'].'</span>';
?>

<div class="margin-top-2 margin-bottom-2">
<?php
    echo (
       Form::label('content', __('Snippet content', 'snippets')).
       Form::textarea('content', $content, array('style' => 'width:100%;height:400px;', 'class'=>'source-editor form-control'))
    );
?>
</div>

<?php
    echo (
       Form::submit('add_snippets_and_exit', __('Save and Exit', 'snippets'), array('class' => 'btn btn-phone btn-primary')).Html::nbsp(2).
       Form::submit('add_snippets', __('Save', 'snippets'), array('class' => 'btn btn-phone btn-primary')).Html::nbsp(2).
       Html::anchor(__('Cancel', 'snippets'), 'index.php?id=snippets', array('title' => __('Cancel', 'snippets'), 'class' => 'btn btn-phone btn-default')).
       Form::close()
    );
?>