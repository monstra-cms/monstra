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

class Notification
{
    /**
     * Notifications session key
     *
     * @var string
     */
    const SESSION_KEY = 'notifications';

    /**
     * Notifications array
     *
     * @var array
     */
    private static $notifications = array();

    /**
     * Protected constructor since this is a static class.
     *
     * @access  protected
     */
    protected function __construct()
    {
        // Nothing here
    }

    /**
     * Returns a specific variable from the Notifications array.
     *
     *  <code>
     *      echo Notification::get('success');
     *      echo Notification::get('errors');
     *  </code>
     *
     * @param  string $key Variable name
     * @return mixed
     */
    public static function get($key)
    {
        // Redefine arguments
        $key = (string) $key;

        // Return specific variable from the Notifications array
        return isset(Notification::$notifications[$key]) ? Notification::$notifications[$key] : null;
    }

    /**
     * Adds specific variable to the Notifications array.
     *
     *  <code>
     *      Notification::set('success', 'Data has been saved with success!');
     *      Notification::set('errors', 'Data not saved!');
     *  </code>
     *
     * @param string $key   Variable name
     * @param mixed  $value Variable value
     */
    public static function set($key, $value)
    {
        // Redefine arguments
        $key = (string) $key;

        // Save specific variable to the Notifications array
        $_SESSION[Notification::SESSION_KEY][$key] = $value;
    }

    /**
     * Adds specific variable to the Notifications array for current page.
     *
     *  <code>
     *      Notification::setNow('success', 'Success!');
     *  </code>
     *
     * @param string $var   Variable name
     * @param mixed  $value Variable value
     */
    public static function setNow($key, $value)
    {
        // Redefine arguments
        $key = (string) $key;

        // Save specific variable for current page only
        Notification::$notifications[$key] = $value;
    }

    /**
     * Clears the Notifications array.
     *
     *  <code>
     *      Notification::clean();
     *  </code>
     *
     * Data that previous pages stored will not be deleted, just the data that
     * this page stored itself.
     */
    public static function clean()
    {
        $_SESSION[Notification::SESSION_KEY] = array();
    }

    /**
     * Initializes the Notification service.
     *
     *  <code>
     *      Notification::init();
     *  </code>
     *
     * This will read notification/flash data from the $_SESSION variable and load it into
     * the $this->previous array.
     */
    public static function init()
    {
        // Get notification/flash data...

        if ( ! empty($_SESSION[Notification::SESSION_KEY]) && is_array($_SESSION[Notification::SESSION_KEY])) {
            Notification::$notifications = $_SESSION[Notification::SESSION_KEY];
        }

        $_SESSION[Notification::SESSION_KEY] = array();

    }

}
