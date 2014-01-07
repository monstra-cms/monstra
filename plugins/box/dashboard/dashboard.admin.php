<?php

// Admin Navigation: add new item
Navigation::add(__('Dashbord', 'dashboard'), 'content', 'dashboard', 10);

/**
 * Dashboard admin class
 */
class DashboardAdmin extends Backend
{
    /**
     * Main Dashboard admin function
     */
    public static function main()
    {
            
        // Display view
        View::factory('dashboard/views/backend/index')->display();
    
    }

}
