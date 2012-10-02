<?php defined('MONSTRA_ACCESS') or die('No direct script access.');


    /**
     * Monstra CMS Defines
     */


    /**
     * Set gzip output
     */
    define('MONSTRA_GZIP', false);    

    /**
     * Set gzip styles 
     */
    define('MONSTRA_GZIP_STYLES', false);
    
    /**
     * Set Monstra version
     */
    define('MONSTRA_VERSION', '2.0.0 beta');
    
    /**
     * Set Monstra version id 
     */
    define('MONSTRA_VERSION_ID', 10301);

    /**
     * Set Monstra site url
     */
    define('MONSTRA_SITEURL', 'http://monstra.org');    
    
    /**
     * The filesystem path to the 'monstra' folder
     */
    define('MONSTRA', ROOT . DS . 'monstra');

    /**
     * The filesystem path to the site 'themes' folder
     */
    define('THEMES_SITE', ROOT . DS . 'public' . DS . 'themes');
    
    /**
     * The filesystem path to the admin 'themes' folder
     */
    define('THEMES_ADMIN', ROOT . DS . 'admin' . DS . 'themes');

    /**
     * The filesystem path to the 'plugins' folder
     */
    define('PLUGINS', ROOT . DS . 'plugins');

    /**
     * The filesystem path to the 'box' folder which is contained within
     * the 'plugins' folder
     */
    define('PLUGINS_BOX', PLUGINS . DS . 'box');    

    /**
     * The filesystem path to the 'helpers' folder which is contained within
     * the 'monstra' folder
     */
    define('HELPERS', MONSTRA . DS . 'helpers');

    /**
     * The filesystem path to the 'engine' folder which is contained within
     * the 'monstra' folder
     */
    define('ENGINE', MONSTRA . DS . 'engine');

    /**
     * The filesystem path to the 'boot' folder which is contained within
     * the 'monstra' folder
     */    
    define('BOOT', MONSTRA . DS . 'boot');

    /**
     * The filesystem path to the 'storage' folder
     */
    define('STORAGE', ROOT . DS . 'storage');

    /**
     * The filesystem path to the 'xmldb' folder
     */
    define('XMLDB', STORAGE . DS . 'database');

    /**
     * The filesystem path to the 'cache' folder
     */
    define('CACHE', ROOT . DS . 'tmp' . DS . 'cache');

    /**
     * The filesystem path to the 'minify' folder
     */
    define('MINIFY', ROOT . DS . 'tmp' . DS . 'minify');

    /**
     * The filesystem path to the 'logs' folder
     */
    define('LOGS', ROOT . DS . 'tmp' . DS . 'logs');

    /**
     * The filesystem path to the 'assets' folder
     */
    define('ASSETS', ROOT . DS . 'public' . DS . 'assets');

    /**
     * The filesystem path to the 'uploads' folder
     */
    define('UPLOADS', ROOT . DS . 'public' . DS . 'uploads');
    
    /**
     * Set login sleep value
     */
    define('MONSTRA_LOGIN_SLEEP', 1);

    /**
     * Set password salt
     */
    define('MONSTRA_PASSWORD_SALT', 'YOUR_SALT_HERE');

    /**
     * Set date format
     */
    define('MONSTRA_DATE_FORMAT', 'Y-m-d / H:i:s');

    /**
     * Set eval php
     */
    define('MONSTRA_EVAL_PHP', false);  

    /**
     * Check Monstra CMS version
     */
    define('CHECK_MONSTRA_VERSION', true);

    /**
     * Monstra CMS mobile detection
     */
    define('MONSTRA_MOBILE', true);

    /**
     * Monstra database settings 
     */
    define('MONSTRA_DB_DSN', 'mysql:dbname=monstra;host=localhost;port=3306');
    define('MONSTRA_DB_USER', 'root');
    define('MONSTRA_DB_PASSWORD', 'password');