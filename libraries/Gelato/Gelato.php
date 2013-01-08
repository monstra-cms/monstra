<?php

/**
 * Gelato Library
 *
 * This source file is part of the Gelato Library. More information,
 * documentation and tutorials can be found at http://gelato.monstra.org
 *
 * @package     Gelato
 *
 * @author      Romanenko Sergey / Awilum
 * @copyright   (c) 2013 Romanenko Sergey / Awilum
 * @since       1.0.0
 */

/**
 * The version of Gelato
 */
define('GELATO_VERSION', '1.0.0');

/**
 * Display Gelato Errors or not ?
 */
if ( ! defined('GELATO_DISPLAY_ERRORS')) {
    define('GELATO_DISPLAY_ERRORS', true);
}

/**
 * Load Gelato Error Handler
 */
require_once __DIR__ . '/ErrorHandler/ErrorHandler.php';

/**
 * Set Error Handler
 */
set_error_handler('ErrorHandler::errorHandler');

/**
 * Set Fatal Error Handler
 */
register_shutdown_function('ErrorHandler::fatalErrorHandler');

/**
 * Set Exception Handler
 */
set_exception_handler('ErrorHandler::exception');

/**
 * Gelato Class Loader
 */
require_once __DIR__ . '/ClassLoader/ClassLoader.php';

/**
 * Map all Gelato Classes
 */
ClassLoader::mapClasses(array(
    'Agent'     => __DIR__.'/Agent/Agent.php',
    'Arr'       => __DIR__.'/Arr/Arr.php',
    'Cache'     => __DIR__.'/Cache/Cache.php',
    'Cookie'    => __DIR__.'/Cookie/Cookie.php',
    'Curl'      => __DIR__.'/Curl/Curl.php',
    'Date'      => __DIR__.'/Date/Date.php',
    'Debug'     => __DIR__.'/Debug/Debug.php',
    'File'      => __DIR__.'/FileSystem/File.php',
    'Dir'       => __DIR__.'/FileSystem/Dir.php',
    'Form'      => __DIR__.'/Form/Form.php',
    'Html'      => __DIR__.'/Html/Html.php',
    'Image'     => __DIR__.'/Image/Image.php',
    'Inflector' => __DIR__.'/Inflector/Inflector.php',
    'Minify'    => __DIR__.'/Minify/Minify.php',
    'Notification' => __DIR__.'/Notification/Notification.php',
    'Number'    => __DIR__.'/Number/Number.php',
    'Registry'  => __DIR__.'/Registry/Registry.php',
    'Request'   => __DIR__.'/Http/Request.php',
    'Response'  => __DIR__.'/Http/Response.php',
    'Token'     => __DIR__.'/Security/Token.php',
    'Text'      => __DIR__.'/Text/Text.php',
    'Session'   => __DIR__.'/Session/Session.php',
    'Url'       => __DIR__.'/Url/Url.php',
    'Valid'     => __DIR__.'/Validation/Valid.php',
    'Zip'       => __DIR__.'/Zip/Zip.php',
));

/**
 * Register Gelato Autoloader
 */
spl_autoload_register('ClassLoader::load');
