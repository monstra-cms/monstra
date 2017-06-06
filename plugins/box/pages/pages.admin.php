<?php

// Add plugin navigation link
Navigation::add(__('Pages', 'pages'), 'content', 'pages', 1);
Dashboard::addNewItem('pages', __('Page', 'pages'), 'index.php?id=pages&action=add_page', 1);

// Add action on admin_pre_render hook
Action::add('admin_pre_render','PagesAdmin::_pageExpandAjax');

/**
 * Pages Admin Class
 */
class PagesAdmin extends Backend
{
    /**
     * Pages tables
     *
     * @var object
     */
    public static $pages = null;

    /**
     * _pageExpandAjax
     */
    public static function _pageExpandAjax()
    {
        if (Request::post('page_slug')) {
            if (Security::check(Request::post('token'))) {
                $pages = new Table('pages');
                $pages->updateWhere('[slug="'.Request::post('page_slug').'"]', array('expand' => Request::post('page_expand')));
                Request::shutdown();
            } else { die('Request was denied because it contained an invalid security token. Please refresh the page and try again.'); }
        }
    }

    /**
     * Pages admin function
     */
    public static function main()
    {
        $current_theme = Option::get('theme_site_name');
        $site_url = Option::get('siteurl');

        $templates_path = THEMES_SITE;

        $errors = array();

        $pages = new Table('pages');
        PagesAdmin::$pages = $pages;

        $users = new Table('users');
        $user = $users->select('[id='.Session::get('user_id').']', null);

        // Page author
        if ( ! empty($user['firstname'])) {
            $author = (empty($user['lastname'])) ? $user['firstname'] : $user['firstname'].' '.$user['lastname'];
        } else {
            $author = Session::get('user_login');
        }

        $author = Html::toText($author);

        // Status array
        $status_array = array('published' => __('Published', 'pages'),
                              'draft'     => __('Draft', 'pages'));

        // Access array
        $access_array = array('public'      => __('Public', 'pages'),
                              'registered'  => __('Registered', 'pages'));

        // Check for get actions
        // ---------------------------------------------
        if (Request::get('action')) {

            // Switch actions
            // -----------------------------------------
            switch (Request::get('action')) {

                // Clone page
                // -------------------------------------
                case "clone_page":

                    if (Security::check(Request::get('token'))) {

                        // Generate rand page name
                        $rand_page_name = Request::get('name').'_clone_'.date("Ymd_His");

                        // Get original page
                        $orig_page = $pages->select('[slug="'.Request::get('name').'"]', null);

                        // Generate rand page title
                        $rand_page_title = $orig_page['title'].' [copy]';

                        // Clone page
                        if ($pages->insert(array('slug'         => $rand_page_name,
                                                 'template'     => $orig_page['template'],
                                                 'parent'       => $orig_page['parent'],
                                                 'robots_index' => $orig_page['robots_index'],
                                                 'robots_follow'=> $orig_page['robots_follow'],
                                                 'status'       => $orig_page['status'],
                                                 'access'       => (isset($orig_page['access'])) ? $orig_page['access'] : 'public',
                                                 'expand'       => (isset($orig_page['expand'])) ? $orig_page['expand'] : '0',
                                                 'title'        => $rand_page_title,
                                                 'meta_title'   => $orig_page['meta_title'],
                                                 'description'  => $orig_page['description'],
                                                 'keywords'     => $orig_page['keywords'],
                                                 'tags'         => $orig_page['tags'],
                                                 'date'         => $orig_page['date'],
                                                 'author'       => $orig_page['author']))) {

                            // Get cloned page ID
                            $last_id = $pages->lastId();

                            // Save cloned page content
                            File::setContent(STORAGE . DS . 'pages' . DS . $last_id . '.page.txt',
                                             File::getContent(STORAGE . DS . 'pages' . DS . $orig_page['id'] . '.page.txt'));

                            // Send notification
                            Notification::set('success', __('The page <i>:page</i> cloned.', 'pages', array(':page' => Security::safeName(Request::get('name'), '-', true))));
                        }

                        // Run add extra actions
                        Action::run('admin_pages_action_clone');

                        // Redirect
                        Request::redirect('index.php?id=pages');

                    } else { die('Request was denied because it contained an invalid security token. Please refresh the page and try again.'); }

                break;

                // Add page
                // -------------------------------------
                case "add_page":

                    // Add page
                    if (Request::post('add_page') || Request::post('add_page_and_exit')) {

                        if (Security::check(Request::post('csrf'))) {

                            // Get parent page
                            if (Request::post('pages') == '0') {
                                $parent_page = '';
                            } else {
                                $parent_page = Request::post('pages');
                            }

                            // Validate
                            //--------------
                            if (trim(Request::post('page_name')) == '') $errors['pages_empty_name'] = __('Required field', 'pages');
                            if (trim(Request::post('page_title')) == '') $errors['pages_empty_title'] = __('Required field', 'pages');
                            if (count($pages->select('[slug="'.Security::safeName(Request::post('page_name'), '-', true).'"]')) != 0) $errors['pages_exists'] = __('This page already exists', 'pages');

                            // Prepare date
                            if (Valid::date(Request::post('page_date'))) {
                                $date = strtotime(Request::post('page_date'));
                            } else {
                                $date = time();
                            }

                            if (Request::post('robots_index'))  $robots_index = 'noindex';   else $robots_index = 'index';
                            if (Request::post('robots_follow')) $robots_follow = 'nofollow'; else $robots_follow = 'follow';

                            // If no errors then try to save
                            if (count($errors) == 0) {

                                // Insert new page
                                if ($pages->insert(array('slug'        => Security::safeName(Request::post('page_name'), '-', true),
                                                        'template'     => Request::post('templates'),
                                                        'parent'       => $parent_page,
                                                        'status'       => Request::post('status'),
                                                        'access'       => Request::post('access'),
                                                        'expand'       => '0',
                                                        'robots_index' => $robots_index,
                                                        'robots_follow'=> $robots_follow,
                                                        'title'        => Request::post('page_title'),
                                                        'meta_title'   => Request::post('page_meta_title'),
                                                        'description'  => Request::post('page_description'),
                                                        'keywords'     => Request::post('page_keywords'),
                                                        'tags'         => Request::post('page_tags'),
                                                        'date'         => $date,
                                                        'author'       => $author))) {

                                    // Get inserted page ID
                                    $last_id = $pages->lastId();

                                    // Save content
                                    File::setContent(STORAGE . DS . 'pages' . DS . $last_id . '.page.txt', XML::safe(Request::post('editor')));

                                    // Send notification
                                    Notification::set('success', __('Your changes to the page <i>:page</i> have been saved.', 'pages', array(':page' => Security::safeName(Request::post('page_title'), '-', true))));
                                }

                                // Run add extra actions
                                Action::run('admin_pages_action_add');

                                // Redirect
                                if (Request::post('add_page_and_exit')) {
                                    Request::redirect('index.php?id=pages');
                                } else {
                                    Request::redirect('index.php?id=pages&action=edit_page&name='.Security::safeName(Request::post('page_name'), '-', true));
                                }
                            }

                        } else { die('Request was denied because it contained an invalid security token. Please refresh the page and try again.'); }

                    }

                    // Get all pages
                    $pages_list = $pages->select('[slug!="error404" and parent=""]');
                    $pages_array[] = '-none-';
                    foreach ($pages_list as $page) {
                        $pages_array[$page['slug']] = $page['title'];
                    }

                    // Get all templates
                    $templates_list = File::scan($templates_path, '.template.php');
                    foreach ($templates_list as $file) {
                        $templates_array[basename($file, '.template.php')] = basename($file, '.template.php');
                    }

                    // Save fields
                    if (Request::post('page_name'))        $post_name        = Request::post('page_name'); else $post_name = '';
                    if (Request::post('page_title'))       $post_title       = Request::post('page_title'); else $post_title = '';
                    if (Request::post('page_meta_title'))  $post_meta_title  = Request::post('page_meta_title'); else $post_meta_title = '';                    
                    if (Request::post('page_keywords'))    $post_keywords    = Request::post('page_keywords'); else $post_keywords = '';
                    if (Request::post('page_description')) $post_description = Request::post('page_description'); else $post_description = '';
                    if (Request::post('page_tags'))        $post_tags        = Request::post('page_tags'); else $post_tags = '';
                    if (Request::post('editor'))           $post_content     = Request::post('editor'); else $post_content = '';
                    if (Request::post('templates'))        $post_template    = Request::post('templates'); else $post_template = 'index';
                    if (Request::post('status'))           $post_status      = Request::post('status'); else $post_status = 'published';
                    if (Request::post('access'))           $post_access      = Request::post('access'); else $post_access = 'public';
                    if (Request::post('pages'))            $parent_page      = Request::post('pages'); else if(Request::get('parent_page')) $parent_page = Request::get('parent_page'); else $parent_page = '';
                    if (Request::post('robots_index'))     $post_robots_index = true; else $post_robots_index = false;
                    if (Request::post('robots_follow'))    $post_robots_follow = true; else $post_robots_follow = false;
                    //--------------

                    // Generate date
                    $date = Date::format(time(), 'Y-m-d H:i:s');

                    // Set Tabs State - page
                    Notification::setNow('page', 'page');

                    // Display view
                    View::factory('box/pages/views/backend/add')
                            ->assign('post_name', $post_name)
                            ->assign('post_title', $post_title)
                            ->assign('post_meta_title', $post_meta_title)                            
                            ->assign('post_description', $post_description)
                            ->assign('post_keywords', $post_keywords)
                            ->assign('post_tags', $post_tags)
                            ->assign('post_content', $post_content)
                            ->assign('pages_array', $pages_array)
                            ->assign('parent_page', $parent_page)
                            ->assign('templates_array', $templates_array)
                            ->assign('post_template', $post_template)
                            ->assign('post_status', $post_status)
                            ->assign('post_access', $post_access)
                            ->assign('status_array', $status_array)
                            ->assign('access_array', $access_array)
                            ->assign('date', $date)
                            ->assign('post_robots_index', $post_robots_index)
                            ->assign('post_robots_follow', $post_robots_follow)
                            ->assign('errors', $errors)
                            ->display();

                break;

                // Edit page
                // -------------------------------------
                case "edit_page":

                    if (Request::post('edit_page') || Request::post('edit_page_and_exit')) {

                        if (Security::check(Request::post('csrf'))) {

                            // Get pages parent
                            if (Request::post('pages') == '0') {
                                $parent_page = '';
                            } else {
                                $parent_page = Request::post('pages');
                            }

                            // Save field
                            $post_parent = Request::post('pages');

                            // Validate
                            //--------------
                            if (trim(Request::post('page_name')) == '') $errors['pages_empty_name'] = __('Required field', 'pages');
                            if ((count($pages->select('[slug="'.Security::safeName(Request::post('page_name'), '-', true).'"]')) != 0) and (Security::safeName(Request::post('page_old_name'), '-', true) !== Security::safeName(Request::post('page_name'), '-', true))) $errors['pages_exists'] = __('This page already exists', 'pages');
                            if (trim(Request::post('page_title')) == '') $errors['pages_empty_title'] = __('Required field', 'pages');

                            // Save fields
                            if (Request::post('page_name'))        $post_name        = Request::post('page_name'); else $post_name = '';
                            if (Request::post('page_title'))       $post_title       = Request::post('page_title'); else $post_title = '';
                            if (Request::post('page_meta_title'))  $post_meta_title  = Request::post('page_meta_title'); else $post_meta_title = '';                            
                            if (Request::post('page_keywords'))    $post_keywords    = Request::post('page_keywords'); else $post_keywords = '';
                            if (Request::post('page_description')) $post_description = Request::post('page_description'); else $post_description = '';
                            if (Request::post('page_tags'))        $post_tags        = Request::post('page_tags'); else $post_tags = '';
                            if (Request::post('editor'))           $post_content     = Request::post('editor'); else $post_content = '';
                            if (Request::post('templates'))        $post_template    = Request::post('templates'); else $post_template = 'index';
                            if (Request::post('status'))           $post_status      = Request::post('status'); else $post_status = 'published';
                            if (Request::post('access'))           $post_access      = Request::post('access'); else $post_access = 'public';
                            if (Request::post('robots_index'))     $post_robots_index = true; else $post_robots_index = false;
                            if (Request::post('robots_follow'))    $post_robots_follow = true; else $post_robots_follow = false;
                            //--------------

                            // Prepare date
                            if (Valid::date(Request::post('page_date'))) {
                                $date = strtotime(Request::post('page_date'));
                            } else {
                                $date = time();
                            }

                            if (Request::post('robots_index'))  $robots_index = 'noindex';   else $robots_index = 'index';
                            if (Request::post('robots_follow')) $robots_follow = 'nofollow'; else $robots_follow = 'follow';

                            if (count($errors) == 0) {

                                // Update parents in all childrens
                                if ((Security::safeName(Request::post('page_name'), '-', true)) !== (Security::safeName(Request::post('page_old_name'), '-', true)) and (Request::post('old_parent') == '')) {

                                    $_pages = $pages->select('[parent="'.Text::translitIt(trim(Request::post('page_old_name'))).'"]');

                                    if ( ! empty($_pages)) {
                                        foreach ($_pages as $_page) {                                            
                                            $pages->updateWhere('[parent="'.$_page['parent'].'"]', array('parent' => Security::safeName(Request::post('page_name'), '-', true)));
                                        }
                                    }

                                    if ($pages->updateWhere('[slug="'.Request::get('name').'"]',
                                                        array('slug'        => Security::safeName(Request::post('page_name'), '-', true),
                                                              'template'    => Request::post('templates'),
                                                              'parent'      => $parent_page,
                                                              'title'       => Request::post('page_title'),
                                                              'meta_title'  => Request::post('page_meta_title'),                                                              
                                                              'description' => Request::post('page_description'),
                                                              'keywords'    => Request::post('page_keywords'),
                                                              'tags'        => Request::post('page_tags'),
                                                              'robots_index' => $robots_index,
                                                              'robots_follow'=> $robots_follow,
                                                              'status'      => Request::post('status'),
                                                              'access'      => Request::post('access'),
                                                              'date'        => $date,
                                                              'author'      => $author))) {

                                        File::setContent(STORAGE . DS . 'pages' . DS . Request::post('page_id') . '.page.txt', XML::safe(Request::post('editor')));
                                        Notification::set('success', __('Your changes to the page <i>:page</i> have been saved.', 'pages', array(':page' => Security::safeName(Request::post('page_title'), '-', true))));
                                    }

                                    // Run edit extra actions
                                    Action::run('admin_pages_action_edit');

                                } else {

                                    if ($pages->updateWhere('[slug="'.Request::get('name').'"]',
                                                        array('slug'        => Security::safeName(Request::post('page_name'), '-', true),
                                                              'template'    => Request::post('templates'),
                                                              'parent'      => $parent_page,
                                                              'title'       => Request::post('page_title'),
                                                              'meta_title'       => Request::post('page_meta_title'),                                                              
                                                              'description' => Request::post('page_description'),
                                                              'keywords'    => Request::post('page_keywords'),
                                                              'tags'        => Request::post('page_tags'),
                                                              'robots_index' => $robots_index,
                                                              'robots_follow'=> $robots_follow,
                                                              'status'      => Request::post('status'),
                                                              'access'      => Request::post('access'),
                                                              'date'        => $date,
                                                              'author'      => $author))) {

                                        File::setContent(STORAGE . DS . 'pages' . DS . Request::post('page_id') . '.page.txt', XML::safe(Request::post('editor')));
                                        Notification::set('success', __('Your changes to the page <i>:page</i> have been saved.', 'pages', array(':page' => Security::safeName(Request::post('page_title'), '-', true))));
                                    }

                                    // Run edit extra actions
                                    Action::run('admin_pages_action_edit');
                                }

                                // Redirect
                                if (Request::post('edit_page_and_exit')) {
                                    Request::redirect('index.php?id=pages');
                                } else {
                                    Request::redirect('index.php?id=pages&action=edit_page&name='.Security::safeName(Request::post('page_name'), '-', true));
                                }
                            }

                        } else { die('Request was denied because it contained an invalid security token. Please refresh the page and try again.'); }
                    }

                    // Get all pages
                    $pages_list = $pages->select();
                    $pages_array[] = '-none-';
                    // Foreach pages find page whithout parent
                    foreach ($pages_list as $page) {
                        if (isset($page['parent'])) {
                            $c_p = $page['parent'];
                        } else {
                            $c_p = '';
                        }
                        if ($c_p == '') {
                            // error404 is system "constant" and no child for it
                            if ($page['slug'] !== 'error404' && $page['slug'] !== Request::get('name')) {
                                $pages_array[$page['slug']] = $page['title'];
                            }
                        }
                    }

                    // Get all templates
                    $templates_list = File::scan($templates_path,'.template.php');
                    foreach ($templates_list as $file) {
                        $templates_array[basename($file,'.template.php')] = basename($file, '.template.php');
                    }

                    $page = $pages->select('[slug="'.Request::get('name').'"]', null);

                    if ($page) {

                        $page_content = File::getContent(STORAGE . DS . 'pages' . DS . $page['id'] . '.page.txt');

                        // Safe fields or load fields
                        if (Request::post('page_name'))         $slug_to_edit        = Request::post('page_name'); else $slug_to_edit = $page['slug'];
                        if (Request::post('page_title'))        $title_to_edit       = Request::post('page_title'); else $title_to_edit = $page['title'];
                        if (Request::post('page_meta_title'))   $meta_title_to_edit  = Request::post('page_meta_title'); else $meta_title_to_edit = isset($page['meta_title']) ? $page['meta_title'] : '';
                        if (Request::post('page_description'))  $description_to_edit = Request::post('page_description'); else $description_to_edit = $page['description'];
                        if (Request::post('page_keywords'))     $keywords_to_edit    = Request::post('page_keywords'); else $keywords_to_edit = $page['keywords'];
                        if (Request::post('page_tags'))         $tags_to_edit        = Request::post('page_tags'); else $tags_to_edit = isset($page['tags']) ? $page['tags'] : '';;
                        if (Request::post('editor'))            $to_edit             = Request::post('editor'); else $to_edit = Text::toHtml($page_content);

                        if (Request::post('robots_index'))      $post_robots_index  = true; else if ($page['robots_index'] == 'noindex') $post_robots_index = true; else  $post_robots_index = false;
                        if (Request::post('robots_follow'))     $post_robots_follow = true; else if ($page['robots_follow'] == 'nofollow') $post_robots_follow = true; else  $post_robots_follow = false;

                        if (Request::post('pages')) {
                            // Get pages parent
                            if (Request::post('pages') == '-none-') {
                                $parent_page = '';
                            } else {
                                $parent_page = Request::post('pages');
                            }
                            // Save field
                            $parent_page = Request::post('pages');
                        } else {
                            $parent_page = $page['parent'];
                        }
                        if (Request::post('templates')) $template = Request::post('templates'); else $template = $page['template'];
                        if (Request::post('status'))    $status   = Request::post('status');    else $status   = $page['status'];
                        if (Request::post('access'))    $access   = Request::post('access');    else $access   = (isset($page['access'])) ? $page['access'] : 'public';

                        // Generate date
                        $date = Request::post('date') ? Request::post('date') : Date::format($page['date'], 'Y-m-d H:i:s');

                        Notification::setNow('page', 'page');

                        // Display view
                        View::factory('box/pages/views/backend/edit')
                                ->assign('slug_to_edit', $slug_to_edit)
                                ->assign('title_to_edit', $title_to_edit)
                                ->assign('meta_title_to_edit', $meta_title_to_edit)                                
                                ->assign('description_to_edit', $description_to_edit)
                                ->assign('keywords_to_edit', $keywords_to_edit)
                                ->assign('tags_to_edit', $tags_to_edit)
                                ->assign('page', $page)
                                ->assign('to_edit', $to_edit)
                                ->assign('pages_array', $pages_array)
                                ->assign('parent_page', $parent_page)
                                ->assign('templates_array', $templates_array)
                                ->assign('template', $template)
                                ->assign('status_array', $status_array)
                                ->assign('access_array', $access_array)
                                ->assign('status', $status)
                                ->assign('access', $access)
                                ->assign('date', $date)
                                ->assign('post_robots_index', $post_robots_index)
                                ->assign('post_robots_follow', $post_robots_follow)
                                ->assign('errors', $errors)
                                ->display();
                    }

                break;

                // Delete page
                // -------------------------------------
                case "delete_page":

                    // Error 404 page can not be removed
                    if (Request::get('slug') !== 'error404') {

                        if (Security::check(Request::get('token'))) {

                            // Get specific page
                            $page = $pages->select('[slug="'.Request::get('name').'"]', null);

                            //  Delete page and update <parent> fields
                            if ($pages->deleteWhere('[slug="'.$page['slug'].'" ]')) {

                                $_pages = $pages->select('[parent="'.$page['slug'].'"]');

                                if ( ! empty($_pages)) {
                                    foreach ($_pages as $_page) {
                                        $pages->updateWhere('[slug="'.$_page['slug'].'"]', array('parent' => ''));
                                    }
                                }

                                File::delete(STORAGE . DS . 'pages' . DS . $page['id'] . '.page.txt');
                                Notification::set('success', __('Page <i>:page</i> deleted', 'pages', array(':page' => Html::toText($page['title']))));
                            }

                            // Run delete extra actions
                            Action::run('admin_pages_action_delete');

                            // Redirect
                            Request::redirect('index.php?id=pages');

                        } else { die('Request was denied because it contained an invalid security token. Please refresh the page and try again.'); }
                    }

                break;

                // Update page access
                // -------------------------------------
                case "update_access":

                    if (Request::get('slug') !== 'error404') {

                        if (Security::check(Request::get('token'))) {

                            $pages->updateWhere('[slug="'.Request::get('slug').'"]', array('access' => Request::get('access')));

                            // Run delete extra actions
                            Action::run('admin_pages_action_update_access');

                            // Send notification
                            Notification::set('success', __('Your changes to the page <i>:page</i> have been saved.', 'pages', array(':page' => Request::get('slug'))));

                            // Redirect
                            Request::redirect('index.php?id=pages');

                        } else { die('Request was denied because it contained an invalid security token. Please refresh the page and try again.'); }
                    }
                    
                break;

                // Update page status
                // -------------------------------------
                case "update_status":

                    if (Request::get('name') !== 'error404') {

                        if (Security::check(Request::get('token'))) {

                            $pages->updateWhere('[slug="'.Request::get('slug').'"]', array('status' => Request::get('status')));

                            // Run delete extra actions
                            Action::run('admin_pages_action_update_status');

                            // Send notification
                            Notification::set('success', __('Your changes to the page <i>:page</i> have been saved.', 'pages', array(':page' => Request::get('slug'))));

                            // Redirect
                            Request::redirect('index.php?id=pages');
                            
                        } else { die('Request was denied because it contained an invalid security token. Please refresh the page and try again.'); }
                    }

                break;
            }

            // Its mean that you can add your own actions for this plugin
            Action::run('admin_pages_extra_actions');

        } else {

            // Index action
            // -------------------------------------

            // Init vars
            $pages_array = array();
            $count = 0;

            // Get pages
            $pages_list = $pages->select(null, 'all', null, array('slug', 'title', 'status', 'date', 'author', 'expand', 'access', 'parent', 'template', 'tags'));

            // Loop
            foreach ($pages_list as $page) {

                $pages_array[$count]['title']   = $page['title'];
                $pages_array[$count]['meta_title'] = isset($page['meta_title']) ? $page['meta_title'] : '';
                $pages_array[$count]['parent']  = $page['parent'];
                $pages_array[$count]['_status'] = $page['status'];
                $pages_array[$count]['_access'] = $page['access'];
                $pages_array[$count]['status']  = $status_array[$page['status']];
                $pages_array[$count]['access']  = isset($access_array[$page['access']]) ? $access_array[$page['access']] : $access_array['public']; // hack for old Monstra Versions
                $pages_array[$count]['date']    = $page['date'];
                $pages_array[$count]['author']  = $page['author'];
                $pages_array[$count]['expand']  = $page['expand'];
                $pages_array[$count]['slug']    = $page['slug'];
                $pages_array[$count]['tags']    = $page['tags'];
                $pages_array[$count]['template']= $page['template'];

                if (isset($page['parent'])) {
                    $c_p = $page['parent'];
                } else {
                    $c_p = '';
                }

                if ($c_p != '') {

                    $_page = $pages->select('[slug="'.$page['parent'].'"]', null);

                    if (isset($_page['title'])) {
                        $_title = $_page['title'];
                    } else {
                        $_title = '';
                    }

                    $pages_array[$count]['sort'] = $_title . ' ' . $page['title'];

                } else {

                    $pages_array[$count]['sort'] = $page['title'];

                }

                $_title = '';
                $count++;
            }

            // Sort pages
            $pages = Arr::subvalSort($pages_array, 'sort');

            // Display view
            View::factory('box/pages/views/backend/index')
                    ->assign('pages', $pages)
                    ->assign('site_url', $site_url)
                    ->display();
        }

    }
}
