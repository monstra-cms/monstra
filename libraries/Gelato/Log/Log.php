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

class Log
{

    /**
     * Path to the logs.
     *
     * @var string
     */
    protected static $path = '';
  
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
     * Configure Log
     *
     * @access  public
     * @param  string  $setting The setting
     * @param  string  $value   The value
     */
    public static function configure($setting, $value)
    {
        if (property_exists("log", $setting)) Log::$$setting = $value;
    }

    /**
     * Writes message to log.
     *
     * @access  public
     * @param  string  $message The message to write to the log
     * @return boolean
     */
    public static function write($message)
    {
        return (bool) file_put_contents(rtrim(Log::$path, '/') . '/' . gmdate('Y_m_d') . '.log',
                                        '[' . gmdate('d-M-Y H:i:s') . '] ' . $message . PHP_EOL,
                                        FILE_APPEND);
    }
}
