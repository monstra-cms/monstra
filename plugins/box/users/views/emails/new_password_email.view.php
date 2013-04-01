Dear <?php echo $user_login ?>,
<br /><br />
As you requested, your password has now been reset.<br/>
Your new details are as follows:
<br /><br />
Username: <?php echo $user_login; ?><br />
Password: <?php echo $new_password; ?>
<br /><br />
To change your password, please visit this page: <a href="<?php echo $site_url; ?>users/<?php echo $user_id; ?>" style="color:#333; text-decoration:underline;"><?php echo $site_url; ?>users/<?php echo $user_id; ?></a>
<br /><br />
All the best,<br />
<?php echo $site_name; ?>
