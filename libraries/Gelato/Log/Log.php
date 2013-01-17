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
 * @copyright   2012-2013 Romanenko Sergey / Awilum <awilum@msn.com>
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
     * Log levels.
     *
     * @var int
     */
    const EMERGENCY = 1;
    const ALERT = 2;
    const CRITICAL = 3;
    const ERROR = 4;
    const WARNING = 5;
    const NOTICE = 6;
    const INFO = 7;
    const DEBUG = 8;

    /**
     * Log types.
     *
     * @var array
     */
    protected static $types = array
    (
        Log::EMERGENCY => 'emergency',
        Log::ALERT     => 'alert',
        Log::CRITICAL  => 'critical',
        Log::ERROR     => 'error',
        Log::WARNING   => 'warning',
        Log::NOTICE    => 'notice',
        Log::INFO      => 'info',
        Log::DEBUG     => 'debug',
    );

    /**
     * Protected constructor since this is a static class.
     *
     * @access  protected
     */
    protected function __construct()
    {
        // Nothing here
    }

    public static function configure($setting, $value)
    {
        if (property_exists("log", $setting)) Log::$$setting = $value;
    }

    /**
     * Writes message to log.
     *
     * @access  public
     * @param  string  $message The message to write to the log
     * @param  int     $type    (optional) Message type
     * @return boolean
     */
    public static function write($message, $type = Log::ERROR)
    {
        $file = rtrim(Log::$path, '/') . '/' . Log::$types[$type] . '_' . gmdate('Y_m_d') . '.log';

        $message = '[' . gmdate('d-M-Y H:i:s') . '] ' . $message . PHP_EOL;

        return (bool) file_put_contents($file, $message, FILE_APPEND);
    }
}
