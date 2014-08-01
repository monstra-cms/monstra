<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="x-dns-prefetch-control" content="on">
    <link rel="dns-prefetch" href="<?php echo Site::url(); ?>" />
    <link rel="dns-prefetch" href="//www.google-analytics.com" />
    
    <title><?php echo Site::name() . ' - ' . Site::title(); ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="<?php echo Site::description(); ?>">
    <meta name="keywords" content="<?php echo Site::keywords(); ?>">
    <meta name="robots" content="<?php echo Page::robots(); ?>">

    <?php Action::run('theme_meta'); ?>

    <!-- Open Graph Protocol -->
    <meta property="og:site_name" content="<?php echo Site::name(); ?>">
    <meta property="og:url" content="<?php echo Url::current(); ?>">
    <meta property="og:title" content="<?php echo Site::title(); ?> | <?php echo Site::name(); ?>">

    <!-- Google+ Snippets -->
    <meta itemprop="url" content="<?php echo Url::current(); ?>">
    <meta itemprop="name" content="<?php echo Site::title(); ?> | <?php echo Site::name(); ?>">

    <!-- Styles -->
    <link rel="stylesheet" href="<?php echo Site::url(); ?>/public/assets/css/bootstrap.css" type="text/css" />
    <?php Stylesheet::add('public/themes/default/css/default.css', 'frontend', 2); ?>
    <?php Stylesheet::load(); ?>

    <!-- JavaScripts -->
    <?php Javascript::add('public/assets/js/jquery.min.js', 'frontend', 1); ?>
    <?php Javascript::add('public/assets/js/bootstrap.min.js', 'frontend', 2); ?>
    <?php Javascript::load(); ?>

    <?php Action::run('theme_header'); ?>

    <!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
      <script src="//cdnjs.cloudflare.com/ajax/libs/html5shiv/3.7/html5shiv.js"></script>
    <![endif]-->

    <!-- Fav-icons -->
    <link rel="icon" href="<?php echo Site::url(); ?>/favicon.ico" type="image/x-icon">
    <link rel="shortcut icon" href="<?php echo Site::url(); ?>/favicon.ico" type="image/x-icon">
  </head>

  <body>

  <div class="masthead">

    <div class="navbar" role="navigation">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="<?php echo Site::url(); ?>"><?php echo Site::name(); ?></a>
        </div>
        <div class="collapse navbar-collapse">
          <ul class="nav navbar-nav">
              <?php echo Menu::get(); ?>
              <?php Users::getPanel(); ?>
          </ul>
        </div>
      </div>
    </div>

    <div class="page-header container text-center">
      <?php if (Uri::segment(0) == 'users'  && Uri::segment(1) == '') { ?>
        <h1><?php echo __('Users', 'users'); ?></h1>
      <?php } elseif (Uri::segment(0) == 'sitemap') { ?>
        <h1><?php echo __('Sitemap', 'sitemap'); ?></h1>
      <?php } elseif (Uri::segment(0) == 'users' && Uri::segment(1) == 'registration') { ?>        
        <h1><?php echo __('Registration', 'users'); ?></h1>
      <?php } elseif (Uri::segment(0) == 'users' && Uri::segment(1) == 'login') { ?>
        <h1><?php echo __('Log In', 'users'); ?></h1>
      <?php } elseif (Uri::segment(0) == 'users' && Uri::segment(1) == 'password-reset') { ?>                
        <h1><?php echo __('Reset Password', 'users') ?></h1>
      <?php } elseif (Uri::segment(0) == 'users' && Uri::segment(2) == 'edit') { ?>                
        <h1><?php echo __('Edit profile', 'users') ?></h1>
      <?php } elseif (Uri::segment(0) == 'users' && Uri::segment(1) ) { ?>
        <h1><?php echo __('Profile', 'users'); ?></h1>
      <?php } else { ?>
        <h1><?php echo Page::title(); ?></h1>
      <?php } ?>
    </div>

  </div>
