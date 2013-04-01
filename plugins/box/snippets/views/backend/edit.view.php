<h2><?php echo __('Edit Snippet', 'snippets'); ?></h2>
<br />

<?php if (Notification::get('success')) Alert::success(Notification::get('success')); ?>

<?php
    if ($content !== null) {

        if (isset($errors['snippets_empty_name']) or isset($errors['snippets_exists'])) $error_class = 'error'; else $error_class = '';

        echo (Form::open(null, array('class' => 'form-horizontal')));

        echo (Form::hidden('csrf', Security::token()));

        echo (Form::hidden('snippets_old_name', Request::get('filename')));

?>

    <?php echo (Form::label('name', __('Name', 'snippets'))); ?>

        <div class="input-append">
            <?php echo (Form::input('name', $name, array('class' => (isset($errors['snippets_empty_name']) || isset($errors['snippets_exists'])) ? 'input-xxlarge error-field' : 'input-xxlarge'))); ?><span class="add-on">.snippet.php</span>
        </div>

        <?php
            if (isset($errors['snippets_empty_name'])) echo '&nbsp;&nbsp;&nbsp;<span style="color:red">'.$errors['snippets_empty_name'].'</span>';
            if (isset($errors['snippets_exists'])) echo '&nbsp;&nbsp;&nbsp;<span style="color:red">'.$errors['snippets_exists'].'</span>';
        ?>

<?php

        echo (
           Html::br(2).
           Form::label('content', __('Snippet content', 'snippets')).
           Form::textarea('content', Html::toText($content), array('style' => 'width:100%;height:400px;', 'class' => 'source-editor')).
           Html::br(2).
           Form::submit('edit_snippets_and_exit', __('Save and Exit', 'snippets'), array('class' => 'btn default')).Html::nbsp(2).
           Form::submit('edit_snippets', __('Save', 'snippets'), array('class' => 'btn default')). Html::nbsp().
           Form::close()
        );

    } else {
        echo '<div class="message-error">'.__('This snippet does not exist').'</div>';
    }
?>
