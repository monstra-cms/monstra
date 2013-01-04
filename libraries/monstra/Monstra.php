<?php

/**
 * Monstra Library
 *
 * This source file is part of the Monstra Library. More information,
 * documentation and tutorials can be found at http://library.monstra.org
 *
 * @package     Monstra
 *
 * @author      Romanenko Sergey / Awilum
 * @copyright   (c) 2012 - 2013 Romanenko Sergey / Awilum
 * @since       1.0.0
 */

/**
 * Version number for the current version of the Monstra Library.
 */
define('MONSTRA_LIBRARY_VERSION', '1.0.0');

/**
 * Should we use the Monstra Autoloader to ensure the dependancies are automatically
 * loaded?
 */
if ( ! defined('MONSTRA_LIBRARY_AUTOLOADER')) {
    define('MONSTRA_LIBRARY_AUTOLOADER', true);
}

/**
 * Register autoload function
 */
if (MONSTRA_LIBRARY_AUTOLOADER) {
    spl_autoload_register(array('Monstra', 'autoload'));
}

/**
 * Monstra
 */
class Monstra
{

    /**
     * Registry of variables
     *
     * @var array
     */
    private static $registry = array();

    /**
     * Autload
     */
    public static function autoload($className)
    {
        $path = dirname(realpath(__FILE__));

        $className = ltrim($className, '\\');
        $fileName  = '';
        $namespace = '';
        if ($lastNsPos = strrpos($className, '\\')) {
            $namespace = substr($className, 0, $lastNsPos);
            $className = substr($className, $lastNsPos + 1);
            $fileName  = str_replace('\\', DIRECTORY_SEPARATOR, $namespace) . DIRECTORY_SEPARATOR;
        }
        $fileName .= str_replace('_', DIRECTORY_SEPARATOR, $className) . '.php';

        require $path.DIRECTORY_SEPARATOR.$fileName;
    }

    /**
     * Checks if an object with this name is in the registry.
     *
     * @return bool
     * @param  string $name The name of the registry item to check for existence.
     */
    public static function exists($name)
    {
        return isset(self::$registry[(string) $name]);
    }

    /**
     * Registers a given value under a given name.
     *
     * @param string          $name  The name of the value to store.
     * @param mixed[optional] $value The value that needs to be stored.
     */
    public static function set($name, $value = null)
    {
        // redefine name
        $name = (string) $name;

        // delete item
        if ($value === null) {
            unset(self::$registry[$name]);
        } else {
            self::$registry[$name] = $value;

            return self::get($name);
        }
    }

    /**
     * Fetch an item from the registry.
     *
     * @return mixed
     * @param  string $name The name of the item to fetch.
     */
    public static function get($name)
    {
        $name = (string) $name;

        if (!isset(self::$registry[$name])) {
            throw new SpoonException('No item "' . $name . '" exists in the registry.');
        }

        return self::$registry[$name];
    }
}
