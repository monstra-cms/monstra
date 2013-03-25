<?php

// Add plugin navigation link
Navigation::add(__('Snippets', 'snippets'), 'extends', 'snippets', 3);

/**
 * Snippets Admin Class
 */
class SnippetsAdmin extends Backend
{
    /**
     * Snippets admin function
     */
    public static function main()
    {
        // Init vars
        $snippets_path = STORAGE . DS  . 'snippets' . DS;
        $snippets_list = array();
        $errors      = array();

        // Check for get actions
         // -------------------------------------
        if (Request::get('action')) {

            // Switch actions
             // -------------------------------------
            switch (Request::get('action')) {

                // Add snippet
                // -------------------------------------
                case "add_snippet":
                    if (Request::post('add_snippets') || Request::post('add_snippets_and_exit')) {

                        if (Security::check(Request::post('csrf'))) {

                            if (trim(Request::post('name')) == '') $errors['snippets_empty_name'] = __('Required field', 'snippets');
                            if (file_exists($snippets_path.Security::safeName(Request::post('name')).'.snippet.php')) $errors['snippets_exists'] = __('This snippet already exists', 'snippets');

                            if (count($errors) == 0) {

                                // Save snippet
                                File::setContent($snippets_path.Security::safeName(Request::post('name')).'.snippet.php', Request::post('content'));

                                Notification::set('success', __('Your changes to the snippet <i>:name</i> have been saved.', 'snippets', array(':name' => Security::safeName(Request::post('name')))));

                                if (Request::post('add_snippets_and_exit')) {
                                    Request::redirect('index.php?id=snippets');
                                } else {
                                    Request::redirect('index.php?id=snippets&action=edit_snippet&filename='.Security::safeName(Request::post('name')));
                                }
                            }

                        } else { die('Request was denied because it contained an invalid security token. Please refresh the page and try again.'); }
                    }
                    // Save fields
                    if (Request::post('name')) $name = Request::post('name'); else $name = '';
                    if (Request::post('content')) $content = Request::post('content'); else $content = '';

                    // Display view
                    View::factory('box/snippets/views/backend/add')
                            ->assign('content', $content)
                            ->assign('name', $name)
                            ->assign('errors', $errors)
                            ->display();
                break;

                // Edit snippet
                // -------------------------------------
                case "edit_snippet":
                    // Save current snippet action
                    if (Request::post('edit_snippets') || Request::post('edit_snippets_and_exit') ) {

                        if (Security::check(Request::post('csrf'))) {

                            if (trim(Request::post('name')) == '') $errors['snippets_empty_name'] = __('Required field', 'snippets');
                            if ((file_exists($snippets_path.Security::safeName(Request::post('name')).'.snippet.php')) and (Security::safeName(Request::post('snippets_old_name')) !== Security::safeName(Request::post('name')))) $errors['snippets_exists'] = __('This snippet already exists', 'snippets');

                            // Save fields
                            if (Request::post('content')) $content = Request::post('content'); else $content = '';
                            if (count($errors) == 0) {

                                $snippet_old_filename = $snippets_path.Request::post('snippets_old_name').'.snippet.php';
                                $snippet_new_filename = $snippets_path.Security::safeName(Request::post('name')).'.snippet.php';
                                if ( ! empty($snippet_old_filename)) {
                                    if ($snippet_old_filename !== $snippet_new_filename) {
                                        rename($snippet_old_filename, $snippet_new_filename);
                                        $save_filename = $snippet_new_filename;
                                    } else {
                                        $save_filename = $snippet_new_filename;
                                    }
                                } else {
                                    $save_filename = $snippet_new_filename;
                                }

                                // Save snippet
                                File::setContent($save_filename, Request::post('content'));

                                Notification::set('success', __('Your changes to the snippet <i>:name</i> have been saved.', 'snippets', array(':name' => basename($save_filename, '.snippet.php'))));

                                if (Request::post('edit_snippets_and_exit')) {
                                    Request::redirect('index.php?id=snippets');
                                } else {
                                    Request::redirect('index.php?id=snippets&action=edit_snippet&filename='.Security::safeName(Request::post('name')));
                                }
                            }

                        } else { die('Request was denied because it contained an invalid security token. Please refresh the page and try again.'); }
                    }
                    if (Request::post('name')) $name = Request::post('name'); else $name = File::name(Request::get('filename'));
                    $content = File::getContent($snippets_path.Request::get('filename').'.snippet.php');

                    // Display view
                    View::factory('box/snippets/views/backend/edit')
                            ->assign('content', $content)
                            ->assign('name', $name)
                            ->assign('errors', $errors)
                            ->display();
                break;
                case "delete_snippet":

                    if (Security::check(Request::get('token'))) {

                        File::delete($snippets_path.Request::get('filename').'.snippet.php');
                        Notification::set('success', __('Snippet <i>:name</i> deleted', 'snippets', array(':name' => File::name(Request::get('filename')))));
                        Request::redirect('index.php?id=snippets');

                    } else { die('Request was denied because it contained an invalid security token. Please refresh the page and try again.'); }

                break;
            }
        } else {

            // Get snippets
            $snippets_list = File::scan($snippets_path, '.snippet.php');

            // Display view
            View::factory('box/snippets/views/backend/index')
                    ->assign('snippets_list', $snippets_list)
                    ->display();

        }
    }

}
