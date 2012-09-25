<h3><?php echo __('Profile', 'users'); ?></h3>
<hr>
<?php if ($user) { ?>
<table>
<tr><td><?php echo __('Username', 'users'); ?></td><td><?php echo $user['login']; ?></td></tr>
<tr><td><?php echo __('Firstname', 'users'); ?></td><td><?php echo Html::toText($user['firstname']); ?></td></tr>
<tr><td><?php echo __('Lastname', 'users'); ?></td><td><?php echo Html::toText($user['lastname']); ?></td></tr>
<tr><td><?php echo __('Email', 'users'); ?></td><td><?php echo Html::toText($user['email']); ?></td></tr>
<tr><td><?php echo __('Registered', 'users'); ?></td><td><?php echo Date::format($user['date_registered']); ?></td></tr>
<tr><td><?php echo __('Skype', 'users'); ?></td><td><?php echo Html::toText($user['skype']); ?></td></tr>
<tr><td><?php echo __('Twitter', 'users'); ?></td><td><?php echo Html::toText($user['twitter']); ?></td></tr>
</table>
<br />
<?php if (Users::isLoged()) { ?>
<a href="<?php echo Site::url(); ?>users/<?php echo $user['id']; ?>/edit"><?php echo __('Edit profile', 'users'); ?></a> /
<?php if(in_array(Session::get('user_role'), array('admin', 'editor'))) { ?> <a href="<?php echo Site::url(); ?>admin"><?php echo __('Administration', 'system'); ?></a> / <?php } ?>
<a href="<?php echo Site::url(); ?>users/logout"><?php echo __('Logout', 'users'); ?></a>
<?php } ?>
<?php } else { echo __('This users doesnt exists', 'users'); } ?>