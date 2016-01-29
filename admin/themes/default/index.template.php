<?php if ( ! defined('MONSTRA_ACCESS')) exit('No direct script access allowed'); ?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">

    <meta http-equiv="x-dns-prefetch-control" content="on">
    <link rel="dns-prefetch" href="<?php echo Site::url(); ?>" />
    <link rel="dns-prefetch" href="//www.google-analytics.com" />
    <link rel="dns-prefetch" href="//www.gravatar.com" />

    <title>Monstra :: <?php echo __('Administration', 'system'); ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Monstra Admin Area" />
    <link rel="icon" href="<?php echo Option::get('siteurl'); ?>/favicon.ico" type="image/x-icon" />
    <link rel="shortcut icon" href="<?php echo Option::get('siteurl'); ?>/favicon.ico" type="image/x-icon" />

    <!-- Styles -->
    <link rel="stylesheet" href="<?php echo Site::url(); ?>/public/assets/css/bootstrap.css" type="text/css" />
    <link rel="stylesheet" href="<?php echo Site::url(); ?>/public/assets/css/messenger.css" type="text/css" />
    <link rel="stylesheet" href="<?php echo Site::url(); ?>/public/assets/css/messenger-theme-flat.css" type="text/css" />
    <?php Stylesheet::add('public/assets/css/chocolat.css', 'backend', 2); ?>
    <?php Stylesheet::add('public/assets/css/bootstrap-fileupload.css', 'backend', 3); ?>
    <?php Stylesheet::add('public/assets/css/icheck-blue.css', 'backend', 4); ?>
    <?php Stylesheet::add('admin/themes/default/css/default.css', 'backend', 5); ?>
    <?php Stylesheet::load(); ?>

    <!-- JavaScripts -->
    <script src="<?php echo Site::url(); ?>/public/assets/js/jquery.min.js"></script>
    <script src="<?php echo Site::url(); ?>/public/assets/js/bootstrap.min.js"></script>
    <script src="<?php echo Site::url(); ?>/public/assets/js/messenger.min.js"></script>
    <script src="<?php echo Site::url(); ?>/public/assets/js/icheck.min.js"></script>
    <?php Javascript::add('public/assets/js/jquery.chocolat.js', 'backend', 3); ?>
    <?php Javascript::add('public/assets/js/bootstrap-fileupload.js', 'backend', 4); ?>
    <?php Javascript::add('admin/themes/default/js/default.js', 'backend', 5); ?>
    <?php Javascript::load(); ?>

    <?php Action::run('admin_header'); ?>

    <script>
        $(document).ready(function() {

          $('.chocolat').Chocolat({
              overlayColor          : '#000',
              leftImg               : "<?php echo Option::get('siteurl'); ?>/public/assets/img/chocolat/left.gif",
              rightImg              : "<?php echo Option::get('siteurl'); ?>/public/assets/img/chocolat/right.gif",
              closeImg              : "<?php echo Option::get('siteurl'); ?>/public/assets/img/chocolat/close.gif",
              loadingImg            : "<?php echo Option::get('siteurl'); ?>/public/assets/img/chocolat/loading.gif"
          });

          $('input').iCheck({
              checkboxClass: 'icheckbox_square-blue',
              radioClass: 'iradio_square-blue',
              increaseArea: '20%'
          });

        });
    </script>

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="//cdnjs.cloudflare.com/ajax/libs/html5shiv/3.7/html5shiv.js"></script>
      <script src="//cdnjs.cloudflare.com/ajax/libs/respond.js/1.4.2/respond.js"></script>
    <![endif]-->
  </head>

  <body class="page-<?php echo Request::get('id'); ?>">

    <nav class="navbar navbar-default navbar-inverse" role="navigation">
      <div class="container">
          <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
              <span class="sr-only">Toggle navigation</span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="<?php echo Site::url(); ?>/admin/index.php?id=dashboard">MONSTRA</a>
          </div>

          <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav">
              <li<?php if (Request::get('id') == 'dashboard') { ?> class="active"<?php } ?>><a href="<?php echo Site::url(); ?>/admin/index.php?id=dashboard"><?php echo __('Dashboard', 'dashboard'); ?></a></li>
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
                    <?php if (Option::get('language') == 'ru') { ?>
                    <li><a href="http://ru.forum.monstra.org" target="_blank"><?php echo __('Official Support Forum', 'system'); ?></a></li>
                    <?php } else { ?>
                    <li><a href="http://forum.monstra.org" target="_blank"><?php echo __('Official Support Forum', 'system'); ?></a></li>
                    <?php } ?>
                </ul>
              </li>
            </ul>
            <ul class="nav navbar-nav navbar-right">
              <li><a href="<?php echo Site::url(); ?>" target="_blank"><?php echo __('View Site', 'system'); ?></a></li>
              <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown"><?php echo Session::get('user_login'); ?> <img src="<?php echo Users::getGravatarURL(Session::get('user_email'), 28); ?>" alt=""> <b class="caret"></b></a>
                <ul class="dropdown-menu">
                  <li><a href="<?php echo Site::url(); ?>/admin/index.php?id=users&action=edit&user_id=<?php echo Session::get('user_id'); ?>"><?php echo __('Profile', 'users')?></a></li>
                  <li><a href="<?php echo Site::url(); ?>/admin/?logout=do"><?php echo __('Log Out', 'users'); ?></a></li>
                </ul>
              </li>
            </ul>
          </div>
      </div>
    </nav>

    <div class="container">

        <?php
            // Monstra Notifications
            Notification::get('success') AND Alert::success(Notification::get('success'));
            Notification::get('warning') AND Alert::warning(Notification::get('warning'));
            Notification::get('error')   AND Alert::error(Notification::get('error'));
        ?>

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
      <div class="margin-top-1  margin-bottom-1 hidden-md"></div>
      <footer class="container visible-md visible-lg">
          <p class="pull-right">
            <span>
              <a href="http://monstra.org" target="_blank">Monstra</a> was made by <a href="http://awilum.github.io" target="_blank" class="highlight">Sergey Romanenko</a> and is maintained by <a href="https://github.com/monstra-cms/monstra/network/members" target="_blank" class="highlight">Monstra Community</a> / © 2012 - 2016 <a href="http://monstra.org/about/license" target="_blank">Monstra</a> – <?php echo __('Version', 'system'); ?> <?php echo Monstra::VERSION; ?>
            </span>
          </p>
      </footer>
</body>
</html>
