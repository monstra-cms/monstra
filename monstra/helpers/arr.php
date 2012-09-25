<?php defined('MONSTRA_ACCESS') or die('No direct script access.');

    /**
     *	Array Helper
     *
     *	@package Monstra
     *	@subpackage Helpers
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


    class Arr {
     

        /** 
         * Protected constructor since this is a static class.
         *
         * @access  protected
         */  
        protected function __construct() {
            // Nothing here
        }
           

        /**
         * Subval sort
         *
         *  <code>
         *      $new_array = Arr::subvalSort($old_array, 'sort');
         *  </code>
         *
         * @param array  $a      Array
         * @param string $subkey Key
         * @param string $order  Order type DESC or ASC
         * @return array
         */
        public static function subvalSort($a, $subkey, $order = null) {
            if (count($a) != 0 || (!empty($a))) {
                foreach ($a as $k => $v) $b[$k] = function_exists('mb_strtolower') ? mb_strtolower($v[$subkey]) : strtolower($v[$subkey]);                
                if ($order == null || $order == 'ASC') asort($b); else if ($order == 'DESC') arsort($b);                
                foreach ($b as $key => $val) $c[] = $a[$key];
                return $c;
            }
        }


        /**
         * Returns value from array using "dot notation".
         * If the key does not exist in the array, the default value will be returned instead.
         *
         *  <code>
         *      $login = Arr::get($_POST, 'login');
         *      
         *      $array = array('foo' => 'bar');
         *      $foo = Arr::get($array, 'foo'); 
         *
         *      $array = array('test' => array('foo' => 'bar'));
         *      $foo = Arr::get($array, 'test.foo');
         *  </code>
         *
         * @param   array  $array   Array to extract from
         * @param   string $path    Array path
         * @param   mixed  $default Default value
         * @return  mixed
         */
        public static function get($array, $path, $default = null) {

            // Get segments from path
            $segments = explode('.', $path);

            // Loop through segments
            foreach($segments as $segment) {

                // Check
                if ( ! is_array($array) || !isset($array[$segment])) {
                    return $default;
                }

                // Write
                $array = $array[$segment];
            }

            // Return 
            return $array;
        }


        /**
         * Deletes an array value using "dot notation".
         * 
         *  <code>
         *      Arr::delete($array, 'foo.bar');
         *  </code>
         *
         * @access  public
         * @param   array    $array  Array you want to modify
         * @param   string   $path   Array path
         * @return  boolean
         */
        public static function delete(&$array, $path) {

            // Get segments from path
            $segments = explode('.', $path);

            // Loop through segments
            while(count($segments) > 1) {

                $segment = array_shift($segments);

                if ( ! isset($array[$segment]) || !is_array($array[$segment])) {
                    return false;
                }

                $array =& $array[$segment];
            }

            unset($array[array_shift($segments)]);

            return true;
        }


        /**
         * Checks if the given dot-notated key exists in the array.
         *
         *  <code>
         *      if (Arr::keyExists($array, 'foo.bar')) {
         *          // Do something...
         *      }
         *  </code>
         *
         * @param   array   $array  The search array
         * @param   mixed   $path   Array path
         * @return  boolean
         */
        public static function keyExists($array, $path) {

            foreach (explode('.', $path) as $segment) {

                if ( ! is_array($array) or ! array_key_exists($segment, $array)) {
                    return false;
                }

                $array = $array[$segment];
            }

            return true;
        }


        /**
         * Returns a random value from an array.
         * 
         *  <code>
         *      Arr::random(array('php', 'js', 'css', 'html'));
         *  </code>
         *
         * @access  public
         * @param   array   $array  Array path
         * @return  mixed
         */
        public static function random($array) {
            return $array[array_rand($array)];
        }


        /**
         * Returns TRUE if the array is associative and FALSE if not.
         *
         *  <code>
         *      if (Arr::isAssoc($array)) {
         *          // Do something...
         *      }
         *  </code>
         *
         * @param   array   $array  Array to check
         * @return  boolean
         */
        public static function isAssoc($array) {
            return (bool) count(array_filter(array_keys($array), 'is_string'));
        }
        
    }