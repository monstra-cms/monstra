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


class Filter
{
    /**
     * Filters
     *
     * @var array
     */
    public static $filters = array();

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
     * Apply filters
     *
     *  <code>
     *      Filter::apply('content', $content);
     *  </code>
     *
     * @param  string $filter_name The name of the filter hook.
     * @param  mixed  $value       The value on which the filters hooked.
     * @return mixed
     */
    public static function apply($filter_name, $value)
    {
        // Redefine arguments
        $filter_name = (string) $filter_name;

        $args = array_slice(func_get_args(), 2);

        if (! isset(Filter::$filters[$filter_name])) {
            return $value;
        }

        foreach (Filter::$filters[$filter_name] as $priority => $functions) {
            if (! is_null($functions)) {
                foreach ($functions as $function) {
                    $all_args = array_merge(array($value), $args);
                    $function_name = $function['function'];
                    $accepted_args = $function['accepted_args'];
                    if ($accepted_args == 1) {
                        $the_args = array($value);
                    } elseif ($accepted_args > 1) {
                        $the_args = array_slice($all_args, 0, $accepted_args);
                    } elseif ($accepted_args == 0) {
                        $the_args = null;
                    } else {
                        $the_args = $all_args;
                    }
                    $value = call_user_func_array($function_name, $the_args);
                }
            }
        }

        return $value;
    }

    /**
     * Add filter
     *
     *  <code>
     *      Filter::add('content', 'replacer');
     *
     *      function replacer($content) {
     *          return preg_replace(array('/\[b\](.*?)\[\/b\]/ms'), array('<strong>\1</strong>'), $content);
     *      }
     *  </code>
     *
     * @param  string  $filter_name     The name of the filter to hook the $function_to_add to.
     * @param  mixed   $function_to_add The name of the function to be called when the filter is applied.
     * @param  integer $priority        Function to add priority - default is 10.
     * @param  integer $accepted_args   The number of arguments the function accept default is 1.
     * @return boolean
     */
    public static function add($filter_name, $function_to_add, $priority = 10, $accepted_args = 1)
    {
        // Redefine arguments
        $filter_name     = (string) $filter_name;
        $function_to_add = $function_to_add;
        $priority        = (int) $priority;
        $accepted_args   = (int) $accepted_args;

        // Check that we don't already have the same filter at the same priority. Thanks to WP :)
        if (isset(Filter::$filters[$filter_name]["$priority"])) {
            foreach (Filter::$filters[$filter_name]["$priority"] as $filter) {
                if ($filter['function'] == $function_to_add) {
                    return true;
                }
            }
        }

        Filter::$filters[$filter_name]["$priority"][] = array('function' => $function_to_add, 'accepted_args' => $accepted_args);

        // Sort
        ksort(Filter::$filters[$filter_name]["$priority"]);

        return true;
    }
}
