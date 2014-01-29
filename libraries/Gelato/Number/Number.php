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

class Number
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
     * Convert bytes in 'KB','MB','GB','TiB','PiB'
     *
     *  <code>
     *      echo Number::byteFormat(10000);
     *  </code>
     *
     * @param  integer $size Data to convert
     * @return string
     */
    public static function byteFormat($size)
    {
        // Redefine vars
        $size = (int) $size;

        $unit = array('B', 'KB', 'MB', 'GB', 'TiB', 'PiB');

        return @round($size/pow(1024, ($i=floor(log($size, 1024)))), 2).' '.$unit[($i < 0 ? 0 : $i)];
    }

    /**
     * Convert 'KB','MB','GB' in bytes
     *
     *  <code>
     *      echo Number::convertToBytes('10MB');
     *  </code>
     *
     * @param  string $num Number to convert
     * @return int
     */
    public static function convertToBytes( $num ) {
        $num  = strtolower( $num );
        $bytes = (int) $num;
        if ( strpos( $num, 'k' ) !== false )
            $bytes = intval( $num ) * 1024;
        elseif ( strpos( $num, 'm' ) !== false )
            $bytes = intval($num) * 1024 * 1024;
        elseif ( strpos( $num, 'g' ) !== false )
            $bytes = intval( $num ) * 1024 * 1024 * 1024;
        return $bytes;
    }

    /**
     * Converts a number into a more readable human-type number.
     *
     *  <code>
     *      echo Number::quantity(7000); // 7K
     *      echo Number::quantity(7500); // 8K
     *      echo Number::quantity(7500, 1); // 7.5K
     *  </code>
     *
     * @param  integer $num      Num to convert
     * @param  integer $decimals Decimals
     * @return string
     */
    public static function quantity($num, $decimals = 0)
    {
        // Redefine vars
        $num      = (int) $num;
        $decimals = (int) $decimals;

        if ($num >= 1000 && $num < 1000000) {
            return sprintf('%01.'.$decimals.'f', (sprintf('%01.0f', $num) / 1000)).'K';
        } elseif ($num >= 1000000 && $num < 1000000000) {
            return sprintf('%01.'.$decimals.'f', (sprintf('%01.0f', $num) / 1000000)).'M';
        } elseif ($num >= 1000000000) {
            return sprintf('%01.'.$decimals.'f', (sprintf('%01.0f', $num) / 1000000000)).'B';
        }

        return $num;
    }

    /**
     * Checks if the value is between the minimum and maximum (min & max included).
     *
     *  <code>
     *      if (Number::between(2, 10, 5)) {
     *          // do something...
     *      }
     *  </code>
     *
     * @param  float   $minimum The minimum.
     * @param  float   $maximum The maximum.
     * @param  float   $value   The value to validate.
     * @return boolean
     */
    public static function between($minimum, $maximum, $value)
    {
        return ((float) $value >= (float) $minimum && (float) $value <= (float) $maximum);
    }

    /**
     * Checks the value for an even number.
     *
     *  <code>
     *      if (Number::even(2)) {
     *          // do something...
     *      }
     *  </code>
     *
     * @param  integer $value The value to validate.
     * @return boolean
     */
    public static function even($value)
    {
        return (((int) $value % 2) == 0);
    }

    /**
     * Checks if the value is greather than a given minimum.
     *
     *  <code>
     *      if (Number::greaterThan(2, 10)) {
     *          // do something...
     *      }
     *  </code>
     *
     * @param  float   $minimum The minimum as a float.
     * @param  float   $value   The value to validate.
     * @return boolean
     */
    public static function greaterThan($minimum, $value)
    {
        return ((float) $value > (float) $minimum);
    }

    /**
     * Checks if the value is smaller than a given maximum.
     *
     *  <code>
     *      if (Number::smallerThan(2, 10)) {
     *          // do something...
     *      }
     *  </code>
     *
     * @param  integer $maximum The maximum.
     * @param  integer $value   The value to validate.
     * @return boolean
     */
    public static function smallerThan($maximum, $value)
    {
        return ((int) $value < (int) $maximum);
    }

    /**
     * Checks if the value is not greater than or equal a given maximum.
     *
     *  <code>
     *      if (Number::maximum(2, 10)) {
     *          // do something...
     *      }
     *  </code>
     *
     * @param  integer $maximum The maximum.
     * @param  integer $value   The value to validate.
     * @return boolean
     */
    public static function maximum($maximum, $value)
    {
        return ((int) $value <= (int) $maximum);
    }

    /**
     * Checks if the value is greater than or equal to a given minimum.
     *
     *  <code>
     *      if (Number::minimum(2, 10)) {
     *          // do something...
     *      }
     *  </code>
     *
     * @param  integer $minimum The minimum.
     * @param  integer $value   The value to validate.
     * @return boolean
     */
    public static function minimum($minimum, $value)
    {
        return ((int) $value >= (int) $minimum);
    }

    /**
     * Checks the value for an odd number.
     *
     *  <code>
     *      if (Number::odd(2)) {
     *          // do something...
     *      }
     *  </code>
     *
     * @param  integer $value The value to validate.
     * @return boolean
     */
    public static function odd($value)
    {
        return ! Number::even((int) $value);
    }

}
