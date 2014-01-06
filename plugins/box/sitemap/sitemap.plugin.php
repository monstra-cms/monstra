<?php

/**
 *	Sitemap plugin
 *
 *	@package Monstra
 *  @subpackage Plugins
 *	@author Romanenko Sergey / Awilum
 *	@copyright 2012-2014 Romanenko Sergey / Awilum
 *	@version 1.0.0
 *
 */

// Register plugin
Plugin::register( __FILE__,
                __('Sitemap', 'sitemap'),
                __('Sitemap plugin', 'sitemap'),
                '1.0.0',
                'Awilum',
                'http://monstra.org/',
                'sitemap',
                'box');

// Add actions
Action::add('admin_pages_action_add', 'Sitemap::create');
Action::add('admin_pages_action_edit', 'Sitemap::create');
Action::add('admin_pages_action_clone', 'Sitemap::create');
Action::add('admin_pages_action_delete', 'Sitemap::create');

/**
 * Sitemap class
 */
class Sitemap extends Frontend
{
    /**
     * Forbidden components
     *
     * @var array
     */
    public static $forbidden_components = array('pages', 'sitemap');

    /**
     * Sitemap Title
     *
     * @return string
     */
    public static function title()
    {
        return __('Sitemap', 'sitemap');
    }

    /**
     * Sitemap template
     */
    public static function template()
    {
        return 'index';
    }

   /**
    * Get sitemap content
    */
   public static function content()
   {
        // Display view
        return View::factory('box/sitemap/views/frontend/index')
                      ->assign('pages_list', Pages::getPages())
                      ->assign('components', Sitemap::getComponents())
                      ->render();
    }

    /**
     * Create sitemap
     */
    public static function create()
    {
        // Get pages list
        $pages_list = Pages::getPages();

        // Create sitemap content
        $map  = '<?xml version="1.0" encoding="UTF-8"?>'."\n";
        $map .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">'."\n";
        foreach ($pages_list as $page) {
            if ($page['parent'] != '') { $parent = $page['parent'].'/'; $priority = '0.5'; } else { $parent = ''; $priority = '1.0'; }
            $map .= "\t".'<url>'."\n\t\t".'<loc>'.Option::get('siteurl').'/'.$parent.$page['slug'].'</loc>'."\n\t\t".'<lastmod>'.date("Y-m-d", (int) $page['date']).'</lastmod>'."\n\t\t".'<changefreq>weekly</changefreq>'."\n\t\t".'<priority>'.$priority.'</priority>'."\n\t".'</url>'."\n";
        }

        // Get list of components
        $components = Sitemap::getComponents();

        // Add components to sitemap
        if (count($components) > 0) {
            foreach ($components as $component) {
                $map .= "\t".'<url>'."\n\t\t".'<loc>'.Option::get('siteurl').'/'.Text::lowercase($component).'</loc>'."\n\t\t".'<lastmod>'.date("Y-m-d", time()).'</lastmod>'."\n\t\t".'<changefreq>weekly</changefreq>'."\n\t\t".'<priority>1.0</priority>'."\n\t".'</url>'."\n";
            }
        }

        // Close sitemap
        $map .= '</urlset>';

        // Save sitemap
        return File::setContent(ROOT . DS . 'sitemap.xml', $map);
    }

    /**
     * Get components
     */
    protected static function getComponents()
    {
        $components = array();

        if (count(Plugin::$components) > 0) {
            foreach (Plugin::$components as $component) {
                if ( ! in_array($component, Sitemap::$forbidden_components)) $components[] = Text::lowercase($component);
            }
        }

        return $components;
    }

}
