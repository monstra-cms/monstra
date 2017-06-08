<!DOCTYPE html>
<html lang="fr">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="x-dns-prefetch-control" content="on">
    <link rel="dns-prefetch" href="<?php echo Site::url(); ?>" />    
    <title><?php echo  Site::title() . ' - ' .Site::name(); ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="<?php echo Site::description(); ?>">
    <meta name="keywords" content="<?php echo Site::keywords(); ?>">
    <meta name="robots" content="index, follow">

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
    <link rel="stylesheet" href="<?php echo Site::url(); ?>/public/assets/css/bootstrap.flatty.min.css" type="text/css" />
    <link rel="stylesheet" href="<?php echo Site::url(); ?>/public/assets/css/font-awesome.min.css" type="text/css" />
    <link rel="stylesheet" href="<?php echo Site::url(); ?>/public/themes/default/css/default.css" type="text/css" />
   



    <?php Stylesheet::load(); ?>



    <!-- JavaScripts -->
    <script src="<?php echo Site::url(); ?>/public/assets/js/jquery.min.js"></script>


    <?php Javascript::add('public/assets/js/bootstrap.min.js', 'frontend', 2); ?>
    <?php Javascript::add('public/themes/default/js/default.js', 'frontend', 6); ?>  
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

<div class="container-fluid headerbg">
<nav class="navbar navbar-default navbar-fixed-top" role="navigation">
    <div class="container">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header page-scroll">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#menu_collapse">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="<?php echo Site::url(); ?>">
                    <?php echo Site::name(); ?>
            </a>        
        </div>
        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse" id="menu_collapse">
            
          <ul class="nav navbar-nav">
                <?php echo Menu::get(); ?>
          </ul>
                 
          <ul class="nav navbar-nav navbar-right">
                <?php Users::getPanel(); ?>          
          </ul>
            
        </div>
        <!-- /.navbar-collapse -->
    </div>
    <!-- /.container-fluid -->

    
    
    
    <div id="topTitle" style="display:none;background:#1a242f">
          <div class="container text-center">
            <div class="navbar-brand">
          
                <?php

                $class=  Uri::segment(0);
                if (Uri::segment(0) == 'users'  && Uri::segment(1) == '') {
                    echo __('Users', 'users');
                } elseif (Uri::segment(0) == 'sitemap') {
                    echo __('Sitemap', 'sitemap');
                } elseif (Uri::segment(0) == 'users' && Uri::segment(1) == 'registration') {
                    echo __('Registration', 'users');
                } elseif (Uri::segment(0) == 'users' && Uri::segment(1) == 'login') {
                    echo __('Log In', 'users');
                } elseif (Uri::segment(0) == 'users' && Uri::segment(1) == 'password-reset') {
                    echo __('Reset Password', 'users');
                } elseif (Uri::segment(0) == 'users' && Uri::segment(2) == 'edit') {
                    echo __('Edit profile', 'users');
                } elseif (Uri::segment(0) == 'users' && Uri::segment(1)) {
                    echo __('Profile', 'users');
                } elseif (class_exists($class)) {
                    echo $class::title() ;
                } else {
                    echo Page::title();
                }
            ?>
          </div>
              
          <a class="navbar-brand navbar-right " href="#top">
              
              <i class="fa fa-angle-up" aria-hidden="true"></i>

          </a>
              
        </div>
        
      </div>
</nav>
      

    <div class="jumbotron transparent text-inverse">
      <div class="container ">
        <h1 id="headerTitle" class=" text-center">
            <?php
            $class=  Uri::segment(0);
            if (Uri::segment(0) == 'users'  && Uri::segment(1) == '') {
                echo __('Users', 'users');
            } elseif (Uri::segment(0) == 'sitemap') {
                echo __('Sitemap', 'sitemap');
            } elseif (Uri::segment(0) == 'users' && Uri::segment(1) == 'registration') {
                echo __('Registration', 'users');
            } elseif (Uri::segment(0) == 'users' && Uri::segment(1) == 'login') {
                echo __('Log In', 'users');
            } elseif (Uri::segment(0) == 'users' && Uri::segment(1) == 'password-reset') {
                echo __('Reset Password', 'users');
            } elseif (Uri::segment(0) == 'users' && Uri::segment(2) == 'edit') {
                echo __('Edit profile', 'users');
            } elseif (Uri::segment(0) == 'users' && Uri::segment(1)) {
                echo __('Profile', 'users');
            } elseif (class_exists($class)) {
                echo $class::title() ;
            } else {
                echo Page::title();
            }

        ?>
        </h1>
            
      </div>
    </div> 
  </div>