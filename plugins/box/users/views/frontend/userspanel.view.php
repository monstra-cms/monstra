<div style="float:right">
    <?php if (Session::get('user_id')) { ?>
        <?php echo __('Welcome', 'users'); ?>,
        <a href="<?php echo Site::url(); ?>users/<?php echo Session::get('user_id'); ?>"><?php echo Session::get('user_login'); ?></a> /
        <?php if (in_array(Session::get('user_role'), array('admin', 'editor'))) { ?>
            <a href="<?php echo Site::url(); ?>admin"><?php echo __('Administration', 'system'); ?></a> /
        <?php } ?>
        <a href="<?php echo Site::url(); ?>users/logout"><?php echo __('Log Out', 'users'); ?></a>
        <?php } else { ?>
        <a href="<?php echo Site::url(); ?>users/login"><?php echo __('Log In', 'users'); ?></a> /
        <a href="<?php echo Site::url(); ?>users/registration"><?php echo __('Registration', 'users'); ?></a>
    <?php } ?>
</div>
