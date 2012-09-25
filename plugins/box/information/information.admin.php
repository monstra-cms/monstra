<?php


    Navigation::add(__('Information', 'information'), 'system', 'information', 5);

    
    class InformationAdmin extends Backend {


        /**
         * Information main function
         */
        public static function main() {

            // Init vars
            $php_modules = array();

            // Get array with the names of all modules compiled and loaded
            $php_modules = get_loaded_extensions();

        	// Display view
            View::factory('box/information/views/backend/index')
                ->assign('php_modules', $php_modules)
                ->display();
        }


    }
