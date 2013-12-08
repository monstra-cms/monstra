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

class Text
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
     * Translit function ua,ru => latin
     *
     *  <code>
     *      echo Text::translitIt('Привет');
     *  </code>
     *
     * @param  string $str [ua,ru] string
     * @return string $str
     */
    public static function translitIt($str)
    {
        // Redefine vars
        $str = (string) $str;

        $patern = array(
            "А" => "A", "Б" => "B", "В" => "V", "Г" => "G",
            "Д" => "D", "Е" => "E", "Ж" => "J", "З" => "Z",
            "И" => "I", "Й" => "Y", "К" => "K", "Л" => "L",
            "М" => "M", "Н" => "N", "О" => "O", "П" => "P",
            "Р" => "R", "С" => "S", "Т" => "T", "У" => "U",
            "Ф" => "F", "Х" => "H", "Ц" => "TS", "Ч" => "CH",
            "Ш" => "SH", "Щ" => "SCH", "Ъ" => "", "Ы" => "YI",
            "Ь" => "", "Э" => "E", "Ю" => "YU", "Я" => "YA",
            "а" => "a", "б" => "b", "в" => "v", "г" => "g",
            "д" => "d", "е" => "e", "ж" => "j", "з" => "z",
            "и" => "i", "й" => "y", "к" => "k", "л" => "l",
            "м" => "m", "н" => "n", "о" => "o","п" => "p",
            "р" => "r", "с" => "s", "т" => "t", "у" => "u",
            "ф" => "f", "х" => "h", "ц" => "ts", "ч" => "ch",
            "ш" => "sh", "щ" => "sch", "ъ" => "y", "ї" => "i",
            "Ї" => "Yi", "є" => "ie", "Є" => "Ye", "ы" => "yi",
            "ь" => "", "э" => "e", "ю" => "yu", "я" => "ya", "ё" => "yo"
        );

        return strtr($str, $patern);
    }

    /**
     * Removes any leading and traling slashes from a string
     *
     *  <code>
     *      echo Text::trimSlashes('some text here/');
     *  </code>
     *
     * @param  string $str String with slashes
     * @return string
     */
    public static function trimSlashes($str)
    {
        // Redefine vars
        $str = (string) $str;

        return trim($str, '/');
    }

    /**
     * Removes slashes contained in a string or in an array
     *
     *  <code>
     *      echo Text::strpSlashes('some \ text \ here');
     *  </code>
     *
     * @param  mixed $str String or array of strings with slashes
     * @return mixed
     */
    public static function strpSlashes($str)
    {
        if (is_array($str)) {
            foreach ($str as $key => $val) {
                $result[$key] = stripslashes($val);
            }
        } else {
            $result = stripslashes($str);
        }

        return $result;
    }

    /**
     * Removes single and double quotes from a string
     *
     *  <code>
     *      echo Text::stripQuotes('some "text" here');
     *  </code>
     *
     * @param  string $str String with single and double quotes
     * @return string
     */
    public static function stripQuotes($str)
    {
        // Redefine vars
        $str = (string) $str;

        return str_replace(array('"', "'"), '', $str);
    }

    /**
     * Convert single and double quotes to entities
     *
     *  <code>
     *      echo Text::quotesToEntities('some "text" here');
     *  </code>
     *
     * @param  string $str String with single and double quotes
     * @return string
     */
    public static function quotesToEntities($str)
    {
        // Redefine vars
        $str = (string) $str;

        return str_replace(array("\'", "\"", "'", '"'), array("&#39;", "&quot;", "&#39;", "&quot;"), $str);
    }

    /**
     * Creates a random string of characters
     *
     *  <code>
     *      echo Text::random();
     *  </code>
     *
     * @param  string  $type   The type of string. Default is 'alnum'
     * @param  integer $length The number of characters. Default is 16
     * @return string
     */
    public static function random($type = 'alnum', $length = 16)
    {
        // Redefine vars
        $type   = (string) $type;
        $length = (int) $length;

        switch ($type) {

            case 'basic':
                return mt_rand();
            break;

            default:
                case 'alnum':
                case 'numeric':
                case 'nozero':
                case 'alpha':
                case 'distinct':
                case 'hexdec':
                    switch ($type) {
                        case 'alpha':
                            $pool = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
                        break;

                        default:
                        case 'alnum':
                            $pool = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
                        break;

                        case 'numeric':
                            $pool = '0123456789';
                        break;

                        case 'nozero':
                            $pool = '123456789';
                        break;

                        case 'distinct':
                            $pool = '2345679ACDEFHJKLMNPRSTUVWXYZ';
                        break;

                        case 'hexdec':
                            $pool = '0123456789abcdef';
                        break;
                    }

                    $str = '';
                    for ($i=0; $i < $length; $i++) {
                        $str .= substr($pool, mt_rand(0, strlen($pool) -1), 1);
                    }

                    return $str;
                break;

            case 'unique':
                return md5(uniqid(mt_rand()));
            break;

            case 'sha1' :
                return sha1(uniqid(mt_rand(), true));
            break;
        }
    }

    /**
     * Add's _1 to a string or increment the ending number to allow _2, _3, etc
     *
     *  <code>
     *      $str = Text::increment($str);
     *  </code>
     *
     * @param  string  $str       String to increment
     * @param  integer $first     Start with
     * @param  string  $separator Separator
     * @return string
     */
    public static function increment($str, $first = 1, $separator = '_')
    {
        preg_match('/(.+)'.$separator.'([0-9]+)$/', $str, $match);

        return isset($match[2]) ? $match[1].$separator.($match[2] + 1) : $str.$separator.$first;
    }


    /**
     * Cut string
     *
     *  <code>
     *      echo Text::cut('Some text here', 5);
     *  </code>
     *
     * @param  string  $str     Input string
     * @param  integer $length  Length after cut
     * @param  string  $cut_msg Message after cut string
     * @return string
     */
    public static function cut($str, $length, $cut_msg = null)
    {
        // Redefine vars
        $str 	= (string) $str;
        $length = (int) $length;

        if (isset($cut_msg)) $msg = $cut_msg; else $msg = '...';
        return function_exists('mb_substr') ? mb_substr($str, 0, $length, 'utf-8') . $msg : substr($str, 0, $length) . $msg;
    }


    /**
     * Lowercase
     *
     *  <code>
     *      echo Text::lowercase('Some text here');
     *  </code>
     *
     * @param  string $str String
     * @return string
     */
    public static function lowercase($str)
    {
        // Redefine vars
        $str = (string) $str;

        return function_exists('mb_strtolower') ? mb_strtolower($str, 'utf-8') : strtolower($str);
    }


    /**
     * Uppercase
     *
     *  <code>
     *      echo Text::uppercase('some text here');
     *  </code>
     *
     * @param  string $str String
     * @return string
     */
    public static function uppercase($str)
    {
        // Redefine vars
        $str = (string) $str;

        return function_exists('mb_strtoupper') ? mb_strtoupper($str, 'utf-8') : strtoupper($str);
    }


    /**
     * Get length
     *
     *  <code>
     *      echo Text::length('Some text here');
     *  </code>
     *
     * @param  string $str String
     * @return string
     */
    public static function length($str)
    {
        // Redefine vars
        $str = (string) $str;

        return function_exists('mb_strlen') ? mb_strlen($str, 'utf-8') : strlen($str);
    }


    /**
     * Create a lorem ipsum text
     *
     *  <code>
     *      echo Text::lorem(2);
     *  </code>
     *
     * @param  integer $num Count
     * @return string
     */
    public static function lorem($num = 1)
    {
        // Redefine vars
        $num = (int) $num;

        return str_repeat('Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.', (int) $num);
    }


    /**
     * Extract the last `$num` characters from a string.
     *
     *  <code>
     *      echo Text::right('Some text here', 4);
     *  </code>
     *
     * @param  string  $str The string to extract the characters from.
     * @param  integer $num The number of characters to extract.
     * @return string
     */
    public static function right($str, $num)
    {
        // Redefine vars
        $str = (string) $str;
        $num = (int) $num;

        return substr($str, Text::length($str)-$num, $num);
    }


    /**
     * Extract the first `$num` characters from a string.
     *
     *  <code>
     *      echo Text::left('Some text here', 4);
     *  </code>
     *
     * @param  string  $str The string to extract the characters from.
     * @param  integer $num The number of characters to extract.
     * @return string
     */
    public static function left($str, $num)
    {
        // Redefine vars
        $str = (string) $str;
        $num = (int) $num;

        return substr($str, 0, $num);
    }


    /**
     * Replaces newline with <br> or <br />.
     *
     *  <code>
     *      echo Text::nl2br("Some \n text \n here");
     *  </code>
     *
     * @param  string  $str   The input string
     * @param  boolean $xhtml Xhtml or not
     * @return string
     */
    public static function nl2br($str, $xhtml = true)
    {
        // Redefine vars
        $str   = (string) $str;
        $xhtml = (bool) $xhtml;

        return str_replace(array("\r\n", "\n\r", "\n", "\r"), (($xhtml) ? '<br />' : '<br>'), $str);
    }


    /**
     * Replaces <br> and <br /> with newline.
     *
     *  <code>
     *      echo Text::br2nl("Some <br /> text <br /> here");
     *  </code>
     *
     * @param  string $str The input string
     * @return string
     */
    public static function br2nl($str)
    {
        // Redefine vars
        $str = (string) $str;

        return str_replace(array('<br>', '<br/>', '<br />'), "\n", $str);
    }


    /**
     * Converts & to &amp;.
     *
     *  <code>
     *      echo Text::ampEncode("M&CMS");
     *  </code>
     *
     * @param  string $str The input string
     * @return string
     */
    public static function ampEncode($str)
    {
        // Redefine vars
        $str = (string) $str;

        return str_replace('&', '&amp;', $str);
    }


    /**
     * Converts &amp; to &.
     *
     *  <code>
     *      echo Text::ampEncode("M&amp;CMS");
     *  </code>
     *
     * @param  string $str The input string
     * @return string
     */
    public static function ampDecode($str)
    {
        // Redefine vars
        $str = (string) $str;

        return str_replace('&amp;', '&', $str);
    }


    /**
     * Convert plain text to html
     *
     *	<code>
     *  	echo Text::toHtml('test');
     * 	</code>
     *
     * @param  string $str String
     * @return string
     */
    public static function toHtml($str)
    {
        // Redefine vars
        $str = (string) $str;

        return html_entity_decode($str, ENT_QUOTES, 'utf-8');
    }

}
