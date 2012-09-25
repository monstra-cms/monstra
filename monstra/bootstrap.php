<?php defined('MONSTRA_ACCESS') or die('No direct script access.');


    /**
     *  Include engine core
     */
    include ROOT . DS . 'monstra' . DS . 'engine' . DS . 'core.php';


    /**
     * Set core environment
     *
     * Monstra has four predefined environments:
     *   Core::DEVELOPMENT - The development environment.
     *   Core::TESTING     - The test environment.
     *   Core::STAGING     - The staging environment.
     *   Core::PRODUCTION  - The production environment.
     */
    Core::$environment = Core::PRODUCTION;


    /**
     * Include defines
     */
    include ROOT . DS . 'monstra' . DS . 'boot' . DS . 'defines.php';


    /**
     *  Monstra requires PHP 5.2.0 or greater
     */
    if (version_compare(PHP_VERSION, "5.2.0", "<")) {
		exit("Monstra requires PHP 5.2.0 or greater.");
	}


    /**
     * Report Errors 
     */
    if (Core::$environment == Core::PRODUCTION) {
        error_reporting(0);
    } else {
        error_reporting(-1);
    }
    

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
     * Initialize core
     */
    Core::init();      