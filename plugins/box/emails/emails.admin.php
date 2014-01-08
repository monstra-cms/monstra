<?php

// Admin Navigation: add new item
Navigation::add(__('Emails', 'emails'), 'system', 'emails', 5);

/**
 * Emails admin class
 */
class EmailsAdmin extends Backend
{
    /**
     * Main Sandbox admin function
     */
    public static function main()
    {
        //
        // Do something here...
        //

        // Check for get actions
        // -------------------------------------
        if (Request::get('action')) {

            // Switch actions
            // -------------------------------------
            switch (Request::get('action')) {

                // Plugin action
                // -------------------------------------
                case "edit":
                    //
                    // Do something here...
                    //
                break;

            }

        } else {

            // Display view
            View::factory('box/emails/views/backend/index')->display();
        }

    }
}
