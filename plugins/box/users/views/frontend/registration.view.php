<div class="row">
	<div class="col-md-3">
		<form method="post">
		<?php echo (Form::hidden('csrf', Security::token())); ?>

		<div class="form-group">
			<label><?php echo __('Username', 'users'); ?></label>
			<input type="text" value="<?php echo $user_login; ?>" name="login" class="form-control">
			<?php
			    if (isset($errors['users_this_user_alredy_exists'])) echo Html::nbsp(3).'<span class="error">'.$errors['users_this_user_alredy_exists'].'</span>';
			    if (isset($errors['users_empty_login'])) echo Html::nbsp(3).'<span class="error">'.$errors['users_empty_login'].'</span>';
			?>
		</div>
		<div class="form-group">
			<label><?php echo __('Password', 'users'); ?></label>
			<input type="password" value="<?php echo $user_password; ?>" name="password" class="form-control">
			<?php
			    if (isset($errors['users_empty_password'])) echo Html::nbsp(3).'<span class="error">'.$errors['users_empty_password'].'</span>';
			?>
		</div>
		<div class="form-group">
			<label><?php echo __('Email', 'users'); ?></label>
			<input type="text" value="<?php echo $user_email; ?>" name="email" class="form-control">
			<?php
			    if (isset($errors['users_this_email_alredy_exists'])) echo Html::nbsp(3).'<span class="error">'.$errors['users_this_email_alredy_exists'].'</span>';
			    if (isset($errors['users_empty_email'])) echo Html::nbsp(3).'<span class="error">'.$errors['users_empty_email'].'</span>';
			    if (isset($errors['users_invalid_email'])) echo Html::nbsp(3).'<span class="error">'.$errors['users_invalid_email'].'</span>';
			?>
		</div>
		<?php if (Option::get('captcha_installed') == 'true') { ?>
		<div class="form-group">
			<label><?php echo __('Captcha', 'users'); ?></label>
			<input type="text" name="answer" class="form-control"><?php if (isset($errors['users_captcha_wrong'])) echo Html::nbsp(3).'<span class="error">'.$errors['users_captcha_wrong'].'</span>'; ?>
			<br>			
			<?php CryptCaptcha::draw(); ?>
		</div>
		<?php } ?>
		<div class="form-group">
			<input type="submit" class="btn btn-primary" value="<?php echo __('Register', 'users'); ?>" name="register">
		</div>
		</form>
	</div>
</div>
