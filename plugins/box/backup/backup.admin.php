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

                } else { die('csrf detected!'); }
            }
            
            // Delete backup
            // -------------------------------------    
            if (Request::get('sub_id') == 'backup' && Request::get('delete_file')) {                
                
                if (Security::check(Request::get('token'))) {

                    File::delete($backups_path . DS . Request::get('delete_file'));
                    Request::redirect(Option::get('siteurl').'admin/index.php?id=backup');                

                } else { die('csrf detected!'); }
            }

            // Download backup
            // -------------------------------------    
            if (Request::get('download')) {    
                if (Security::check(Request::get('token'))) {                            
                    File::download($backups_path . DS . Request::get('download'));                
                } else { die('csrf detected!'); }
            }

            // Get backup list
            $backups_list = File::scan($backups_path, '.zip');
            
            // Display view
            View::factory('box/backup/views/backend/index')
                    ->assign('backups_list', $backups_list)
                    ->display();
        }
    }