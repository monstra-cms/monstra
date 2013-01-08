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

class Registry
{

    /**
     * Registry of variables
     *
     * @var array
     */
    private static $registry = array();

    /**
     * Checks if an object with this name is in the registry.
     *
     * @return bool
     * @param  string $name The name of the registry item to check for existence.
     */
    public static function exists($name)
    {
        return isset(Gelato::$registry[(string) $name]);
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
            unset(Gelato::$registry[$name]);
        } else {
            Gelato::$registry[$name] = $value;

            return Gelato::get($name);
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

        if ( ! isset(Gelato::$registry[$name])) {
            throw new RuntimeException('No item "' . $name . '" exists in the registry.');
        }

        return Gelato::$registry[$name];
    }

}
