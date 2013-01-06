<?php defined('MONSTRA_ACCESS') or die('No direct script access.');

/**
 *  Main Monstra Engine module.
 *
 *	Monstra - Content Management System.
 *  Site: mostra.org
 *	Copyright (C) 2012 Romanenko Sergey / Awilum [awilum@msn.com]
 *
 *	@package Monstra
 *	@author Romanenko Sergey / Awilum
 *	@copyright 2012 Romanenko Sergey / Awilum
 *	@version $Id$
 *	@since 1.0.0
 *  @license http://opensource.org/licenses/gpl-license.php GNU Public License
 *  Monstra is free software. This version may have been modified pursuant
 *  to the GNU General Public License, and as distributed it includes or
 *  is derivative of works licensed under the GNU General Public License or
 *  other free or open source software licenses.
 *  See COPYING.txt for copyright notices and details.
 */

class Core
{
    /**
     * An instance of the Core class
     *
     * @var core
     */
    protected static $instance = null;

    /**
     * Common environment type constants for consistency and convenience
     */
    const PRODUCTION  = 1;
    const STAGING     = 2;
    const TESTING     = 3;
    const DEVELOPMENT = 4;

    /**
     * The version of Monstra
     */
    const VERSION = '2.1.3';

    /**
     * Monstra environment
     *
     * @var string
     */
    public static $environment = Core::PRODUCTION;

    /**
     * Protected clone method to enforce singleton behavior.
     *
     * @access  protected
     */
    protected function __clone()
    {
        // Nothing here.
    }

    /**
     * Construct
     */
    protected function __construct()
    {
        // Load core defines
        Core::loadDefines();

        /**
         * Compress HTML with gzip
         */
        if (MONSTRA_GZIP) {
            if ( ! ob_start("ob_gzhandler")) ob_start();
        } else {
            ob_start();
        }

        /**
         * Send default header and set internal encoding
         */
        header('Content-Type: text/html; charset=UTF-8');
        function_exists('mb_language') AND mb_language('uni');
        function_exists('mb_regex_encoding') AND mb_regex_encoding('UTF-8');
        function_exists('mb_internal_encoding') AND mb_internal_encoding('UTF-8');

        /**
         * Gets the current configuration setting of magic_quotes_gpc
         * and kill magic quotes
         */
        if (get_magic_quotes_gpc()) {
            function stripslashesGPC(&$value) { $value = stripslashes($value); }
            array_walk_recursive($_GET, 'stripslashesGPC');
            array_walk_recursive($_POST, 'stripslashesGPC');
            array_walk_recursive($_COOKIE, 'stripslashesGPC');
            array_walk_recursive($_REQUEST, 'stripslashesGPC');
        }

        /**
         * Set Gelato Display Errors to False for Production environment.
         */
        if (Core::$environment == Core::PRODUCTION) {
            define('GELATO_DISPLAY_ERRORS', false);
        }

        /**
         * Include Gelato Library
         */
        include ROOT . '/libraries/Gelato/Gelato.php';

        // Start session
        Session::start();

        // Init ORM
        if (defined('MONSTRA_DB_DSN')) {
            require_once(ROOT . '/libraries/Idiorm/Idiorm.php');
            Orm::configure(MONSTRA_DB_DSN);
            Orm::configure('username', MONSTRA_DB_USER);
            Orm::configure('password',  MONSTRA_DB_PASSWORD);
        }

        // Auto cleanup if MONSTRA_DEBUG is true
        if (Core::$environment == Core::DEVELOPMENT) {

            // Cleanup minify
            if (count($files = File::scan(MINIFY, array('css', 'js', 'php'))) > 0) foreach ($files as $file) File::delete(MINIFY . DS . $file);

            // Cleanup cache
            if (count($namespaces = Dir::scan(CACHE)) > 0) foreach ($namespaces as $namespace) Dir::delete(CACHE . DS . $namespace);
        }

        // Set cache dir
        Cache::configure('cache_dir', CACHE);

        // Load Securitu module
        require_once(ROOT . '/engine/Security.php');

        // Load URI module
        require_once(ROOT . '/engine/Uri.php');

        // Load XMLDB API module
        require_once(ROOT . '/engine/Xmldb.php');

        // Load Options API module
        require_once(ROOT . '/engine/Options.php');

        // Init Options API module
        Option::init();

        // Set default timezone
        @ini_set('date.timezone', Option::get('timezone'));
        if (function_exists('date_default_timezone_set')) date_default_timezone_set(Option::get('timezone')); else putenv('TZ='.Option::get('timezone'));

        // Sanitize URL to prevent XSS - Cross-site scripting
        Security::runSanitizeURL();

        // Load Plugins API module
        require_once(ROOT . '/engine/Plugins.php');

        // Load Shortcodes API module
        require_once(ROOT . '/engine/Shortcodes.php');

        // Load default
        Core::loadPluggable();

        // Init I18n
        I18n::init(Option::get('language'));

        // Init Plugins API
        Plugin::init();

        // Init Notification service
        Notification::init();

        // Load Site module
        require_once(ROOT . '/engine/Site.php');

        // Init site module
        if( ! BACKEND) Site::init();

    }

