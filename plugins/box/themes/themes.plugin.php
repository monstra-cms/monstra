<?php

/**
 *  Themes plugin
 *
 *  @package Monstra
 *  @subpackage Plugins
 *  @author Romanenko Sergey / Awilum
 *  @copyright 2012-2014 Romanenko Sergey / Awilum
 *  @version 1.0.0
 *
 */

// Register plugin
Plugin::register( __FILE__,
                __('Themes', 'themes'),
                __('Themes manager', 'themes'),
                '1.0.0',
                'Awilum',
                'http://monstra.org/',
                null,
                'box');

if (Session::exists('user_role') && in_array(Session::get('user_role'), array('admin'))) {

    // Include Admin
    Plugin::admin('themes', 'box');

}

/**
 * Themes Class
 */
class Themes
{
    /**
     * Get Themes
     */
    public static function getAdminThemes()
    {
        $themes_folders = array();

        // Get all themes folders
        $_themes_admin_folders = Dir::scan(THEMES_ADMIN);

        // Create an array of valid themes folders
        foreach($_themes_admin_folders as $folder) if (File::exists(THEMES_ADMIN . DS . $folder . DS . 'index.template.php')) $__themes_admin_folders[] = $folder;
        foreach($__themes_admin_folders as $theme) $themes[$theme] = $theme;

        return $themes;
    }

    /**
     * Get Admin Themes
     */
    public static function getSiteThemes()
    {
        $themes_folders = array();

        // Get all themes folders
        $_themes_folders = Dir::scan(THEMES_SITE);

        // Create an array of valid themes folders
        foreach($_themes_folders as $folder) if (File::exists(THEMES_SITE . DS . $folder . DS . 'index.template.php')) $__themes_folders[] = $folder;
        foreach($__themes_folders as $theme) $themes[$theme] = $theme;

        return $themes;
    }

    /**
     * Get Templates
     *
     * @param  string $theme Theme name
     * @return mixed
     */
    public static function getTemplates($theme = null)
    {
        $theme = ($theme === null) ? null : (string) $theme;

        if ($theme == null) $theme = Option::get('theme_site_name');

        $templates = array();

        // Get all templates in current theme folder
        $templates = File::scan(THEMES_SITE . DS . $theme, '.template.php');

        return ($templates) ? $templates : array();
    }

    /**
     * Get Chunks
     *
     * @param  string $theme Theme name
     * @return mixed
     */
    public static function getChunks($theme = null)
    {
        $theme = ($theme === null) ? null : (string) $theme;

        if ($theme == null) $theme = Option::get('theme_site_name');

        $chunks = array();

        // Get all templates in current theme folder
        $chunks = File::scan(THEMES_SITE . DS . $theme, '.chunk.php');

        return ($chunks) ? $chunks : array();
    }

    /**
     * Get Styles
     *
     * @param  string $theme Theme name
     * @return mixed
     */
    public static function getStyles($theme = null)
    {
        $theme = ($theme === null) ? null : (string) $theme;

        if ($theme == null) $theme = Option::get('theme_site_name');

        $styles = array();

        // Get all templates in current theme folder
        $styles = File::scan(THEMES_SITE . DS . $theme . DS . 'css', '.css');

        return ($styles) ? $styles : array();
    }

    /**
     * Get Scripts
     *
     * @param  string $theme Theme name
     * @return mixed
     */
    public static function getScripts($theme = null)
    {
        $theme = ($theme === null) ? null : (string) $theme;

        if ($theme == null) $theme = Option::get('theme_site_name');

        $scripts = array();

        // Get all templates in current theme folder
        $scripts = File::scan(THEMES_SITE . DS . $theme . DS . 'js' . DS , '.js');

        return ($scripts) ? $scripts : array();
    }

}

/**
 * Chunk class
 */
class Chunk
{
    /**
     * Get chunk
     *
     * @param string $name  Chunk name
     * @param string $theme Theme name
     */
    public static function get($name, $vars = array(), $theme = null)
    {
        // Redefine vars
        $name  = (string) $name;
        $current_theme = ($theme === null) ? Option::get('theme_site_name') : (string) $theme;

        // Extract vars
        extract($vars);

        // Chunk path
        $chunk_path  = THEMES_SITE . DS . $current_theme . DS;

        // Is chunk exist ?
        if (file_exists($chunk_path . $name . '.chunk.php')) {

            // Is chunk minified
            if ( ! file_exists(MINIFY . DS . 'theme.' . $current_theme . '.minify.' . $name . '.chunk.php') or
                filemtime(THEMES_SITE . DS . $current_theme . DS . $name .'.chunk.php') > filemtime(MINIFY . DS . 'theme.' . $current_theme . '.minify.' . $name . '.chunk.php')) {
                    file_put_contents(MINIFY . DS . 'theme.' . $current_theme . '.minify.' . $name . '.chunk.php',
                                      MinifyHTML::process(file_get_contents(THEMES_SITE. DS . $current_theme . DS . $name .'.chunk.php')));
            }

            // Include chunk
            include MINIFY . DS . 'theme.' . $current_theme . '.minify.' . $name . '.chunk.php';
        }

    }

}
