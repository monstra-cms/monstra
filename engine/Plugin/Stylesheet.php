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

class Stylesheet
{
    /**
     * Stylesheets
     *
     * @var array
     */
    public static $stylesheets = array();

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
     * Add stylesheet
     *
     *  <code>
     *      Stylesheet::add('path/to/my/stylesheet1.css');
     *      Stylesheet::add('path/to/my/stylesheet2.css', 'frontend', 11);
     *      Stylesheet::add('path/to/my/stylesheet3.css', 'backend',12);
     *  <code>
     *
     * @param string  $file     File path
     * @param string  $load     Load stylesheet on frontend, backend or both
     * @param integer $priority Priority. Default is 10
     */
    public static function add($file, $load = 'frontend', $priority = 10)
    {
        Stylesheet::$stylesheets[] = array(
            'file'     => (string) $file,
            'load'     => (string) $load,
            'priority' => (int) $priority,
        );
    }

    /**
     *  Minify, combine and load site stylesheet
     */
    public static function load()
    {
        $backend_site_css_path  = MINIFY . DS . 'backend_site.minify.css';
        $frontend_site_css_path = MINIFY . DS . 'frontend_site.minify.css';

        // Load stylesheets
        if (count(Stylesheet::$stylesheets) > 0) {

            $backend_buffer = '';
            $backend_regenerate = false;

            $frontend_buffer = '';
            $frontend_regenerate = false;

            // Sort stylesheets by priority
            $stylesheets = Arr::subvalSort(Stylesheet::$stylesheets, 'priority');

            if (BACKEND) {

                // Build backend site stylesheets
                foreach ($stylesheets as $stylesheet) {
                    if ((file_exists(ROOT . DS . $stylesheet['file'])) and (($stylesheet['load'] == 'backend') or ($stylesheet['load'] == 'both')) ) {
                        if ( ! file_exists($backend_site_css_path) or filemtime(ROOT . DS . $stylesheet['file']) > filemtime($backend_site_css_path)) {
                            $backend_regenerate = true;
                            break;
                        }
                    }
                }

                // Regenerate site stylesheet
                if ($backend_regenerate) {
                    foreach ($stylesheets as $stylesheet) {
                        if ((file_exists(ROOT . DS . $stylesheet['file'])) and (($stylesheet['load'] == 'backend') or ($stylesheet['load'] == 'both')) ) {
                            $backend_buffer .= file_get_contents(ROOT . DS . $stylesheet['file']);
                        }
                    }
                    $backend_buffer = Stylesheet::parseVariables($backend_buffer);
                    file_put_contents($backend_site_css_path, MinifyCSS::process($backend_buffer));
                    $backend_regenerate = false;
                }

            } else {

                // Build frontend site stylesheets
                foreach ($stylesheets as $stylesheet) {
                    if ((file_exists(ROOT . DS . $stylesheet['file'])) and (($stylesheet['load'] == 'frontend') or ($stylesheet['load'] == 'both')) ) {
                        if ( ! file_exists($frontend_site_css_path) or filemtime(ROOT . DS . $stylesheet['file']) > filemtime($frontend_site_css_path)) {
                            $frontend_regenerate = true;
                            break;
                        }
                    }
                }

                // Regenerate site stylesheet
                if ($frontend_regenerate) {
                    foreach ($stylesheets as $stylesheet) {
                        if ((file_exists(ROOT . DS . $stylesheet['file'])) and (($stylesheet['load'] == 'frontend') or ($stylesheet['load'] == 'both')) ) {
                            $frontend_buffer .= file_get_contents(ROOT . DS . $stylesheet['file']);
                        }
                    }
                    $frontend_buffer = Stylesheet::parseVariables($frontend_buffer);
                    file_put_contents($frontend_site_css_path, MinifyCSS::process($frontend_buffer));
                    $frontend_regenerate = false;
                }

            }

            // Render
            if (BACKEND) {
                echo '<link rel="stylesheet" href="'.Option::get('siteurl').'tmp/minify/backend_site.minify.css'.'" type="text/css" />';
            } else {
                echo '<link rel="stylesheet" href="'.Option::get('siteurl').'tmp/minify/frontend_site.minify.css'.'" type="text/css" />'."\n";
            }
        }
    }

    /**
     * CSS Parser
     */
    public static function parseVariables($frontend_buffer)
    {
        return str_replace(array('@site_url',
                                 '@theme_site_url',
                                 '@theme_admin_url'),
                           array(Option::get('siteurl'),
                                 Option::get('siteurl').'public/themes/'.Option::get('theme_site_name'),
                                 Option::get('siteurl').'admin/themes/'.Option::get('theme_admin_name')),
                           $frontend_buffer);
    }

}
