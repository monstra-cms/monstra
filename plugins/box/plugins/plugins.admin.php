<?php

// Add plugin navigation link
Navigation::add(__('Plugins', 'plugins'), 'extends', 'plugins', 1);

/**
 * Plugins Admin
 */
class PluginsAdmin extends Backend
{
    /**
     * Plugins admin
     */
    public static function main()
    {
        // Get siteurl
        $site_url = Option::get('siteurl');

        // Get installed plugin from $plugins array
        $installed_plugins = Plugin::$plugins;

        // Get installed users plugins
        $_users_plugins = array();
        foreach (Plugin::$plugins as $plugin) {
            if ($plugin['privilege'] !== 'box') $_users_plugins[] = $plugin['id'];
        }

        // Get plugins table
        $plugins = new Table('plugins');

        // Delete plugin
        // -------------------------------------
        if (Request::get('delete_plugin')) {

            if (Security::check(Request::get('token'))) {

                // Nobody cant remove box plugins
                if ($installed_plugins[Text::lowercase(str_replace("Plugin", "", Request::get('delete_plugin')))]['privilege'] !== 'box') {

                    // Run plugin uninstaller file
                    $plugin_name = Request::get('delete_plugin');
                    if (File::exists(PLUGINS . DS . $plugin_name . DS .'install' . DS . $plugin_name . '.uninstall.php')) {
                        include PLUGINS . DS . $plugin_name . DS . 'install' . DS . $plugin_name . '.uninstall.php';
                    }

                    // Clean Monstra TMP folder.
                    Monstra::cleanTmp();

                    // Delete plugin form plugins table
                    $plugins->deleteWhere('[name="'.Request::get('delete_plugin').'"]');

                    // Redirect
                    Request::redirect('index.php?id=plugins');
                }

            } else { die('Request was denied because it contained an invalid security token. Please refresh the page and try again.'); }
        }

        // Install new plugin
        // -------------------------------------
        if (Request::get('install')) {

            if (Security::check(Request::get('token'))) {

                // Load plugin install xml file
                $plugin_xml = XML::loadFile(PLUGINS . DS . basename(Text::lowercase(Request::get('install')), '.manifest.xml') . DS . 'install' . DS . Request::get('install'));

                // Add plugin to plugins table
                $plugins->insert(array('name'     => basename(Request::get('install'), '.manifest.xml'),
                                       'location' => (string) $plugin_xml->plugin_location,
                                       'status'   => (string) $plugin_xml->plugin_status,
                                       'priority' => (int) $plugin_xml->plugin_priority));

                // Clean Monstra TMP folder.
                Monstra::cleanTmp();

                // Run plugin installer file
                $plugin_name = str_replace(array("Plugin", ".manifest.xml"), "", Request::get('install'));
                if (File::exists(PLUGINS . DS .basename(Text::lowercase(Request::get('install')), '.manifest.xml') . DS . 'install' . DS . $plugin_name . '.install.php')) {
                    include PLUGINS . DS . basename(Text::lowercase(Request::get('install')), '.manifest.xml') . DS . 'install' . DS . $plugin_name . '.install.php';
                }

                Request::redirect('index.php?id=plugins');

            } else { die('Request was denied because it contained an invalid security token. Please refresh the page and try again.'); }
        }

        // Delete plugin from server
        // -------------------------------------
        if (Request::get('delete_plugin_from_server')) {

            if (Security::check(Request::get('token'))) {

                Dir::delete(PLUGINS . DS . basename(Request::get('delete_plugin_from_server'), '.manifest.xml'));
                Request::redirect('index.php?id=plugins');

            } else { die('Request was denied because it contained an invalid security token. Please refresh the page and try again.'); }

        }

        // Installed plugins
        $plugins_installed = array();

        // New plugins
        $plugins_new = array();

        // Plugins to install
        $plugins_to_intall = array();

        // Scan plugins directory for .manifest.xml
        $plugins_new = File::scan(PLUGINS, '.manifest.xml');

        // Get installed plugins from plugins table
        $plugins_installed = $plugins->select(null, 'all', null, array('location', 'priority'), 'priority', 'ASC');

        // Update $plugins_installed array. extract plugins names
        foreach ($plugins_installed as $plg) {
            $_plg[] = basename($plg['location'], 'plugin.php').'manifest.xml';
        }

        // Diff
        $plugins_to_install = array_diff($plugins_new, $_plg);

        // Create array of plugins to install
        $count = 0;
        foreach ($plugins_to_install as $plugin) {
            $plg_path = PLUGINS . DS . Text::lowercase(basename($plugin, '.manifest.xml')) . DS . 'install' . DS . $plugin;
            if (file_exists($plg_path)) {
                $plugins_to_intall[$count]['path']   = $plg_path;
                $plugins_to_intall[$count]['plugin'] = $plugin;
                $count++;
            }
        }

        // Draw template
        View::factory('box/plugins/views/backend/index')
                ->assign('installed_plugins', $installed_plugins)
                ->assign('plugins_to_intall', $plugins_to_intall)
                ->assign('_users_plugins', $_users_plugins)
                ->display();
    }
}
