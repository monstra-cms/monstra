<?php

/**
 *	Files manager plugin
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
                __('Files manager', 'filesmanager'),
                __('Files manager', 'filesmanager'),
                '1.0.0',
                'Awilum',
                'http://monstra.org/',
                null,
                'box');

if (Session::exists('user_role') && in_array(Session::get('user_role'), array('admin', 'editor'))) {

    // Include Admin
    Plugin::admin('filesmanager', 'box');

}