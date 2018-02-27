<?php

/**
 * This file is part of the Monstra.
 *
 * (c) Romanenko Sergey / Awilum <awilum@msn.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

class Plugins
{
    /**
     * An instance of the Plugins class
     *
     * @var object
     * @access protected
     */
    protected static $instance = null;

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
     * Constructor.
     *
     * @access  protected
     */
    protected function __construct()
    {
        $plugins_cache_id = '';

        $plugin_manifest = [];
        $plugin_settings = [];

        // Get Plugins List
        $plugins_list = Config::get('site.plugins');

        // If Plugins List isnt empty then create plugin cache ID
        if (is_array($plugins_list) && count($plugins_list) > 0) {

            // Go through...
            foreach ($plugins_list as $plugin) {
                if (File::exists($_plugin = PLUGINS_PATH . '/' . $plugin . '/' . $plugin . '.yml')) {
                    $plugins_cache_id .= filemtime($_plugin);
                }
            }

            // Create Unique Cache ID for Plugins
            $plugins_cache_id = md5('plugins' . ROOT_DIR . PLUGINS_PATH . $plugins_cache_id);
        }

        // Get plugins list from cache or scan plugins folder and create new plugins cache item
        if (Cache::driver()->contains($plugins_cache_id)) {
            Config::set('plugins', Cache::driver()->fetch($plugins_cache_id));
        } else {

            // If Plugins List isnt empty
            if (is_array($plugins_list) && count($plugins_list) > 0) {

                // Go through...
                foreach ($plugins_list as $plugin) {
                    if (File::exists($_plugin_manifest = PLUGINS_PATH . '/' . $plugin . '/' . $plugin . '.yml')) {
                        $plugin_manifest = Yaml::parseFile($_plugin_manifest);
                    }

                    if (File::exists($_plugin_settings = PLUGINS_PATH . '/' . $plugin . '/settings.yml')) {
                        $plugin_settings = Yaml::parseFile($_plugin_settings);
                    }

                    $_plugins_config[File::name($_plugin_manifest)] = array_merge($plugin_manifest, $plugin_settings);
                }

                Config::set('plugins', $_plugins_config);
                Cache::driver()->save($plugins_cache_id, $_plugins_config);
            }
        }

        // Include enabled plugins
        if (is_array(Config::get('plugins')) && count(Config::get('plugins')) > 0) {
            foreach (Config::get('plugins') as $plugin_name => $plugin) {
                if (Config::get('plugins.'.$plugin_name.'.enabled')) {
                    include_once PLUGINS_PATH .'/'. $plugin_name .'/'. $plugin_name . '.php';
                }
            }
        }

        // Run Actions on plugins_loaded
        Action::run('plugins_loaded');
    }

    /**
     * Initialize Monstra Plugins
     *
     *  <code>
     *      Plugins::init();
     *  </code>
     *
     * @access  public
     */
    public static function init()
    {
        if (! isset(self::$instance)) {
            self::$instance = new Plugins();
        }
        return self::$instance;
    }
}
