<?php defined('MONSTRA_ACCESS') or die('No direct script access.');

    /**
     *  Main Monstra engine module. Core module.
     *
     *	Monstra - Content Management System. 
     *  Site: mostra.org
     *	Copyright (C) 2012 Romanenko Sergey / Awilum [awilum@msn.com]
     *
     *	@package Monstra
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
     */

  

    class Core {
        

        /**
         * An instance of the Core class
         *
         * @var core
         */
        protected static $instance = null;


        /**
         * Common environment type constants for consistency and convenience
         */
        const PRODUCTION  = 1;
        const STAGING     = 2;
        const TESTING     = 3;
        const DEVELOPMENT = 4;


        /**
         * Monstra environment
         * 
         * @var string  
         */
        public static $environment = Core::PRODUCTION;
        

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

            //  Error handling for Developers only.
            if (Core::$environment != Core::PRODUCTION) {

                // Set error handler
                set_error_handler('Core::errorHandler');

                // Set fatal error handler
                register_shutdown_function('Core::fatalErrorHandler');

                // Set exception handler
                set_exception_handler('Core::exceptionHandler');
            }

            // Register autoload function
            spl_autoload_register('Core::autoloadHelpers');

            // Start session
            Session::start();

            // Init ORM
            ORM::configure(MONSTRA_DB_DSN);
            ORM::configure('username', MONSTRA_DB_USER);
            ORM::configure('password',  MONSTRA_DB_PASSWORD);

            // Auto cleanup if MONSTRA_DEBUG is true
            if (Core::$environment == Core::DEVELOPMENT) {
                
                // Cleanup minify                               
                if (count($files = File::scan(MINIFY, array('css', 'js', 'php'))) > 0) foreach ($files as $file) File::delete(MINIFY . DS . $file);
                
                // Cleanup cache
                if (count($namespaces = Dir::scan(CACHE)) > 0) foreach ($namespaces as $namespace) Dir::delete(CACHE . DS . $namespace);
            }

            // Load XMLDB API module
            require_once(ENGINE . DS . 'xmldb.php'); 
            
            // Load Options API module
            require_once(ENGINE . DS . 'options.php'); 

            // Init Options API module
            Option::init();

            // Set default timezone
            @ini_set('date.timezone', Option::get('timezone'));               
            if (function_exists('date_default_timezone_set')) date_default_timezone_set(Option::get('timezone')); else putenv('TZ='.Option::get('timezone'));    

            // Sanitize URL to prevent XSS - Cross-site scripting
            Security::runSanitizeURL();

            // Load Plugins API module
            require_once(ENGINE . DS . 'plugins.php');

            // Load Shortcodes API module
            require_once(ENGINE . DS . 'shortcodes.php');

            // Load default filters
            require_once(BOOT . DS . 'filters.php');

            // Load default hooks
            require_once(BOOT . DS . 'hooks.php');

            // Init I18n
            I18n::init(Option::get('language'));

            // Init Plugins API
            Plugin::init();    
           
            // Init Notification service
            Notification::init();

            // Load Site module
            require_once(ENGINE . DS . 'site.php');

            // Init site module
            Site::init();

        }


        /**
         * Autoload helpers
         *
         * @param string $class_name Class name 
         */  
        protected static function autoloadHelpers($class_name) {
            if (file_exists($path = HELPERS . DS . strtolower($class_name) . '.php')) include $path; 
        }


        /**
         * Exception Handler
         * 
         * @param object $exception An exception object
         */  
        public static function exceptionHandler($exception) {
            
            // Empty output buffers
            while (ob_get_level() > 0) ob_end_clean();
            
            // Send headers and output
            @header('Content-Type: text/html; charset=UTF-8');
            @header('HTTP/1.1 500 Internal Server Error');


            // Get highlighted code
            $code = Core::highlightCode($exception->getFile(), $exception->getLine());

            // Determine error type
            if ($exception instanceof ErrorException) {

                $error_type = 'ErrorException: ';

                $codes = array (
                    E_ERROR             => 'Fatal Error',
                    E_PARSE             => 'Parse Error',
                    E_COMPILE_ERROR     => 'Compile Error',
                    E_COMPILE_WARNING   => 'Compile Warning',
                    E_STRICT            => 'Strict Mode Error',
                    E_NOTICE            => 'Notice',
                    E_WARNING           => 'Warning',
                    E_RECOVERABLE_ERROR => 'Recoverable Error',
                    /*E_DEPRECATED        => 'Deprecated',*/ /* PHP 5.3 */
                    E_USER_NOTICE       => 'Notice',
                    E_USER_WARNING      => 'Warning',
                    E_USER_ERROR        => 'Error',
                    /*E_USER_DEPRECATED   => 'Deprecated'*/ /* PHP 5.3 */
                );

                $error_type .= in_array($exception->getCode(), array_keys($codes)) ? $codes[$exception->getCode()] : 'Unknown Error';
            } else {
                $error_type = get_class($exception);
            }

            // Show exception if core environment is DEVELOPMENT
            if (Core::$environment == Core::DEVELOPMENT) {
                
                // Development
                echo ("
                    <!DOCTYPE html>
                    <html>
                    <head>
                        <meta charset='utf-8'>
                        <title>Monstra</title>
                        <style>
                            * { margin: 0; padding: 0; }
                            body { background-color: #EEE; }                            
                            h1,h2,h3,p{font-family:Verdana;font-weight:lighter;margin:10px;}
                            .exception {border: 1px solid #CCC; padding: 10px; background-color: #FFF; color: #333; margin:10px;}
                            pre, .code {font-family: Courier, monospace; font-size:12px;margin:0px;padding:0px;}
                            .highlighted {background-color: #f0eb96; font-weight: bold; border-top: 1px solid #ccc; border-bottom: 1px solid #ccc;}
                            .code {background:#fff;border:1px solid #ccc;overflow:auto;}
                            .line {display: inline-block; background-color: #EFEFEF; padding: 4px 8px 4px 8px; margin-right:10px; }                                
                        </style>
                    </head>
                    <body>
                    <div class='exception'>
                        <h1>Monstra - ".$error_type."</h1>
                        <p>".$exception->getMessage()."</p>
                        <h2>Location</h2>
                        <p>Exception thrown on line <code>".$exception->getLine()."</code> in <code>".$exception->getFile()."</code></p>                    
                "); 

                if ( ! empty($code)) {
                    echo '<div class="code">';
                    foreach ($code as $line) {
                        echo '<pre '; if ($line['highlighted']) { echo 'class="highlighted"'; } echo '><span class="line">' . $line['number'] . '</span>' . $line['code'] . '</pre>';
                    }
                    echo '</div>';
                }       
                         
                echo '</div></body></html>';

            } else {

                // Production 
                echo ("
                    <!DOCTYPE html>
                    <html>
                    <head>
                        <meta charset='utf-8'>
                        <title>Monstra</title>
                        <style>
                            * { margin: 0; padding: 0; }
                            .exception {border: 1px solid #CCC; padding: 10px; background-color: #FFF; color: #333; margin:10px;}
                            body { background-color: #EEE; font-family: sans-serif; font-size: 16px; line-height: 20px; margin: 40px; }                            
                            h1,h2,h3,p{font-family:Verdana;font-weight:lighter;margin:10px;}
                        </style>
                    </head>
                    <body>
                        <div class='exception'>
                            <h1>Oops!</h1>
                            <p>An unexpected error has occurred.</p>
                        </div>
                    </body>
                    </html>
                ");
            }
                        
            // Writes message to log
            @file_put_contents(LOGS . DS . gmdate('Y_m_d') . '.log',
                               gmdate('Y/m/d H:i:s') . ' --- ' . '['.$error_type.']' . ' --- ' . $exception->getMessage() . ' --- ' . 'Exception thrown on line '.$exception->getLine().' in '.$exception->getFile() . "\n",
                               FILE_APPEND);

            exit(1);
        }


        /**
         * Converts errors to ErrorExceptions.
         *
         * @param   integer $code     The error code
         * @param   string  $message  The error message
         * @param   string  $file     The filename where the error occurred
         * @param   integer $line     The line number where the error occurred
         * @return  boolean
         */
        public static function errorHandler($code, $message, $file, $line) {             
            
            // If isset error_reporting and $code then throw new error exception
            if ((error_reporting() & $code) !== 0) {
                throw new ErrorException($message, $code, 0, $file, $line);
            }

            // Don't execute PHP internal error handler
            return true;
        }



        /**
         * Returns an array of lines from a file.
         *
         * @param   string  $file    File in which you want to highlight a line
         * @param   integer $line    Line number to highlight
         * @param   integer $padding Number of padding lines
         * @return  array
         */
        protected static function highlightCode($file, $line, $padding = 5) {
         
            // Is file readable ?
            if ( ! is_readable($file)) {
                return false;
            }

            // Init vars
            $lines        = array();
            $current_line = 0;

            // Open file
            $handle = fopen($file, 'r');

            // Read file
            while ( ! feof($handle)) {

                $current_line++;

                $temp = fgets($handle);

                if ($current_line > $line + $padding) {
                    break; // Exit loop after we have found what we were looking for
                }

                if ($current_line >= ($line - $padding) && $current_line <= ($line + $padding)) {
                   
                    $lines[] = array (
                        'number'      => str_pad($current_line, 4, ' ', STR_PAD_LEFT),
                        'highlighted' => ($current_line === $line),
                        'code'        => Core::highlightString($temp),
                    );
                }
            }

            // Close
            fclose($handle);

            // Return lines
            return $lines;
        }


        /**
         * Highlight string
         *
         * @param  string $string String
         * @return string
         */
        protected static function highlightString($string) {            
            
            return str_replace(array("\n", '<code>', '</code>', '<span style="color: #0000BB">&lt;?php&nbsp;', '#$@r4!/*'),
                               array('', '', '', '<span style="color: #0000BB">', '/*'),
                               highlight_string('<?php ' . str_replace('/*', '#$@r4!/*', $string), true));
            
        }

        /**
         * Convert errors not caught by the errorHandler to ErrorExceptions.
         */
        public static function fatalErrorHandler() {
         
            // Get last error
            $error = error_get_last();
            
            // If isset error then throw new error exception
            if (isset($error) && ($error['type'] === E_ERROR)) {

                Core::exceptionHandler(new ErrorException($error['message'], $error['type'], 0, $error['file'], $error['line']));

                exit(1);
            }
        }

        /**
         * Initialize Monstra engine
         * 
         * @return Core
         */
        public static function init() {
            if ( ! isset(self::$instance)) self::$instance = new Core();
            return self::$instance;
        }

    }