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


class Action
{
    /**
     * Actions
     *
     * @var array
     */
    public static $actions = array();

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
     *  Hooks a function on to a specific action.
     *
     *  <code>
     *      // Hooks a function "newLink" on to a "footer" action.
     *      Action::add('footer', 'newLink', 10);
     *
     *      function newLink() {
     *          echo '<a href="#">My link</a>';
     *      }
     *  </code>
     *
     * @param string  $action_name    Action name
     * @param mixed   $added_function Added function
     * @param integer $priority       Priority. Default is 10
     * @param array   $args           Arguments
     */
    public static function add($action_name, $added_function, $priority = 10, array $args = null)
    {
        // Hooks a function on to a specific action.
        Action::$actions[] = array(
                        'action_name' => (string) $action_name,
                        'function'    => $added_function,
                        'priority'    => (int) $priority,
                        'args'        => $args
        );
    }

    /**
     * Run functions hooked on a specific action hook.
     *
     *  <code>
     *      // Run functions hooked on a "footer" action hook.
     *      Action::run('footer');
     *  </code>
     *
     * @param  string  $action_name Action name
     * @param  array   $args        Arguments
     * @param  boolean $return      Return data or not. Default is false
     * @return mixed
     */
    public static function run($action_name, $args = array(), $return = false)
    {
        // Redefine arguments
        $action_name = (string) $action_name;
        $return      = (bool) $return;

        // Run action
        if (count(Action::$actions) > 0) {

            // Sort actions by priority
            $actions = Arr::subvalSort(Action::$actions, 'priority');

            // Loop through $actions array
            foreach ($actions as $action) {

                // Execute specific action
                if ($action['action_name'] == $action_name) {

                    // isset arguments ?
                    if (isset($args)) {

                        // Return or Render specific action results ?
                        if ($return) {
                            return call_user_func_array($action['function'], $args);
                        } else {
                            call_user_func_array($action['function'], $args);
                        }
                    } else {
                        if ($return) {
                            return call_user_func_array($action['function'], $action['args']);
                        } else {
                            call_user_func_array($action['function'], $action['args']);
                        }
                    }
                }
            }
        }
    }
}
