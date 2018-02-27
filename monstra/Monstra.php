<?php

 /**
  * Monstra
  *
  * @package Monstra
  * @author Romanenko Sergey / Awilum <awilum@msn.com>
  * @link http://monstra.org
  *
  * For the full copyright and license information, please view the LICENSE
  * file that was distributed with this source code.
  */

class Monstra
{
    /**
     * An instance of the Monstra class
     *
     * @var object
     * @access protected
     */
    protected static $instance = null;

    /**
     * The version of Monstra
     *
     * @var string
     */
    const VERSION = '4.0.0 alpha';

    /**
     * Protected clone method to enforce singleton behavior.
     *
     * @access protected
     */
    protected function __clone()
    {
        // Nothing here.
    }

    /**
     * Constructor.
     *
     * @access protected
     */
    protected function __construct()
    {
        // Init Config
        Config::init();

        // Turn on output buffering
        ob_start();

        // Display Errors
        Config::get('site.errors.display') and error_reporting(-1);

        // Set internal encoding
        function_exists('mb_language') and mb_language('uni');
        function_exists('mb_regex_encoding') and mb_regex_encoding(Config::get('site.charset'));
        function_exists('mb_internal_encoding') and mb_internal_encoding(Config::get('site.charset'));

        // Set default timezone
        date_default_timezone_set(Config::get('site.timezone'));

        // Start the session
        Session::start();

        // Init Cache
        Cache::init();

        // Init Plugins
        Plugins::init();

        // Init Blocks
        Blocks::init();

        // Init Pages
        Pages::init();

        // Flush (send) the output buffer and turn off output buffering
        ob_end_flush();
    }

    /**
     * Initialize Monstra Application
     *
     *  <code>
     *      Monstra::init();
     *  </code>
     *
     * @access public
     * @return object
     */
    public static function init()
    {
        return !isset(self::$instance) and self::$instance = new Monstra();
    }
}
