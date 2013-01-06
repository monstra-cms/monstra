<?php defined('MONSTRA_ACCESS') or die('No direct script access.');

/**
 *  Include engine core
 */
include ROOT . '/libraries/Gelato/Gelato.php';
include ROOT . '/engine/Core.php';

/**
 * Set core environment
 *
 * Monstra has four predefined environments:
 *   Core::DEVELOPMENT - The development environment.
 *   Core::TESTING     - The test environment.
 *   Core::STAGING     - The staging environment.
 *   Core::PRODUCTION  - The production environment.
 */
Core::$environment = Core::DEVELOPMENT;

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

    /**
     * Report All Errors
     *
     * By setting error reporting to -1, we essentially force PHP to report
     * every error, and this is guranteed to show every error on future
     * releases of PHP. This allows everything to be fixed early!
     */
    error_reporting(0);

} else {

    /**
     * Production environment
     */
    error_reporting(-1);

}

/**
 * Initialize core
 */
Core::init();
