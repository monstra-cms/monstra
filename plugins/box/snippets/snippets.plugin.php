<?php

/**
 *	Snippets plugin
 *
 *	@package Monstra
 *  @subpackage Plugins
 *	@author Romanenko Sergey / Awilum
 *	@copyright 2012-2014 Romanenko Sergey / Awilum
 *	@version 1.0.0
 *
 */

// Register plugin
Plugin::register( __FILE__,
                __('Snippets', 'snippets'),
                __('Snippets manager plugin', 'snippets'),
                '1.0.0',
                'Awilum',
                'http://monstra.org/',
                null,
                'box');

if (Session::exists('user_role') && in_array(Session::get('user_role'),array('admin'))) {

    // Include Admin
    Plugin::admin('snippets', 'box');

}

// Add Plugin Javascript
Javascript::add('plugins/box/snippets/js/snippets.js', 'backend');

// Add shortcode {snippet}
Shortcode::add('snippet', 'Snippet::_content');

/**
 * Snippet class
 */
class Snippet
{
    /**
     * Get snippet
     *
     *  <code>
     *      echo Snippet::get('snippetname');
     *      echo Snippet::get('snippetname', array('message' => 'Hello World'));
     *  </code>
     *
     * @param  string $name Snippet file name
     * @param  string $vars Vars
     * @return string
     */
    public static function get($name, $vars = array())
    {
        $vars['get'] = $name;

        return Snippet::_content($vars);
    }

    /**
     * Returns snippet content for shortcode {snippet get="snippetname"}
     *
     *  <code>
     *      {snippet get="snippetname"}
     *      {snippet get="snippetname" message="Hello World"}
     *  </code>
     *
     * @param  array  $attributes Array of attributes
     * @return string
     */
    public static function _content($attributes)
    {
        // Extracst attributes
        extract($attributes);

        // Get snippet name
        $name = (isset($get)) ? (string) $get : '';

        // Get snippet path
        $snippet_path = STORAGE . DS . 'snippets' . DS . $name . '.snippet.php';

        // Get snippet content
        if (File::exists($snippet_path)) {

            // Turn on output buffering
            ob_start();

            // Include view file
            include $snippet_path;

            // Output...
            return ob_get_clean();

        } else {
            if (Session::exists('admin') && Session::get('admin') == true) {
                return __('<b>Snippet <u>:name</u> is not found!</b>', 'snippets', array(':name' => $name));
            }
        }
    }
}
