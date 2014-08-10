<?php

Stylesheet::add('plugins/box/filesmanager/css/style.css', 'backend', 11);
Javascript::add('plugins/box/filesmanager/js/fileuploader.js', 'backend', 11);
Javascript::add('plugins/box/plugins/js/plugins.js', 'backend', 11);

// Add plugin navigation link
Navigation::add(__('Plugins', 'plugins'), 'extends', 'plugins', 1);

// Add action on admin_pre_render hook
Action::add('admin_pre_render','PluginsAdmin::_readmeLoadAjax');

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

                    // Increment Styles and Javascript version
                    Stylesheet::stylesVersionIncrement();
                    Javascript::javascriptVersionIncrement();

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

                Stylesheet::stylesVersionIncrement();
                Javascript::javascriptVersionIncrement();

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

                // Clean Monstra TMP folder.
                Monstra::cleanTmp();
                
                Stylesheet::stylesVersionIncrement();
                Javascript::javascriptVersionIncrement();

                Dir::delete(PLUGINS . DS . basename(Request::get('delete_plugin_from_server'), '.manifest.xml'));
                Request::redirect('index.php?id=plugins');

            } else { die('Request was denied because it contained an invalid security token. Please refresh the page and try again.'); }

        }


        // Upload & extract plugin archive
        // -------------------------------------
        if (Request::post('upload_file')) {

            if (Security::check(Request::post('csrf'))) {

                if ($_FILES['file']) {
                    if (in_array(File::ext($_FILES['file']['name']), array('zip'))) {

                        $tmp_dir = ROOT . DS .'tmp'. DS . uniqid('plugin_');

                        $error = 'Plugin was not uploaded';

                        if (Dir::create($tmp_dir)) {
                            $file_locations = Zip::factory()->extract($_FILES['file']['tmp_name'], $tmp_dir);
                            if (!empty($file_locations)) {

                                $manifest = '';
                                foreach ($file_locations as $filepath) {
                                    if (substr($filepath, -strlen('.manifest.xml')) === '.manifest.xml') {
                                        $manifest = $filepath;
                                        break;
                                    }
                                }

                                if (!empty($manifest) && basename(dirname($manifest)) === 'install') {
                                    $manifest_file = pathinfo($manifest, PATHINFO_BASENAME);
                                    $plugin_name = str_replace('.manifest.xml', '', $manifest_file);

                                    if (Dir::create(PLUGINS . DS . $plugin_name)) {
                                        $tmp_plugin_dir = dirname(dirname($manifest));
                                        Dir::copy($tmp_plugin_dir, PLUGINS . DS . $plugin_name);
                                        Notification::set('success', __('Plugin was uploaded', 'plugins'));
                                        $error = false;
                                    }
                                }
                            }
                        } else {
                            $error = 'System error';
                        }
                    } else {
                        $error = 'Forbidden plugin file type';
                    }
                } else {
                    $error = 'Plugin was not uploaded';
                }

                if ($error) {
                    Notification::set('error', __($error, 'plugins'));
                }

                if (Request::post('dragndrop')) {
                    Request::shutdown();
                } else {
                    Request::redirect($site_url.'/admin/index.php?id=plugins#installnew');
                }
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
                ->assign('fileuploader', array(
                    'uploadUrl' => $site_url.'/admin/index.php?id=plugins',
                    'csrf'      => Security::token(),
                    'errorMsg'  => __('Upload server error', 'filesmanager')
                ))
                ->display();
    }

    /**
     * _readmeLoadAjax
     */
    public static function _readmeLoadAjax() {
        if (Request::post('readme_plugin')) {
            if (File::exists($file = PLUGINS . DS . Request::post('readme_plugin') . DS . 'README.md')) {
                echo Text::toHtml(markdown(Html::toText(File::getContent($file))));
            } else {
                echo __('README.md not found', 'plugins');
            }
            Request::shutdown();
        }
    }

}
