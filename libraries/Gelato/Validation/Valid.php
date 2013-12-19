<?php

/**
 * Gelato Library
 *
 * This source file is part of the Gelato Library. More information,
 * documentation and tutorials can be found at http://gelato.monstra.org
 *
 * @package     Gelato
 *
 * @author      Romanenko Sergey / Awilum <awilum@msn.com>
 * @copyright   2012-2014 Romanenko Sergey / Awilum <awilum@msn.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

class Valid
{
    /**
     * Protected constructor since this is a static class.
     *
     * @access  protected
     */
    protected function __construct()
    {
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
     * @param  string  $email email address
     * @return boolean
     */
    public static function email($email)
    {
        return (bool) filter_var((string) $email, FILTER_VALIDATE_EMAIL);
    }

    /**
     * Check an ip address for correct format.
     *
     *	<code>
     *		if (Valid::ip('127.0.0.1') || Valid::ip('0:0:0:0:0:0:7f00:1')) {
     *			// Do something...
     *  	}
     *	</code>
     *
     * @param  string  $ip ip address
     * @return boolean
     */
    public static function ip($ip)
    {
        return (bool) filter_var((string) $ip, FILTER_VALIDATE_IP);
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
     * @param integer $num  Credit card num
     * @param string  $type Credit card type:
     *						  American - American Express
     *						  Dinners - Diner's Club
     *						  Discover - Discover Card
     *					 	  Master - Mastercard
     *						  Visa - Visa
     * @return boolean
     */
    public static function creditCard($num, $type)
    {
        // Redefine vars
        $num  = (int) $num;
        $type = (string) $type;

        switch ($type) {
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
     * @param  string  $num Phone number
     * @return boolean
     */
    public static function phone($num)
    {
        return (bool) preg_match("/^([0-9\(\)\/\+ \-]*)$/", (string) $num);
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
     * @param  string  $url Url
     * @return boolean
     */
    public static function url($url)
    {
        return (bool) filter_var((string) $url, FILTER_VALIDATE_URL);
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
     * @param  string  $str Date
     * @return boolean
     */
    public static function date($str)
    {
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
     * @param  string  $str String
     * @return boolean
     */
    public static function digit($str)
    {
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
     * @param  string  $str String
     * @return boolean
     */
    public static function numeric($str)
    {
        $locale = localeconv();

        return (bool) preg_match('/^-?[0-9'.$locale['decimal_point'].']++$/D', (string) $str);
    }


    /**
     * Checks if the given regex statement is valid.
     *
     * @param  string  $regexp The value to validate.
     * @return boolean
     */
    public static function regexp($regexp)
    {
        // dummy string
        $dummy = 'Gelato is a PHP5 library for kickass Web Applications.';

        // validate
        return (@preg_match((string) $regexp, $dummy) !== false);

    }

}
