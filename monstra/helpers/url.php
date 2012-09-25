<?php defined('MONSTRA_ACCESS') or die('No direct script access.');

    /**
     *	Url Helper
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
   
   
	class Url {


        /** 
         * Protected constructor since this is a static class.
         *
         * @access  protected
         */  
        protected function __construct() {
            // Nothing here
        }
        				

	    /**
	     * Takes a long url and uses the TinyURL API to return a shortened version.
	     *
         *  <code>
         *      echo Url::tiny('http:://sitename.com');
         *  </code>
         *
	     * @param  string $url Long url
	     * @return string
	     */
	    public static function tiny($url) {
	        return file_get_contents('http://tinyurl.com/api-create.php?url='.(string)$url);
	    }


	    /**
	     * Check is url exists
	     *
         *  <code>
         *      if(Url::exists('http:://sitename.com')) {
         *			// Do something...
         *		}
         *  </code>
         *
	     * @param  string $url Url
	     * @return boolean
	     */
	    public static function exists($url) {
	        $a_url = parse_url($url);
	        if ( ! isset($a_url['port'])) $a_url['port'] = 80;
	        $errno = 0;
	        $errstr = '';
	        $timeout = 30;
	        if (isset($a_url['host']) && $a_url['host']!=gethostbyname($a_url['host'])){
	            $fid = fsockopen($a_url['host'], $a_url['port'], $errno, $errstr, $timeout);
	            if ( ! $fid) return false;
	            $page  = isset($a_url['path']) ? $a_url['path'] : '';
	            $page .= isset($a_url['query']) ? '?'.$a_url['query'] : '';
	            fputs($fid, 'HEAD '.$page.' HTTP/1.0'."\r\n".'Host: '.$a_url['host']."\r\n\r\n");
	            $head = fread($fid, 4096);
	            fclose($fid);
	            return preg_match('#^HTTP/.*\s+[200|302]+\s#i', $head);
	        } else {
	            return false;
	        }
	    }


	    /**
	     * Find url 
	     *
         *  <code>
         *      // Outputs: http://sitename.com/home
         *      echo Url::find('home'); 
         *  </code>
         *
	     * @global string $site_url Site url
	     * @param  string $url      URL - Uniform Resource Locator
	     * @return string
	     */
	    public static function find($url) {	        
	        $pos = strpos($url, 'http://');
	        if ($pos === false) { $url_output = Option::get('siteurl') . $url; } else { $url_output = $url; }
	        return $url_output;
	    }


	    /**
	 	 * Gets the base URL
	 	 * 
         *  <code>
         *      echo Url::base();         
         *  </code>
         *
	 	 * @return string	
	     */
	    public static function base() {
	    	return 'http://' . rtrim(rtrim($_SERVER['HTTP_HOST'], '\\/') . dirname($_SERVER['PHP_SELF']), '\\/');
	    }

	}