<?php defined('MONSTRA_ACCESS') or die('No direct script access.');

    /**
     *	Validation Helper
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
	

	class Valid {
		

        /** 
         * Protected constructor since this is a static class.
         *
         * @access  protected
         */  
        protected function __construct() {
            // Nothing here
        }

        
		/**
		 * Check an email address for correct format.
		 *
		 *	<code>
		 *		if (Valid::email('test@test.com')) {
		 *			// Do something...
		 *  	}
		 *	</code>
		 *
		 * @param   string $email email address
		 * @return  boolean
		 */
		public static function email($email) {
			return (bool) preg_match('/^[-_a-z0-9\'+*$^&%=~!?{}]++(?:\.[-_a-z0-9\'+*$^&%=~!?{}]+)*+@(?:(?![-.])[-a-z0-9.]+(?<![-.])\.[a-z]{2,6}|\d{1,3}(?:\.\d{1,3}){3})(?::\d++)?$/iD', (string)$email);
		}
		

		/**
		 * Check an ip address for correct format.
		 *
		 *	<code>
		 *		if (Valid::ip('127.0.0.1')) {
		 *			// Do something...
		 *  	}
		 *	</code>
		 *
		 * @param   string $ip ip address
		 * @return  boolean
		 */
		public static function ip($ip) {
			return (bool) preg_match("^([1-9]|[1-9][0-9]|1[0-9][0-9]|2[0-4][0-9]|25[0-5])(\.([0-9]|[1-9][0-9]|1[0-9][0-9]|2[0-4][0-9]|25[0-5])){3}^", (string)$ip);
		}


		/**
		 * Check an credit card for correct format.
		 *
		 *	<code>
		 *		if (Valid::creditCard(7711111111111111, 'Visa')) {
		 *			// Do something...
		 *  	}
		 *	</code>
		 *
		 * @param   integer $num  Credit card num
		 * @param   string  $type Credit card type: 
		 *						  American - American Express		  
		 *						  Dinners - Diner's Club
		 *						  Discover - Discover Card
		 *					 	  Master - Mastercard
		 *						  Visa - Visa	
		 * @return  boolean
		 */
		public static function creditCard($num, $type) {

			// Redefine vars
            $num  = (int)    $num;
            $type = (string) $type;

			switch($type) {
				case "American": return (bool) preg_match("/^([34|37]{2})([0-9]{13})$/", $num);
				case "Dinners":  return (bool) preg_match("/^([30|36|38]{2})([0-9]{12})$/", $num);
				case "Discover": return (bool) preg_match("/^([6011]{4})([0-9]{12})$/", $num);
				case "Master":   return (bool) preg_match("/^([51|52|53|54|55]{2})([0-9]{14})$/", $num);
				case "Visa":     return (bool) preg_match("/^([4]{1})([0-9]{12,15})$/", $num);
			}			
		}


		/**
		 * Check an phone number for correct format.
		 *
		 *	<code>
		 *		if (Valid::phone(0661111117)) {
		 *			// Do something...
		 *  	}
		 *	</code>
		 *
		 * @param   string $num Phone number
		 * @return  boolean
		 */
		public static function phone($num) {
			return (bool) preg_match("/^([0-9\(\)\/\+ \-]*)$/", (string)$num);
		}


		/**
		 * Check an url for correct format.
		 *
		 *	<code>
		 *		if (Valid::url('http://site.com/')) {
		 *			// Do something...
		 *  	}
		 *	</code>
		 *
		 * @param   string $url Url
		 * @return  boolean
		 */
		public static function url($url) {
			return (bool) preg_match("|^http(s)?://[a-z0-9-]+(.[a-z0-9-]+)*(:[0-9]+)?(/.*)?$|i", (string)$url);	
		}


		/**
		 * Check an date for correct format.
		 *
		 *	<code>
		 *		if (Valid::date('12/12/12')) {
		 *			// Do something...
		 *  	}
		 *	</code>
		 *
		 * @param   string $str Date
		 * @return  boolean
		 */
	    public static function date($str) {
	        return (strtotime($str) !== false);
	    }


		/**
		 * Checks whether a string consists of digits only (no dots or dashes).
		 *
		 *	<code>
		 *		if (Valid::digit('12')) {
		 *			// Do something...
		 *  	}
		 *	</code>
		 *
		 * @param   string  $str String
		 * @return  boolean
		 */
	    public static function digit($str) {
	    	return (bool) preg_match ("/[^0-9]/", $str);
	    }


		/**
		 * Checks whether a string is a valid number (negative and decimal numbers allowed).
		 *
		 *	<code>
		 *		if (Valid::numeric('3.14')) {
		 *			// Do something...
		 *  	}
		 *	</code>
		 *
		 * Uses {@link http://www.php.net/manual/en/function.localeconv.php locale conversion}
		 * to allow decimal point to be locale specific.
		 *
		 * @param   string  $str String
		 * @return  boolean
		 */
	    public static function numeric($str) {	        
	        $locale = localeconv();
	        return (bool) preg_match('/^-?[0-9'.$locale['decimal_point'].']++$/D', (string)$str);
	    }


		/**
		 * Checks if the given regex statement is valid.
		 *		 
		 * @param	string  $regexp The value to validate.
		 * @return	boolean				
		 */
		public static function regexp($regexp) {
			
			// dummy string
			$dummy = 'Monstra - fast and simple cms';

			// validate
			return (@preg_match((string) $regexp, $dummy) !== false);

		}
		
	}