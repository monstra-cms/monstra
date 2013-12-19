<?php

/**
 *  Captcha plugin
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
                __('Captcha', 'captcha'),
                __('Captcha plugin for Monstra', 'captcha'),
                '1.0.0',
                'Awilum',
                'http://monstra.org/');

// Set crypt captcha path to images
$cryptinstall = Option::get('siteurl').'plugins/captcha/crypt/images/';

// Include Crypt Captcha
include PLUGINS . DS . 'captcha/crypt/cryptographp.fct.php';

/**
 * Crypt Captha class
 */
class CryptCaptcha
{
    /**
     * Draw
     */
    public static function draw()
    {
        dsp_crypt();
    }

    /**
     * Check
     */
    public static function check($answer)
    {
        return chk_crypt($answer);
    }
}
