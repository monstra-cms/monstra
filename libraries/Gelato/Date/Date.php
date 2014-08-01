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

class Date
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
     * Get format date
     *
     *  <code>
     *      echo Date::format($date, 'j.n.Y');
     *  </code>
     *
     * @param  integer $date   Unix timestamp
     * @param  string  $format Date format
     * @return integer
     */
    public static function format($date, $format = 'j.n.Y')
    {
        // Redefine vars
        $format = (string) $format;
        $date   = (int) $date;

        return date($format, $date);
    }

    /**
     * Get number of seconds in a minute, incrementing by a step.
     *
     *  <code>
     *      $seconds = Date::seconds();
     *  </code>
     *
     * @param  integer $step  Amount to increment each step by, 1 to 30
     * @param  integer $start Start value
     * @param  integer $end   End value
     * @return array
     */
    public static function seconds($step = 1, $start = 0, $end = 60)
    {
        // Redefine vars
        $step  = (int) $step;
        $start = (int) $start;
        $end   = (int) $end;

        return Date::_range($step, $start, $end);
    }

    /**
     * Get number of minutes in a hour, incrementing by a step.
     *
     *  <code>
     *      $minutes = Date::minutes();
     *  </code>
     *
     * @param  integer $step  Amount to increment each step by, 1 to 30
     * @param  integer $start Start value
     * @param  integer $end   End value
     * @return array
     */
    public static function minutes($step = 5, $start = 0, $end = 60)
    {
        // Redefine vars
        $step  = (int) $step;
        $start = (int) $start;
        $end   = (int) $end;

        return Date::_range($step, $start, $end);
    }

    /**
     * Get number of hours, incrementing by a step.
     *
     *  <code>
     *      $hours = Date::hours();
     *  </code>
     *
     * @param  integer $step  Amount to increment each step by, 1 to 30
     * @param  integer $long  Start value
     * @param  integer $start End value
     * @return array
     */
    public static function hours($step = 1, $long = false, $start = null)
    {
        // Redefine vars
        $step  = (int) $step;
        $long  = (bool) $long;

        if ($start === null) $start = ($long === FALSE) ? 1 : 0;
        $end = ($long === true) ? 23 : 12;

        return Date::_range($step, $start, $end, true);
    }

    /**
     * Get number of months.
     *
     *  <code>
     *      $months = Date::months();
     *  </code>
     *
     * @return array
     */
    public static function months()
    {
        return Date::_range(1, 1, 12, true);
    }

    /**
     * Get number of days.
     *
     *  <code>
     *      $months = Date::days();
     *  </code>
     *
     * @return array
     */
    public static function days()
    {
        return Date::_range(1, 1, Date::daysInMonth((int) date('M')), true);
    }

    /**
     * Returns the number of days in the requested month
     *
     *  <code>
     *      $days = Date::daysInMonth(1);
     *  </code>
     *
     * @param  integer $month Month as a number (1-12)
     * @param  integer $year  The year
     * @return integer
     */
    public static function daysInMonth($month, $year = null)
    {
        // Redefine vars
        $month = (int) $month;
        $year   = ! empty($year) ? (int) $year : (int) date('Y');

        if ($month < 1 or $month > 12) {
            return false;
        } elseif ($month == 2) {
            if ($year % 400 == 0 or ($year % 4 == 0 and $year % 100 != 0)) {
                return 29;
            }
        }

        $days_in_month = array(31, 28, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31);

        return $days_in_month[$month-1];
    }

    /**
     * Get number of years.
     *
     *  <code>
     *      $years = Date::years();
     *  </code>
     *
     * @param  integer $long  Start value
     * @param  integer $start End value
     * @return array
     */
    public static function years($start = 1980, $end = 2024)
    {
        // Redefine vars
        $start = (int) $start;
        $end   = (int) $end;

        return Date::_range(1, $start, $end, true);
    }

    /**
     * Get current season name
     *
     *  <code>
     *      echo Date::season();
     *  </code>
     *
     * @return string
     */
    public static function season()
    {
        $seasons = array("Winter", "Spring", "Summer", "Autumn");

        return $seasons[(int) ((date("n") %12)/3)];
    }

    /**
     * Get today date
     *
     *  <code>
     *      echo Date::today();
     *  </code>
     *
     * @param  string $format Date format
     * @return string
     */
    public static function today($format = '')
    {
        // Redefine vars
        $format = (string) $format;

        if ($format != '') { return date($format); } else { return date(MONSTRA_DATE_FORMAT); }
    }

    /**
     * Get yesterday date
     *
     *  <code>
     *      echo Date::yesterday();
     *  </code>
     *
     * @param  string $format Date format
     * @return string
     */
    public static function yesterday($format = '')
    {
        // Redefine vars
        $format = (string) $format;

        if ($format != '') { return date($format, strtotime("-1 day")); } else { return date(MONSTRA_DATE_FORMAT, strtotime("-1 day")); }
    }

    /**
     * Get tomorrow date
     *
     *  <code>
     *      echo Date::tomorrow();
     *  </code>
     *
     * @param  string $format Date format
     * @return string
     */
    public static function tomorrow($format = '')
    {
        // Redefine vars
        $format = (string) $format;

        if ($format != '') { return date($format, strtotime("+1 day")); } else { return date(MONSTRA_DATE_FORMAT, strtotime("-1 day")); }
    }

    /**
     * Converts a UNIX timestamp to DOS format.
     *
     *  <code>
     *      $dos = Date::unix2dos($unix);
     *  </code>
     *
     * @param  integer $timestamp UNIX timestamp
     * @return integer
     */
    public static function unix2dos($timestamp = 0)
    {
        $timestamp = ($_timestamp == 0) ? getdate() : getdate($_timestamp);

        if ($timestamp['year'] < 1980) return (1 << 21 | 1 << 16);

        $timestamp['year'] -= 1980;

        return ($timestamp['year']    << 25 | $timestamp['mon']     << 21 |
                $timestamp['mday']    << 16 | $timestamp['hours']   << 11 |
                $timestamp['minutes'] << 5  | $timestamp['seconds'] >> 1);
    }

    /**
     * Converts a DOS timestamp to UNIX format.
     *
     *  <code>
     *      $unix = Date::dos2unix($dos);
     *  </code>
     *
     * @param  integer $timestamp DOS timestamp
     * @return integer
     */
    public static function dos2unix($timestamp)
    {
        $sec  = 2 * ($timestamp & 0x1f);
        $min  =  ($timestamp >> 5) & 0x3f;
        $hrs  =  ($timestamp >> 11) & 0x1f;
        $day  =  ($timestamp >> 16) & 0x1f;
        $mon  = (($timestamp >> 21) & 0x0f);
        $year = (($timestamp >> 25) & 0x7f) + 1980;

        return mktime($hrs, $min, $sec, $mon, $day, $year);
    }

    /**
     * Get Time zones
     *
     * @return array
     */
    public static function timezones()
    {
        return array('Kwajalein'=>'(GMT-12:00) International Date Line West',
                    'Pacific/Samoa'=>'(GMT-11:00) Midway Island, Samoa',
                    'Pacific/Honolulu'=>'(GMT-10:00) Hawaii',
                    'America/Anchorage'=>'(GMT-09:00) Alaska',
                    'America/Los_Angeles'=>'(GMT-08:00) Pacific Time (US &amp; Canada)',
                    'America/Tijuana'=>'(GMT-08:00) Tijuana, Baja California',
                    'America/Denver'=>'(GMT-07:00) Mountain Time (US &amp; Canada)',
                    'America/Chihuahua'=>'(GMT-07:00) Chihuahua, La Paz, Mazatlan',
                    'America/Phoenix'=>'(GMT-07:00) Arizona',
                    'America/Regina'=>'(GMT-06:00) Saskatchewan',
                    'America/Tegucigalpa'=>'(GMT-06:00) Central America',
                    'America/Chicago'=>'(GMT-06:00) Central Time (US &amp; Canada)',
                    'America/Mexico_City'=>'(GMT-06:00) Guadalajara, Mexico City, Monterrey',
                    'America/New_York'=>'(GMT-05:00) Eastern Time (US &amp; Canada)',
                    'America/Bogota'=>'(GMT-05:00) Bogota, Lima, Quito, Rio Branco',
                    'America/Indiana/Indianapolis'=>'(GMT-05:00) Indiana (East)',
                    'America/Caracas'=>'(GMT-04:30) Caracas',
                    'America/Halifax'=>'(GMT-04:00) Atlantic Time (Canada)',
                    'America/Manaus'=>'(GMT-04:00) Manaus',
                    'America/Santiago'=>'(GMT-04:00) Santiago',
                    'America/La_Paz'=>'(GMT-04:00) La Paz',
                    'America/St_Johns'=>'(GMT-03:30) Newfoundland',
                    'America/Argentina/Buenos_Aires'=>'(GMT-03:00) Buenos Aires',
                    'America/Sao_Paulo'=>'(GMT-03:00) Brasilia',
                    'America/Godthab'=>'(GMT-03:00) Greenland',
                    'America/Montevideo'=>'(GMT-03:00) Montevideo',
                    'America/Argentina/Buenos_Aires'=>'(GMT-03:00) Georgetown',
                    'Atlantic/South_Georgia'=>'(GMT-02:00) Mid-Atlantic',
                    'Atlantic/Azores'=>'(GMT-01:00) Azores',
                    'Atlantic/Cape_Verde'=>'(GMT-01:00) Cape Verde Is.',
                    'Europe/London'=>'(GMT) Greenwich Mean Time : Dublin, Edinburgh, Lisbon, London',
                    'Atlantic/Reykjavik'=>'(GMT) Monrovia, Reykjavik',
                    'Africa/Casablanca'=>'(GMT) Casablanca',
                    'Europe/Belgrade'=>'(GMT+01:00) Belgrade, Bratislava, Budapest, Ljubljana, Prague',
                    'Europe/Sarajevo'=>'(GMT+01:00) Sarajevo, Skopje, Warsaw, Zagreb',
                    'Europe/Brussels'=>'(GMT+01:00) Brussels, Copenhagen, Madrid, Paris',
                    'Africa/Algiers'=>'(GMT+01:00) West Central Africa',
                    'Europe/Amsterdam'=>'(GMT+01:00) Amsterdam, Berlin, Bern, Rome, Stockholm, Vienna',
                    'Africa/Cairo'=>'(GMT+02:00) Cairo',
                    'Europe/Helsinki'=>'(GMT+02:00) Helsinki, Kyiv, Riga, Sofia, Tallinn, Vilnius',
                    'Europe/Athens'=>'(GMT+02:00) Athens, Bucharest, Istanbul',
                    'Asia/Jerusalem'=>'(GMT+02:00) Jerusalem',
                    'Asia/Amman'=>'(GMT+02:00) Amman',
                    'Asia/Beirut'=>'(GMT+02:00) Beirut',
                    'Africa/Windhoek'=>'(GMT+02:00) Windhoek',
                    'Africa/Harare'=>'(GMT+02:00) Harare, Pretoria',
                    'Asia/Kuwait'=>'(GMT+03:00) Kuwait, Riyadh',
                    'Asia/Baghdad'=>'(GMT+03:00) Baghdad',
                    'Europe/Minsk'=>'(GMT+03:00) Minsk',
                    'Africa/Nairobi'=>'(GMT+03:00) Nairobi',
                    'Asia/Tbilisi'=>'(GMT+03:00) Tbilisi',
                    'Asia/Tehran'=>'(GMT+03:30) Tehran',
                    'Asia/Muscat'=>'(GMT+04:00) Abu Dhabi, Muscat',
                    'Asia/Baku'=>'(GMT+04:00) Baku',
                    'Europe/Moscow'=>'(GMT+04:00) Moscow, St. Petersburg, Volgograd',
                    'Asia/Yerevan'=>'(GMT+04:00) Yerevan',
                    'Asia/Karachi'=>'(GMT+05:00) Islamabad, Karachi',
                    'Asia/Tashkent'=>'(GMT+05:00) Tashkent',
                    'Asia/Kolkata'=>'(GMT+05:30) Chennai, Kolkata, Mumbai, New Delhi',
                    'Asia/Colombo'=>'(GMT+05:30) Sri Jayawardenepura',
                    'Asia/Katmandu'=>'(GMT+05:45) Kathmandu',
                    'Asia/Dhaka'=>'(GMT+06:00) Astana, Dhaka',
                    'Asia/Yekaterinburg'=>'(GMT+06:00) Ekaterinburg',
                    'Asia/Rangoon'=>'(GMT+06:30) Yangon (Rangoon)',
                    'Asia/Novosibirsk'=>'(GMT+07:00) Almaty, Novosibirsk',
                    'Asia/Bangkok'=>'(GMT+07:00) Bangkok, Hanoi, Jakarta',
                    'Asia/Beijing'=>'(GMT+08:00) Beijing, Chongqing, Hong Kong, Urumqi',
                    'Asia/Ulaanbaatar'=>'(GMT+08:00) Irkutsk, Ulaan Bataar',
                    'Asia/Krasnoyarsk'=>'(GMT+08:00) Krasnoyarsk',
                    'Asia/Kuala_Lumpur'=>'(GMT+08:00) Kuala Lumpur, Singapore',
                    'Asia/Taipei'=>'(GMT+08:00) Taipei',
                    'Australia/Perth'=>'(GMT+08:00) Perth',
                    'Asia/Seoul'=>'(GMT+09:00) Seoul',
                    'Asia/Tokyo'=>'(GMT+09:00) Osaka, Sapporo, Tokyo',
                    'Australia/Darwin'=>'(GMT+09:30) Darwin',
                    'Australia/Adelaide'=>'(GMT+09:30) Adelaide',
                    'Australia/Sydney'=>'(GMT+10:00) Canberra, Melbourne, Sydney',
                    'Australia/Brisbane'=>'(GMT+10:00) Brisbane',
                    'Australia/Hobart'=>'(GMT+10:00) Hobart',
                    'Asia/Yakutsk'=>'(GMT+10:00) Yakutsk',
                    'Pacific/Guam'=>'(GMT+10:00) Guam, Port Moresby',
                    'Asia/Vladivostok'=>'(GMT+11:00) Vladivostok',
                    'Pacific/Fiji'=>'(GMT+12:00) Fiji, Kamchatka, Marshall Is.',
                    'Asia/Magadan'=>'(GMT+12:00) Magadan, Solomon Is., New Caledonia',
                    'Pacific/Auckland'=>'(GMT+12:00) Auckland, Wellington',
                    'Pacific/Tongatapu'=>'(GMT+13:00) Nukualofa'
                    );
    }

    /**
     * _range()
     */
    protected static function _range($step, $start, $end, $flag = false)
    {
        $result = array();
        if ($flag) {
            for ($i = $start; $i <= $end; $i += $step) $result[$i] = (string) $i;
        } else {
            for ($i = $start; $i < $end; $i += $step) $result[$i]  = sprintf('%02d', $i);
        }

        return $result;
    }

}
