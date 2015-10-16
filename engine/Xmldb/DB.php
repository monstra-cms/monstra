<?php defined('MONSTRA_ACCESS') or die('No direct script access.');

/**
 * Monstra
 *
 * @package Monstra
 * @author Romanenko Sergey / Awilum <awilum@msn.com>
 * @link http://monstra.org
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */


class DB
{
    /**
     * XMLDB directory
     *
     * @var string
     */
    public static $db_dir = STORAGE;

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
     * Configure the settings of XMLDB
     *
     * @param mixed $setting Setting name
     * @param mixed $value   Setting value
     */
    public static function configure($setting, $value)
    {
        if (property_exists("db", $setting)) {
            DB::$$setting = $value;
        }
    }

    /**
     * Create new database
     *
     * @param  string  $db_name Database name
     * @param  integer $mode    Mode
     * @return boolean
     */
    public static function create($db_name, $chmod = 0775)
    {
        // Redefine vars
        $db_name = (string) $db_name;

        // Create
        if (is_dir(DB::$db_dir . '/' . $db_name)) {
            return false;
        }
        return mkdir(DB::$db_dir . '/' . $db_name, $chmod);
    }

    /**
     * Drop database
     *
     * @param  string  $db_name Database name
     * @return boolean
     */
    public static function drop($db_name)
    {
        // Redefine vars
        $db_name = (string) $db_name;

        // Drop
        if (is_dir(DB::$db_dir . '/' . $db_name)) {
            $ob=scandir(DB::$db_dir . '/' . $db_name); foreach ($ob as $o) {
     if ($o!='.'&&$o!='..') {
         if (filetype(DB::$db_dir . '/' . $db_name.'/'.$o)=='dir') {
             DB::drop(DB::$db_dir . '/' . $db_name.'/'.$o);
         } else {
             unlink(DB::$db_dir . '/' . $db_name.'/'.$o);
         }
     }
 }
        }
        reset($ob);
        rmdir(DB::$db_dir . '/' . $db_name);
    }
}
