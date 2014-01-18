<?php

// Add Plugin Javascript
Stylesheet::add('plugins/box/filesmanager/css/style.css', 'backend');
Javascript::add('plugins/box/filesmanager/js/fileuploader.js', 'backend');

// Add plugin navigation link
Navigation::add(__('Files', 'filesmanager'), 'content', 'filesmanager', 3);

/**
 * Filesmanager Admin Class
 */
class FilesmanagerAdmin extends Backend
{
    /**
     * Main function
     */
    public static function main()
    {
        // Array of forbidden types
        $forbidden_types = array('html', 'htm', 'js', 'jsb', 'mhtml', 'mht',
                                 'php', 'phtml', 'php3', 'php4', 'php5', 'phps',
                                 'shtml', 'jhtml', 'pl', 'py', 'cgi', 'sh', 'ksh', 'bsh', 'c', 'htaccess', 'htpasswd',
                                 'exe', 'scr', 'dll', 'msi', 'vbs', 'bat', 'com', 'pif', 'cmd', 'vxd', 'cpl', 'empty');

        // Array of image types
        $image_types = array('jpg', 'png', 'bmp', 'gif', 'tif');

        // Get Site url
        $site_url = Option::get('siteurl');

        // Init vars
        if (Request::get('path')) $path = Request::get('path'); else $path = 'uploads/';

        // Add slash if not exists
        if (substr($path, -1, 1) != '/') {
            $path .= '/';
            Request::redirect($site_url.'/admin/index.php?id=filesmanager&path='.$path);
        }

        // Upload corectly!
        if ($path == 'uploads' || $path == 'uploads//') {
            $path = 'uploads/';
            Request::redirect($site_url.'/admin/index.php?id=filesmanager&path='.$path);
        }

        // Only 'uploads' folder!
        if (strpos($path, 'uploads') === false) {
            $path = 'uploads/';
            Request::redirect($site_url.'/admin/index.php?id=filesmanager&path='.$path);
        }

        // Set default path value if path is empty
        if ($path == '') {
            $path = 'uploads/';
            Request::redirect($site_url.'/admin/index.php?id=filesmanager&path='.$path);
        }

        $files_path = ROOT . DS . 'public' . DS . $path;
        
        $current = explode('/', $path);

        // Delete file
        // -------------------------------------
        if (Request::get('id') == 'filesmanager' && Request::get('delete_file')) {

            if (Security::check(Request::get('token'))) {

                File::delete($files_path.Request::get('delete_file'));
                Request::redirect($site_url.'/admin/index.php?id=filesmanager&path='.$path);

            } else { die('Request was denied because it contained an invalid security token. Please refresh the page and try again.'); }
        }

        // Delete dir
        // -------------------------------------
        if (Request::get('id') == 'filesmanager' && Request::get('delete_dir')) {

            if (Security::check(Request::get('token'))) {

                Dir::delete($files_path.Request::get('delete_dir'));

                if (!is_dir($files_path.Request::get('delete_dir'))) {
                    Notification::set('success', __('Directory was deleted', 'system'));
                } else {
                    Notification::set('error', __('Directory was not deleted', 'system'));
                }
                
                Request::redirect($site_url.'/admin/index.php?id=filesmanager&path='.$path);
                
                    
            } else { die('Request was denied because it contained an invalid security token. Please refresh the page and try again.'); }
        }

        // Upload file
        // -------------------------------------
        if (Request::post('upload_file')) {

            if (Security::check(Request::post('csrf'))) {

                if ($_FILES['file']) {
                    if ( ! in_array(File::ext($_FILES['file']['name']), $forbidden_types)) {
                        move_uploaded_file($_FILES['file']['tmp_name'], $files_path.Security::safeName(basename($_FILES['file']['name'], File::ext($_FILES['file']['name'])), '-', true).'.'.File::ext($_FILES['file']['name']));
                        Request::redirect($site_url.'/admin/index.php?id=filesmanager&path='.$path);
                    }
                }

            } else { die('Request was denied because it contained an invalid security token. Please refresh the page and try again.'); }
        }


        if (Request::post('directory_name')) {
            
            if (Security::check(Request::post('csrf'))) {
                
                $abs_path = $files_path . Security::safeName(Request::post('directory_name'));
                
                $error = false;
                
                if ( !is_dir($abs_path) ) {
                    try {
                        mkdir($abs_path);
                    } catch(Exception $e) {
                        $error = true;
                    }
                } else {
                    $error = true;
                }
                
                if ($error) {
                    Alert::error(__('Directory was not created', 'system'));
                } else {
                    Alert::success(__('Directory was created', 'system'));
                }
                
            }
            
        }

        // Get information about current path
        $_list = FilesmanagerAdmin::fdir($files_path);

        $files_list = array();

        // Get files
        if (isset($_list['files'])) {
            foreach ($_list['files'] as $files) {
                $files_list[] = $files;
            }
        }
        
        $dir_list = array();
        
        // Get dirs
        if (isset($_list['dirs'])) {
            foreach ($_list['dirs'] as $dirs) {
                if (strpos($dirs, '.') === false && strpos($dirs, '..') === false){ 
                    $dir_list[] = $dirs;
                }
            }
        }

        // Display view
        View::factory('box/filesmanager/views/backend/index')
                ->assign('path', $path)
                ->assign('current', $current)
                ->assign('files_list', $files_list)
                ->assign('dir_list', $dir_list)
                ->assign('forbidden_types', $forbidden_types)
                ->assign('image_types', $image_types)
                ->assign('site_url', $site_url)
                ->assign('files_path', $files_path)
                ->assign('fileuploader', array(
                    'uploadUrl' => $site_url.'/admin/index.php?id=filesmanager&path='.$path,
                    'csrf'      => Security::token()
                ))->display();

    }

    /**
     * Get directories and files in current path
     */
    protected static function fdir($dir, $type = null)
    {
        $files = array();
        $c = 0;
        $_dir = $dir;
        if (is_dir($dir)) {
        $dir = opendir ($dir);
            while (false !== ($file = readdir($dir))) {
                if (($file !=".") && ($file !="..")) {
                    $c++;
                    if (is_dir($_dir.$file)) {
                        $files['dirs'][$c] = $file;
                    } else {
                        $files['files'][$c] = $file;
                    }
                }
            }
            closedir($dir);

            return $files;
        } else {
            return false;
        }
    }

}
