Dear <?php echo $user_login; ?>,

You have requested to reset your password on <?php echo $site_name; ?> because you have forgotten your password.
If you did not request this, please ignore it.

To reset your password, please visit the following page:
<?php echo $site_url; ?>users/password-reset?hash=<?php echo $new_hash; ?>

When you visit that page, your password will be reset, and the new password will be emailed to you.

Your username is: <?php echo $user_login; ?>


To edit your profile, go to this page:
<?php echo $site_url ?>users/<?php echo $user_id; ?>


All the best,
<?php echo $site_name; ?>