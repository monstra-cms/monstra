<?php


    Navigation::add(__('Information', 'information'), 'system', 'information', 5);

    
    class InformationAdmin extends Backend {


        /**
         * Information main function
         */
        public static function main() {

        	// Display view
            View::factory('box/information/views/backend/index')->display();
        }


    }
