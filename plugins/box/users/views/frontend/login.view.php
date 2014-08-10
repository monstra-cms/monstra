<div class="row">	
	<div class="col-md-12">		
	    <?php
            // Monstra Notifications
            $error = Notification::get('error') ?: '';
            ($error != '') AND print('<div class="error margin-bottom-1">'.$error.'</div>');
        ?>
    </div>
</div>
<div class="row">	
	<div class="col-md-3">
		<form method="post">
		    <?php echo Form::hidden('csrf', Security::token()); ?>
		    <div class="form-group">
		    	<label><?php echo __('Username', 'users'); ?></label>
		    	<input name="username" type="text" class="form-control">
		    </div>    
		    <div class="form-group">
			    <label><?php echo __('Password', 'users'); ?></label>
			    <input name="password" type="password" class="form-control">
			</div>
			<div class="form-group">
				<input name="login_submit" class="btn btn-primary" type="submit" value="<?php echo __('Log In', 'users'); ?>"> <a class="small-grey-text reset-password-btn" href="<?php echo Option::get('siteurl').'/users/password-reset'; ?>"><?php echo __('Forgot your password?', 'users');?></a>
			</div>    
		</form>
	</div>
</div>