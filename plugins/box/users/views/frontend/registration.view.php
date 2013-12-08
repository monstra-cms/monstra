<h3><?php echo __('Registration', 'users'); ?></h3>
<hr>
<form method="post">
<?php
    echo (Form::hidden('csrf', Security::token()));
?>

<label><?php echo __('Username', 'users'); ?></label><input type="text" value="<?php echo $user_login; ?>" name="login" class="input-large">
<?php
    if (isset($errors['users_this_user_alredy_exists'])) echo Html::nbsp(3).'<span class="error">'.$errors['users_this_user_alredy_exists'].'</span>';
    if (isset($errors['users_empty_login'])) echo Html::nbsp(3).'<span class="error">'.$errors['users_empty_login'].'</span>';
?>
<label><?php echo __('Password', 'users'); ?></label><input type="password" value="<?php echo $user_password; ?>" name="password" class="input-large">
<?php
    if (isset($errors['users_empty_password'])) echo Html::nbsp(3).'<span class="error">'.$errors['users_empty_password'].'</span>';
?>
<label><?php echo __('Email', 'users'); ?></label><input type="text" value="<?php echo $user_email; ?>" name="email" class="input-large">
<?php
    if (isset($errors['users_this_email_alredy_exists'])) echo Html::nbsp(3).'<span class="error">'.$errors['users_this_email_alredy_exists'].'</span>';
    if (isset($errors['users_empty_email'])) echo Html::nbsp(3).'<span class="error">'.$errors['users_empty_email'].'</span>';
    if (isset($errors['users_invalid_email'])) echo Html::nbsp(3).'<span class="error">'.$errors['users_invalid_email'].'</span>';
?>
<?php if (Option::get('captcha_installed') == 'true') { ?>
<label><?php echo __('Captcha', 'users'); ?></label>
<input type="text" name="answer" class="input-large"><?php if (isset($errors['users_captcha_wrong'])) echo Html::nbsp(3).'<span class="error">'.$errors['users_captcha_wrong'].'</span>'; ?>
<?php CryptCaptcha::draw(); ?>
<?php } ?>

<br /><input type="submit" class="btn" value="<?php echo __('Register', 'users'); ?>" name="register">
</form>
