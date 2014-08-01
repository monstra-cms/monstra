<h2 class="margin-bottom-1"><?php echo __('Edit Email Template', 'emails'); ?></h2>

<?php   
if ($content !== null) {
    echo (Form::open());
    echo (Form::hidden('csrf', Security::token()));
    echo (Form::hidden('email_template_name', Request::get('filename')));
?>
<?php echo (Form::label('name', __('Name', 'emails'))); ?>
<div class="input-group">
    <?php echo (Form::input('name', Request::get('filename'), array('disabled', 'class' => 'form-control'))); ?><span class="input-group-addon">.email.php</span>
</div>

<div class="margin-top-2 margin-bottom-2">
<?php
    echo (        
       Form::label('content', __('Email template content', 'emails')).
       Form::textarea('content', Html::toText($content), array('style' => 'width:100%;height:400px;', 'class' => 'source-editor form-control'))
    );
?>
</div>

<?php
    echo (

       Form::submit('edit_email_template_and_exit', __('Save and Exit', 'emails'), array('class' => 'btn btn-phone btn-primary')).Html::nbsp(2).
       Form::submit('edit_email_template', __('Save', 'emails'), array('class' => 'btn btn-phone btn-primary')). Html::nbsp(2).
       Html::anchor(__('Cancel', 'emails'), 'index.php?id=emails', array('title' => __('Cancel', 'emails'), 'class' => 'btn btn-phone btn-default')).
       Form::close()
    );

} else {
    echo '<div class="message-error">'.__('This email template does not exist', 'emails').'</div>';
}
?>
