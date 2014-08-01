<?php

/**
 *	Pages plugin
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
                __('Pages' , 'pages'),
                __('Pages manager', 'pages'),
                '1.0.0',
                'Awilum',
                'http://monstra.org/',
                'pages',
                'box');

if (Session::exists('user_role') && in_array(Session::get('user_role'), array('admin', 'editor'))) {

    // Include Admin
    Plugin::Admin('pages', 'box');

}

// Add Plugin Javascript
Javascript::add('plugins/box/pages/js/pages.js', 'backend');

/**
 * Pages Class
 */
class Pages extends Frontend
{
    /**
     * Current page data
     *
     * @var object
     */
    public static $page = null;

    /**
     * Pages tables
     *
     * @var object
     */
    public static $pages = null;

    /**
     * Requested page
     *
     * @var string
     */
    public static $requested_page = null;

    /**
     *  Main function
     */
    public static function main()
    {
        Pages::$pages = new Table('pages');
        Pages::$page  = Pages::pageLoader();
    }

    /**
     * Page loader
     *
     * @param  boolean $return_data data
     * @return array
     */
    public static function pageLoader($return_data = true)
    {
        $requested_page = Pages::lowLoader(Uri::segments());
        Pages::$requested_page = $requested_page;

        return Pages::$pages->select('[slug="'.$requested_page.'"]', null);
    }

    /**
     * Load current page
     *
     * @global string $defpage default page
     * @param  array  $data uri
     * @return string
     */
    public static function lowLoader($data)
    {
        $defpage = Option::get('defaultpage');

        // If data count 2 then it has Parent/Child
        if (count($data) >= 2) {

            // If exists parent file
            if (count(Pages::$pages->select('[slug="'.$data[0].'"]')) !== 0) {

                // Get child file and get parent page name
                $child_page = Pages::$pages->select('[slug="'.$data[1].'"]', null);

                // If child page parent is not empty then get his parent
                if (count($child_page) == 0) {
                    $c_p = '';
                } else {
                    if ($child_page['parent'] != '') {
                        $c_p = $child_page['parent'];
                    } else {
                        $c_p = '';
                    }
                }

                // Hack For old Monstra
                $child_page['access'] = (isset($child_page['access'])) ? $child_page['access'] : 'public' ;

                // Check is child_parent -> request parent
                if ($c_p == $data[0]) {

                    if (count($data) < 3) { // Checking only for the parent and one child, the remaining issue 404

                        if ((($child_page['status'] == 'published') or
                            (Session::exists('user_role') && in_array(Session::get('user_role'), array('admin', 'editor')))) and
                            ($child_page['access'] == 'public')) {

                            $id = $data[1];

                        } elseif (($child_page['access'] == 'registered') and
                                 (Session::exists('user_id')) and
                                 ($child_page['status'] == 'published')) {

                            $id = $data[1];

                        } else {
                            $id = 'error404';
                            Response::status(404);
                        }
                    } else {
                        $id = 'error404';
                        Response::status(404);
                    }

                } else {
                    $id = 'error404';
                    Response::status(404);
                }
            } else {
                $id = 'error404';
                Response::status(404);
            }

        } else { // Only parent page come
            if (empty($data[0])) {

                $id = $defpage;

            } else {

                // Get current page
                $current_page = Pages::$pages->select('[slug="'.$data[0].'"]', null);

                // Hack For old Monstra
                $current_page['access'] = (isset($current_page['access'])) ? $current_page['access'] : 'public' ;

                if (count($current_page) != 0) {
                    if ( ! empty($current_page['parent'])) {
                        $c_p = $current_page['parent'];
                    } else {
                        $c_p = '';
                    }
                } else {
                    $c_p = '';
                }

                // Check if this page has parent
                if ($c_p !== '') {

                    if ($c_p == $data[0]) {
                        if (count(Pages::$pages->select('[slug="'.$data[0].'"]', null)) != 0) {

                            if ((($current_page['status'] == 'published') or
                                (Session::exists('user_role') && in_array(Session::get('user_role'), array('admin', 'editor')))) and
                                ($current_page['access'] == 'public')) {

                                $id = $data[0];

                            } elseif (($current_page['access'] == 'registered') and
                                     (Session::exists('user_id')) and
                                     ($current_page['status'] == 'published')) {

                                $id = $data[0];

                            } else {
                                $id = 'error404';
                                Response::status(404);
                            }
                        } else {
                            $id = 'error404';
                            Response::status(404);
                        }
                    } else {
                        $id = 'error404';
                        Response::status(404);
                    }
                } else {

                    if (count(Pages::$pages->select('[slug="'.$data[0].'"]', null)) != 0) {
                        if ((($current_page['status'] == 'published') or
                            (Session::exists('user_role') && in_array(Session::get('user_role'), array('admin', 'editor')))) and
                            ($current_page['access'] == 'public')) {

                            $id = $data[0];

                        } elseif (($current_page['access'] == 'registered') and
                                 (Session::exists('user_id')) and
                                 ($current_page['status'] == 'published')) {

                            $id = $data[0];

                        } else {
                            $id = 'error404';
                            Response::status(404);
                        }
                    } else {
                        $id = 'error404';
                        Response::status(404);
                    }
                }
            }
        }

        // Return page name/id to load
        return $id;
    }

