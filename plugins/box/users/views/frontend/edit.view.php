<div class="row">
	<div class="col-md-3">

		<form method="post">
		<?php
		    echo (
		        Form::hidden('csrf', Security::token()).
		        Form::hidden('user_id', $user['id'])
		    );
		?>

		<?php if (isset($_SESSION['user_role']) && in_array($_SESSION['user_role'], array('admin'))) { ?>
		<div class="form-group">
			<label><?php echo __('Username', 'users'); ?></label>
			<input class="form-control" type="text" value="<?php echo $user['login']; ?>" name="login">
		</div>
		<?php } else { echo Form::hidden('login', $user['login']); } ?>
		<div class="form-group">
			<label><?php echo __('Firstname', 'users'); ?></label>
			<input class="form-control" type="text" value="<?php echo $user['firstname']; ?>" name="firstname">
		</div>
		<div class="form-group">
			<label><?php echo __('Lastname', 'users'); ?></label>
			<input class="form-control" type="text" value="<?php echo $user['lastname']; ?>" name="lastname">
		</div>
		<div class="form-group">
			<label><?php echo __('Email', 'users'); ?></label>
			<input class="form-control" type="text" value="<?php echo $user['email']; ?>" name="email">
		</div>
		<div class="form-group">
			<label><?php echo __('Twitter', 'users'); ?></label>
			<input class="form-control" type="text" value="<?php echo $user['twitter']; ?>" name="twitter">
		</div>
		<div class="form-group">
			<label><?php echo __('Skype', 'users'); ?></label>
			<input class="form-control" type="text" value="<?php echo $user['skype']; ?>" name="skype">
		</div>
		<div class="form-group">
			<label><?php echo __('About Me', 'users'); ?></label>
			<textarea class="form-control" name="about_me"><?php echo $user['about_me']; ?></textarea>
		</div>
		<div class="form-group">
			<label><?php echo __('New Password', 'users'); ?></label>
			<input class="form-control" type="text" name="new_password">
		</div>
		<div class="form-group">
		<input type="submit" class="btn btn-primary" value="<?php echo __('Save', 'users'); ?>" name="edit_profile">
		<?php echo Html::anchor(__('Cancel', 'users'), Site::url().'/users/'.Uri::segment(1), array('title' => __('Cancel', 'pages'), 'class' => 'btn btn-default')); ?>
		</div>
		</form>
	</div>
</div>