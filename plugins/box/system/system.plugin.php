<?php

/**
 *	System plugin
 *
 *	@package Monstra
 *  @subpackage Plugins
 *	@author Romanenko Sergey / Awilum
 *	@copyright 2012-2014 Romanenko Sergey / Awilum
 *	@version 1.0.0
 *
 */

// Register plugin
Plugin::register( __FILE__,
                __('System', 'system'),
                __('System plugin', 'system'),
                '1.0.0',
                'Awilum',
                'http://monstra.org/',
                null,
                'box');

if (Session::exists('user_role') && in_array(Session::get('user_role'), array('admin', 'editor'))) {

    // Admin top navigation
    Navigation::add(__('Welcome, :username', 'system', array(':username' => Session::get('user_login'))), 'top', 'users&action=edit&user_id='.Session::get('user_id'), 1, Navigation::TOP, false);
    Navigation::add(__('View Site', 'system'), 'top', Option::get('siteurl'), 2, Navigation::TOP, true);
    Navigation::add(__('Log Out', 'users'), 'top', '&logout=do', 3, Navigation::TOP, false);

    if (Session::exists('user_role') && in_array(Session::get('user_role'), array('admin'))) {
        Navigation::add(__('Settings', 'system'), 'system', 'system', 1);
    }

}

Plugin::Admin('system', 'box');
