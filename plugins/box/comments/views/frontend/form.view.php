<div class="col-md-5">
<div class="panel panel-success">
  <div class="panel-heading"><?php echo __('Add comment', 'comments'); ?></div>
  <div class="panel-body">
    <?php foreach ($errors as $error) { ?>
    <div class="alert alert-danger">
         <strong>Erreur</strong>
         <p><?php echo $error; ?></p>
    </div>
    <?php } ?> 
<form method="post">
    <?php echo (Form::hidden('csrf', Security::token())); ?>
    <div class="form-group">
        <label class="col-md-4 control-label" for="comments_username"><?php echo __('Username', 'comments'); ?></label>
        <input  class="form-control"  type="text" name="comments_username" id="comments_username"  value="<?php echo $username; ?>" />
    </div>
    <div class="form-group">
        <label class="col-md-4 control-label" for="comments_email"><?php echo __('Email', 'comments'); ?></label>
        <input type="text" name="comments_email" id="comments_email"  class="form-control"  value="<?php echo $email; ?>" />
    </div>
    <div class="form-group">
        <label class="col-md-4 control-label" for="comments_message"><?php echo __('Message', 'comments'); ?></label>
        <textarea class="form-control" rows="10" name="comments_message" id="comments_message"><?php echo $message; ?></textarea>
    </div>
    
            <?php if (Option::get('captcha_installed') == 'true') { ?>

    <div class="form-group">
        
        <label class="col-md-4 control-label" for="answer">
        <?php echo __('Captcha', 'users'); ?>
        </label>
        
        
        <input class="form-control"  type="text" name="answer" id="answer">
                <?php CryptCaptcha::draw(); ?>

    </div>

        <?php } ?>

     <div class="form-group">
        <input class="form-control btn btn-success"  type="submit" value="<?php echo __('Send', 'comments'); ?>" name="comments_submit"/>
    </div>
    
</form>

</div>
</div>
</div>
</div>