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

class Plugin
{
    /**
     * Plugins
     *
     * @var array
     */
    public static $plugins = array();

    /**
     * Components
     *
     * @var array
     */
    public static $components = array();

    /**
     * An instance of the Plugin class
     *
     * @var plugin
     */
    protected static $instance = null;

    /**
     * Initializing plugins
     *
     * @return Plugin
     */
    public static function init()
    {
        if ( ! isset(self::$instance)) self::$instance = new Plugin();
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
     * Construct
     */
    protected function __construct()
    {
        // Get plugins Table
        $plugins = new Table('plugins');

        // Select all plugins
        $records = $plugins->select(null, 'all', null, array('location', 'status', 'priority'), 'priority', 'ASC');

        // Now include plugins from $records plugins array
        // If plugin is active then load it to the system.
        foreach ($records as $record) {
            if ($record['status'] == 'active') {
                include_once ROOT . DS . $record['location'];
            }
        }
    }

    /**
     * Get plugin admin
     *
     *  <code>
     *      // Get admin for Blog plugin
     *      Plugin::admin('blog');
     *  </code>
     *
     * @param string $plug       Plugin Name
     * @param string $alt_folder Alternative plugin folder
     */
    public static function admin($plug, $alt_folder = null)
    {
        // Redefine arguments
        $plug = (string) $plug;

        // Plugin admin extension
        $ext = '.admin.php';

        // Plugin admin can be loaded only in backend
        if (BACKEND) {

            // Plugin admin folder
            if ( ! empty($alt_folder)) {
                $folder = $alt_folder . DS . strtolower($plug);
            } else {
                $folder = strtolower($plug);
            }

            // Path to plugin admin file
            $path = PLUGINS . DS . $folder . DS . $plug . $ext;

            // Load plugin admin
            if (File::exists($path)) {
                include $path;
            }
        }
    }

    /**
     * Register new plugin in system
     *
     *  <code>
     *      // Register plugin
     *      Plugin::register( __FILE__,
     *                        __('Blog'),
     *                        __('Blog plugin'),
     *                        '1.0.0',
     *                        'Awilum',
     *                        'http://example.org/',
     *                        'blog');
     *  </code>
     *
     * @param string  $file        Plugin file
     * @param string  $title       Plugin title
     * @param string  $description Plugin description
     * @param string  $version     Plugin version
     * @param string  $author      Plugin author
     * @param string  $author_uri  Plugin author uri
     * @param string  $component   Plugin as component
     * @param boolean $box         Plugin as box
     */
    public static function register($file, $title, $description = null, $version = null, $author = null, $author_uri = null, $component = null, $box = false)
    {
        // Redefine arguments
        $file            = (string) $file;
        $title           = (string) $title;
        $description     = ($description === null)    ? null : (string) $description;
        $version         = ($version === null)        ? null : (string) $version;
        $author          = ($author === null)         ? null : (string) $author;
        $author_uri      = ($author_uri === null)     ? null : (string) $author_uri;
        $component       = ($component === null)      ? null : (string) $component;
        $box             = (bool) $box;

        // Get plugin id from name.plugin.php
        $id = strtolower(basename($file, '.plugin.php'));

        // Set plugin privilege 'box' if $box is true
        if ($box) $privilege = 'box'; else $privilege = '';

        // Register plugin in global plugins array.
        Plugin::$plugins[$id] = array(
          'id'              => $id,
          'title'           => $title,
          'privilege'       => $privilege,
          'version'         => $version,
          'description'     => $description,
          'author'          => $author,
          'author_uri'      => $author_uri,
        );

        // Add plugin as a component
        // Plugin - component will be available at the link sitename/component_name
        // Example:
        //    www.example.org/guestbook
        //    www.example.org/news
        if ( ! empty($component)) {
            Plugin::$components[] = $component;
        }
    }

}
