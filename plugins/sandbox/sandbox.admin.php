<?php

// Admin Navigation: add new item
Navigation::add(__('Sandbox', 'sandbox'), 'content', 'sandbox', 10);

// Add actions
Action::add('admin_themes_extra_index_template_actions','SandboxAdmin::formComponent');
Action::add('admin_themes_extra_actions','SandboxAdmin::formComponentSave');

/**
 * Sandbox admin class
 */
class SandboxAdmin extends Backend
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
                case "add":
                    //
                    // Do something here...
                    //
                break;

                // Plugin action
                // -------------------------------------
                case "delete":
                    //
                    // Do something here...
                    //
                break;
            }

        } else {

            // Display view
            View::factory('sandbox/views/backend/index')->display();
        }

    }

    /**
     * Form Component Save
     */
    public static function formComponentSave()
    {
        if (Request::post('sandbox_component_save')) {
            if (Security::check(Request::post('csrf'))) {
                Option::update('sandbox_template', Request::post('sandbox_form_template'));
                Request::redirect('index.php?id=themes');
            }
        }
    }

    /**
     * Form Component
     */
    public static function formComponent()
    {
        $_templates = Themes::getTemplates();
        foreach ($_templates as $template) {
            $templates[basename($template, '.template.php')] = basename($template, '.template.php');
        }

        echo (
            Form::open().
            Form::hidden('csrf', Security::token()).
            Form::label('sandbox_form_template', __('Sandbox template', 'sandbox')).
            Form::select('sandbox_form_template', $templates, Option::get('sandbox_template')).
            Html::br().
            Form::submit('sandbox_component_save', __('Save', 'sandbox'), array('class' => 'btn')).
            Form::close()
        );
    }

}
