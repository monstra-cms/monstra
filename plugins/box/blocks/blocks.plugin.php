<?php

    /**
     *	Blocks plugin
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
                    __('Blocks', 'blocks'),
                    __('Blocks manager plugin', 'blocks'),
                    '1.0.0',
                    'Awilum',
                    'http://monstra.org/',
                    null,
                    'box');


    if (Session::exists('user_role') && in_array(Session::get('user_role'), array('admin', 'editor'))) {
    
    	// Include Admin
    	Plugin::admin('blocks', 'box');

    }

    // Add shortcode {block get="blockname"}
    Shortcode::add('block', 'Block::_content');      
    

    class Block {


        /**
         * Get block
         *
         * @param string $name Block file name
         */
        public static function get($name) {
            return Block::_content(array('get' => $name));
        }


        /**
         * Returns block content for shortcode {block get="blockname"}
         *
         * @param array $attributes block filename
         */
        public static function _content($attributes) {  
            
            if (isset($attributes['get'])) $name = (string)$attributes['get']; else $name = '';
              
            $block_path = STORAGE . DS . 'blocks' . DS . $name . '.block.html';

            if (File::exists($block_path)) {
                ob_start();        
                include $block_path;
                $block_contents = ob_get_contents();
                ob_end_clean();
                return Filter::apply('content', Text::toHtml($block_contents));
            } else {
                if (Session::exists('admin') && Session::get('admin') == true) {
                    return __('<b>Block <u>:name</u> is not found!</b>', 'blocks', array(':name' => $name));
                }
            }
        }   
    }