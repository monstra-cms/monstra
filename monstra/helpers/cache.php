<?php defined('MONSTRA_ACCESS') or die('No direct script access.');

    /**
     *  Cache Helper
     *
     *  @package Monstra
     *  @subpackage Helpers
     *  @author Romanenko Sergey / Awilum
     *  @copyright 2012 Romanenko Sergey / Awilum
     *  @version $Id$
     *  @since 1.0.0
     *  @license http://opensource.org/licenses/gpl-license.php GNU Public License
     *  Monstra is free software. This version may have been modified pursuant
     *  to the GNU General Public License, and as distributed it includes or
     *  is derivative of works licensed under the GNU General Public License or
     *  other free or open source software licenses.
     *  See COPYING.txt for copyright notices and details.
     *  @filesource 
     */

    
	class Cache {


        /**
         * Cache directory
         *
         * @var string
         */
        public static $cache_dir = CACHE;
        

        /**
         * Cache file ext
         *
         * @var string
         */
        public static $cache_file_ext = 'txt';        


        /**
         * Cache life time (in seconds)
         *
         * @var int 
         */
        public static $cache_time = 31556926;        


        /** 
         * Protected constructor since this is a static class.
         *
         * @access  protected
         */  
        protected function __construct() {
            // Nothing here
        }


        /**
         * Configure the settings of Cache
         *
         *  <code>
         *      Cache::configure('cache_dir', 'path/to/cache/dir');
         *  </code>
         *
         * @param mixed $setting Setting name
         * @param mixed $value   Setting value
         */
        public static function configure($setting, $value){            
            if (property_exists("cache", $setting)) Cache::$$setting = $value;
        }


	    /**
         * Get data from cache
         *
         *  <code>
         *      $profile = Cache::get('profiles', 'profile');
         *  </code>
         *
         * @param  string $namespace Namespace
         * @param  string $key       Cache key
         * @return boolean
         */
        public static function get($namespace, $key){
            
            // Redefine vars
            $namespace = (string) $namespace;

            // Get cache file id
            $cache_file_id = Cache::getCacheFileID($namespace, $key);       
             
            // Is cache file exists ?
            if (file_exists($cache_file_id)) {	    		
                   
                // If cache file has not expired then fetch it   
                if ((time() - filemtime($cache_file_id)) < Cache::$cache_time) {

                   $handle = fopen($cache_file_id, 'r');

                   $cache = '';

                   while ( ! feof($handle)) {
                       $cache .= fgets($handle);
                   }

                   fclose($handle);

                   return unserialize($cache);
                                      
                } else {                    
                    unlink($cache_file_id);
                    return false;
                }	           
	    	} else {                
	            return false;
	        }
        }


        /**
         * Create new cache file $key in namescapce $namespace with the given data $data
         *
         *  <code>
         *      $profile = array('login' => 'Awilum',
         *                       'email' => 'awilum@msn.com');
         *      Cache::put('profiles', 'profile', $profile);
         *  </code>
         *
         * @param  string $namespace Namespace
         * @param  string $key       Cache key
         * @param  mixed  $data      The variable to store
         * @return boolean
         */
        public static function put($namespace, $key, $data) {  
        
            // Redefine vars
            $namespace = (string) $namespace;

            // Is CACHE directory writable ?
            if (file_exists(CACHE) === false || is_readable(CACHE) === false || is_writable(CACHE) === false) {
                throw new RuntimeException(vsprintf("%s(): Cache directory ('%s') is not writable.", array(__METHOD__, CACHE)));
            }
                  	
            // Create namespace                    
        	if ( ! file_exists(Cache::getNamespaceID($namespace))) {
                mkdir(Cache::getNamespaceID($namespace), 0775, true);
            }

            // Write cache to specific namespace
        	return file_put_contents(Cache::getCacheFileID($namespace, $key), serialize($data), LOCK_EX);
        }


        /**
         * Deletes a cache in specific namespace
         *
         *  <code>
         *      Cache::delete('profiles', 'profile');
         *  </code>
         *
         * @param  string $namespace Namespace
         * @param  string $key       Cache key
         * @return boolean
         */
        public static function delete($namespace, $key) {         
            
            // Redefine vars
            $namespace = (string) $namespace;
               
            if (file_exists(Cache::getCacheFileID($namespace, $key))) unlink(Cache::getCacheFileID($namespace, $key)); else return false;
        }


        /**
         * Clean specific cache namespace.
         *
         *  <code>
         *      Cache::clean('profiles');
         *  </code>
         *
         * @param  string $namespace Namespace
         * @return null
         */
        public static function clean($namespace) {      
            
            // Redefine vars
            $namespace = (string) $namespace;

            array_map("unlink", glob(Cache::$cache_dir . DS . md5($namespace) . DS . "*." . Cache::$cache_file_ext));
        }


        /**
         * Get cache file ID
         *
         * @param  string $namespace Namespace
         * @param  string $key       Cache key
         * @return string
         */
        protected static function getCacheFileID($namespace, $key) {

            // Redefine vars
            $namespace = (string) $namespace;

            return Cache::$cache_dir . DS . md5($namespace) . DS . md5($key) . '.' . Cache::$cache_file_ext;
        }


		/**
         * Get namespace ID
         *
         * @param  string $namespace Namespace
         * @return string
         */
        protected static function getNamespaceID($namespace) {

            // Redefine vars
            $namespace = (string) $namespace;

        	return Cache::$cache_dir . DS . md5($namespace);
        }
        

	}