    /**
     * Load Defines
     */
    protected static function loadDefines()
    {
        $environments = array(1 => 'production',
                              2 => 'staging',
                              3 => 'testing',
                              4 => 'development');

        $root_defines         = ROOT . DS . 'boot' . DS . 'defines.php';
        $environment_defines  = ROOT . DS . 'boot' . DS . $environments[Core::$environment] . DS . 'defines.php';
        $monstra_defines      = ROOT . DS . 'engine' . DS . 'boot' . DS . 'defines.php';

        if (file_exists($root_defines)) {
            include $root_defines;
        } elseif (file_exists($environment_defines)) {
            include $environment_defines;
        } elseif (file_exists($monstra_defines)) {
            include $monstra_defines;
        } else {
            throw new RuntimeException("The defines file does not exist.");
        }
    }

    /**
     * Load Pluggable
     */
    protected static function loadPluggable()
    {
        $environments = array(1 => 'production',
                              2 => 'staging',
                              3 => 'testing',
                              4 => 'development');

        $root_pluggable         = ROOT . DS . 'boot';
        $environment_pluggable  = ROOT . DS . 'boot' . DS . $environments[Core::$environment];
        $monstra_pluggable      = ROOT . DS . 'engine' . DS . 'boot';

        if (file_exists($root_pluggable . DS . 'filters.php')) {
            include $root_pluggable . DS . 'filters.php';
        } elseif (file_exists($environment_pluggable . DS . 'filters.php')) {
            include $environment_pluggable . DS . 'filters.php';
        } elseif (file_exists($monstra_pluggable . DS . 'filters.php')) {
            include $monstra_pluggable . DS . 'filters.php';
        } else {
            throw new RuntimeException("The pluggable file does not exist.");
        }

        if (file_exists($root_pluggable . DS . 'actions.php')) {
            include $root_pluggable . DS . 'actions.php';
        } elseif (file_exists($environment_pluggable . DS . 'actions.php')) {
            include $environment_pluggable . DS . 'actions.php';
        } elseif (file_exists($monstra_pluggable . DS . 'actions.php')) {
            include $monstra_pluggable . DS . 'actions.php';
        } else {
            throw new RuntimeException("The pluggable file does not exist.");
        }

        if (file_exists($root_pluggable . DS . 'shortcodes.php')) {
            include $root_pluggable . DS . 'shortcodes.php';
        } elseif (file_exists($environment_pluggable . DS . 'shortcodes.php')) {
            include $environment_pluggable . DS . 'shortcodes.php';
        } elseif (file_exists($monstra_pluggable . DS . 'shortcodes.php')) {
            include $monstra_pluggable . DS . 'shortcodes.php';
        } else {
            throw new RuntimeException("The pluggable file does not exist.");
        }

    }

    /**
     * Initialize Monstra Engine
     *
     * @return Core
     */
    public static function init()
    {
        if ( ! isset(self::$instance)) self::$instance = new Core();
        return self::$instance;
    }

}
