Dear <?php echo $user_login ?>,
<br><br>
As you requested, your password has now been reset. Your new details are as follows:
<br><br>   
Username: <?php echo $user_login; ?><br>
Password: <?php echo $new_password; ?>
<br><br>
To change your password, please visit this page: <?php echo $site_url; ?>users/<?php echo $user_id; ?>
<br><br>
All the best,
<?php echo $site_name; ?>