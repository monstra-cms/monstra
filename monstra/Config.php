<?php
namespace Monstra;

use Arr;
use Symfony\Component\Yaml\Yaml;

/**
 * This file is part of the Monstra.
 *
 * (c) Romanenko Sergey / Awilum <awilum@msn.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

class Config
{
    /**
     * @var Monstra
     */
    protected $monstra;

    /**
     * Config
     *
     * @var array
     * @access  protected
     */
    protected static $config = [];

    /**
     * Constructor.
     *
     * @access  protected
     */
    public function __construct(Monstra $c)
    {
        $this->monstra = $c;

        if ($this->monstra['filesystem']->exists($site_config = CONFIG_PATH . '/' . 'site.yml')) {
            self::$config['site'] = Yaml::parse(file_get_contents($site_config));
        } else {
            throw new RuntimeException("Monstra site config file does not exist.");
        }
    }

    /**
     * Set new or update existing config variable
     *
     * @access public
     * @param string $key   Key
     * @param mixed  $value Value
     */
    public function set($key, $value)
    {
        Arr::set(self::$config, $key, $value);
    }

    /**
     * Get config variable
     *
     * @access  public
     * @param  string $key Key
     * @param  mixed  $default Default value
     * @return mixed
     */
    public function get($key, $default = null)
    {
        return Arr::get(self::$config, $key, $default);
    }

    /**
     * Get config array
     *
     * @access  public
     * @return array
     */
    public function getConfig()
    {
        return self::$config;
    }
}
