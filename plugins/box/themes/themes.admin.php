<?php

// Add plugin navigation link
Navigation::add(__('Themes', 'themes'), 'extends', 'themes', 2);

/**
 * Themes Admin Class
 */
class ThemesAdmin extends Backend
{
    /**
     * Themes plugin admin
     */
    public static function main()
    {
        // Get current themes
        $current_site_theme = Option::get('theme_site_name');
        $current_admin_theme = Option::get('theme_admin_name');

        // Init vars
        $themes_site   = Themes::getSiteThemes();
        $themes_admin  = Themes::getAdminThemes();
        $templates     = Themes::getTemplates();
        $chunks        = Themes::getChunks();
        $styles        = Themes::getStyles();
        $scripts       = Themes::getScripts();
        $errors        = array();
        $chunk_path     = THEMES_SITE . DS . $current_site_theme . DS;
        $template_path  = THEMES_SITE . DS . $current_site_theme . DS;
        $style_path     = THEMES_SITE . DS . $current_site_theme . DS . 'css' . DS;
        $script_path    = THEMES_SITE . DS . $current_site_theme . DS . 'js' . DS;

        // Save site theme
        if (Request::post('save_site_theme')) {

            if (Security::check(Request::post('csrf'))) {

                Option::update('theme_site_name', Request::post('themes'));

                // Clean Monstra TMP folder.
                Monstra::cleanTmp();

                // Increment Styles and Javascript version
                Stylesheet::stylesVersionIncrement();
                Javascript::javascriptVersionIncrement();

                Request::redirect('index.php?id=themes');

            } else { die('Request was denied because it contained an invalid security token. Please refresh the page and try again.'); }
        }

        // Save site theme
        if (Request::post('save_admin_theme')) {

            if (Security::check(Request::post('csrf'))) {

                Option::update('theme_admin_name', Request::post('themes'));

                // Clean Monstra TMP folder.
                Monstra::cleanTmp();

                Request::redirect('index.php?id=themes');

            } else { die('Request was denied because it contained an invalid security token. Please refresh the page and try again.'); }
        }

        // Its mean that you can add your own actions for this plugin
        Action::run('admin_themes_extra_actions');

        // Check for get actions
        // -------------------------------------
        if (Request::get('action')) {

            // Switch actions
            // -------------------------------------
            switch (Request::get('action')) {

                // Add chunk
                // -------------------------------------
                case "add_chunk":
                    if (Request::post('add_file') || Request::post('add_file_and_exit')) {

                        if (Security::check(Request::post('csrf'))) {

                            if (trim(Request::post('name')) == '') $errors['file_empty_name'] = __('Required field', 'themes');
                            if (file_exists($chunk_path.Security::safeName(Request::post('name'), null, false).'.chunk.php')) $errors['file_exists'] = __('This chunk already exists', 'themes');

                            if (count($errors) == 0) {

                                // Save chunk
                                File::setContent($chunk_path.Security::safeName(Request::post('name'), null, false).'.chunk.php', Request::post('content'));

                                Notification::set('success', __('Your changes to the chunk <i>:name</i> have been saved.', 'themes', array(':name' => Security::safeName(Request::post('name'), null, false))));

                                if (Request::post('add_file_and_exit')) {
                                    Request::redirect('index.php?id=themes');
                                } else {
                                    Request::redirect('index.php?id=themes&action=edit_chunk&filename='.Security::safeName(Request::post('name'), null, false));
                                }
                            }

                        } else { die('Request was denied because it contained an invalid security token. Please refresh the page and try again.'); }
                    }

                    // Save fields
                    if (Request::post('name')) $name = Request::post('name'); else $name = '';
                    if (Request::post('content')) $content = Request::post('content'); else $content = '';

                    // Display view
                    View::factory('box/themes/views/backend/add')
                            ->assign('name', $name)
                            ->assign('content', $content)
                            ->assign('errors', $errors)
                            ->assign('action', 'chunk')
                            ->display();
                break;

                // Add template
                // -------------------------------------
                case "add_template":
                     if (Request::post('add_file') || Request::post('add_file_and_exit')) {

                        if (Security::check(Request::post('csrf'))) {

                            if (trim(Request::post('name')) == '') $errors['file_empty_name'] = __('Required field', 'themes');
                            if (file_exists($template_path.Security::safeName(Request::post('name'), null, false).'.template.php')) $errors['file_exists'] = __('This template already exists', 'themes');

                            if (count($errors) == 0) {

                                // Save chunk
                                File::setContent($template_path.Security::safeName(Request::post('name'), null, false).'.template.php', Request::post('content'));

                                Notification::set('success', __('Your changes to the chunk <i>:name</i> have been saved.', 'themes', array(':name' => Security::safeName(Request::post('name'), null, false))));

                                if (Request::post('add_file_and_exit')) {
                                    Request::redirect('index.php?id=themes');
                                } else {
                                    Request::redirect('index.php?id=themes&action=edit_template&filename='.Security::safeName(Request::post('name'), null, false));
                                }
                            }

                        } else { die('Request was denied because it contained an invalid security token. Please refresh the page and try again.'); }
                    }

                    // Save fields
                    if (Request::post('name')) $name = Request::post('name'); else $name = '';
                    if (Request::post('content')) $content = Request::post('content'); else $content = '';

                    // Display view
                    View::factory('box/themes/views/backend/add')
                            ->assign('name', $name)
                            ->assign('content', $content)
                            ->assign('errors', $errors)
                            ->assign('action', 'template')
                            ->display();
                break;

                // Add styles
                // -------------------------------------
                case "add_styles":
                     if (Request::post('add_file') || Request::post('add_file_and_exit')) {

                        if (Security::check(Request::post('csrf'))) {

                            if (trim(Request::post('name')) == '') $errors['file_empty_name'] = __('Required field', 'themes');
                            if (file_exists($style_path.Security::safeName(Request::post('name'), null, false).'.css')) $errors['file_exists'] = __('This styles already exists', 'themes');

                            if (count($errors) == 0) {

                                // Save chunk
                                File::setContent($style_path.Security::safeName(Request::post('name'), null, false).'.css', Request::post('content'));

                                Notification::set('success', __('Your changes to the styles <i>:name</i> have been saved.', 'themes', array(':name' => Security::safeName(Request::post('name'), null, false))));

                                // Clean Monstra TMP folder.
                                Monstra::cleanTmp();

                                // Increment Styles version
                                Stylesheet::stylesVersionIncrement();

                                if (Request::post('add_file_and_exit')) {
                                    Request::redirect('index.php?id=themes');
                                } else {
                                    Request::redirect('index.php?id=themes&action=edit_styles&filename='.Security::safeName(Request::post('name'), null, false));
                                }

                            }

                        } else { die('Request was denied because it contained an invalid security token. Please refresh the page and try again.'); }
                    }

                    // Save fields
                    if (Request::post('name')) $name = Request::post('name'); else $name = '';
                    if (Request::post('content')) $content = Request::post('content'); else $content = '';

                    // Display view
                    View::factory('box/themes/views/backend/add')
                            ->assign('name', $name)
                            ->assign('content', $content)
                            ->assign('errors', $errors)
                            ->assign('action', 'styles')
                            ->display();
                break;

                // Add script
                // -------------------------------------
                case "add_script":
                     if (Request::post('add_file') || Request::post('add_file_and_exit')) {

                        if (Security::check(Request::post('csrf'))) {

                            if (trim(Request::post('name')) == '') $errors['file_empty_name'] = __('Required field', 'themes');
                            if (file_exists($script_path.Security::safeName(Request::post('name'), null, false).'.js')) $errors['file_exists'] = __('This script already exists', 'themes');

                            if (count($errors) == 0) {

                                // Save chunk
                                File::setContent($script_path.Security::safeName(Request::post('name'), null, false).'.js', Request::post('content'));

                                Notification::set('success', __('Your changes to the script <i>:name</i> have been saved.', 'themes', array(':name' => Security::safeName(Request::post('name'), null, false))));


                                // Clean Monstra TMP folder.
                                Monstra::cleanTmp();

                                // Increment Javascript version
                                Javascript::javascriptVersionIncrement();


                                if (Request::post('add_file_and_exit')) {
                                    Request::redirect('index.php?id=themes');
                                } else {
                                    Request::redirect('index.php?id=themes&action=edit_script&filename='.Security::safeName(Request::post('name'), null, false));
                                }

                            }

                        } else { die('Request was denied because it contained an invalid security token. Please refresh the page and try again.'); }
                    }

                    // Save fields
                    if (Request::post('name')) $name = Request::post('name'); else $name = '';
                    if (Request::post('content')) $content = Request::post('content'); else $content = '';

                    // Display view
                    View::factory('box/themes/views/backend/add')
                            ->assign('name', $name)
                            ->assign('content', $content)
                            ->assign('errors', $errors)
                            ->assign('action', 'script')
                            ->display();
                break;

                // Edit chunk
                // -------------------------------------
                case "edit_chunk":

                    // Save current chunk action
                    if (Request::post('edit_file') || Request::post('edit_file_and_exit') ) {

                        if (Security::check(Request::post('csrf'))) {

                            if (trim(Request::post('name')) == '') $errors['file_empty_name'] = __('Required field', 'themes');
                            if ((file_exists($chunk_path.Security::safeName(Request::post('name'), null, false).'.chunk.php') and (Security::safeName(Request::post('chunk_old_name'), null, false)) !== Security::safeName(Request::post('name'), null, false))) $errors['file_exists'] = __('This chunk already exists', 'themes');

                            // Save fields
                            if (Request::post('content')) $content = Request::post('content'); else $content = '';
                            if (count($errors) == 0) {

                                $chunk_old_filename = $chunk_path.Request::post('chunk_old_name').'.chunk.php';
                                $chunk_new_filename = $chunk_path.Security::safeName(Request::post('name'), null, false).'.chunk.php';
                                if ( ! empty($chunk_old_filename)) {
                                    if ($chunk_old_filename !== $chunk_new_filename) {
                                        rename($chunk_old_filename, $chunk_new_filename);
                                        $save_filename = $chunk_new_filename;
                                    } else {
                                        $save_filename = $chunk_new_filename;
                                    }
                                } else {
                                    $save_filename = $chunk_new_filename;
                                }

                                // Save chunk
                                File::setContent($save_filename, Request::post('content'));

                                Notification::set('success', __('Your changes to the chunk <i>:name</i> have been saved.', 'themes', array(':name' => basename($save_filename, '.chunk.php'))));

                                if (Request::post('edit_file_and_exit')) {
                                    Request::redirect('index.php?id=themes');
                                } else {
                                    Request::redirect('index.php?id=themes&action=edit_chunk&filename='.Security::safeName(Request::post('name'), null, false));
                                }
                            }

                        } else { die('Request was denied because it contained an invalid security token. Please refresh the page and try again.'); }
                    }
                    if (Request::post('name')) $name = Request::post('name'); else $name = File::name(Request::get('filename'));
                    $content = File::getContent($chunk_path.Request::get('filename').'.chunk.php');

                    // Display view
                    View::factory('box/themes/views/backend/edit')
                            ->assign('content', $content)
                            ->assign('name', $name)
                            ->assign('errors', $errors)
                            ->assign('action', 'chunk')
                            ->display();

                break;

                // Edit Template
                // -------------------------------------
                case "edit_template":

                    // Save current chunk action
                    if (Request::post('edit_file') || Request::post('edit_file_and_exit') ) {

                        if (Security::check(Request::post('csrf'))) {

                            if (trim(Request::post('name')) == '') $errors['file_empty_name'] = __('Required field', 'themes');
                            if ((file_exists($template_path.Security::safeName(Request::post('name'), null, false).'.template.php') and (Security::safeName(Request::post('template_old_name'), null, false)) !== Security::safeName(Request::post('name'), null, false))) $errors['template_exists'] = __('This template already exists', 'themes');

                            // Save fields
                            if (Request::post('content')) $content = Request::post('content'); else $content = '';
                            if (count($errors) == 0) {

                                $template_old_filename = $template_path.Request::post('template_old_name').'.template.php';
                                $template_new_filename = $template_path.Security::safeName(Request::post('name'), null, false).'.template.php';
                                if ( ! empty($template_old_filename)) {
                                    if ($template_old_filename !== $template_new_filename) {
                                        rename($template_old_filename, $template_new_filename);
                                        $save_filename = $template_new_filename;
                                    } else {
                                        $save_filename = $template_new_filename;
                                    }
                                } else {
                                    $save_filename = $template_new_filename;
                                }

                                // Save chunk
                                File::setContent($save_filename, Request::post('content'));

                                Notification::set('success', __('Your changes to the template <i>:name</i> have been saved.', 'themes', array(':name' => basename($save_filename, '.template.php'))));

                                if (Request::post('edit_file_and_exit')) {
                                    Request::redirect('index.php?id=themes');
                                } else {
                                    Request::redirect('index.php?id=themes&action=edit_template&filename='.Security::safeName(Request::post('name'), null, false));
                                }
                            }

                        } else { die('Request was denied because it contained an invalid security token. Please refresh the page and try again.'); }
                    }
                    if (Request::post('name')) $name = Request::post('name'); else $name = File::name(Request::get('filename'));
                    $content = File::getContent($chunk_path.Request::get('filename').'.template.php');

                    // Display view
                    View::factory('box/themes/views/backend/edit')
                            ->assign('content', $content)
                            ->assign('name', $name)
                            ->assign('errors', $errors)
                            ->assign('action', 'template')
                            ->display();

                break;

                // Edit Styles
                // -------------------------------------
                case "edit_styles":

                    // Save current chunk action
                    if (Request::post('edit_file') || Request::post('edit_file_and_exit') ) {

                        if (Security::check(Request::post('csrf'))) {

                            if (trim(Request::post('name')) == '') $errors['file_empty_name'] = __('Required field', 'themes');
                            if ((file_exists($style_path.Security::safeName(Request::post('name'), null, false).'.css') and (Security::safeName(Request::post('styles_old_name'), null, false)) !== Security::safeName(Request::post('name'), null, false))) $errors['file_exists'] = __('This styles already exists', 'themes');

                            // Save fields
                            if (Request::post('content')) $content = Request::post('content'); else $content = '';
                            if (count($errors) == 0) {

                                $styles_old_filename = $style_path.Request::post('styles_old_name').'.css';
                                $styles_new_filename = $style_path.Security::safeName(Request::post('name'), null, false).'.css';
                                if ( ! empty($styles_old_filename)) {
                                    if ($styles_old_filename !== $styles_new_filename) {
                                        rename($styles_old_filename, $styles_new_filename);
                                        $save_filename = $styles_new_filename;
                                    } else {
                                        $save_filename = $styles_new_filename;
                                    }
                                } else {
                                    $save_filename = $styles_new_filename;
                                }

                                // Save chunk
                                File::setContent($save_filename, Request::post('content'));

                                Notification::set('success', __('Your changes to the styles <i>:name</i> have been saved.', 'themes', array(':name' => basename($save_filename, '.css'))));

                                // Clean Monstra TMP folder.
                                Monstra::cleanTmp();

                                // Increment Styles version
                                Stylesheet::stylesVersionIncrement();

                                if (Request::post('edit_file_and_exit')) {
                                    Request::redirect('index.php?id=themes');
                                } else {
                                    Request::redirect('index.php?id=themes&action=edit_styles&filename='.Security::safeName(Request::post('name'), null, false));
                                }
                            }

                        } else { die('Request was denied because it contained an invalid security token. Please refresh the page and try again.'); }
                    }
                    if (Request::post('name')) $name = Request::post('name'); else $name = File::name(Request::get('filename'));
                    $content = File::getContent($style_path.Request::get('filename').'.css');

                    // Display view
                    View::factory('box/themes/views/backend/edit')
                            ->assign('content', $content)
                            ->assign('name', $name)
                            ->assign('errors', $errors)
                            ->assign('action', 'styles')
                            ->display();

                break;

                // Edit Script
                // -------------------------------------
                case "edit_script":

                    // Save current chunk action
                    if (Request::post('edit_file') || Request::post('edit_file_and_exit') ) {

                        if (Security::check(Request::post('csrf'))) {

                            if (trim(Request::post('name')) == '') $errors['file_empty_name'] = __('Required field', 'themes');
                            if ((file_exists($script_path.Security::safeName(Request::post('name'), null, false).'.js')) and (Security::safeName(Request::post('script_old_name'), null, false)) !== Security::safeName(Request::post('name'), null, false)) $errors['file_exists'] = __('This script already exists', 'themes');

                            // Save fields
                            if (Request::post('content')) $content = Request::post('content'); else $content = '';
                            if (count($errors) == 0) {

                                $script_old_filename = $script_path.Request::post('script_old_name').'.js';
                                $script_new_filename = $script_path.Security::safeName(Request::post('name'), null, false).'.js';
                                if ( ! empty($script_old_filename)) {
                                    if ($script_old_filename !== $script_new_filename) {
                                        rename($script_old_filename, $script_new_filename);
                                        $save_filename = $script_new_filename;
                                    } else {
                                        $save_filename = $script_new_filename;
                                    }
                                } else {
                                    $save_filename = $script_new_filename;
                                }

                                // Save chunk
                                File::setContent($save_filename, Request::post('content'));

                                Notification::set('success', __('Your changes to the script <i>:name</i> have been saved.', 'themes', array(':name' => basename($save_filename, '.js'))));

                                // Clean Monstra TMP folder.
                                Monstra::cleanTmp();

                                // Increment Javascript version
                                Javascript::javascriptVersionIncrement();

                                if (Request::post('edit_file_and_exit')) {
                                    Request::redirect('index.php?id=themes');
                                } else {
                                    Request::redirect('index.php?id=themes&action=edit_script&filename='.Security::safeName(Request::post('name'), null, false));
                                }
                            }

                        } else { die('Request was denied because it contained an invalid security token. Please refresh the page and try again.'); }
                    }
                    if (Request::post('name')) $name = Request::post('name'); else $name = File::name(Request::get('filename'));
                    $content = File::getContent($script_path.Request::get('filename').'.js');

                    // Display view
                    View::factory('box/themes/views/backend/edit')
                            ->assign('content', $content)
                            ->assign('name', $name)
                            ->assign('errors', $errors)
                            ->assign('action', 'script')
                            ->display();

                break;

                // Delete chunk
                // -------------------------------------
                case "delete_chunk":

                    if (Security::check(Request::get('token'))) {

                        File::delete($chunk_path.Request::get('filename').'.chunk.php');
                        Notification::set('success', __('Chunk <i>:name</i> deleted', 'themes', array(':name' => File::name(Request::get('filename')))));
                        Request::redirect('index.php?id=themes');

                    } else { die('Request was denied because it contained an invalid security token. Please refresh the page and try again.'); }

                break;

                // Delete styles
                // -------------------------------------
                case "delete_styles":

                    if (Security::check(Request::get('token'))) {

                        File::delete($style_path.Request::get('filename').'.css');
                        Notification::set('success', __('Styles <i>:name</i> deleted', 'themes', array(':name' => File::name(Request::get('filename')))));

                        // Clean Monstra TMP folder.
                        Monstra::cleanTmp();

                        // Increment Styles version
                        Stylesheet::stylesVersionIncrement();

                        Request::redirect('index.php?id=themes');

                    } else { die('Request was denied because it contained an invalid security token. Please refresh the page and try again.'); }

                break;

                // Delete script
                // -------------------------------------
                case "delete_script":

                    if (Security::check(Request::get('token'))) {

                        File::delete($script_path.Request::get('filename').'.js');
                        Notification::set('success', __('Script <i>:name</i> deleted', 'themes', array(':name' => File::name(Request::get('filename')))));

                        // Clean Monstra TMP folder.
                        Monstra::cleanTmp();

                        // Increment Javascript version
                        Javascript::javascriptVersionIncrement();

                        Request::redirect('index.php?id=themes');

                    } else { die('Request was denied because it contained an invalid security token. Please refresh the page and try again.'); }

                break;

                // Delete template
                // -------------------------------------
                case "delete_template":

                    if (Security::check(Request::get('token'))) {

                        File::delete($template_path.Request::get('filename').'.template.php');
                        Notification::set('success', __('Template <i>:name</i> deleted', 'themes', array(':name' => File::name(Request::get('filename')))));
                        Request::redirect('index.php?id=themes');
                    }

                break;

                // Clone styles
                // -------------------------------------
                case "clone_styles":

                    if (Security::check(Request::get('token'))) {

                        File::setContent(THEMES_SITE . DS . $current_site_theme . DS . 'css' . DS . Request::get('filename') .'_clone_'.date("Ymd_His").'.css',
                                         File::getContent(THEMES_SITE . DS . $current_site_theme . DS . 'css' . DS . Request::get('filename') . '.css'));

                        // Clean Monstra TMP folder.
                        Monstra::cleanTmp();

                        // Increment Styles version
                        Stylesheet::stylesVersionIncrement();

                        Request::redirect('index.php?id=themes');
                    }

                break;

                // Clone script
                // -------------------------------------
                case "clone_script":

                    if (Security::check(Request::get('token'))) {

                        File::setContent(THEMES_SITE . DS . $current_site_theme . DS . 'js' . DS . Request::get('filename') .'_clone_'.date("Ymd_His").'.js',
                                         File::getContent(THEMES_SITE . DS . $current_site_theme . DS . 'js' . DS . Request::get('filename') . '.js'));


                        // Clean Monstra TMP folder.
                        Monstra::cleanTmp();

                        // Increment Javascript version
                        Javascript::javascriptVersionIncrement();
                        
                        Request::redirect('index.php?id=themes');
                    }

                break;

                // Clone template
                // -------------------------------------
                case "clone_template":

                    if (Security::check(Request::get('token'))) {

                        File::setContent(THEMES_SITE . DS . $current_site_theme . DS . Request::get('filename') .'_clone_'.date("Ymd_His").'.template.php',
                                         File::getContent(THEMES_SITE . DS . $current_site_theme . DS . Request::get('filename') . '.template.php'));

                        Request::redirect('index.php?id=themes');

                    }

                break;

                // Clone chunk
                // -------------------------------------
                case "clone_chunk":

                    if (Security::check(Request::get('token'))) {
                        File::setContent(THEMES_SITE . DS . $current_site_theme . DS . Request::get('filename') .'_clone_'.date("Ymd_His").'.chunk.php',
                                         File::getContent(THEMES_SITE . DS . $current_site_theme . DS . Request::get('filename') . '.chunk.php'));

                        Request::redirect('index.php?id=themes');
                    }

                break;

            }

        } else {

            // Display view
            View::factory('box/themes/views/backend/index')
                    ->assign('themes_site', $themes_site)
                    ->assign('themes_admin', $themes_admin)
                    ->assign('templates', $templates)
                    ->assign('chunks', $chunks)
                    ->assign('styles', $styles)
                    ->assign('scripts', $scripts)
                    ->assign('current_site_theme', $current_site_theme)
                    ->assign('current_admin_theme', $current_admin_theme)
                    ->display();

        }
    }
}
