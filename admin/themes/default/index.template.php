<?php if ( ! defined('MONSTRA_ACCESS')) exit('No direct script access allowed'); ?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Monstra :: <?php echo __('Administration', 'system'); ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Monstra admin area" />
    <link rel="icon" href="<?php echo Option::get('siteurl'); ?>favicon.ico" type="image/x-icon" />
    <link rel="shortcut icon" href="<?php echo Option::get('siteurl'); ?>favicon.ico" type="image/x-icon" />

    <!-- Styles -->
    <link rel="stylesheet" href="<?php echo Site::url(); ?>public/assets/css/bootstrap.min.css" type="text/css" />
    <link rel="stylesheet" href="<?php echo Site::url(); ?>public/assets/css/messenger.css" type="text/css" />
    <link rel="stylesheet" href="<?php echo Site::url(); ?>public/assets/css/messenger-theme-flat.css" type="text/css" />
    <?php Stylesheet::add('public/assets/css/bootstrap-lightbox.css', 'backend', 2); ?>
    <?php Stylesheet::add('public/assets/css/bootstrap-fileupload.css', 'backend', 3); ?>
    <?php Stylesheet::add('admin/themes/default/css/default.css', 'backend', 5); ?>
    <?php Stylesheet::load(); ?>

    <!-- JavaScripts -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
    <script src="<?php echo Site::url(); ?>public/assets/js/bootstrap.min.js"></script>
    <script src="<?php echo Site::url(); ?>public/assets/js/messenger.min.js"></script>
    <script src="<?php echo Site::url(); ?>public/assets/js/messenger-theme-flat.js"></script>
    
    <?php Javascript::add('public/assets/js/bootstrap-lightbox.js', 'backend', 3); ?>
    <?php Javascript::add('public/assets/js/bootstrap-fileupload.js', 'backend', 4); ?>
    <?php Javascript::add('admin/themes/default/js/default.js', 'backend', 5); ?>
    <?php Javascript::load(); ?>

    <?php Action::run('admin_header'); ?>

    <script>
      Messenger.options = {
          extraClasses: 'messenger-fixed messenger-on-bottom messenger-on-right',
          theme: 'flat'
      }
    </script>

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
    <![endif]-->
  </head>

  <body>

    <nav class="navbar navbar-default navbar-inverse" role="navigation">
      
      <div class="container">
          <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
              <span class="sr-only">Toggle navigation</span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="<?php echo Option::get('siteurl'); ?>admin">MONSTRA</a>
          </div>

          <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">      
            <ul class="nav navbar-nav">          
              <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown"><?php echo __('Content', 'pages'); ?> <b class="caret"></b></a>
                <ul class="dropdown-menu">
                    <?php Navigation::draw('content'); ?>
                </ul>
              </li>
              <?php if (Session::exists('user_role') && in_array(Session::get('user_role'), array('admin'))) { ?>               
              <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown"><?php echo __('Extends', 'system'); ?> <b class="caret"></b></a>
                <ul class="dropdown-menu">
                    <?php Navigation::draw('extends'); ?>                      
                </ul>
              </li>
              <?php } ?>
              <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown"><?php echo __('System', 'system'); ?> <b class="caret"></b></a>
                <ul class="dropdown-menu">
                    <?php Navigation::draw('system'); ?>                       
                </ul>
              </li>
              <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown"><?php echo __('Help', 'system'); ?> <b class="caret"></b></a>
                <ul class="dropdown-menu">
                    <li><a href="http://monstra.org/documentation" target="_blank"><?php echo __('Documentation', 'system'); ?></a></li>              
                    <li><a href="http://forum.monstra.org" target="_blank"><?php echo __('Official Support Forum', 'system'); ?></a></li>
                </ul>
              </li>
            </ul>        
            <ul class="nav navbar-nav navbar-right">
              <li><a href="<?php echo Site::url(); ?>" target="_blank"><?php echo __('View Site', 'system'); ?></a></li>
              <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown"><?php echo Session::get('user_login'); ?> <b class="caret"></b></a>
                <ul class="dropdown-menu">
                  <li><a href="<?php echo Site::url(); ?>admin/index.php?id=users&action=edit&user_id=<?php echo Session::get('user_id'); ?>"><?php echo __('Profile', 'users')?></a></li>
                  <li><a href="<?php echo Site::url(); ?>admin/?logout=do"><?php echo __('Log Out', 'users'); ?></a></li>              
                </ul>
              </li>
            </ul>        
          </div>
      </div>
    </nav>

    <div class="container">
        <div id="update-monstra"></div>
        <div><?php Action::run('admin_pre_template'); ?></div>
        <div>
            <?php
                if ($plugin_admin_area) {
                    if (is_callable(ucfirst(Plugin::$plugins[$area]['id']).'Admin::main')) {
                        call_user_func(ucfirst(Plugin::$plugins[$area]['id']).'Admin::main');
                    } else {
                        echo '<div class="message-error">'.__('Plugin main admin function does not exist', 'system').'</div>';
                    }
                } else {
                    echo '<div class="message-error">'.__('Plugin does not exist', 'system').'</div>';
                }
            ?>
        </div>
        <div><?php Action::run('admin_post_template'); ?></div>
      </div>
      <footer class="container">
          <p class="pull-right">
              <span style="border-top:1px solid #E0E0E0; padding-top:10px;">
                  <span class="hidden-phone">
                      <a href="http://forum.monstra.org" target="_blank"><?php echo __('Official Support Forum', 'system'); ?></a> /
                      <a href="http://monstra.org/documentation" target="_blank"><?php echo __('Documentation', 'system'); ?></a> /
                  </span>
                  © 2012 - 2014 <a href="http://monstra.org" target="_blank">Monstra</a> – <?php echo __('Version', 'system'); ?> <?php echo Monstra::VERSION; ?>
              </span>
          </p>
      </footer>
</body>
</html>
