<?php

// Add plugin navigation link
Navigation::add(__('Backups', 'backup'), 'system', 'backup', 3);

/**
 * Backup Admin Class
 */
class BackupAdmin extends Backend
{
    /**
     * Backup admin
     */
    public static function main()
    {
        $backups_path = ROOT . DS . 'backups';

        $backups_list = array();

        // Create backup
        // -------------------------------------
        if (Request::post('create_backup')) {

            if (Security::check(Request::post('csrf'))) {

                @set_time_limit(0);
                @ini_set("memory_limit", "512M");

                $zip = Zip::factory();

                // Add storage folder
                $zip->readDir(STORAGE . DS, false);

                // Add public folder
                if (Request::post('add_public_folder')) $zip->readDir(ROOT . DS . 'public' . DS, false);

                // Add plugins folder
                if (Request::post('add_plugins_folder')) $zip->readDir(PLUGINS . DS, false);

                $zip->archive($backups_path . DS . Date::format(time(), "Y-m-d-H-i-s").'.zip');

            } else { die('Request was denied because it contained an invalid security token. Please refresh the page and try again.'); }
        }

        // Delete backup
        // -------------------------------------
        if (Request::get('id') == 'backup' && Request::get('delete_file')) {

            if (Security::check(Request::get('token'))) {

                File::delete($backups_path . DS . Request::get('delete_file'));
                Request::redirect(Option::get('siteurl').'admin/index.php?id=backup');

            } else { die('Request was denied because it contained an invalid security token. Please refresh the page and try again.'); }
        }

        // Download backup
        // -------------------------------------
        if (Request::get('download')) {
            if (Security::check(Request::get('token'))) {
                File::download($backups_path . DS . Request::get('download'));
            } else { die('Request was denied because it contained an invalid security token. Please refresh the page and try again.'); }
        }

        // Get backup list
        $backups_list = File::scan($backups_path, '.zip');

        // Display view
        View::factory('box/backup/views/backend/index')
                ->assign('backups_list', $backups_list)
                ->display();
    }
}
