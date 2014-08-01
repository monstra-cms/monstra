<?php if ($user) { ?>
<table>
<tr><td><b><?php echo __('Username', 'users'); ?></b>:</td><td><?php echo $user['login']; ?></td></tr>
<?php if ($user['firstname'] !== '') { ?><tr><td><b><?php echo __('Firstname', 'users'); ?></b>:</td><td><?php echo Html::toText($user['firstname']); ?></td></tr><?php } ?>
<?php if ($user['lastname'] !== '') { ?><tr><td><b><?php echo __('Lastname', 'users'); ?></b>:</td><td><?php echo Html::toText($user['lastname']); ?></td></tr><?php } ?>
<?php if ($user['email'] !== '') { ?><tr><td><b><?php echo __('Email', 'users'); ?></b>:</td><td><?php echo Html::email(Html::toText($user['email'])); ?></td></tr><?php } ?>
<?php if ($user['date_registered'] !== '') { ?><tr><td><b><?php echo __('Registered', 'users'); ?></b>:</td><td><?php echo Date::format($user['date_registered']); ?></td></tr><?php } ?>
<?php if ($user['skype'] !== '') { ?><tr><td><b><?php echo __('Skype', 'users'); ?></b>:</td><td><?php echo Html::toText($user['skype']); ?></td></tr><?php } ?>
<?php if ($user['twitter'] !== '') { ?><tr><td><b><?php echo __('Twitter', 'users'); ?></b>:</td><td><?php echo Html::toText($user['twitter']); ?></td></tr><?php } ?>
<?php if ($user['about_me'] !== '') { ?><tr><td><b><?php echo __('About Me', 'users'); ?></b>:</td><td><?php echo Filter::apply('content', Html::toText($user['about_me'])); ?></td></tr><?php } ?>
</table>
<?php if (Users::isLoged()) { ?>
<br>
<a href="<?php echo Site::url(); ?>/users/<?php echo $user['id']; ?>/edit"><?php echo __('Edit profile', 'users'); ?></a> /
<?php if (in_array(Session::get('user_role'), array('admin', 'editor'))) { ?> <a href="<?php echo Site::url(); ?>/admin"><?php echo __('Administration', 'system'); ?></a> / <?php } ?>
<a href="<?php echo Site::url(); ?>/users/logout"><?php echo __('Log Out', 'users'); ?></a>
<?php } ?>
<?php } else { echo __('This users doesnt exists', 'users'); } ?>
