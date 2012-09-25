<?php defined('MONSTRA_ACCESS') or die('No direct script access.');

    /**
     *	Security module
     *
     *	@package Monstra
     *  @subpackage Helpers
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


    class Security {


        /**
         * Key name for token storage
         *
         * @var  string
         */
        public static $token_name = 'security_token';


        /** 
         * Protected constructor since this is a static class.
         *
         * @access  protected
         */  
        protected function __construct() {
            // Nothing here
        }


        /**
         * Generate and store a unique token which can be used to help prevent
         * [CSRF](http://wikipedia.org/wiki/Cross_Site_Request_Forgery) attacks.
         *
         *  <code>
         *      $token = Security::token();
         *  </code>
         *
         * You can insert this token into your forms as a hidden field:
         *
         *  <code>
         *      echo Form::hidden('csrf', Security::token());
         *  </code>
         *
         * This provides a basic, but effective, method of preventing CSRF attacks.
         *
         * @param   boolean $new force a new token to be generated?. Default is false
         * @return  string
         */
        public static function token($new = false) {
            
            // Get the current token
            $token = Session::get(Security::$token_name);

            // Create a new unique token
            if ($new === true or ! $token) {

                // Generate a new unique token
                $token = sha1(uniqid(mt_rand(), true));                

                // Store the new token
                Session::set(Security::$token_name, $token);
            }

            // Return token
            return $token;
        }


        /**
         * Check that the given token matches the currently stored security token.
         *
         *  <code>
         *     if (Security::check($token)) {
         *         // Pass
         *     }
         *  </code>
         *
         * @param   string  $token token to check
         * @return  boolean
         */
        public static function check($token) {
            return Security::token() === $token;
        }


        
        /**
         * Encrypt password
         *
         *  <code>
         *      $encrypt_password = Security::encryptPassword('password');
         *  </code>
         *
         * @param string $password Password to encrypt
         */
        public static function encryptPassword($password) {
           return md5(md5(trim($password) . MONSTRA_PASSWORD_SALT));
        }


        /**
         * Create safe name. Use to create safe username, filename, pagename.
         *
         *  <code>
         *      $safe_name = Security::safeName('hello world');
         *  </code>
         *
         * @param  string  $str        String
         * @param  string  $delimiter  String delimiter
         * @param  boolean $lowercase  String Lowercase
         * @return string
         */
        public static function safeName($str, $delimiter = '-', $lowercase = false) {

            // Redefine vars
            $str       = (string) $str;
            $delimiter = (string) $delimiter;
            $lowercase = (bool)   $lowercase;
            $delimiter = (string) $delimiter;

            // Remove tags
            $str = filter_var($str, FILTER_SANITIZE_STRING);

            // Decode all entities to their simpler forms
            $str = html_entity_decode($str, ENT_QUOTES, 'UTF-8');

            // Reserved characters (RFC 3986)
            $reserved_characters = array(
                '/', '?', ':', '@', '#', '[', ']',
                '!', '$', '&', '\'', '(', ')', '*',
                '+', ',', ';', '='
            );

            // Remove reserved characters
            $str = str_replace($reserved_characters, ' ', $str);

            // Set locale to en_US.UTF8
            setlocale(LC_ALL, 'en_US.UTF8');

            // Translit ua,ru => latin          
            $str = Text::translitIt($str);

            // Convert string
            $str = iconv('UTF-8', 'ASCII//TRANSLIT', $str);

            // Remove characters
            $str = preg_replace("/[^a-zA-Z0-9\/_|+ -]/", '', $str );
            $str = preg_replace("/[\/_|+ -]+/", $delimiter, $str );
            $str = trim($str, $delimiter);  

            // Lowercase
            if ($lowercase === true) $str = Text::lowercase($str);            

            // Return safe name
            return $str;            
         }


        /**
         * Create safe url. 
         *
         *  <code>
         *      $url = Security::sanitizeURL('http://test.com');
         *  </code>
         *
         * @param  string $url Url to sanitize
         * @return string
         */
        public static function sanitizeURL($url) {
            
            $url = trim($url);
            $url = rawurldecode($url);
            $url = str_replace(array('--','&quot;','!','@','#','$','%','^','*','(',')','+','{','}','|',':','"','<','>',
                                      '[',']','\\',';',"'",',','*','+','~','`','laquo','raquo',']>','&#8216;','&#8217;','&#8220;','&#8221;','&#8211;','&#8212;'),
                                array('-','-','','','','','','','','','','','','','','','','','','','','','','','','','','',''),
                                $url);
            $url = str_replace('--', '-', $url);
            $url = rtrim($url, "-");

            $url = str_replace('..', '', $url);
            $url = str_replace('//', '', $url);
            $url = preg_replace('/^\//', '', $url);
            $url = preg_replace('/^\./', '', $url);   

            return $url;
         }


        /**
         * Sanitize URL to prevent XSS - Cross-site scripting
         */
        public static function runSanitizeURL() {
            $_GET = array_map('Security::sanitizeURL', $_GET);
        }


        /**
         * That prevents null characters between ascii characters. 
         *
         * @param string $str String
         */
        public static function removeInvisibleCharacters($str) {
            
            // Redefine vars
            $str = (string) $str;

            // Thanks to ci for this tip :)
            $non_displayables = array('/%0[0-8bcef]/', '/%1[0-9a-f]/', '/[\x00-\x08]/', '/\x0b/', '/\x0c/', '/[\x0e-\x1f]/');
            
            do {
                $cleaned = $str;
                $str = preg_replace($non_displayables, '', $str);
            } while ($cleaned != $str);

            // Return safe string
            return $str;
        }


        /**
         * Sanitize data to prevent XSS - Cross-site scripting
         *
         * @param string $str String
         */
        public static function xssClean($str) {

            // Remove invisible characters
            $str = Security::removeInvisibleCharacters($str);

            // Convert html to plain text
            $str = Html::toText($str); 

            // Return safe string
            return $str;
        }
            
    }
