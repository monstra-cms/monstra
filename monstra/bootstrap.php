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
     * Initialize core
     */
    Core::init();      