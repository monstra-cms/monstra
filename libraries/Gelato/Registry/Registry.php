<?php

/**
 * Gelato Library
 *
 * This source file is part of the Gelato Library. More information,
 * documentation and tutorials can be found at http://gelato.monstra.org
 *
 * @package     Gelato
 *
 * @author      Romanenko Sergey / Awilum <awilum@msn.com>
 * @copyright   2012-2014 Romanenko Sergey / Awilum <awilum@msn.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
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
     *  <code>
     *      if (Registry::exists('var')) {
     *          // Do something...
     *      }
     *  </code>
     *
     * @return bool
     * @param  string $name The name of the registry item to check for existence.
     */
    public static function exists($name)
    {
        return isset(Registry::$registry[(string) $name]);
    }

    /**
     * Registers a given value under a given name.
     *
     *  <code>
     *      Registry::set('var', 'value');
     *  </code>
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
            unset(Registry::$registry[$name]);
        } else {
            Registry::$registry[$name] = $value;

            return Registry::get($name);
        }
    }

    /**
     * Fetch an item from the registry.
     *
     *  <code>
     *      $var = Registry::get('var', 'value');
     *  </code>
     *
     * @return mixed
     * @param  string $name The name of the item to fetch.
     */
    public static function get($name)
    {
        $name = (string) $name;

        if ( ! isset(Registry::$registry[$name])) {
            throw new RuntimeException('No item "' . $name . '" exists in the registry.');
        }

        return Registry::$registry[$name];
    }

}
