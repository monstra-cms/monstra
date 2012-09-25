<?php


    class BackupAdmin extends Backend {


        /**
         * Backup admin
         */
        public static function main() {

            $backups_path = ROOT . DS . 'backups';

            $backups_list = array();

            // Create backup
            // -------------------------------------    
            if (Request::post('create_backup')) {
                
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
            }
            
            // Delete backup
            // -------------------------------------    
            if (Request::get('sub_id') == 'backup') {
                if (Request::get('delete_file')) {
                    File::delete($backups_path . DS . Request::get('delete_file'));
                    Request::redirect(Option::get('siteurl').'admin/index.php?id=backup');
                }
            }

            // Download backup
            // -------------------------------------    
            if (Request::get('download')) {                                
                File::download('../backups/'.Request::get('download'));                
            }

            // Get backup list
            $backups_list = File::scan($backups_path, '.zip');
            
            // Display view
            View::factory('box/backup/views/backend/index')
                    ->assign('backups_list', $backups_list)
                    ->display();
        }
    }