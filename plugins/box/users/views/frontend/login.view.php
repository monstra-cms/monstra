<h3><?php echo __('Login', 'users'); ?></h3>
<hr>
<?php if (Notification::get('error')) Alert::error(Notification::get('error')); ?>
<form method="post">
    <?php echo Form::hidden('csrf', Security::token()); ?>
    <label><?php echo __('Username', 'users'); ?></label><input name="username" type="text" />
    <label><?php echo __('Password', 'users'); ?></label><input name="password" type="password" />
    <br /><input name="login_submit" class="btn" type="submit" value="<?php echo __('Enter', 'users'); ?>" /> <a class="small-grey-text reset-password-btn" href="<?php echo Option::get('siteurl').'users/password-reset'; ?>"><?php echo __('Forgot your password?', 'users');?></a></td></tr>
</form>

