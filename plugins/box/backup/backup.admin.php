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
                $zip->readDir(ROOT . DS . 'public' . DS, false);

                // Add plugins folder
                $zip->readDir(PLUGINS . DS, false, null, array(PLUGINS . DS . 'box'));

                if ($zip->archive($backups_path . DS . Date::format(time(), "Y-m-d-H-i-s").'.zip')) {
                    Notification::set('success', __('Backup was created', 'backup'));
                } else {
                    Notification::set('error', __('Backup was not created', 'backup'));
                }

                Request::redirect(Option::get('siteurl').'/admin/index.php?id=backup');

            } else { die('Request was denied because it contained an invalid security token. Please refresh the page and try again.'); }
        }

        // Delete backup
        // -------------------------------------
        if (Request::get('id') == 'backup' && Request::get('delete_file')) {

            if (Security::check(Request::get('token'))) {

                if (File::delete($backups_path . DS . Request::get('delete_file'))) {
                    Notification::set('success', __('Backup was deleted', 'backup'));
                } else {
                    Notification::set('error', __('Backup was not deleted', 'backup'));
                }
                
                Request::redirect(Option::get('siteurl').'/admin/index.php?id=backup');

            } else { die('Request was denied because it contained an invalid security token. Please refresh the page and try again.'); }
        }

        // Download backup
        // -------------------------------------
        if (Request::get('download')) {
            if (Security::check(Request::get('token'))) {
                File::download($backups_path . DS . Request::get('download'));
            } else { die('Request was denied because it contained an invalid security token. Please refresh the page and try again.'); }
        }

        // Restore backup
        // -------------------------------------
        if (Request::get('restore')) {

            if (Security::check(Request::get('token'))) {

                $tmp_dir = ROOT . DS . 'tmp' . DS . uniqid('backup_');

                if (Dir::create($tmp_dir)) {
                    $file_locations = Zip::factory()->extract($backups_path . DS . Request::get('restore'), $tmp_dir);
                     if (!empty($file_locations)) {
                         Dir::copy($tmp_dir, ROOT . DS);
                         Notification::set('success', __('Backup was restored', 'backup'));
                     } else {
                         Notification::set('error', __('Unzip error', 'backup'));
                     }
                } else {
                    Notification::set('error', __('Backup was not restored', 'backup'));
                }

                Request::redirect(Option::get('siteurl').'/admin/index.php?id=backup');

            } else { die('Request was denied because it contained an invalid security token. Please refresh the page and try again.'); }
        }

        // Display view
        View::factory('box/backup/views/backend/index')
                ->assign('backups_list', File::scan($backups_path, '.zip'))
                ->display();
    }
}
