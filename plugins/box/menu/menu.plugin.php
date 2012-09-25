<?php

    /**
     *  Menu plugin
     *
     *  @package Monstra
     *  @subpackage Plugins
     *  @author Romanenko Sergey / Awilum
     *  @copyright 2012 Romanenko Sergey / Awilum
     *  @version 1.0.0
     *
     */


    // Register plugin
    Plugin::register( __FILE__,                    
                    __('Menu', 'menu'),
                    __('Menu manager', 'menu'),  
                    '1.0.0',
                    'Awilum',                 
                    'http://monstra.org/',
                    null,
                    'box');


    if (Session::exists('user_role') && in_array(Session::get('user_role'), array('admin'))) {
        
        // Include Admin
        Plugin::admin('menu', 'box');
        
    }


    class Menu {
        
        public static function get() {
            
            // Get menu table
            $menu = new Table('menu');

            // Select all items
            $items = $menu->select(null, 'all', null, array('id', 'name', 'link', 'target', 'order'), 'order', 'ASC');

            // Display view
            View::factory('box/menu/views/frontend/index')
                    ->assign('items', $items)
                    ->assign('uri', Uri::segments())
                    ->assign('defpage', Option::get('defaultpage'))                    
                    ->display();
                    
        }

    } 