<?php

/**
 *  Menu plugin
 *
 *  @package Monstra
 *  @subpackage Plugins
 *  @author Romanenko Sergey / Awilum
 *  @copyright 2012-2013 Romanenko Sergey / Awilum
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

// Add Plugin Javascript
Javascript::add('plugins/box/menu/js/menu.js', 'backend');

/**
 * Menu Class
 */
class Menu
{
    /**
     * Get menu
     *
     * @param string $category   Category name
     * @param array  $after_text Text after item menu
     */
    public static function get($category = '', $after_text = '')
    {
        echo Menu::getAsString($category, $after_text);
    }

    /**
     * Get menu as string
     *
     * @param string $category   Category name
     * @param array  $after_text Text after item menu
     * @return string
     */
    public static function getAsString($category = '', $after_text = '')
    {
        // Get menu table
        $menu = new Table('menu');

        // Display view
        return View::factory('box/menu/views/frontend/index')
                ->assign('items', $menu->select('[category="'.$category.'"]', 'all', null, array('id', 'name', 'link', 'target', 'class', 'order', 'category'), 'order', 'ASC'))
                ->assign('uri', Uri::segments())
                ->assign('defpage', Option::get('defaultpage'))
                ->assign('after_text_array', $after_text)
                ->render();
    }

}
