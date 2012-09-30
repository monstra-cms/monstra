Dear <?php echo $user_login; ?>,
<br><br>
You have requested to reset your password on <?php echo $site_name; ?> because you have forgotten your password.
If you did not request this, please ignore it. It will expire and become useless in 24 hours time.
<br><br>
To reset your password, please visit the following page:
<?php echo $site_url; ?>users/password-reset?hash=<?php echo $new_hash; ?>
<br><br>    
When you visit that page, your password will be reset, and the new password will be emailed to you.
<br><br>
Your username is: <?php echo $user_login; ?>
<br><br>
To edit your profile, go to this page:
<?php echo $site_url ?>users/<?php echo $user_id; ?>
<br><br>
All the best,
<?php echo $site_name; ?>