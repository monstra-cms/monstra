<?php defined('MONSTRA_ACCESS') or die('No direct script access.');

/**
 *  Monstra requires PHP 5.2.3 or greater
 */
if (version_compare(PHP_VERSION, "5.2.3", "<")) {
    exit("Monstra requires PHP 5.2.3 or greater.");
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
 * Report Errors
 */
if (Monstra::$environment == Monstra::PRODUCTION) {
    error_reporting(0); 
} else {
    error_reporting(-1);
}

/**
 * Initialize Monstra
 */
Monstra::init();