    /**
     * Get pages template
     *
     * @return string
     */
    public static function template()
    {
        if (Pages::$page['template'] == '') return 'index'; else return Pages::$page['template'];
    }

    /**
     * Get pages contents
     *
     * @return string
     */
    public static function content($slug = '')
    {
        if ( ! empty($slug)) {

            $page = Table::factory('pages')->select('[slug="'.$slug.'"]', null);

            if ( ! empty($page)) {

                $content = Text::toHtml(File::getContent(STORAGE . DS . 'pages' . DS . $page['id'] . '.page.txt'));

                $content = Filter::apply('content', $content);

                return $content;

            } else {
                return '';
            }

        } else {
            return Text::toHtml(File::getContent(STORAGE . DS . 'pages' . DS . Pages::$page['id'] . '.page.txt'));
        }

    }

    /**
     * Get pages title
     *
     *  <code>
     *      echo Page::title();
     *  </code>
     *
     * @return string
     */
    public static function title()
    {
        return !empty(Pages::$page['meta_title']) ? Pages::$page['meta_title'] : Pages::$page['title'];
    }

    /**
     * Get pages Description
     *
     *  <code>
     *      echo Page::description();
     *  </code>
     *
     * @return string
     */
    public static function description()
    {
        return Pages::$page['description'];
    }

    /**
     * Get pages Keywords
     *
     *  <code>
     *      echo Page::keywords();
     *  </code>
     *
     * @return string
     */
    public static function keywords()
    {
        return Pages::$page['keywords'];
    }


    /**
     * Get pages
     */
    public static function getPages()
    {
        // Init vars
        $pages_array = array();
        $count = 0;

        // Get pages table
        $pages = new Table('pages');

        // Get Pages List
        $pages_list = $pages->select('[slug!="error404" and status="published"]');

        foreach ($pages_list as $page) {

            $pages_array[$count]['title']   = Html::toText($page['title']);
            $pages_array[$count]['meta_title'] = !empty($page['meta_title']) ? Html::toText($page['meta_title']) : $page['title'];
            $pages_array[$count]['parent']  = $page['parent'];
            $pages_array[$count]['date']    = $page['date'];
            $pages_array[$count]['author']  = $page['author'];
            $pages_array[$count]['slug']    = ($page['slug'] == Option::get('defaultpage')) ? '' : $page['slug'] ;

            if (isset($page['parent'])) {
                $c_p = $page['parent'];
            } else {
                $c_p = '';
            }

            if ($c_p != '') {
                $_page = $pages->select('[slug="'.$page['parent'].'"]', null);

                if (isset($_page['title'])) {
                    $_title = $_page['title'];
                } else {
                    $_title = '';
                }
                $pages_array[$count]['sort'] = $_title . ' ' . $page['title'];
            } else {
                $pages_array[$count]['sort'] = $page['title'];
            }
            $_title = '';
            $count++;
        }

        // Sort pages
        $_pages_list = Arr::subvalSort($pages_array, 'sort');

        // return
        return $_pages_list;
    }

}

