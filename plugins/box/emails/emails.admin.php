<?php

// Admin Navigation: add new item
Navigation::add(__('Emails', 'emails'), 'system', 'emails', 5);

/**
 * Emails admin class
 */
class EmailsAdmin extends Backend
{
    /**
     * Main Emails admin function
     */
    public static function main()
    {
        // Init vars
        $email_templates_path = STORAGE . DS  . 'emails' . DS;
        $email_templates_list = array();

        // Check for get actions
        // -------------------------------------
        if (Request::get('action')) {

            // Switch actions
            // -------------------------------------
            switch (Request::get('action')) {

                // Plugin action
                // -------------------------------------
                case "edit_email_template":

                    if (Request::post('edit_email_template') || Request::post('edit_email_template_and_exit') ) {
                        
                        if (Security::check(Request::post('csrf'))) {

                            // Save Email Template
                            File::setContent(STORAGE . DS  . 'emails' . DS . Request::post('email_template_name') .'.email.php', Request::post('content'));

                            Notification::set('success', __('Your changes to the email template <i>:name</i> have been saved.', 'emails', array(':name' => Request::post('email_template_name'))));

                            if (Request::post('edit_email_template_and_exit')) {
                                Request::redirect('index.php?id=emails');
                            } else {
                                Request::redirect('index.php?id=emails&action=edit_email_template&filename='.Request::post('email_template_name'));
                            }

                        }

                    }

                    $content = File::getContent($email_templates_path.Request::get('filename').'.email.php');

                    // Display view
                    View::factory('box/emails/views/backend/edit')
                            ->assign('content', $content)
                            ->display();
                break;

            }

        } else {

            // Get email templates
            $email_templates_list = File::scan($email_templates_path, '.email.php');

            // Display view
            View::factory('box/emails/views/backend/index')
                    ->assign('email_templates_list', $email_templates_list)
                    ->display();
        }
    }
}
