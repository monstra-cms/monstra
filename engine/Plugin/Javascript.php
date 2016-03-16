<?php defined('MONSTRA_ACCESS') or die('No direct script access.');

/**
 * Monstra
 *
 * @package Monstra
 * @author Romanenko Sergey / Awilum <awilum@msn.com>
 * @link http://monstra.org
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */


class Javascript
{
    /**
     * Javascripts
     *
     * @var array
     */
    public static $javascripts = array();

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
     * Add javascript
     *
     *  <code>
     *      Javascript::add('path/to/my/script1.js');
     *      Javascript::add('path/to/my/script2.js', 'frontend', 11);
     *      Javascript::add('path/to/my/script3.js', 'backend', 12);
     *  <code>
     *
     * @param string  $file     File path
     * @param string  $load     Load script on frontend, backend or both
     * @param inteeer $priority Priority default is 10
     */
    public static function add($file, $load = 'frontend', $priority = 10)
    {
        Javascript::$javascripts[] = array(
            'file'     => (string) $file,
            'load'     => (string) $load,
            'priority' => (int) $priority,
        );
    }

    /**
     *  Combine and load site javascript
     */
    public static function load()
    {
        $backend_site_js_path  = MINIFY . DS . 'backend_site.minify.js';
        $frontend_site_js_path = MINIFY . DS . 'frontend_site.minify.'.Option::get('javascript_version').'.js';

        // Load javascripts
        if (count(Javascript::$javascripts) > 0) {
            $backend_buffer = '';
            $backend_regenerate = false;

            $frontend_buffer = '';
            $frontend_regenerate = false;

            // Sort javascripts by priority
            $javascripts = Arr::subvalSort(Javascript::$javascripts, 'priority');

            if (BACKEND) {

                // Build backend site javascript
                foreach ($javascripts as $javascript) {
                    if ((file_exists(ROOT . DS . $javascript['file'])) and (($javascript['load'] == 'backend') or ($javascript['load'] == 'both'))) {
                        if (! file_exists($backend_site_js_path) or filemtime(ROOT . DS . $javascript['file']) > filemtime($backend_site_js_path)) {
                            $backend_regenerate = true;
                            break;
                        }
                    }
                }

                // Regenerate site javascript
                if ($backend_regenerate) {
                    foreach ($javascripts as $javascript) {
                        if ((file_exists(ROOT . DS . $javascript['file'])) and (($javascript['load'] == 'backend') or ($javascript['load'] == 'both'))) {
                            $backend_buffer .= file_get_contents(ROOT . DS . $javascript['file'])."\n";
                        }
                    }
                    file_put_contents($backend_site_js_path, $backend_buffer);
                    $backend_regenerate = false;
                }
            } else {

                // Build frontend site javascript
                foreach ($javascripts as $javascript) {
                    if ((file_exists(ROOT . DS . $javascript['file'])) and (($javascript['load'] == 'frontend') or ($javascript['load'] == 'both'))) {
                        if (! file_exists($frontend_site_js_path) or filemtime(ROOT . DS . $javascript['file']) > filemtime($frontend_site_js_path)) {
                            $frontend_regenerate = true;
                            break;
                        }
                    }
                }

                // Regenerate site javascript
                if ($frontend_regenerate) {
                    foreach ($javascripts as $javascript) {
                        if ((file_exists(ROOT . DS . $javascript['file'])) and (($javascript['load'] == 'frontend') or ($javascript['load'] == 'both'))) {
                            $frontend_buffer .= file_get_contents(ROOT . DS . $javascript['file'])."\n";
                        }
                    }
                    file_put_contents($frontend_site_js_path, $frontend_buffer);
                    $frontend_regenerate = false;
                }
            }

            // Render
            if (BACKEND) {
                echo '<script type="text/javascript" src="'.Option::get('siteurl').'/tmp/minify/backend_site.minify.js?'.Option::get('javascript_version').'"></script>';
            } else {
                echo '<script type="text/javascript" src="'.Option::get('siteurl').'/tmp/minify/frontend_site.minify.'.Option::get('javascript_version').'.js"></script>'."\n";
            }
        }
    }

    /**
     *  javascriptVersionIncrement
     */
    public static function javascriptVersionIncrement()
    {
        Option::update('javascript_version', (int) Option::get('javascript_version') + 1);
    }
}
