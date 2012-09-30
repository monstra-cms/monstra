<?php defined('MONSTRA_ACCESS') or die('No direct script access.');

    /**
     *	Monstra Plugins API module
     *
     *  Monstra Plugin API consists of classes:
     *  Plugin, Frontend, Backend, View, I18n, Action, Filter, Stylesheet, Javascript, Navigation.
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



    /**
     * Plugin class
     */
    class Plugin {


        /**
         * Plugins
         *
         * @var array
         */
        public static $plugins = array();


        /**
         * Components
         *
         * @var array
         */
        public static $components = array();


        /**
         * An instance of the Plugin class
         *
         * @var plugin
         */
        protected static $instance = null;
        

        /**
         * Initializing plugins
         *
         * @return Plugin
         */
        public static function init(){
            if ( ! isset(self::$instance)) self::$instance = new Plugin();
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
            
            // Get plugins Table
            $plugins = new Table('plugins');

            // Select all plugins
            $records = $plugins->select(null, 'all', null, array('location', 'frontend', 'backend', 'status', 'priority'), 'priority', 'ASC');
         
            // Now include plugins from $records plugins array
            // If plugin is active then load it to the system.
            foreach ($records as $record) {
                if ($record['status'] == 'active') {
                    include_once ROOT . DS . $record['location'];
                }
            }
        }


        /**
         * Get plugin admin
         *
         *  <code>
         *      // Get admin for Blog plugin
         *      Plugin::admin('blog');
         *  </code>
         *
         * @param string $plug       Plugin Name
         * @param string $alt_folder Alternative plugin folder
         */
        public static function admin($plug, $alt_folder = null) {

            // Redefine arguments
            $plug = (string) $plug;

            // Plugin admin extension
            $ext = '.admin.php';        

            // Plugin admin can be loaded only in backend
            if (BACKEND) {
                
                // Plugin admin folder  
                if ( ! empty($alt_folder)) {
                    $folder = $alt_folder . DS . strtolower($plug);
                } else {
                    $folder = strtolower($plug);
                }

                // Path to plugin admin file
                $path = PLUGINS . DS . $folder . DS . $plug . $ext;

                // Load plugin admin
                if (File::exists($path)) {
                    include $path;
                }
            }        
        }



        /**
         * Register new plugin in system
         *
         *  <code>
         *      // Register plugin
         *      Plugin::register( __FILE__,                    
         *                        __('Blog'),
         *                        __('Blog plugin'),  
         *                        '1.0.0',
         *                        'Awilum',               
         *                        'http://example.org/',
         *                        'blog');
         *  </code> 
         *     
         * @param string  $file           Plugin file 
         * @param string  $title          Plugin title
         * @param string  $description    Plugin description
         * @param string  $version        Plugin version
         * @param string  $author         Plugin author
         * @param string  $author_uri     Plugin author uri
         * @param string  $component      Plugin as component
         * @param boolean $box            Plugin as box
         */
        public static function register($file, $title, $description = null, $version = null, $author = null, $author_uri = null, $component = null, $box = false) {            

            // Redefine arguments
            $file            = (string) $file;
            $title           = (string) $title;
            $description     = ($description === null)    ? null : (string) $description;
            $version         = ($version === null)        ? null : (string) $version;
            $author          = ($author === null)         ? null : (string) $author;
            $author_uri      = ($author_uri === null)     ? null : (string) $author_uri;
            $component       = ($component === null)      ? null : (string) $component;
            $box             = (bool) $box;


            // Get plugin id from name.plugin.php    
            $id = strtolower(basename($file, '.plugin.php'));

            // Set plugin privilege 'box' if $box is true
            if ($box) $privilege = 'box'; else $privilege = '';  

            // Register plugin in global plugins array.
            Plugin::$plugins[$id] = array(
              'id'              => $id,
              'title'           => $title,
              'privilege'       => $privilege,
              'version'         => $version,
              'description'     => $description,
              'author'          => $author,
              'author_uri'      => $author_uri,
            );

            // Add plugin as a component
            // Plugin - component will be available at the link sitename/component_name
            // Example:
            //    www.example.org/guestbook
            //    www.example.org/news
            if ( ! empty($component)) {
                Plugin::$components[] = $component;
            }
        }
                
    }


    /**
     * Frontend class
     */
    class Frontend {
                
        public static function main() { }
        public static function title() { return ''; }
        public static function description() { return ''; }
        public static function keywords() { return ''; }
        public static function template() { return 'index'; }
        public static function content() { return ''; }

    }


    /**
     * Backend class
     */
    class Backend {
        
        public static function main() { }

    }


    /**
     * View class
     */
    class View {

    
        /**
         * Path to view file.
         *
         * @var string
         */
        protected $view_file;


        /**
         * View variables.
         *
         * @var array
         */
        protected $vars = array();


        /**
         * Global view variables.
         *
         * @var array
         */
        protected static $global_vars = array();


        /**
         * The output.
         *
         * @var string
         */
        protected $output;


        /**
         * Create a new view object.
         *
         *  <code>
         *      // Create new view object
         *      $view = new View('blog/views/backend/index');
         *
         *      // Assign some new variables
         *      $view->assign('msg', 'Some message...');
         *      
         *      // Get view
         *      $output = $view->render();
         *      
         *      // Display view
         *      echo $output;
         *  </code>
         *
         * @param  string $view      Name of the view file
         * @param  array  $variables Array of view variables
         */
        public function __construct($view, array $variables = array()) {

            // Set view file
            // From current theme folder or from plugin folder
            if (File::exists($theme_view_file = THEMES_SITE . DS . Site::theme() . DS . $view . '.view.php') && BACKEND == false) {
                $this->view_file = $theme_view_file;
            } else {
                $this->view_file = PLUGINS . DS . $view . '.view.php';
            }            

            // Is view file exists ?
            if (file_exists($this->view_file) === false) {
                throw new RuntimeException(vsprintf("%s(): The '%s' view does not exist.", array(__METHOD__, $view)));
            }

            // Set view variables
            $this->vars = $variables;
        }


        /**
         * View factory
         *
         *  <code>
         *      // Create new view object, assign some variables
         *      // and displays the rendered view in the browser.
         *      View::factory('blog/views/backend/index')
         *          ->assign('msg', 'Some message...')
         *          ->display();
         *  </code>
         *
         * @param   string $view      Name of the view file
         * @param   array  $variables Array of view variables
         * @return  View
         */
        public static function factory($view, array $variables = array()) {
            return new View($view, $variables);
        }


        /**
         * Assign a view variable.
         *
         *  <code>
         *      $view->assign('msg', 'Some message...');
         *  </code>
         *
         * @param   string  $key    Variable name
         * @param   mixed   $value  Variable value
         * @param   boolean $global Set variable available in all views
         * @return  View
         */
        public function assign($key, $value, $global = false) {
            
            // Assign a new view variable (global or locale)
            if ($global === false) {
                $this->vars[$key] = $value;
            } else {
                View::$global_vars[$key] = $value;
            }

            return $this;
        }


        /**
         * Include the view file and extracts the view variables before returning the generated output.
         *
         *  <code>
         *      // Get view
         *      $output = $view->render();
         *      
         *      // Display output
         *      echo $output;
         *  </code>
         *
         * @param   string $filter Callback function used to filter output
         * @return  string
         */
        public function render($filter = null) {
            
            // Is output empty ?
            if (empty($this->output)) {
 
                // Extract variables as references
                extract(array_merge($this->vars, View::$global_vars), EXTR_REFS);

                // Turn on output buffering
                ob_start();

                // Include view file
                include($this->view_file);

                // Output...
                $this->output = ob_get_clean();
            }

            // Filter output ?
            if ($filter !== null) {
                $this->output = call_user_func($filter, $this->output);
            }

            // Return output
            return $this->output;
        }


        /**
         * Displays the rendered view in the browser.
         *
         *  <code>
         *      $view->display();
         *  </code>
         *
         */
        public function display() {
            echo $this->render();
        }


        /**
         * Magic setter method that assigns a view variable.
         *
         * @param string $key   Variable name
         * @param mixed  $value Variable value
         */
        public function __set($key, $value) {
            $this->vars[$key] = $value;
        }


        /**
         * Magic getter method that returns a view variable.
         *
         * @param  string $key Variable name
         * @return mixed
         */
        public function __get($key) {

            if (isset($this->vars[$key])) {
                return $this->vars[$key];
            }
        }


        /**
         * Magic isset method that checks if a view variable is set.
         *
         * @param  string  $key Variable name
         * @return boolean
         */
        public function __isset($key) {
            return isset($this->vars[$key]);
        }


        /**
         * Magic unset method that unsets a view variable.
         *
         * @param string $key Variable name
         */
        public function __unset($key) {
            unset($this->vars[$key]);
        }


        /**
         * Method that magically converts the view object into a string.
         *
         * @return  string
         */
        public function __toString() {
            return $this->render();
        }
    }


    /**
     *  I18n class
     */    
    class I18n {


        /**
         * Locales array
         *
         * @var array
         */
        public static $locales = array(
            'ar' => 'العربية',
            'bg' => 'Български',
            'ca' => 'Català',
            'cs' => 'Česky',
            'da' => 'Dansk',
            'de' => 'Deutsch',
            'el' => 'Ελληνικά',
            'en' => 'English',
            'es' => 'Español',
            'fi' => 'Suomi',
            'fr' => 'Français',
            'gl' => 'Galego',
            'hu' => 'Magyar',
            'it' => 'Italiano',
            'ja' => '日本語',
            'lt' => 'Lietuvių',
            'nl' => 'Nederlands',
            'no' => 'Norsk',
            'pl' => 'Polski',
            'pt' => 'Português',
            'pt-br' => 'Português do Brasil',
            'ru' => 'Русский',
            'sk' => 'Slovenčina',
            'sl' => 'Slovenščina',
            'sv' => 'Svenska',
            'tr' => 'Türkçe',
            'uk' => 'Українська',
            'zh' => '中文',
        );


        /**
         * Dictionary
         *
         * @var array
         */
        public static $dictionary = array();


        /**
         * An instance of the I18n class
         *
         * @var I18n
         */
        protected static $instance = null;


        /**
         * Initializing I18n
         *
         * @param string $dir Plugins directory
         */
        public static function init($locale) {
            if ( ! isset(self::$instance)) self::$instance = new I18n($locale);
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
        protected function __construct($locale) {    
        
            // Redefine arguments
            $locale = (string) $locale;    
         
            // Get lang table for current locale 
            $lang_table = Cache::get('i18n', $locale);

            // If lang_table is empty then create new
            if ( ! $lang_table) {  
              
                // Get plugins Table
                $plugins = new Table('plugins');

                // Get all plugins
                $records = $plugins->select(null, 'all', null, array('location', 'priority'), 'priority', 'ASC');
             
                // Init var
                $lang_table = array();

                // Loop through each installed plugin 
                foreach ($records as $record) {  
                                  
                    if (is_dir(ROOT . DS . dirname($record['location']) . DS . 'languages')) {                    
                        
                        // Init var
                        $t = array();            
                                    
                        // Check lang file            
                        if (file_exists(ROOT . DS . dirname($record['location']) . DS . 'languages' . DS . $locale . '.lang.php')) {

                            // Merge the language strings into the sub table
                            $t = array_merge($t, include ROOT . DS . dirname($record['location']) . DS . 'languages' . DS . $locale . '.lang.php');                                                    

                        }

                        // Append the sub table, preventing less specific language files from overloading more specific files                        
                        $lang_table += $t;                        
                    }
                }

                // Save lang table for current locale
                Cache::put('i18n', $locale, $lang_table);

                // Update dictionary
                I18n::$dictionary = $lang_table;
            }

            // Update dictionary
            I18n::$dictionary = $lang_table;
        }
        

        /**
         * Returns translation of a string. If no translation exists, the original
         * string will be returned. No parameters are replaced.
         *
         *  <code>
         *      $hello = I18n::find('Hello friends, my name is :name', 'namespace');
         *  <code>
         *
         * @param   string $string Text to translate
         * @param   string $namespace Namespace
         * @return  string
         */
        public static function find($string, $namespace = null) {
            
            // Redefine arguments
            $string = (string) $string;   

            // Return string
            if (isset(I18n::$dictionary[$namespace][$string])) return I18n::$dictionary[$namespace][$string]; else return $string;
        }

    }


    /**
     * Global Translation/internationalization function.
     * Accepts an English string and returns its translation
     * to the active system language. If the given string is not available in the
     * current dictionary the original English string will be returned.
     *
     *  <code>
     *      // Display a translated message
     *      echo __('Hello, world', 'namespace');
     *
     *      // With parameter replacement
     *      echo __('Hello, :user', 'namespace', array(':user' => $username));
     *  </code>
     *
     * @global array  $dictionary Dictionary
     * @param  string $string     String to translate
     * @param  array  $values     Values to replace in the translated text
     * @param  string $namespace  Namespace
     * @return string
     */
    function __($string, $namespace = null, array $values = null) {          
        
        // Redefine arguments
        $string = (string) $string;        

        // Find string in dictionary
        $string = I18n::find($string, $namespace);

        // Return string
        return empty($values) ? $string : strtr($string, $values);
    }


    /**
     * Action class     
     */    
    class Action {


        /**
         * Actions
         *
         * @var array
         */
        public static $actions = array();


        /** 
         * Protected constructor since this is a static class.
         *
         * @access  protected
         */  
        protected function __construct() {
            // Nothing here
        }


        /**
         *  Hooks a function on to a specific action.
         *
         *  <code>
         *      // Hooks a function "newLink" on to a "footer" action.
         *      Action::add('footer', 'newLink', 10);
         *
         *      function newLink() {
         *          echo '<a href="#">My link</a>';
         *      }     
         *  </code>
         *
         * @param string  $action_name    Action name
         * @param string  $added_function Added function
         * @param integer $priority       Priority. Default is 10
         * @param array   $args           Arguments
         */
        public static function add($action_name, $added_function, $priority = 10, array $args = null) {            
            
            // Hooks a function on to a specific action.
            Action::$actions[] = array(
                            'action_name' => (string)$action_name,
                            'function'    => (string)$added_function,
                            'priority'    => (int)$priority,
                            'args'        => $args
            );
        }


        /**
         * Run functions hooked on a specific action hook.
         *
         *  <code>
         *      // Run functions hooked on a "footer" action hook.
         *      Action::run('footer');
         *  </code>
         *
         * @param  string  $action_name Action name
         * @param  array   $args        Arguments
         * @param  boolean $return      Return data or not. Default is false
         * @return mixed
         */
        public static function run($action_name, $args = array(), $return = false) {

            // Redefine arguments
            $action_name = (string) $action_name;
            $return      = (bool)   $return;

            // Run action
            if (count(Action::$actions) > 0) {

                // Sort actions by priority
                $actions = Arr::subvalSort(Action::$actions, 'priority');

                // Loop through $actions array
                foreach ($actions as $action) {

                    // Execute specific action
                    if ($action['action_name'] == $action_name) {

                        // isset arguments ?
                        if (isset($args)) {

                            // Return or Render specific action results ?
                            if ($return) {
                                return call_user_func_array($action['function'], $args); 
                            } else {
                                call_user_func_array($action['function'], $args);     
                            }      
                                               
                        } else {

                            if ($return) {
                                return call_user_func_array($action['function'], $action['args']); 
                            } else {                        
                                call_user_func_array($action['function'], $action['args']); 
                            }

                        }

                    }

                }

            }

        }

    }


    /**
     * Filter class
     */
    class Filter {


        /**
         * Filters
         *
         * @var array
         */
        public static $filters = array();


        /** 
         * Protected constructor since this is a static class.
         *
         * @access  protected
         */  
        protected function __construct() {
            // Nothing here
        }


        /**
         * Apply filters
         *
         *  <code>
         *      Filter::apply('content', $content);
         *  </code>
         *
         * @param  string $filter_name The name of the filter hook.
         * @param  mixed  $value       The value on which the filters hooked.
         * @return mixed
         */
        public static function apply($filter_name, $value) {            

            // Redefine arguments
            $filter_name = (string) $filter_name;

            $args = array_slice(func_get_args(), 2);

            if ( ! isset(Filter::$filters[$filter_name])) {
                return $value;
            }
            
            foreach (Filter::$filters[$filter_name] as $priority => $functions) {
                if ( ! is_null($functions)) {
                    foreach ($functions as $function) {
                        $all_args = array_merge(array($value), $args);
                        $function_name = $function['function'];
                        $accepted_args = $function['accepted_args'];
                        if ($accepted_args == 1) {
                            $the_args = array($value);
                        } elseif ($accepted_args > 1) {
                            $the_args = array_slice($all_args, 0, $accepted_args);
                        } elseif ($accepted_args == 0) {
                            $the_args = null;
                        } else {
                            $the_args = $all_args;
                        }
                        $value = call_user_func_array($function_name, $the_args);
                    }
                }
            }
            return $value;
        }


        /**
         * Add filter
         *
         *  <code>
         *      Filter::add('content', 'replacer');
         *
         *      function replacer($content) {
         *          return preg_replace(array('/\[b\](.*?)\[\/b\]/ms'), array('<strong>\1</strong>'), $content);
         *      }
         *  </code>
         *
         * @param  string   $filter_name     The name of the filter to hook the $function_to_add to.
         * @param  string   $function_to_add The name of the function to be called when the filter is applied.
         * @param  integer  $priority        Function to add priority - default is 10.
         * @param  integer  $accepted_args   The number of arguments the function accept default is 1.
         * @return boolean
         */
        public static function add($filter_name, $function_to_add, $priority = 10, $accepted_args = 1) {

            // Redefine arguments
            $filter_name     = (string) $filter_name;
            $function_to_add = (string) $function_to_add;
            $priority        = (int)    $priority;
            $accepted_args   = (int)    $accepted_args;

            // Check that we don't already have the same filter at the same priority. Thanks to WP :)
            if (isset(Filter::$filters[$filter_name]["$priority"])) {
                foreach (Filter::$filters[$filter_name]["$priority"] as $filter) {
                    if ($filter['function'] == $function_to_add) {
                        return true;
                    }
                }
            }

            Filter::$filters[$filter_name]["$priority"][] = array('function' => $function_to_add, 'accepted_args' => $accepted_args);
            
            // Sort
            ksort(Filter::$filters[$filter_name]["$priority"]);

            return true;
        }  

    }


    /**
     * Stylesheet class
     */
    class Stylesheet {
        

        /**
         * Stylesheets
         *
         * @var array
         */
        public static $stylesheets = array();


        /** 
         * Protected constructor since this is a static class.
         *
         * @access  protected
         */  
        protected function __construct() {
            // Nothing here
        }


        /**
         * Add stylesheet
         *
         *  <code>
         *      Stylesheet::add('path/to/my/stylesheet1.css');
         *      Stylesheet::add('path/to/my/stylesheet2.css', 'frontend', 11);
         *      Stylesheet::add('path/to/my/stylesheet3.css', 'backend',12);
         *  <code>
         *
         * @param string  $file     File path
         * @param string  $load     Load stylesheet on frontend, backend or both
         * @param integer $priority Priority. Default is 10
         */        
        public static function add($file, $load = 'frontend', $priority = 10) {
            Stylesheet::$stylesheets[] = array(
                'file'     => (string)$file,               
                'load'     => (string)$load, 
                'priority' => (int)$priority,            
            );
        }


        /**
         *  Minify, combine and load site stylesheet
         */
        public static function load() {            

            $backend_site_css_path  = MINIFY . DS . 'backend_site.minify.css';
            $frontend_site_css_path = MINIFY . DS . 'frontend_site.minify.css';

            // Load stylesheets
            if (count(Stylesheet::$stylesheets) > 0) {
                
                $backend_buffer = '';
                $backend_regenerate = false;

                $frontend_buffer = '';
                $frontend_regenerate = false;

                
                // Sort stylesheets by priority
                $stylesheets = Arr::subvalSort(Stylesheet::$stylesheets, 'priority');

                // Build backend site stylesheets
                foreach ($stylesheets as $stylesheet) {
                    if ((file_exists(ROOT . DS . $stylesheet['file'])) and (($stylesheet['load'] == 'backend') or ($stylesheet['load'] == 'both')) ) {
                        if ( ! file_exists($backend_site_css_path) or filemtime(ROOT . DS . $stylesheet['file']) > filemtime($backend_site_css_path)) {
                            $backend_regenerate = true;
                            break;
                        }
                    } 
                }

                // Regenerate site stylesheet
                if ($backend_regenerate) {
                    foreach ($stylesheets as $stylesheet) {                        
                        if ((file_exists(ROOT . DS . $stylesheet['file'])) and (($stylesheet['load'] == 'backend') or ($stylesheet['load'] == 'both')) ) {
                            $backend_buffer .= file_get_contents(ROOT . DS . $stylesheet['file']);                            
                        }
                    }
                    $backend_buffer = Stylesheet::parseVariables($backend_buffer);
                    file_put_contents($backend_site_css_path, Minify::css($backend_buffer));
                    $backend_regenerate = false;
                }


                // Build frontend site stylesheets
                foreach ($stylesheets as $stylesheet) {                    
                    if ((file_exists(ROOT . DS . $stylesheet['file'])) and (($stylesheet['load'] == 'frontend') or ($stylesheet['load'] == 'both')) ) {
                        if ( ! file_exists($frontend_site_css_path) or filemtime(ROOT . DS . $stylesheet['file']) > filemtime($frontend_site_css_path)) {
                            $frontend_regenerate = true;
                            break;
                        }
                    } 
                }

                // Regenerate site stylesheet
                if ($frontend_regenerate) {
                    foreach ($stylesheets as $stylesheet) {                        
                        if ((file_exists(ROOT . DS . $stylesheet['file'])) and (($stylesheet['load'] == 'frontend') or ($stylesheet['load'] == 'both')) ) {
                            $frontend_buffer .= file_get_contents(ROOT . DS . $stylesheet['file']);
                        }
                    }
                    $frontend_buffer = Stylesheet::parseVariables($frontend_buffer);
                    file_put_contents($frontend_site_css_path, Minify::css($frontend_buffer));
                    $frontend_regenerate = false;
                }               

                // Render 
                if (BACKEND) {
                    echo '<link rel="stylesheet" href="'.Option::get('siteurl').'tmp/minify/backend_site.minify.css'.'" type="text/css" />';    
                } else {
                    echo '<link rel="stylesheet" href="'.Option::get('siteurl').'tmp/minify/frontend_site.minify.css'.'" type="text/css" />';
                }                
            }        
        }


        /**
         * CSS Parser
         */
        public static function parseVariables($frontend_buffer) {
            return str_replace(array('@site_url',
                                     '@theme_site_url',
                                     '@theme_admin_url'),
                               array(Option::get('siteurl'),
                                     Option::get('siteurl').'public/themes/'.Option::get('theme_site_name'),
                                     Option::get('siteurl').'admin/themes/'.Option::get('theme_admin_name')),
                               $frontend_buffer);
        }


    }


    /**
     * Javascript class
     */
    class Javascript {
        

        /**
         * Javascripts
         *
         * @var array
         */
        public static $javascripts = array();

        /** 
         * Protected constructor since this is a static class.
         *
         * @access  protected
         */  
        protected function __construct() {
            // Nothing here
        }
        

        /**
         * Add javascript
         *
         *  <code>
         *      Javascript::add('path/to/my/script1.js');
         *      Javascript::add('path/to/my/script2.js', 'frontend', 11);
         *      Javascript::add('path/to/my/script3.js', 'backend', 12);
         *  <code>
         *
         * @param string  $file      File path
         * @param string  $load      Load script on frontend, backend or both
         * @param inteeer $priority  Priority default is 10
         */        
        public static function add($file, $load = 'frontend', $priority = 10) {
            Javascript::$javascripts[] = array(
                'file'     => (string)$file,        
                'load'     => (string)$load,        
                'priority' => (int)$priority,            
            );
        }


        /**
         *  Combine and load site javascript
         */
        public static function load() {
            
            $backend_site_js_path  = MINIFY . DS . 'backend_site.minify.js';
            $frontend_site_js_path = MINIFY . DS . 'frontend_site.minify.js';

            // Load javascripts
            if (count(Javascript::$javascripts) > 0) {
                
                $backend_buffer = '';
                $backend_regenerate = false;

                $frontend_buffer = '';
                $frontend_regenerate = false;

                
                // Sort javascripts by priority
                $javascripts = Arr::subvalSort(Javascript::$javascripts, 'priority');

                // Build backend site javascript
                foreach ($javascripts as $javascript) {
                    if ((file_exists(ROOT . DS . $javascript['file'])) and (($javascript['load'] == 'backend') or ($javascript['load'] == 'both')) ) {
                        if ( ! file_exists($backend_site_js_path) or filemtime(ROOT . DS . $javascript['file']) > filemtime($backend_site_js_path)) {
                            $backend_regenerate = true;
                            break;
                        }
                    } 
                }

                // Regenerate site javascript
                if ($backend_regenerate) {
                    foreach ($javascripts as $javascript) {                        
                        if ((file_exists(ROOT . DS . $javascript['file'])) and (($javascript['load'] == 'backend') or ($javascript['load'] == 'both')) ) {
                            $backend_buffer .= file_get_contents(ROOT . DS . $javascript['file']);
                        }
                    }
                    file_put_contents($backend_site_js_path, $backend_buffer);
                    $backend_regenerate = false;
                }


                // Build frontend site javascript
                foreach ($javascripts as $javascript) {                    
                        if ((file_exists(ROOT . DS . $javascript['file'])) and (($javascript['load'] == 'frontend') or ($javascript['load'] == 'both')) ) {
                        if ( ! file_exists($frontend_site_js_path) or filemtime(ROOT . DS . $javascript['file']) > filemtime($frontend_site_js_path)) {
                            $frontend_regenerate = true;
                            break;
                        }
                    } 
                }

                // Regenerate site javascript
                if ($frontend_regenerate) {
                    foreach ($javascripts as $javascript) {                        
                        if ((file_exists(ROOT . DS . $javascript['file'])) and (($javascript['load'] == 'frontend') or ($javascript['load'] == 'both')) ) {
                            $frontend_buffer .= file_get_contents(ROOT . DS . $javascript['file']);
                        }
                    }
                    file_put_contents($frontend_site_js_path, $frontend_buffer);
                    $frontend_regenerate = false;
                }

                // Render 
                if (BACKEND) {
                    echo '<script type="text/javascript" src="'.Option::get('siteurl').'tmp/minify/backend_site.minify.js"></script>';                    
                } else {
                    echo '<script type="text/javascript" src="'.Option::get('siteurl').'tmp/minify/frontend_site.minify.js"></script>';
                } 
            }        
        }

    }


    /**
     * Navigation class
     */
    class Navigation {


        /**
         * Items
         *
         * @var array
         */
        public static $items = array();


        /**
         * Navigation types
         */
        const LEFT = 1;
        const TOP  = 2;

        
        /**
         * Add new item
         *
         *  <code>
         *      // Add link for left navigation
         *      Navigation::add(__('Blog'), 'content', 'blog', 11);
         *
         *      // Add link for top navigation
         *      Navigation::add(__('View site'), 'top', 'http://site.com/', 11, Navigation::TOP, true);
         *  <code>
         *
         * @param string  $name     Name
         * @param string  $category Category
         * @param stirng  $link     Link
         * @param integer $priority Priority. Default is 10 
         * @param integer $type     Type. Default is LEFT 
         * @param bool    $external External or not. Default is false 
         */
        public static function add($name, $category, $id, $priority = 10, $type = Navigation::LEFT, $external = false) {
            Navigation::$items[] = array(
                'name'      => (string)$name,        
                'category'  => (string)$category,        
                'id'        => (string)$id,
                'priority'  => (int)$priority,         
                'type'      => (int)$type,
                'external'  => (bool)$external,
            );
        }


        /**
         * Draw items
         *
         *  <code>
         *      Navigation::draw('content');
         *      Navigation::draw('top', Navigation::TOP);
         *  <code>
         *
         * @param string  $category Category
         * @param integer $type     Type. Default is LEFT 
         */
        public static function draw($category, $type = Navigation::LEFT) {

            // Sort items by priority
            $items = Arr::subvalSort(Navigation::$items, 'priority');
            
            // Draw left navigation
            if ($type == Navigation::LEFT) {

                // Loop trough the items
                foreach ($items as $item) {

                    // If current plugin id == selected item id then set class to current
                    if (Request::get('id') == $item['id'] && $item['external'] == false) $class = 'class = "current" '; else $class = '';
                    
                    // If current category == item category and navigation type is left them draw this item
                    if ($item['category'] == $category && $item['type'] == Navigation::LEFT)  {

                        // Is external item id or not ?
                        if ($item['external'] == false) { 
                            echo '<li><a '.$class.'href="index.php?id='.$item['id'].'">'.$item['name'].'</a></li>'; 
                        } else {
                            echo '<li><a target="_blank" href="'.$item['id'].'">'.$item['name'].'</a></li>'; 
                        }
                    }
                }
            } elseif ($type == Navigation::TOP) {                
                // Draw top navigation
                foreach ($items as $item) {                    
                    if ($item['category'] == $category && $item['type'] == Navigation::TOP)  {   
                        if ($item['external'] == false) {                      
                            echo '<a class="btn btn-small btn-inverse" href="index.php?id='.$item['id'].'">'.$item['name'].'</a>'.Html::nbsp(2); 
                        } else {
                            echo '<a target="_blank" class="btn btn-small btn-inverse" href="'.$item['id'].'">'.$item['name'].'</a>'.Html::nbsp(2); 
                        }
                    }
                }
            }
        }

    }