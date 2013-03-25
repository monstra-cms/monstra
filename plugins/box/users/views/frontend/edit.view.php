<h3><?php echo __('Edit profile', 'users') ?></h3>
<hr>

<?php if (Notification::get('success')) Alert::success(Notification::get('success')); ?>
<?php if (Notification::get('error'))   Alert::success(Notification::get('error')); ?>

<form method="post">
<?php
    echo (
        Form::hidden('csrf', Security::token()).
        Form::hidden('user_id', $user['id'])
    );
?>

<?php if (isset($_SESSION['user_role']) && in_array($_SESSION['user_role'], array('admin'))) { ?>
<label><?php echo __('Username', 'users'); ?></label><input class="input-xlarge" type="text" value="<?php echo $user['login']; ?>" name="login">
<?php } else { echo Form::hidden('login', $user['login']); } ?>
<label><?php echo __('Firstname', 'users'); ?></label><input class="input-xlarge" type="text" value="<?php echo $user['firstname']; ?>" name="firstname">
<label><?php echo __('Lastname', 'users'); ?></label><input class="input-xlarge" type="text" value="<?php echo $user['lastname']; ?>" name="lastname">
<label><?php echo __('Email', 'users'); ?></label><input class="input-xlarge" type="text" value="<?php echo $user['email']; ?>" name="email">
<label><?php echo __('Twitter', 'users'); ?></label><input class="input-xlarge" type="text" value="<?php echo $user['twitter']; ?>" name="twitter">
<label><?php echo __('Skype', 'users'); ?></label><input class="input-xlarge" type="text" value="<?php echo $user['skype']; ?>" name="skype">
<label><?php echo __('About Me', 'users'); ?></label><textarea class="input-xlarge" name="about_me"><?php echo $user['about_me']; ?></textarea>
<label><?php echo __('New Password', 'users'); ?></label><input class="input-xlarge" type="text" name="new_password">
<br/><input type="submit" class="btn" value="<?php echo __('Save', 'users'); ?>" name="edit_profile">
</form>
