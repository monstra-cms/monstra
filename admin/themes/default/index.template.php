<?php if ( ! defined('MONSTRA_ACCESS')) exit('No direct script access allowed'); ?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Monstra :: <?php echo __('Administration', 'system'); ?></title>  
    <meta name="description" content="Monstra admin area" />
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

    <?php Action::run('admin_header'); ?>

    <!--[if lt IE 9]>
    <link rel="stylesheet" href="css/ie.css" type="text/css" media="screen" />
    <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->

</head>
<body>

    <!-- Block_topbar -->
    <div class="monstra-header">
        <div class="monstra-header-inner">
            <div class="container-fluid">               
                <a class="brand" href="<?php echo Option::get('siteurl'); ?>admin"><img src="<?php echo Option::get('siteurl'); ?>public/assets/img/monstra-logo-black.png" height="44" width="191"></a>            
                <p class="pull-right">
                    <?php Navigation::draw('top', Navigation::TOP); ?>
                </p>
            </div>
        </div>
    </div>
    <!-- /Block_topbar -->

    <!-- Block_container -->
    <div class="container-fluid">

        <div class="row-fluid">

            <!-- Block_sidebar -->
            <div class="span2 monstra-menu-sidebar">
                <h3><?php echo __('Content', 'pages'); ?></h3>
                <ul>
                    <?php Navigation::draw('content'); ?>
                </ul>
                <div class="monstra-menu-category-separator"></div>
                <?php if (Session::exists('user_role') && in_array(Session::get('user_role'), array('admin'))) { ?>
                <h3><?php echo __('Extends', 'system'); ?></h3>
                <ul>
                   <?php Navigation::draw('extends'); ?>
                </ul>                
                <div class="monstra-menu-category-separator"></div>
                <?php } ?>
                <h3><?php echo __('System', 'system'); ?></h3>
                <ul>
                    <?php Navigation::draw('system'); ?>
                </ul> 
            </div>
            <!-- /Block_sidebar -->

            <!-- Block_content -->
            <div class="span10 monstra-content">
               
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
            <!-- /Block_content -->

        </div>

        <!-- Block_footer -->
        <footer>
            <p align="right"><span class="badge"><span class="small-white-text">© 2012 <a href="http://monstra.org" class="small-white-text" target="_blank">Monstra</a> – <?php echo __('Version', 'system'); ?> <?php echo MONSTRA_VERSION; ?></span></span></p>
        </footer>
        <!-- /Block_footer -->

    </div>
    <!-- /Block_container -->

</body>
</html>