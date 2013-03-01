<?php defined('MONSTRA_ACCESS') or die('No direct script access.');

/**
 * Report All Errors
 *
 * By setting error reporting to -1, we essentially force PHP to report
 * every error, and this is guranteed to show every error on future
 * releases of PHP. This allows everything to be fixed early!
 */
error_reporting(-1);

/**
 *  Monstra requires PHP 5.2.0 or greater
 */
if (version_compare(PHP_VERSION, "5.2.0", "<")) {
    exit("Monstra requires PHP 5.2.0 or greater.");
}

/**
 *  Include Monstra Engine
 */
include ROOT . DS .'engine'. DS .'Monstra.php';

/**
 * Set Monstra Environment
 *
 * Monstra has four predefined environments:
 *   Monstra::DEVELOPMENT - The development environment.
 *   Monstra::TESTING     - The test environment.
 *   Monstra::STAGING     - The staging environment.
 *   Monstra::PRODUCTION  - The production environment.
 */
Monstra::$environment = Monstra::PRODUCTION;

/**
 * Initialize Monstra
 */
Monstra::init();
