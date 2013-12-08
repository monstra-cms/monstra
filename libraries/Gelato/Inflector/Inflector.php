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

class Inflector
{
    /**
     * Plural rules
     *
     * @var array
     */
    protected static $plural_rules = array(
        '/^(ox)$/'                 => '\1\2en',     // ox
        '/([m|l])ouse$/'           => '\1ice',      // mouse, louse
        '/(matr|vert|ind)ix|ex$/'  => '\1ices',     // matrix, vertex, index
        '/(x|ch|ss|sh)$/'          => '\1es',       // search, switch, fix, box, process, address
        '/([^aeiouy]|qu)y$/'       => '\1ies',      // query, ability, agency
        '/(hive)$/'                => '\1s',        // archive, hive
        '/(?:([^f])fe|([lr])f)$/'  => '\1\2ves',    // half, safe, wife
        '/sis$/'                   => 'ses',        // basis, diagnosis
        '/([ti])um$/'              => '\1a',        // datum, medium
        '/(p)erson$/'              => '\1eople',    // person, salesperson
        '/(m)an$/'                 => '\1en',       // man, woman, spokesman
        '/(c)hild$/'               => '\1hildren',  // child
        '/(buffal|tomat)o$/'       => '\1\2oes',    // buffalo, tomato
        '/(bu|campu)s$/'           => '\1\2ses',    // bus, campus
        '/(alias|status|virus)$/'  => '\1es',       // alias
        '/(octop)us$/'             => '\1i',        // octopus
        '/(ax|cris|test)is$/'      => '\1es',       // axis, crisis
        '/s$/'                     => 's',          // no change (compatibility)
        '/$/'                      => 's',
    );

    /**
     * Singular rules
     *
     * @var array
     */
    protected static $singular_rules = array(
        '/(matr)ices$/'         => '\1ix',
        '/(vert|ind)ices$/'     => '\1ex',
        '/^(ox)en/'             => '\1',
        '/(alias)es$/'          => '\1',
        '/([octop|vir])i$/'     => '\1us',
        '/(cris|ax|test)es$/'   => '\1is',
        '/(shoe)s$/'            => '\1',
        '/(o)es$/'              => '\1',
        '/(bus|campus)es$/'     => '\1',
        '/([m|l])ice$/'         => '\1ouse',
        '/(x|ch|ss|sh)es$/'     => '\1',
        '/(m)ovies$/'           => '\1\2ovie',
        '/(s)eries$/'           => '\1\2eries',
        '/([^aeiouy]|qu)ies$/'  => '\1y',
        '/([lr])ves$/'          => '\1f',
        '/(tive)s$/'            => '\1',
        '/(hive)s$/'            => '\1',
        '/([^f])ves$/'          => '\1fe',
        '/(^analy)ses$/'        => '\1sis',
        '/((a)naly|(b)a|(d)iagno|(p)arenthe|(p)rogno|(s)ynop|(t)he)ses$/' => '\1\2sis',
        '/([ti])a$/'            => '\1um',
        '/(p)eople$/'           => '\1\2erson',
        '/(m)en$/'              => '\1an',
        '/(s)tatuses$/'         => '\1\2tatus',
        '/(c)hildren$/'         => '\1\2hild',
        '/(n)ews$/'             => '\1\2ews',
        '/([^us])s$/'           => '\1',
    );

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
     * Returns a camelized string from a string using underscore syntax.
     *
     *  <code>
     *		// "some_text_here" becomes "SomeTextHere"
     *      echo Inflector::camelize('some_text_here');
     *  </code>
     *
     * @param  string $string Word to camelize.
     * @return string Camelized word.
     */
    public static function camelize($string)
    {
        // Redefine vars
        $string = (string) $string;

        return str_replace(' ', '', ucwords(str_replace('_', ' ', $string)));
    }

    /**
     * Returns a string using underscore syntax from a camelized string.
     *
     *  <code>
     *		// "SomeTextHere" becomes "some_text_here"
     *      echo Inflector::underscore('SomeTextHere');
     *  </code>
     *
     * @param  string $string CamelCased word
     * @return string Underscored version of the $string
     */
    public static function underscore($string)
    {
        // Redefine vars
        $string = (string) $string;

        return strtolower(preg_replace('/(?<=\\w)([A-Z])/', '_\\1', $string));
    }

    /**
     * Returns a humanized string from a string using underscore syntax.
     *
     *  <code>
     *		// "some_text_here" becomes "Some text here"
     *      echo Inflector::humanize('some_text_here');
     *  </code>
     *
     * @param  string $string String using underscore syntax.
     * @return string Humanized version of the $string
     */
    public static function humanize($string)
    {
        // Redefine vars
        $string = (string) $string;

        return ucfirst(strtolower(str_replace('_', ' ', $string)));
    }

    /**
     * Returns ordinalize number.
     *
     *  <code>
     *      // 1 becomes 1st
     *      echo Inflector::ordinalize(1);
     *  </code>
     *
     * @param  integer $number Number to ordinalize
     * @return string
     */
    public static function ordinalize($number)
    {
        if ( ! is_numeric($number)) {
            return $number;
        }

        if (in_array(($number % 100), range(11, 13))) {
            return $number . 'th';
        } else {
            switch ($number % 10) {
                case 1:  return $number . 'st'; break;
                case 2:  return $number . 'nd'; break;
                case 3:  return $number . 'rd'; break;
                default: return $number . 'th'; break;
            }
        }
    }

    /**
     * Returns the plural version of the given word
     *
     *  <code>
     *      echo Inflector::pluralize('cat');
     *  </code>
     *
     * @param  string $word Word to pluralize
     * @return string
     */
    public static function pluralize($word)
    {
        $result = (string) $word;

        foreach (Inflector::$plural_rules as $rule => $replacement) {
            if (preg_match($rule, $result)) {
                $result = preg_replace($rule, $replacement, $result);
                break;
            }
        }

        return $result;
    }

    /**
     * Returns the singular version of the given word
     *
     *  <code>
     *      echo Inflector::singularize('cats');
     *  </code>
     *
     * @param  string $word Word to singularize
     * @return string
     */
    public static function singularize($word)
    {
        $result = (string) $word;

        foreach (Inflector::$singular_rules as $rule => $replacement) {
            if (preg_match($rule, $result)) {
                $result = preg_replace($rule, $replacement, $result);
                break;
            }
        }

        return $result;
    }

}
