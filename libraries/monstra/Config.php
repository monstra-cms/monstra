<?php

class Config
{

    private static $path = '';


    /**
     * Config array.
     *
     * @var array
     */

    protected static $config;


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
     * Set the location where to save the config file.
     *
     * @return  SpoonLog
     * @param   string[optional] $path      The path where you want to store the logfile. If null it will be saved in 'spoon/log/*'.
     */
    public static function setPath($path)
    {
        Config::$path = $path;
    }


    /**
     * Returns the path to the configuration file.
     *
     * @access  protected
     * @param  string $file File name
     * @return string
     */

    protected static function file($file)
    {
        
        //$path = MONSTRA_LIBRARIES_PATH.'/'.Config::$path.'/'.$file.'.php';

        if (file_exists(Config::$path.'/'.$file.'.php')) {
            return Config::$path.'/'.$file.'.php';
        }
    
        throw new RuntimeException(vsprintf("%s(): The '%s' config file does not exist.", array(__METHOD__, $file)));
    }

    /**
     * Returns config value or entire config array from a file.
     *
     * @access  public
     * @param  string $key     Config key
     * @param  mixed  $default (optional) Default value to return if config value doesn't exist
     * @return mixed
     */

    public static function get($key, $default = null)
    {
        $keys = explode('.', $key, 2);

        if (!isset(static::$config[$keys[0]])) {
            static::$config[$keys[0]] = include(static::file($keys[0]));
        }

        if (!isset($keys[1])) {
            return static::$config[$keys[0]];
        } else {
            return Arr::get(static::$config[$keys[0]], $keys[1], $default);
        }
    }
}
