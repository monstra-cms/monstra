<?php

// Add Monstra check action
if (CHECK_MONSTRA_VERSION) {
    Action::add('admin_post_template', 'checkMonstraVersion', 9999);
}

/**
 * Check Monstra version
 */
function checkMonstraVersion()
{
    echo ('
            <script type="text/javascript">
                $.getJSON("http://monstra.org/api/version.php?jsoncallback=?",
                    function(data){
                        var current_monstra_version = "'.Monstra::VERSION.'";
                        var stable_monstra_version = data.version;
                        if (current_monstra_version < stable_monstra_version) {
                            $("#update-monstra").addClass("alert alert-info").html("'.__("Published a new version of the :monstra", "system", array(":monstra" => "<a target='_blank' href='http://monstra.org/download'>Monstra</a>")).'");
                        }
                    }
                );
            </script>
    ');
}

/**
 * System Admin
 */
class SystemAdmin extends Backend
{
    /**
     * System plugin admin
     */
    public static function main()
    {
        if (Session::exists('user_role') && in_array(Session::get('user_role'), array('admin'))) {

            $filters    = Filter::$filters;
            $plugins    = Plugin::$plugins;
            $components = Plugin::$components;
            $actions    = Action::$actions;

            // Get pages table
            $pages = new Table('pages');

            // Get system timezone
            $system_timezone = Option::get('timezone');

            // Get languages files
            $language_files = File::scan(PLUGINS_BOX . DS . 'system' . DS . 'languages' . DS, '.lang.php');
            foreach ($language_files as $language) {
                $parts = explode('.', $language);
                $languages_array[$parts[0]] = I18n::$locales[$parts[0]];
            }

            // Get all pages
            $pages_array = array();
            $pages_list = $pages->select('[slug!="error404" and parent="" and status="published"]');
            foreach ($pages_list as $page) {
                $pages_array[$page['slug']] = Html::toText($page['title']);
            }

            // Create Sitemap
            // -------------------------------------
            if (Request::get('sitemap') == 'create') {

                if (Security::check(Request::get('token'))) {

                    Notification::set('success', __('Sitemap created', 'system'));

                    Sitemap::create();

                    Request::redirect('index.php?id=system');

                } else { die('Request was denied because it contained an invalid security token. Please refresh the page and try again.'); }

            }

            // Delete temporary files
            // -------------------------------------
            if (Request::get('temporary_files') == 'delete') {

                if (Security::check(Request::get('token'))) {

                    Monstra::cleanTmp();

                    if (count(File::scan(MINIFY, array('css', 'js', 'php'))) == 0 && count(Dir::scan(CACHE)) == 0) {
                        Notification::set('success', __('Temporary files deleted', 'system'));
                        Request::redirect('index.php?id=system');
                    }

                } else { die('Request was denied because it contained an invalid security token. Please refresh the page and try again.'); }
            }

            // Set maintenance state on or off
            // -------------------------------------
            if (Request::get('maintenance')) {

                if (Security::check(Request::get('token'))) {

                    if ('on' == Request::get('maintenance')) {
                        Option::update('maintenance_status', 'on');
                        Request::redirect('index.php?id=system');
                    }

                    if ('off' == Request::get('maintenance')) {
                        Option::update('maintenance_status', 'off');
                        Request::redirect('index.php?id=system');
                    }

                } else { die('Request was denied because it contained an invalid security token. Please refresh the page and try again.'); }
            }

            // Edit settings
            // -------------------------------------
            if (Request::post('edit_settings')) {

                if (Security::check(Request::post('csrf'))) {

                    // Add trailing slashes
                    $_site_url = Request::post('system_url');

                    Option::update(array('sitename'          => Request::post('site_name'),
                                       'keywords'            => Request::post('site_keywords'),
                                       'description'         => Request::post('site_description'),
                                       'slogan'              => Request::post('site_slogan'),
                                       'defaultpage'         => Request::post('site_default_page'),
                                       'siteurl'             => $_site_url,
                                       'timezone'            => Request::post('system_timezone'),
                                       'system_email'        => Request::post('system_email'),
                                       'language'            => Request::post('system_language'),
                                       'maintenance_message' => Request::post('site_maintenance_message')));

                    Notification::set('success', __('Your changes have been saved.', 'system'));
                    Request::redirect('index.php?id=system');

                } else { die('Request was denied because it contained an invalid security token. Please refresh the page and try again.'); }
            }

            // Its mean that you can add your own actions for this plugin
            Action::run('admin_system_extra_actions');

            // Display view
            View::factory('box/system/views/backend/index')
                    ->assign('pages_array', $pages_array)
                    ->assign('languages_array', $languages_array)
                    ->display();

        } else {

            Request::redirect('index.php?id=users&action=edit&user_id='.Session::get('user_id'));
        }
    }
}
