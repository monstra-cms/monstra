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

class Debug
{
    /**
     * Time
     *
     * @var array
     */
    protected static $time = array();

    /**
     * Memory
     *
     * @var array
     */
    protected static $memory = array();

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
     * Save current time for current point
     *
     *  <code>
     *      Debug::elapsedTimeSetPoint('point_name');
     *  </code>
     *
     * @param string $point_name Point name
     */
    public static function elapsedTimeSetPoint($point_name)
    {
        Debug::$time[$point_name] = microtime(true);
    }

    /**
     * Get elapsed time for current point
     *
     *  <code>
     *      echo Debug::elapsedTime('point_name');
     *  </code>
     *
     * @param  string $point_name Point name
     * @return string
     */
    public static function elapsedTime($point_name)
    {
        if (isset(Debug::$time[$point_name])) return sprintf("%01.4f", microtime(true) - Debug::$time[$point_name]);
    }

    /**
     * Save current memory for current point
     *
     *  <code>
     *      Debug::memoryUsageSetPoint('point_name');
     *  </code>
     *
     * @param string $point_name Point name
     */
    public static function memoryUsageSetPoint($point_name)
    {
        Debug::$memory[$point_name] = memory_get_usage();
    }

    /**
     * Get memory usage for current point
     *
     *  <code>
     *      echo Debug::memoryUsage('point_name');
     *  </code>
     *
     * @param  string $point_name Point name
     * @return string
     */
    public static function memoryUsage($point_name)
    {
        if (isset(Debug::$memory[$point_name])) return Number::byteFormat(memory_get_usage() - Debug::$memory[$point_name]);
    }

    /**
     * Print the variable $data and exit if exit = true
     *
     *  <code>
     *      Debug::dump($data);
     *  </code>
     *
     * @param mixed   $data Data
     * @param boolean $exit Exit
     */
    public static function dump($data, $exit = false)
    {
        echo "<pre>dump \n---------------------- \n\n" . print_r($data, true) . "\n----------------------</pre>";
        if ($exit) exit;
    }

}
