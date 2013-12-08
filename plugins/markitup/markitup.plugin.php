<?php

/**
 *	MarkItUp! plugin
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
                __('MarkItUp!', 'markitup'),
                __('MarkItUp! universal markup jQuery editor', 'markitup'),
                '1.0.0',
                'Awilum',
                'http://monstra.org/');

// Add hooks
Action::add('admin_header', 'MarkItUp::headers');

/**
 * MarkItUp Class
 */
class MarkItUp
{
    /**
     * Set editor headers
     */
    public static function headers()
    {
        echo ('
            <!-- markItUp! 1.1.13 -->
            <script type="text/javascript" src="'.Option::get('siteurl').'plugins/markitup/markitup/jquery.markitup.js"></script>
            <!-- markItUp! toolbar settings -->
            <script type="text/javascript" src="'.Option::get('siteurl').'plugins/markitup/markitup/sets/html/set.js"></script>
            <!-- markItUp! skin -->
            <link rel="stylesheet" type="text/css" href="'.Option::get('siteurl').'plugins/markitup/markitup/skins/simple/style.css" />
            <!--  markItUp! toolbar skin -->
            <link rel="stylesheet" type="text/css" href="'.Option::get('siteurl').'plugins/markitup/markitup/sets/html/style.css" />
        ');

        echo ('<script>$(document).ready(function(){$("#editor_area").markItUp(mySettings);});</script>');
    }

}
