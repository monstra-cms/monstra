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


class XML
{
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
     * Create safe xml data. Removes dangerous characters for string.
     *
     *  <code>
     *      $xml_safe = XML::safe($xml_unsafe);
     *  </code>
     *
     * @param  string  $str  String
     * @param  boolean $flag Flag
     * @return string
     */
    public static function safe($str, $flag = true)
    {
        // Redefine vars
        $str  = (string) $str;
        $flag = (bool) $flag;

        // Remove invisible chars
        $non_displayables = array('/%0[0-8bcef]/', '/%1[0-9a-f]/', '/[\x00-\x08]/', '/\x0b/', '/\x0c/', '/[\x0e-\x1f]/');
        do {
            $cleaned = $str;
            $str = preg_replace($non_displayables, '', $str);
        } while ($cleaned != $str);

        // htmlspecialchars
        if ($flag) {
            $str = htmlspecialchars($str, ENT_QUOTES, 'utf-8');
        }

        // Return safe string
        return $str;
    }

    /**
     * Get XML file
     *
     *  <code>
     *      $xml_file = XML::loadFile('path/to/file.xml');
     *  </code>
     *
     * @param  string  $file  File name
     * @param  boolean $force Method
     * @return array
     */
    public static function loadFile($file, $force = false)
    {
        // Redefine vars
        $file  = (string) $file;
        $force = (bool) $force;

        // For CMS API XML file force method
        if ($force) {
            $xml = file_get_contents($file);
            $data = simplexml_load_string($xml);

            return $data;
        } else {
            if (file_exists($file) && is_file($file)) {
                $xml = file_get_contents($file);
                $data = simplexml_load_string($xml);

                return $data;
            } else {
                return false;
            }
        }
    }
}
