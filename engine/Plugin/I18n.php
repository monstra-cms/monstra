<?php defined('MONSTRA_ACCESS') or die('No direct script access.');

/**
 * Monstra Engine
 *
 * This source file is part of the Monstra Engine. More information,
 * documentation and tutorials can be found at http://monstra.org
 *
 * @package     Monstra
 *
 * @author      Romanenko Sergey / Awilum <awilum@msn.com>
 * @copyright   2012-2014 Romanenko Sergey / Awilum <awilum@msn.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

class I18n
{
    /**
     * Locales array
     *
     * @var array
     */
    public static $locales = array(
        'ar' => 'العربية',
        'bg' => 'Български',
        'ca' => 'Català',
        'cs' => 'Česky',
        'da' => 'Dansk',
        'de' => 'Deutsch',
        'el' => 'Ελληνικά',
        'en' => 'English',
        'es' => 'Español',
        'fa' => 'Farsi',
        'fi' => 'Suomi',
        'fr' => 'Français',
        'gl' => 'Galego',
        'hu' => 'Magyar',
        'it' => 'Italiano',
        'ja' => '日本語',
        'lt' => 'Lietuvių',
        'nl' => 'Nederlands',
        'no' => 'Norsk',
        'pl' => 'Polski',
        'pt' => 'Português',
        'pt-br' => 'Português do Brasil',
        'ru' => 'Русский',
        'sk' => 'Slovenčina',
        'sl' => 'Slovenščina',
        'sv' => 'Svenska',
        'sr-yu' => 'Serbian',
        'tr' => 'Türkçe',
        'uk' => 'Українська',
        'zh' => '中文',
    );

    /**
     * Dictionary
     *
     * @var array
     */
    public static $dictionary = array();

    /**
     * An instance of the I18n class
     *
     * @var I18n
     */
    protected static $instance = null;

    /**
     * Initializing I18n
     *
     * @param string $dir Plugins directory
     */
    public static function init($locale)
    {
        if ( ! isset(self::$instance)) self::$instance = new I18n($locale);
        return self::$instance;
    }

    /**
     * Protected clone method to enforce singleton behavior.
     *
     * @access  protected
     */
    protected function __clone()
    {
        // Nothing here.
    }

    /**
     * Construct
     */
    protected function __construct($locale)
    {
        // Redefine arguments
        $locale = (string) $locale;

        // Get lang table for current locale
        $lang_table = Cache::get('i18n', $locale);

        // If lang_table is empty then create new
        if (! $lang_table) {

            // Get plugins Table
            $plugins = new Table('plugins');

            // Get all plugins
            $records = $plugins->select(null, 'all', null, array('location', 'priority'), 'priority', 'ASC');

            // Init var
            $lang_table = array();

            // Loop through each installed plugin
            foreach ($records as $record) {

                if (is_dir(ROOT . DS . dirname($record['location']) . DS . 'languages')) {

                    // Init var
                    $t = array();

                    // Check lang file
                    if (file_exists(ROOT . DS . dirname($record['location']) . DS . 'languages' . DS . $locale . '.lang.php')) {

                        // Merge the language strings into the sub table
                        $t = array_merge($t, include ROOT . DS . dirname($record['location']) . DS . 'languages' . DS . $locale . '.lang.php');

                    }

                    // Append the sub table, preventing less specific language files from overloading more specific files
                    $lang_table += $t;
                }
            }

            // Save lang table for current locale
            Cache::put('i18n', $locale, $lang_table);

            // Update dictionary
            I18n::$dictionary = $lang_table;
        }

        // Update dictionary
        I18n::$dictionary = $lang_table;
    }

    /**
     * Returns translation of a string. If no translation exists, the original
     * string will be returned. No parameters are replaced.
     *
     *  <code>
     *      $hello = I18n::find('Hello friends, my name is :name', 'namespace');
     *  <code>
     *
     * @param  string $string    Text to translate
     * @param  string $namespace Namespace
     * @return string
     */
    public static function find($string, $namespace = null)
    {
        // Redefine arguments
        $string = (string) $string;

        // Return string
        if (isset(I18n::$dictionary[$namespace][$string])) return I18n::$dictionary[$namespace][$string]; else return $string;
    }

}

/**
 * Global Translation/internationalization function.
 * Accepts an English string and returns its translation
 * to the active system language. If the given string is not available in the
 * current dictionary the original English string will be returned.
 *
 *  <code>
 *      // Display a translated message
 *      echo __('Hello, world', 'namespace');
 *
 *      // With parameter replacement
 *      echo __('Hello, :user', 'namespace', array(':user' => $username));
 *  </code>
 *
 * @global array  $dictionary Dictionary
 * @param  string $string    String to translate
 * @param  array  $values    Values to replace in the translated text
 * @param  string $namespace Namespace
 * @return string
 */
function __($string, $namespace = null, array $values = null)
{
    // Redefine arguments
    $string = (string) $string;

    // Find string in dictionary
    $string = I18n::find($string, $namespace);

    // Return string
    return empty($values) ? $string : strtr($string, $values);
}
