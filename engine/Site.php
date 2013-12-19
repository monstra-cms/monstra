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

class Site
{
    /**
     * An instance of the Site class
     *
     * @var site
     */
    protected static $instance = null;

    /**
     * Initializing site
     *
     * @return Site
     */
    public static function init()
    {
        if ( ! isset(self::$instance)) self::$instance = new Site();
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
    protected function __construct()
    {
        call_user_func(ucfirst(Uri::command()).'::main');
    }

    /**
     * Get site name
     *
     *  <code>
     *      echo Site::name();
     *  </code>
     *
     * @return string
     */
    public static function name()
    {
        return Option::get('sitename');
    }

    /**
     * Get site theme
     *
     *  <code>
     *      echo Site::theme();
     *  </code>
     *
     * @return string
     */
    public static function theme()
    {
        return Option::get('theme_site_name');
    }

    /**
     * Get Page title
     *
     *  <code>
     *      echo Site::title();
     *  </code>
     *
     * @return string
     */
    public static function title()
    {
        return call_user_func(ucfirst(Uri::command()).'::title');
    }

    /**
     * Get page description
     *
     *  <code>
     *      echo Site::description();
     *  </code>
     *
     * @return string
     */
    public static function description()
    {
        return (($description = trim(call_user_func(ucfirst(Uri::command()).'::description'))) == '') ? Html::toText(Option::get('description')) : Html::toText($description);
    }

    /**
     * Get page keywords
     *
     *  <code>
     *      echo Site::keywords();
     *  </code>
     *
     * @return string
     */
    public static function keywords()
    {
        return (($keywords = trim(call_user_func(ucfirst(Uri::command()).'::keywords'))) == '') ? Html::toText(Option::get('keywords')) : Html::toText($keywords);
    }

    /**
     * Get site slogan
     *
     *  <code>
     *      echo Site::slogan();
     *  </code>
     *
     * @return string
     */
    public static function slogan()
    {
        return Option::get('slogan');
    }

    /**
     * Get page content
     *
     *  <code>
     *      echo Site::content();
     *  </code>
     *
     * @return string
     */
    public static function content()
    {
        return Filter::apply('content', call_user_func(ucfirst(Uri::command()).'::content'));
    }

    /**
     * Get compressed template
     *
     *  <code>
     *      echo Site::template();
     *  </code>
     *
     * @param  string $theme Theme name
     * @return mixed
     */
    public static function template($theme = null)
    {
        // Get specific theme or current theme
        $current_theme = ($theme == null) ? Option::get('theme_site_name') : $theme ;

        // Get template
        $template = call_user_func(ucfirst(Uri::command()).'::template');

        // Check whether is there such a template in the current theme
        // else return default template: index
        // also compress template file :)
        if (File::exists(THEMES_SITE . DS . $current_theme . DS . $template . '.template.php')) {
            if ( ! file_exists(MINIFY . DS . 'theme.' . $current_theme . '.minify.' . $template . '.template.php') or
                filemtime(THEMES_SITE . DS . $current_theme . DS . $template .'.template.php') > filemtime(MINIFY . DS . 'theme.' . $current_theme . '.minify.' . $template . '.template.php')) {
                    $buffer = file_get_contents(THEMES_SITE. DS . $current_theme . DS . $template .'.template.php');
                    $buffer = MinifyHTML::process($buffer);
                    file_put_contents(MINIFY . DS . 'theme.' . $current_theme . '.minify.' . $template . '.template.php', $buffer);
            }

            return 'minify.'.$template;
        } else {
            if ( ! File::exists(MINIFY . DS . 'theme.' . $current_theme . '.' . 'minify.index.template.php') or
                filemtime(THEMES_SITE . DS . $current_theme . DS . 'index.template.php') > filemtime(MINIFY . DS . 'theme.' . $current_theme . '.' . 'minify.index.template.php')) {
                    $buffer = file_get_contents(THEMES_SITE . DS . $current_theme . DS . 'index.template.php');
                    $buffer = MinifyHTML::process($buffer);
                    file_put_contents(MINIFY . DS . 'theme.' . $current_theme . '.' . 'minify.index.template.php', $buffer);
            }

            return 'minify.index';
        }
    }

    /**
     * Get site url
     *
     *  <code>
     *      echo Site::url();
     *  </code>
     *
     * @return string
     */
    public static function url()
    {
        return Option::get('siteurl');
    }

    /**
     * Get copyright information
     *
     *  <code>
     *      echo Site::powered();
     *  </code>
     *
     * @return string
     */
    public static function powered()
    {
        return __('Powered by', 'system').' <a href="http://monstra.org" target="_blank">Monstra</a> ' . Monstra::VERSION;
    }

}
