<?php  if ( ! defined('MONSTRA_ACCESS')) exit('No direct script access allowed'); ?><!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <title>Monstra :: <?php echo __('Administration', 'system'); ?></title>
        <meta name="description" content="Monstra Admin Area">
        <link rel="icon" href="<?php echo Option::get('siteurl'); ?>favicon.ico" type="image/x-icon" />
        <link rel="shortcut icon" href="<?php echo Option::get('siteurl'); ?>favicon.ico" type="image/x-icon" />

        <!-- Styles -->
        <?php Stylesheet::add('public/assets/css/bootstrap.css', 'backend', 1); ?>
        <?php Stylesheet::add('public/assets/css/bootstrap-responsive.css', 'backend', 2); ?>
        <?php Stylesheet::add('admin/themes/default/css/default.css', 'backend', 3); ?>
        <?php Stylesheet::load(); ?>

        <!-- JavaScripts -->
        <?php Javascript::add('public/assets/js/jquery.js', 'backend', 1); ?>
        <?php Javascript::add('public/assets/js/bootstrap.js', 'backend', 2); ?>
        <?php Javascript::add('admin/themes/default/js/default.js', 'backend', 3); ?>
        <?php Javascript::load(); ?>
        <script type="text/javascript">
            $().ready(function () {
                <?php if (Notification::get('reset_password') == 'reset_password') { ?>
                    $('.reset-password-area, .administration-btn').show();   
                    $('.administration-area, .reset-password-btn').hide();              
                <?php } else { ?>
                    $('.reset-password-area, .administration-btn').hide();
                    $('.administration-area, .reset-password-btn').show();              
                <?php } ?>
                 
                $('.reset-password-btn').click(function() {
                    $('.reset-password-area, .administration-btn').show();   
                    $('.administration-area, .reset-password-btn').hide();
                });

                $('.administration-btn').click(function() {
                    $('.reset-password-area, .administration-btn').hide();   
                    $('.administration-area, .reset-password-btn').show();
                });
            });     
        </script>

        
        <?php Action::run('admin_header'); ?>

        <!--[if lt IE 9]>
        <link rel="stylesheet" href="css/ie.css" type="text/css" media="screen" />
        <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
        <![endif]-->
        
    </head>
    <body class="login-body">
        
        <div class="row">
            <div class="well span3 authorization-block">
                <div style="text-align:center;"><a class="brand" href="<?php echo Option::get('siteurl'); ?>admin"><img src="<?php echo Option::get('siteurl'); ?>public/assets/img/monstra-logo-black.png" height="44" width="191"></a></div>
                <div class="administration-area">
                    <hr>
                    <div>
                        <h2 style="text-align:center;"><?php echo __('Administration', 'system'); ?></h2><br />
                        <form method="post">
                            <label><?php echo __('Username', 'users'); ?></label>
                            <input class="span3" name="login" type="text" />

                            <label><?php echo __('Password', 'users'); ?></label>
                            <input class="span3" name="password" type="password" />
                            <br />
                            <?php if (isset($login_error) && $login_error !== '') { ?><div class="alert alert-error"><?php echo $login_error; ?></div><?php } ?>
                            <input type="submit" name="login_submit" class="btn" value="<?php echo __('Enter', 'users'); ?>" />
                        </form>
                    </div>
                </div>
                
                <div class="reset-password-area">
                    <hr>
                    <div>
                        <h2 style="text-align:center;"><?php echo __('Reset Password', 'users'); ?></h2><br />
                        <?php if (Notification::get('success')) Alert::success(Notification::get('success')); ?>
                        <form method="post">
                            <label><?php echo __('Username', 'users'); ?></label>
                            <input name="login" class="span3" type="text" value="<?php echo $user_login; ?>" />

                            <?php if (Option::get('captcha_installed') == 'true') { ?>
                            <label><?php echo __('Captcha'); ?><label>
                            <input type="text" name="answer" class="span3">
                            <?php CryptCaptcha::draw(); ?>
                            <?php } ?>
                            <br>
                            <?php
                                if (count($errors) > 0) {
                                    foreach($errors as $error) {
                                        Alert::error($error);
                                    }
                                }
                            ?>
                            <input type="submit" name="reset_password_submit" class="btn" value="<?php echo __('Send New Password', 'users')?>" />
                        </form>
                    </div> 
                </div>  
                
                <hr>
                <div>
                    <div style="text-align:center;">
                        <a class="small-grey-text" href="<?php echo Option::get('siteurl'); ?>"><?php echo __('< Back to Website', 'system');?></a> - 
                        <a class="small-grey-text reset-password-btn" href="javascript:;"><?php echo __('Forgot your password? >', 'system');?></a>
                        <a class="small-grey-text administration-btn" href="javascript:;"><?php echo __('Administration >', 'system');?></a>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="span4 authorization-block-footer">
                <div style="text-align:center">
                    <span class="small-grey-text">© 2012 <a href="http://monstra.org" class="small-grey-text" target="_blank">Monstra</a> – <?php echo __('Version', 'system'); ?> <?php echo MONSTRA_VERSION; ?></span>            
                </div>
            </div>
        </div>

    </body>
</html>