<?php

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
        View::factory('box/dashboard/views/backend/index')->display();
    
    }

}
