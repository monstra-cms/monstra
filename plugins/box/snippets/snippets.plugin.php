<?php

    /**
     *	Snippets plugin
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
                    __('Snippets', 'snippets'),
                    __('Snippets manager plugin', 'snippets'),  
                    '1.0.0',
                    'Awilum',                 
                    'http://monstra.org/',        
                    null,
                    'box');


    if(Session::exists('user_role') && in_array(Session::get('user_role'),array('admin'))) {
    
    	// Include Admin    
    	Plugin::admin('snippets', 'box');

    }

    // Add shortcode {snippet get="snippetname"}
    Shortcode::add('snippet', 'Snippet::_content');      
    

    class Snippet {


        /**
         * Get snippet
         *
         * @param string $name Snippet file name
         */
        public static function get($name) {
            return Snippet::_content(array('get' => $name));
        }


        /**
         * Returns snippet content for shortcode {snippet get="snippetname"}
         *
         * @param array $attributes snippet filename
         */
        public static function _content($attributes) {  
            
            if (isset($attributes['get'])) $name = (string)$attributes['get']; else $name = '';
              
            $snippet_path = STORAGE . DS . 'snippets' . DS . $name . '.snippet.php';

            if (File::exists($snippet_path)) {
                ob_start();        
                include $snippet_path;
                $snippet_contents = ob_get_contents();
                ob_end_clean();
                return $snippet_contents;
            } else {
                if (Session::exists('admin') && Session::get('admin') == true) {
                    return __('<b>Snippet <u>:name</u> is not found!</b>', 'snippets', array(':name' => $name));
                }
            }
        }   
    }