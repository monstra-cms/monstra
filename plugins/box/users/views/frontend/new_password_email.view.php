Dear <?php echo $user_login ?>,

As you requested, your password has now been reset. Your new details are as follows:

Username: <?php echo $user_login; ?>

Password: <?php echo $new_password; ?>


To change your password, please visit this page: <?php echo $site_url; ?>users/<?php echo $user_id; ?>


All the best,
<?php echo $site_name; ?>