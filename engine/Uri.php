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


class Uri
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
     * Default component
     *
     * @var string
     */
    public static $default_component = 'pages';

    /**
     *	Get uri and explode command/param1/param2
     *
     *  <code>
     *      $segments = Uri::segments();
     *  </code>
     *
     *  @return array
     */
    public static function segments()
    {
        // Get request uri and current script path
        $request_uri = explode('/', $_SERVER['REQUEST_URI']);
        $script_name = explode('/', $_SERVER['SCRIPT_NAME']);

        // Delete script name
        for ($i = 0; $i < sizeof($script_name); $i++) {
            if ($request_uri[$i] == $script_name[$i]) {
                unset($request_uri[$i]);
            }
        }

        // Get all the values of an array
        $uri = array_values($request_uri);

        // Ability to pass parameters
        foreach ($uri as $i => $u) {
            if (isset($uri[$i])) {
                $pos = strrpos($uri[$i], "?");
                if ($pos === false) {
                    $uri[$i] = Security::sanitizeURL($uri[$i]);
                } else {
                    $uri[$i] = Security::sanitizeURL(substr($uri[$i], 0, $pos));
                }
            }
        }

        // Return uri segments
        return $uri;
    }

    /**
     *  Get uri segment
     *
     *  <code>
     *      $segment = Uri::segment(1);
     *  </code>
     *
     *  @param  integer $segment Segment
     *  @return mixed
     */
    public static function segment($segment)
    {
        $segments = Uri::segments();

        return isset($segments[$segment]) ? $segments[$segment] : null;
    }

    /**
     *	Get command/component from registed components
     *
     *  <code>
     *      $command = Uri::command();
     *  </code>
     *
     *  @return array
     */
    public static function command()
    {
        // Get uri segments
        $uri = Uri::segments();

        if (! isset($uri[0])) {
            $uri[0] = Uri::$default_component;
        } else {
            if (! in_array($uri[0], Plugin::$components)) {
                $uri[0] = Uri::$default_component;
            } else {
                $uri[0] = $uri[0];
            }
        }

        return $uri[0];
    }

    /**
     *	Get uri parammeters
     *
     *  <code>
     *      $params = Uri::params();
     *  </code>
     *
     *  @return array
     */
    public static function params()
    {
        //Init data array
        $data = array();

        // Get URI
        $uri = Uri::segments();

        // http://site.com/ and http://site.com/index.php same main home pages
        if (! isset($uri[0])) {
            $uri[0] = '';
        }

        // param1/param2
        if ($uri[0] !== Uri::$default_component) {
            if (isset($uri[1])) {
                foreach ($uri as $part) {
                    $data[] = $part;
                }
            } else { // default
                $data[0] = $uri[0];
            }
        } else {
            // This is good for box plugin Pages
            // parent/child
            if (isset($uri[2])) {
                $data[0] = $uri[1];
                $data[1] = $uri[2];
            } else { // default
                $data[0] = $uri[1];
            }
        }

        return $data;
    }
}
