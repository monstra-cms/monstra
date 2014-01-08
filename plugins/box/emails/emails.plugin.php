<?php

/**
 *  Emails plugin
 *
 *  @package Monstra
 *  @subpackage Plugins
 *  @author Romanenko Sergey / Awilum
 *  @copyright 2012-2014 Romanenko Sergey / Awilum
 *  @version 1.0.0
 *
 */

// Register plugin
Plugin::register( __FILE__,
                __('Emails', 'emails'),
                __('Emails plugin for Monstra', 'emails'),
                '1.0.0',
                'Awilum',
                'http://monstra.org/',
                null,
                'box');

// Load Emails Admin for Editor and Admin
if (Session::exists('user_role') && in_array(Session::get('user_role'), array('admin', 'editor'))) {

    Plugin::admin('emails', 'box');

}