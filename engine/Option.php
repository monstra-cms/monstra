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


class Option
{
    /**
     * Options
     *
     * @var array
     */
    protected static $options = null;

    /**
     * An instance of the Option class
     *
     * @var option
     */
    protected static $instance = null;

    /**
     * Initializing options
     *
     * @param string $name Options file
     */
    public static function init()
    {
        if (! isset(self::$instance)) {
            self::$instance = new Option();
        }
        return self::$instance;
    }

    /**
     * Protected clone method to enforce singleton behavior.
     *
     * @access  protected
     */
    protected function __clone()
    {
        // Nothing here.
    }

    /**
     *  Construct
     */
    protected function __construct()
    {
        Option::$options = new Table('options');
    }

    /**
     * Add a new option
     *
     *  <code>
     *      Option::add('pages_limit', 10);
     *      Option::add(array('pages_count' => 10, 'pages_default' => 'home'));
     *  </code>
     *
     * @param  mixed   $option Name of option to add.
     * @param  mixed   $value  Option value.
     * @return boolean
     */
    public static function add($option, $value = null)
    {
        if (is_array($option)) {
            foreach ($option as $k => $v) {
                $_option = Option::$options->select('[name="'.$k.'"]', null);
                if (count($_option) == 0) {
                    Option::$options->insert(array('name' => $k, 'value' => $v));
                }
            }
        } else {
            $_option = Option::$options->select('[name="'.$option.'"]', null);
            if (count($_option) == 0) {
                return Option::$options->insert(array('name' => $option, 'value' => $value));
            }
        }
    }

    /**
     * Update option value
     *
     *  <code>
     *      Option::update('pages_limit', 12);
     *      Option::update(array('pages_count' => 10, 'pages_default' => 'home'));
     *  </code>
     *
     * @param  mixed   $option Name of option to update.
     * @param  mixed   $value  Option value.
     * @return boolean
     */
    public static function update($option, $value = null)
    {
        if (is_array($option)) {
            foreach ($option as $k => $v) {
                Option::$options->updateWhere('[name="'.$k.'"]', array('value' => $v));
            }
        } else {
            return Option::$options->updateWhere('[name="'.$option.'"]', array('value' => $value));
        }
    }

    /**
     * Get option value
     *
     *  <code>
     *      $pages_limit = Option::get('pages_limit');
     *      if ($pages_limit == '10') {
     *          // do something...
     *      }
     *  </code>
     *
     * @param  string $option Name of option to get.
     * @return string
     */
    public static function get($option)
    {
        // Redefine vars
        $option = (string) $option;

        // Select specific option
        $option_name = Option::$options->select('[name="'.$option.'"]', null);

        // Return specific option value
        return isset($option_name['value']) ? $option_name['value'] : '';
    }

    /**
     * Delete option
     *
     *  <code>
     *      Option::delete('pages_limit');
     *  </code>
     *
     * @param  string  $option Name of option to delete.
     * @return boolean
     */
    public static function delete($option)
    {
        // Redefine vars
        $option = (string) $option;

        // Delete specific option
        return Option::$options->deleteWhere('[name="'.$option.'"]');
    }

    /**
     * Check if option exist
     *
     *  <code>
     *      if (Option::exists('pages_limit')) {
     *          // do something...
     *      }
     *  </code>
     *
     * @param  string  $option Name of option to check.
     * @return boolean
     */
    public static function exists($option)
    {
        // Redefine vars
        $option = (string) $option;

        // Check if option exists
        return (count(Option::$options->select('[name="'.$option.'"]', null)) > 0) ? true : false;
    }
}
