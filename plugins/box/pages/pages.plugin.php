<?php

    /**
     *	Pages plugin
     *
     *	@package Monstra
     *  @subpackage Plugins
     *	@author Romanenko Sergey / Awilum
     *	@copyright 2012 Romanenko Sergey / Awilum
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


    class Pages extends Frontend { 


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
        public static function main() {
            if (BACKEND == false) {
                $pages = new Table('pages');            
                Pages::$pages = $pages;

                $page = Pages::pageLoader(); 
                Pages::$page = $page;
            }
        }

        
        /**
         * Page loader
         *
         * @param boolean $return_data data
         * @return array 
         */
        public static function pageLoader($return_data = true) {            
            $requested_page = Pages::lowLoader(Uri::segments());             
            Pages::$requested_page = $requested_page;            
            return Pages::$pages->select('[slug="'.$requested_page.'"]', null);
        }


        /**
         * Load current page
         *
         * @global string $defpage default page
         * @param array $data uri
         * @return string 
         */
        public static function lowLoader($data) {
            
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
                  
                    // Check is child_parent -> request parent
                    if ($c_p == $data[0]) {                    
                        // Checking only for the parent and one child, the remaining issue 404
                        if (count($data) < 3) {
                            $id = $data[1]; // Get real request page
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
                if(empty($data[0])) {        
                    
                    $id = $defpage;

                } else {

                    // Get current page
                    $current_page = Pages::$pages->select('[slug="'.$data[0].'"]', null);
                   
                    if (count($current_page) != 0) {
                        if ($current_page['parent'] != '') {
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
                                if (($current_page['status'] == 'published') or (Session::exists('user_role') && in_array(Session::get('user_role'), array('admin', 'editor')))) {
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
                            if (($current_page['status'] == 'published') or (Session::exists('user_role') && in_array(Session::get('user_role'), array('admin', 'editor')))) {
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
        public static function template() {            
            if (Pages::$page['template'] == '') return 'index'; else return Pages::$page['template'];
        }


        /**
         * Get pages contents
         *
         * @return string
         */
        public static function content() {
            return Text::toHtml(File::getContent(STORAGE . DS . 'pages' . DS . Pages::$page['id'] . '.page.txt'));
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
        public static function title() {        
            return Pages::$page['title'];
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
        public static function description() {        
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
        public static function keywords() {        
            return Pages::$page['keywords'];
        }

    }


    class Page extends Pages {        


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
        public static function date($format = 'Y-m-d') {                
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
        public static function author() {        
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
        public static function children($parent) {
            return Pages::$pages->select('[parent="'.(string)$parent.'"]', 'all');
        }


        /**
         * Get the available children pages for requested page.       
         *
         *  <code>
         *      echo Page::available();
         *  </code>
         *  
         */ 
        public static function available() {            
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
        public static function breadcrumbs() {                        
            $current_page = Pages::$requested_page;
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


        /**
         * Get page url 
         *
         *  <code>
         *      echo Page::url();
         *  </code>
         *  
         */
        public static function url() {
            return Option::get('siteurl').Pages::$page['slug'];
        }


        /**
         * Get page slug 
         *
         *  <code>
         *      echo Page::slug();
         *  </code>
         *  
         */
        public static function slug() {
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
        public static function robots() {
            return (Pages::$page !== null) ? Pages::$page['robots_index'].', '.Pages::$page['robots_follow'] : '';
        }

    }