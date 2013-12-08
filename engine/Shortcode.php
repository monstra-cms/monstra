<?php defined('MONSTRA_ACCESS') or die('No direct script access.');

/**
 * Monstra Engine
 *
 * This source file is part of the Monstra Engine. More information,
 * documentation and tutorials can be found at http://monstra.org
 *
 * @package     Monstra
 *
 * @author      Romanenko Sergey / Awilum <awilum@msn.com>
 * @copyright   2012-2014 Romanenko Sergey / Awilum <awilum@msn.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

class Shortcode
{
    /**
     * Shortcode tags array
     *
     * @var shortcode_tags
     */
    protected static $shortcode_tags = array();

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
     * Add new shortcode
     *
     *  <code>
     *      function returnSiteUrl() {
     *          return Option::get('siteurl');
     *      }
     *
     *      // Add shortcode {siteurl}
     *      Shortcode::add('siteurl', 'returnSiteUrl');
     *  </code>
     *
     * @param string $shortcode         Shortcode tag to be searched in content.
     * @param string $callback_function The callback function to replace the shortcode with.
     */
    public static function add($shortcode, $callback_function)
    {
        // Redefine vars
        $shortcode = (string) $shortcode;

        // Add new shortcode
        if (is_callable($callback_function)) Shortcode::$shortcode_tags[$shortcode] = $callback_function;
    }

    /**
     * Remove a specific registered shortcode.
     *
     *  <code>
     *      Shortcode::delete('shortcode_name');
     *  </code>
     *
     * @param string $shortcode Shortcode tag.
     */
    public static function delete($shortcode)
    {
        // Redefine vars
        $shortcode = (string) $shortcode;

        // Delete shortcode
        if (Shortcode::exists($shortcode)) unset(Shortcode::$shortcode_tags[$shortcode]);
    }

    /**
     * Remove all registered shortcodes.
     *
     *  <code>
     *      Shortcode::clear();
     *  </code>
     *
     */
    public static function clear()
    {
        Shortcode::$shortcode_tags = array();
    }

    /**
     * Check if a shortcode has been registered.
     *
     *  <code>
     *      if (Shortcode::exists('shortcode_name')) {
     *          // do something...
     *      }
     *  </code>
     *
     * @param string $shortcode Shortcode tag.
     */
    public static function exists($shortcode)
    {
        // Redefine vars
        $shortcode = (string) $shortcode;

        // Check shortcode
        return array_key_exists($shortcode, Shortcode::$shortcode_tags);
    }

    /**
     * Parse a string, and replace any registered shortcodes within it with the result of the mapped callback.
     *
     *  <code>
     *      $content = Shortcode::parse($content);
     *  </code>
     *
     * @param  string $content Content
     * @return string
     */
    public static function parse($content)
    {
        if ( ! Shortcode::$shortcode_tags) return $content;

        $shortcodes = implode('|', array_map('preg_quote', array_keys(Shortcode::$shortcode_tags)));
        $pattern    = "/(.?)\{([$shortcodes]+)(.*?)(\/)?\}(?(4)|(?:(.+?)\{\/\s*\\2\s*\}))?(.?)/s";

        return preg_replace_callback($pattern, 'Shortcode::_handle', $content);
    }

    /**
     * _handle()
     */
    protected static function _handle($matches)
    {
        $prefix    = $matches[1];
        $suffix    = $matches[6];
        $shortcode = $matches[2];

        // Allow for escaping shortcodes by enclosing them in {{shortcode}}
        if ($prefix == '{' && $suffix == '}') {
            return substr($matches[0], 1, -1);
        }

        $attributes = array(); // Parse attributes into into this array.

        if (preg_match_all('/(\w+) *= *(?:([\'"])(.*?)\\2|([^ "\'>]+))/', $matches[3], $match, PREG_SET_ORDER)) {
            foreach ($match as $attribute) {
                if ( ! empty($attribute[4])) {
                    $attributes[strtolower($attribute[1])] = $attribute[4];
                } elseif ( ! empty($attribute[3])) {
                    $attributes[strtolower($attribute[1])] = $attribute[3];
                }
            }
        }

        // Check if this shortcode realy exists then call user function else return empty string
        return (isset(Shortcode::$shortcode_tags[$shortcode])) ? $prefix . call_user_func(Shortcode::$shortcode_tags[$shortcode], $attributes, $matches[5], $shortcode) . $suffix : '';
    }

}