/**
 * Page class
 */
class Page extends Pages
{
    /**
     * Get date of current page
     *
     *  <code>
     *      echo Page::date();
     *  </code>
     *
     * @param  string $format Date format
     * @return string
     */
    public static function date($format = 'Y-m-d')
    {
        return Date::format(Pages::$page['date'], $format);
    }

    /**
     * Get author of current page
     *
     *  <code>
     *      echo Page::author();
     *  </code>
     *
     * @return string
     */
    public static function author()
    {
        return Pages::$page['author'];
    }

    /**
     * Get children pages for a specific parent page
     *
     *  <code>
     *      $pages = Page::children('page');
     *  </code>
     *
     * @param  string $parent Parent page
     * @return array
     */
    public static function children($parent)
    {
        return Pages::$pages->select('[parent="'.(string) $parent.'"]', 'all');
    }

    /**
     * Get the available children pages for requested page.
     *
     *  <code>
     *      echo Page::available();
     *  </code>
     *
     */
    public static function available()
    {
        $pages = Pages::$pages->select('[parent="'.Pages::$requested_page.'"]', 'all');

        // Display view
        View::factory('box/pages/views/frontend/available_pages')
                ->assign('pages', $pages)
                ->display();
    }

    /**
     * Get page breadcrumbs
     *
     *  <code>
     *      echo Page::breadcrumbs();
     *  </code>
     *
     */
    public static function breadcrumbs()
    {
        if (Uri::command() == 'pages') {
            $current_page = Pages::$requested_page;
            $parent_page = '';
            if ($current_page !== 'error404') {
                $page = Pages::$pages->select('[slug="'.$current_page.'"]', null);
                if (trim($page['parent']) !== '') {
                    $parent = true;
                    $parent_page = Pages::$pages->select('[slug="'.$page['parent'].'"]', null);
                } else {
                    $parent = false;
                }

            // Display view
            View::factory('box/pages/views/frontend/breadcrumbs')
                    ->assign('current_page', $current_page)
                    ->assign('page', $page)
                    ->assign('parent', $parent)
                    ->assign('parent_page', $parent_page)
                    ->display();
            }
        }    
    }

    /**
     * Get page url
     *
     *  <code>
     *      echo Page::url();
     *  </code>
     *
     */
    public static function url()
    {
        return Option::get('siteurl').'/'.Pages::$page['slug'];
    }

    /**
     * Get page slug
     *
     *  <code>
     *      echo Page::slug();
     *  </code>
     *
     */
    public static function slug()
    {
        return Pages::$page['slug'];
    }

    /**
     * Get page meta robots
     *
     *  <code>
     *      echo Page::robots();
     *  </code>
     *
     */
    public static function robots()
    {
        if (Pages::$page !== null) {
            $_index  = (isset(Pages::$page['robots_index'])) ? Pages::$page['robots_index'] : '';
            $_follow = (isset(Pages::$page['robots_follow'])) ? Pages::$page['robots_follow'] : '';
            $robots  = ( ! empty($_index) && ! empty($_follow)) ? $_index.', '.$_follow : '';
        } else {
            $robots = '';
        }

        return $robots;
    }

    public static function _date($attributes)
    {
        return Page::date((isset($attributes['format'])) ? $attributes['format'] : 'Y-m-d');
    }

    public static function _content($attributes)
    {
        return Pages::content((isset($attributes['name']) ? $attributes['name'] : ''));
    }

}


/**
 * Add new shortcodes {page_author} {page_slug} {page_url} {page_date} {page_content}
 */
Shortcode::add('page_author', 'Page::author');
Shortcode::add('page_slug', 'Page::slug');
Shortcode::add('page_url', 'Page::url');
Shortcode::add('page_content', 'Page::_content');
Shortcode::add('page_date', 'Page::_date');
