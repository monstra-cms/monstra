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

class ClassLoader
{

    /**
     * Mapping from class names to paths.
     *
     * @var array
     */
    protected static $classes = array();

    /**
     * PSR-0 directories.
     *
     * @var array
     */
    protected static $directories = array();

    /**
     * Registered namespaces.
     *
     * @var array
     */
    protected static $namespaces = array();

    /**
     * Class aliases.
     *
     * @var array
     */
    protected static $aliases = array();

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
     * Add class to mapping.
     *
     *  <code>
     *      ClassLoader::mapClass('ClassName', 'path/to/class');
     *  </code>
     *
     * @access  public
     * @param string $className Class name
     * @param string $classPath Full path to class
     */
    public static function mapClass($className, $classPath)
    {
        ClassLoader::$classes[$className] = $classPath;
    }

    /**
     * Add multiple classes to mapping.
     *
     *  <code>
     *      ClassLoader::mapClasses(array('ClassName' => 'path/to/class','ClassName' => 'path/to/class'));
     *  </code>
     *
     * @access  public
     * @param array $classes Array of classes to map (key = class name and value = class path)
     */
    public static function mapClasses(array $classes)
    {
        foreach ($classes as $name => $path) {
            ClassLoader::$classes[$name] = $path;
        }
    }

    /**
     * Adds a PSR-0 directory path.
     *
     *  <code>
     *      ClassLoader::directory('path/to/classes');
     *  </code>
     *
     * @access  public
     * @param string $path Path to PSR-0 directory
     */
    public static function directory($path)
    {
        ClassLoader::$directories[] = rtrim($path, '/');
    }

    /**
     * Registers a namespace.
     *
     *  <code>
     *      ClassLoader::registerNamespace('Namespace', '/path/to/namespace/');
     *  </code>
     *
     * @access  public
     * @param string $namespace Namespace
     * @param string $path      Path
     */
    public static function registerNamespace($namespace, $path)
    {
        ClassLoader::$namespaces[trim($namespace, '\\') . '\\'] = rtrim($path, '/');
    }

    /**
     * Set an alias for a class.
     *
     *  <code>
     *      ClassLoader::alias('ClassNameAlias', 'ClassName');
     *  </code>
     *
     * @access  public
     * @param string $alias     Class alias
     * @param string $className Class name
     */
    public static function alias($alias, $className)
    {
        ClassLoader::$aliases[$alias] = $className;
    }

    /**
     * Try to load a PSR-0 compatible class.
     *
     * @access  protected
     * @param  string  $className Class name
     * @param  string  $directory (Optional) Overrides the array of PSR-0 paths
     * @return boolean
     */
    protected static function loadPSR0($className, $directory = null)
    {
        $classPath = '';

        if (($pos = strripos($className, '\\')) !== false) {
            $namespace = substr($className, 0, $pos);
            $className = substr($className, $pos + 1);
            $classPath = str_replace('\\', '/', $namespace) . '/';
        }

        $classPath .= str_replace('_', '/', $className) . '.php';

        $directories = ($directory === null) ? ClassLoader::$directories : array($directory);

        foreach ($directories as $directory) {
            if (file_exists($directory . '/' . $classPath)) {
                include($directory . '/' . $classPath);

                return true;
            }
        }

        return false;
    }

    /**
     * Autoloader.
     *
     *  <code>
     *      ClassLoader::load();
     *  </code>
     *
     * @access  public
     * @param  string  $className Class name
     * @return boolean
     */
    public static function load($className)
    {

        $className = ltrim($className, '\\');

        /**
         * Try to autoload an aliased class
         */
        if (isset(ClassLoader::$aliases[$className])) {
            return class_alias(ClassLoader::$aliases[$className], $className);
        }

        /**
         * Try to load a mapped class
         */
        if (isset(ClassLoader::$classes[$className]) && file_exists(ClassLoader::$classes[$className])) {
            include ClassLoader::$classes[$className];

            return true;
        }

        /**
         * Try to load class from a registered namespace
         */
        foreach (ClassLoader::$namespaces as $namespace => $path) {
            if (strpos($className, $namespace) === 0) {
                if (ClassLoader::loadPSR0(substr($className, strlen($namespace)), $path)) {
                    return true;
                }
            }
        }

        /**
         * Try to load a PSR-0 compatible class
         * The second call to the loadPSR0 method is used to autoload legacy code
         */
        if (ClassLoader::loadPSR0($className) || ClassLoader::loadPSR0(strtolower($className))) {
            return true;
        }

        return false;
    }

    /**
     * Register the Gelato ClassLoader to the SPL autoload stack.
     *
     * @return  void
     */
    public static function register()
    {
        spl_autoload_register('ClassLoader::load', true);
    }

}
