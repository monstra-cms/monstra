<?php

/**
 * This file is part of the Monstra.
 *
 * (c) Romanenko Sergey / Awilum <awilum@msn.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

class Pages
{
    /**
     * An instance of the Pages class
     *
     * @var object
     * @access  protected
     */
    protected static $instance = null;

    /**
     * Current page.
     *
     * @var array
     * @access  protected
     */
    protected static $current_page;

    /**
     * Current page template.
     *
     * @var object
     * @access  protected
     */
    protected static $current_template;

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
     * Constructor.
     *
     * @access  protected
     */
    protected function __construct()
    {
        // Get Current Page
        static::$current_page = static::getPage(Url::getUriString());

        // Get Theme Templates
        static::$current_template = ((!empty(static::$current_page['template'])) ? static::$current_page['template'] : 'index');

        // Send default header
        header('Content-Type: text/html; charset='.Config::get('site.charset'));

        // Run actions before page rendered
        Action::run('before_page_rendered');

        // Display page for current requested url
        static::display(static::$current_page);

        // Run actions after page rendered
        Action::run('after_page_rendered');
    }

    /**
     * Get pages
     *
     *  <code>
     *      $pages = Pages::getPages('blog');
     *  </code>
     *
     * @access  public
     * @param  string  $url        Url
     * @param  string  $order_by   Order by
     * @param  string  $order_type Order type
     * @param  array   $ignore     Pages to ignore
     * @param  int     $limit      Limit of pages
     * @return array
     */
    public static function getPages($url = '', $order_by = 'date', $order_type = 'DESC', $ignore = array('404'), $limit = null)
    {
        $pages = File::scan(CONTENT_PATH . '/pages/' . $url, 'md');

        if ($pages) {
            foreach ($pages as $page) {
                $pages_cache_id .= filemtime($page);
            }

            // Create Unique Cache ID for Pages
            $pages_cache_id = md5('pages' . ROOT_DIR . $url . $order_by . $order_type . implode(",", $ignore) . (($limit === null) ? 'null' : $limit) . $pages_cache_id);
        }

        if (Cache::driver()->contains($pages_cache_id)) {
            return Cache::driver()->fetch($pages_cache_id);
        } else {
            foreach ($pages as $key => $page) {
                if (!in_array(basename($page, '.md'), $ignore)) {
                    $content = file_get_contents($page);

                    $_page = explode('---', $content, 3);

                    $_pages[$key] = Yaml::parse($_page[1]);

                    $url = str_replace(CONTENT_PATH . '/pages', Url::getBase(), $page);
                    $url = str_replace('index.md', '', $url);
                    $url = str_replace('.md', '', $url);
                    $url = str_replace('\\', '/', $url);
                    $url = rtrim($url, '/');
                    $_pages[$key]['url'] = $url;

                    $_content = $_page[2];

                        // Parse page for summary <!--more-->
                        if (($pos = strpos($_content, "<!--more-->")) === false) {
                            $_content = Filter::apply('content', $_content);
                        } else {
                            $_content = explode("<!--more-->", $_content);
                            $_content['summary']  = Filter::apply('content', $_content[0]);
                            $_content['content']  = Filter::apply('content', $_content[0].$_content[1]);
                        }

                    if (is_array($_content)) {
                        $_pages[$key]['summary'] = $_content['summary'];
                        $_pages[$key]['content'] = $_content['content'];
                    } else {
                        $_pages[$key]['summary'] = $_content;
                        $_pages[$key]['content'] = $_content;
                    }

                    $_pages[$key]['slug'] = basename($page, '.md');
                }
            }

            $_pages = Arr::subvalSort($_pages, $order_by, $order_type);

            if ($limit != null) {
                $_pages = array_slice($_pages, null, $limit);
            }

            Cache::driver()->save($pages_cache_id, $_pages);
            return $_pages;
        }
    }

    /**
     * Get page
     *
     *  <code>
     *      $page = Pages::getPage('downloads');
     *  </code>
     *
     * @access  public
     * @param  string $url Url
     * @return array
     */
    public static function getPage($url)
    {

        // If url is empty then its a homepage
        if ($url) {
            $file = CONTENT_PATH . '/pages/' . $url;
        } else {
            $file = CONTENT_PATH . '/pages/' . Config::get('site.pages.main') . '/' . 'index';
        }

        // Select the file
        if (is_dir($file)) {
            $file = CONTENT_PATH . '/pages/' . $url .'/index.md';
        } else {
            $file .= '.md';
        }

        // Get 404 page if file not exists
        if (!file_exists($file)) {
            $file = CONTENT_PATH . '/pages/404/' . 'index.md';
            Response::status(404);
        }

        // Create Unique Cache ID for requested page
        $page_cache_id = md5('page' . ROOT_DIR . $file . filemtime($file));

        if (Cache::driver()->contains($page_cache_id) && Config::get('site.pages.flush_cache') == false) {
            return Cache::driver()->fetch($page_cache_id);
        } else {
            $content = file_get_contents($file);

            $_page = explode('---', $content, 3);

            $page = Yaml::parse($_page[1]);

            $url = str_replace(CONTENT_PATH . '/pages', Url::getBase(), $file);
            $url = str_replace('index.md', '', $url);
            $url = str_replace('.md', '', $url);
            $url = str_replace('\\', '/', $url);
            $url = rtrim($url, '/');
            $page['url'] = $url;

            $_content = $_page[2];

            // Parse page for summary <!--more-->
            if (($pos = strpos($_content, "<!--more-->")) === false) {
                $_content = Filter::apply('content', $_content);
            } else {
                $_content = explode("<!--more-->", $_content);
                $_content['summary']  = Filter::apply('content', $_content[0]);
                $_content['content']  = Filter::apply('content', $_content[0].$_content[1]);
            }

            if (is_array($_content)) {
                $page['summary'] = $_content['summary'];
                $page['content'] = $_content['content'];
            } else {
                $page['content'] = $_content;
            }

            $page['slug'] = basename($file, '.md');

            // Overload page title, keywords and description if needed
            empty($page['title']) and $page['title'] = Config::get('site.title');
            empty($page['keywords']) and $page['keywords'] = Config::get('site.keywords');
            empty($page['description']) and $page['description'] = Config::get('site.description');

            Cache::driver()->save($page_cache_id, $page);
            return $page;
        }
    }

    /**
     * Get Current Page
     *
     *  <code>
     *      $page = Pages::getCurrentPage();
     *  </code>
     *
     * @return array
     */
    public static function getCurrentPage()
    {
        return static::$current_page;
    }

    /**
     * Update Current Page
     *
     *  <code>
     *      Pages::updateCurrentPage('title', 'My new Page Title');
     *  </code>
     *
     * @return array
     */
    public static function updateCurrentPage($path, $value)
    {
        Arr::set(static::$current_page, $path, $value);
    }

    /**
     * Display Page
     *
     *  <code>
     *      Pages::display($page);
     *  </code>
     *
     * @access public
     * @param  array $page Page array
     * @return string
     */
    public static function display($page)
    {
        Theme::getTemplate(((!empty($page['template'])) ? $page['template'] : 'index'));
    }

    /**
     * Get Current Template
     *
     *  <code>
     *      $template = Pages::getCurrentTemplate();
     *  </code>
     *
     * @access public
     * @return object
     */
    public static function getCurrentTemplate()
    {
        return static::$current_template;
    }

    /**
     * Initialize Monstra Pages
     *
     *  <code>
     *      Pages::init();
     *  </code>
     *
     * @access  public
     */
    public static function init()
    {
        return !isset(self::$instance) and self::$instance = new Pages();
    }
}
