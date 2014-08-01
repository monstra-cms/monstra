<?php if (Session::get('user_id')) { ?>
    <li class="dropdown">
        <a href="#" class="dropdown-toggle" data-toggle="dropdown"><?php echo __('Welcome', 'users'); ?>, <?php echo Session::get('user_login'); ?><b class="caret"></b></a>
        <ul class="dropdown-menu">
            <li><a href="<?php echo Site::url(); ?>/users/<?php echo Session::get('user_id'); ?>"><?php echo __('Profile', 'users'); ?></a></li>
            <?php if (in_array(Session::get('user_role'), array('admin', 'editor'))) { ?>
                <li><a href="<?php echo Site::url(); ?>/admin"><?php echo __('Administration', 'system'); ?></a></li>
            <?php } ?>
            <li><a href="<?php echo Site::url(); ?>/users/logout"><?php echo __('Log Out', 'users'); ?></a></li>
        </ul>
    </li>
    <?php } else { ?>
    <li><a href="<?php echo Site::url(); ?>/users/login"><?php echo __('Log In', 'users'); ?></a></li>
    <li><a href="<?php echo Site::url(); ?>/users/registration"><?php echo __('Registration', 'users'); ?></a></li>
<?php } ?>