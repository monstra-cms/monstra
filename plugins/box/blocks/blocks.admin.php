<?php

// Add plugin navigation link
Navigation::add(__('Blocks', 'blocks'), 'content', 'blocks', 2);

/**
 * Blocks Admin Class
 */
class BlocksAdmin extends Backend
{
    /**
     * Blocks admin function
     */
    public static function main()
    {
        // Init vars
        $blocks_path = STORAGE . DS  . 'blocks' . DS;
        $blocks_list = array();
        $errors      = array();

        // Check for get actions
         // -------------------------------------
        if (Request::get('action')) {

            // Switch actions
             // -------------------------------------
            switch (Request::get('action')) {

                // Add block
                // -------------------------------------
                case "add_block":

                    if (Request::post('add_blocks') || Request::post('add_blocks_and_exit')) {

                        if (Security::check(Request::post('csrf'))) {

                            if (trim(Request::post('name')) == '') $errors['blocks_empty_name'] = __('Required field', 'blocks');
                            if (file_exists($blocks_path.Security::safeName(Request::post('name')).'.block.html')) $errors['blocks_exists'] = __('This block already exists', 'blocks');

                            if (count($errors) == 0) {

                                // Save block
                                File::setContent($blocks_path.Security::safeName(Request::post('name')).'.block.html', XML::safe(Request::post('editor')));

                                Notification::set('success', __('Your changes to the block <i>:name</i> have been saved.', 'blocks', array(':name' => Security::safeName(Request::post('name')))));

                                if (Request::post('add_blocks_and_exit')) {
                                    Request::redirect('index.php?id=blocks');
                                } else {
                                    Request::redirect('index.php?id=blocks&action=edit_block&filename='.Security::safeName(Request::post('name')));
                                }
                            }

                        } else { die('Request was denied because it contained an invalid security token. Please refresh the page and try again.'); }
                    }

                    // Save fields
                    if (Request::post('name')) $name = Request::post('name'); else $name = '';
                    if (Request::post('editor')) $content = Request::post('editor'); else $content = '';

                    // Display view
                    View::factory('box/blocks/views/backend/add')
                            ->assign('content', $content)
                            ->assign('name', $name)
                            ->assign('errors', $errors)
                            ->display();
                break;

                // Edit Block
                // -------------------------------------
                case "edit_block":
                    // Save current block action
                    if (Request::post('edit_blocks') || Request::post('edit_blocks_and_exit') ) {

                        if (Security::check(Request::post('csrf'))) {

                            if (trim(Request::post('name')) == '') $errors['blocks_empty_name'] = __('Required field', 'blocks');
                            if ((file_exists($blocks_path.Security::safeName(Request::post('name')).'.block.html')) and (Security::safeName(Request::post('blocks_old_name')) !== Security::safeName(Request::post('name')))) $errors['blocks_exists'] = __('This block already exists', 'blocks');

                            // Save fields
                            if (Request::post('editor')) $content = Request::post('editor'); else $content = '';
                            if (count($errors) == 0) {

                                $block_old_filename = $blocks_path.Request::post('blocks_old_name').'.block.html';
                                $block_new_filename = $blocks_path.Security::safeName(Request::post('name')).'.block.html';
                                if ( ! empty($block_old_filename)) {
                                    if ($block_old_filename !== $block_new_filename) {
                                        rename($block_old_filename, $block_new_filename);
                                        $save_filename = $block_new_filename;
                                    } else {
                                        $save_filename = $block_new_filename;
                                    }
                                } else {
                                    $save_filename = $block_new_filename;
                                }

                                // Save block
                                File::setContent($save_filename, XML::safe(Request::post('editor')));

                                Notification::set('success', __('Your changes to the block <i>:name</i> have been saved.', 'blocks', array(':name' => basename($save_filename, '.block.html'))));

                                if (Request::post('edit_blocks_and_exit')) {
                                    Request::redirect('index.php?id=blocks');
                                } else {
                                    Request::redirect('index.php?id=blocks&action=edit_block&filename='.Security::safeName(Request::post('name')));
                                }
                            }

                        } else { die('Request was denied because it contained an invalid security token. Please refresh the page and try again.'); }
                    }
                    if (Request::post('name')) $name = Request::post('name'); else $name = File::name(Request::get('filename'));
                    if (Request::post('editor')) $content = Request::post('editor'); else $content = File::getContent($blocks_path.Request::get('filename').'.block.html');

                    // Display view
                    View::factory('box/blocks/views/backend/edit')
                            ->assign('content', Text::toHtml($content))
                            ->assign('name', $name)
                            ->assign('errors', $errors)
                            ->display();
                break;
                case "delete_block":

                    if (Security::check(Request::get('token'))) {

                        File::delete($blocks_path.Request::get('filename').'.block.html');
                        Notification::set('success', __('Block <i>:name</i> deleted', 'blocks', array(':name' => File::name(Request::get('filename')))));
                        Request::redirect('index.php?id=blocks');

                    } else { die('Request was denied because it contained an invalid security token. Please refresh the page and try again.'); }

                break;
            }
        } else {

            // Get blocks
            $blocks_list = File::scan($blocks_path, '.block.html');

            // Display view
            View::factory('box/blocks/views/backend/index')
                    ->assign('blocks_list', $blocks_list)
                    ->display();

        }
    }

}
