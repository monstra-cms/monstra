<?php defined('MONSTRA_ACCESS') or die('No direct script access.');

    /**
     *	Monstra Site module
     * 
     *	@package Monstra
     *  @subpackage Engine
     *	@author Romanenko Sergey / Awilum
     *	@copyright 2012 Romanenko Sergey / Awilum
     *	@version $Id$
     *	@since 1.0.0
     *  @license http://opensource.org/licenses/gpl-license.php GNU Public License
     *  Monstra is free software. This version may have been modified pursuant
     *  to the GNU General Public License, and as distributed it includes or
     *  is derivative of works licensed under the GNU General Public License or
     *  other free or open source software licenses.
     *  See COPYING.txt for copyright notices and details.
     *  @filesource 
     */


    class Site {


        /**
         * An instance of the Site class
         *
         * @var site
         */
        protected static $instance = null;


        /**
         * Initializing site
         *
         * @return Site
         */
        public static function init() {            
            if ( ! isset(self::$instance)) self::$instance = new Site();
            return self::$instance;            
        }


        /**
         * Protected clone method to enforce singleton behavior.
         *
         * @access  protected
         */        
        protected function __clone() {
            // Nothing here.
        }

        
        /**
         * Construct
         */
        protected function __construct() {  
            call_user_func(ucfirst(Uri::command()).'::main');
        }


        /**
         * Get site name
         *
         *  <code> 
         *      echo Site::name();
         *  </code>
         *
         * @return string
         */
        public static function name() {
            return Option::get('sitename');
        }


        /**
         * Get site theme
         *
         *  <code> 
         *      echo Site::theme();
         *  </code>
         *
         * @return string
         */
        public static function theme() {
            return Option::get('theme_site_name');
        }


        /**
         * Get Page title
         *
         *  <code> 
         *      echo Site::title();
         *  </code>
         *
         * @return string
         */
        public static function title() {        
        
            // Get title
            $title = call_user_func(ucfirst(Uri::command()).'::title');    

            return $title;
        }


        /**
         * Get page description
         *
         *  <code> 
         *      echo Site::description();
         *  </code>
         *
         * @return string
         */
        public static function description() {            
           
            // Get description   
            $description = call_user_func(ucfirst(Uri::command()).'::description');
                                    
            if (trim($description) !== '') {
                return Html::toText($description);
            } else {
                return Html::toText(Option::get('description'));
            }
        }


        /**
         * Get page keywords
         *
         *  <code> 
         *      echo Site::keywords();
         *  </code>
         *
         * @return string
         */
        public static function keywords() {
                
            // Get keywords                
            $keywords = call_user_func(ucfirst(Uri::command()).'::keywords');
                                    
            if (trim($keywords) !== '') {
                return Html::toText($keywords);
            } else {
                return Html::toText(Option::get('keywords'));
            }

        }


        /**
         * Get site slogan
         *
         *  <code> 
         *      echo Site::slogan();
         *  </code>
         *
         * @return string
         */
        public static function slogan() {
            return Option::get('slogan');
        }


        /**
         * Get page content
         *
         *  <code> 
         *      echo Site::content();
         *  </code>
         *
         * @return string
         */
        public static function content() {            
            
            // Get content            
            $content = call_user_func(ucfirst(Uri::command()).'::content');
            
            return Filter::apply('content', $content);
        }


        /**
         * Get compressed template
         *
         *  <code> 
         *      echo Site::template();
         *  </code>
         *
         * @return mixed
         */
        public static function template() {

            // Get current theme
            $current_theme = Option::get('theme_site_name');           

            // Get template
            $template = call_user_func(ucfirst(Uri::command()).'::template');

            // Check whether is there such a template in the current theme
            // else return default template: index
            // also compress template file :)            
            if (File::exists(THEMES_SITE . DS . $current_theme . DS . $template . '.template.php')) {            
                if ( ! file_exists(MINIFY . DS . 'theme.' . $current_theme . '.minify.' . $template . '.template.php') or 
                    filemtime(THEMES_SITE . DS . $current_theme . DS . $template .'.template.php') > filemtime(MINIFY . DS . 'theme.' . $current_theme . '.minify.' . $template . '.template.php')) {
                        $buffer = file_get_contents(THEMES_SITE. DS . $current_theme . DS . $template .'.template.php');
                        $buffer = Minify::html($buffer);
                        file_put_contents(MINIFY . DS . 'theme.' . $current_theme . '.minify.' . $template . '.template.php', $buffer);
                }
                return 'minify.'.$template;
            } else {
                if ( ! File::exists(MINIFY . DS . 'theme.' . $current_theme . '.' . 'minify.index.template.php') or
                    filemtime(THEMES_SITE . DS . $current_theme . DS . 'index.template.php') > filemtime(MINIFY . DS . 'theme.' . $current_theme . '.' . 'minify.index.template.php')) {
                        $buffer = file_get_contents(THEMES_SITE . DS . $current_theme . DS . 'index.template.php');
                        $buffer = Minify::html($buffer);
                        file_put_contents(MINIFY . DS . 'theme.' . $current_theme . '.' . 'minify.index.template.php', $buffer);
                }
                return 'minify.index';
            }        
        }


        /**
         * Get site url
         *
         *  <code> 
         *      echo Site::url();
         *  </code>
         *   
         * @return string
         */
        public static function url() {
            return Option::get('siteurl');
        }


        /**
         * Get copyright information
         *
         *  <code> 
         *      echo Site::powered();
         *  </code>
         *
         * @return string
         */
        public static function powered() {
            return __('Powered by', 'system').' <a href="' . MONSTRA_SITEURL . '" target="_blank">Monstra</a> ' . MONSTRA_VERSION;        
        }

    }


    // Add new shortcode {siteurl}
    Shortcode::add('siteurl', 'returnSiteUrl');
    function returnSiteUrl() { return Option::get('siteurl'); }