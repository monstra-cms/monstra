<?php

// Add plugin navigation link
Navigation::add(__('Menu', 'menu'), 'content', 'menu', 4);

/**
 * Menu Admin Class
 */
class MenuAdmin extends Backend
{
    /**
     * Menu table
     *
     * @var object
     */
    public static $menu = null;

    /**
     * Main
     */
    public static function main()
    {
        // Get menu table
        MenuAdmin::$menu = new Table('menu');

        // Get pages table
        $pages = new Table('pages');

        // Create target array
        $menu_item_target_array = array( '' => '',
                                         '_blank' => '_blank',
                                         '_parent' => '_parent',
                                         '_top' => '_top');

        // Create order array
        $menu_item_order_array = range(0, 40);

        // Check for get actions
        // ---------------------------------------------
        if (Request::get('action')) {

            // Switch actions
            // -----------------------------------------
            switch (Request::get('action')) {

                // Edit menu item
                // -----------------------------------------
                case "edit":

                    // Select item
                    $item = MenuAdmin::$menu->select('[id="'.Request::get('item_id').'"]', null);

                    $menu_item_name       = $item['name'];
                    $menu_item_link       = $item['link'];
                    $menu_item_category   = $item['category'];
                    $menu_item_target     = $item['target'];
                    $menu_item_order      = $item['order'];

                    $errors = array();

                    // Edit current menu item
                    if (Request::post('menu_add_item')) {

                        if (Security::check(Request::post('csrf'))) {

                            if (trim(Request::post('menu_item_name')) == '') {

                                if (Request::post('menu_item_name')) $menu_item_name = Request::post('menu_item_name'); else $menu_item_name = $item['name'];
                                if (Request::post('menu_item_link')) $menu_item_link = Request::post('menu_item_link'); else $menu_item_link = $item['link'];
                                if (Request::post('menu_item_category')) $menu_item_category = Request::post('menu_item_category'); else $menu_item_category = $item['category'];
                                if (Request::post('menu_item_target')) $menu_item_target = Request::post('menu_item_target'); else $menu_item_target = $item['target'];
                                if (Request::post('menu_item_order')) $menu_item_order = Request::post('menu_item_order'); else $menu_item_order = $item['order'];

                                $errors['menu_item_name_empty'] = __('Required field', 'menu');
                            }

                            // Update menu item
                            if (count($errors) == 0) {
                                MenuAdmin::$menu->update(Request::get('item_id'),
                                                         array('name' => Request::post('menu_item_name'),
                                                              'link'       => Request::post('menu_item_link'),
                                                              'category'   => Security::safeName(Request::post('menu_item_category'), '-', true),
                                                              'target'     => Request::post('menu_item_target'),
                                                              'order'      => Request::post('menu_item_order')));

                                Request::redirect('index.php?id=menu');
                            }

                        } else { die('Request was denied because it contained an invalid security token. Please refresh the page and try again.'); }

                    }

                    // Display view
                    View::factory('box/menu/views/backend/edit')
                            ->assign('menu_item_name', $menu_item_name)
                            ->assign('menu_item_link', $menu_item_link)
                            ->assign('menu_item_category', $menu_item_category)
                            ->assign('menu_item_target', $menu_item_target)
                            ->assign('menu_item_order', $menu_item_order)
                            ->assign('menu_item_target_array', $menu_item_target_array)
                            ->assign('menu_item_order_array', $menu_item_order_array)
                            ->assign('errors', $errors)
                            ->assign('categories', MenuAdmin::getCategories())
                            ->assign('pages_list', MenuAdmin::getPages())
                            ->assign('components_list', MenuAdmin::getComponents())
                            ->display();

                break;

                // Add menu item
                // -----------------------------------------
                case "add":

                    $menu_item_name = '';
                    $menu_item_link = '';
                    $menu_item_category = '';
                    $menu_item_target = '';
                    $menu_item_order = '';
                    $errors = array();

                    // Get current category
                    $menu_item_category = $current_category = (Request::get('category')) ? Request::get('category') : '' ;

                    // Add new menu item
                    if (Request::post('menu_add_item')) {

                        if (Security::check(Request::post('csrf'))) {

                            if (trim(Request::post('menu_item_name')) == '') {

                                if (Request::post('menu_item_name')) $menu_item_name = Request::post('menu_item_name'); else $menu_item_name = '';
                                if (Request::post('menu_item_link')) $menu_item_link = Request::post('menu_item_link'); else $menu_item_link = '';
                                if (Request::post('menu_item_category')) $menu_item_category = Request::post('menu_item_category'); else $menu_item_category = $current_category;
                                if (Request::post('menu_item_target')) $menu_item_target = Request::post('menu_item_target'); else $menu_item_target = '';
                                if (Request::post('menu_item_order')) $menu_item_order = Request::post('menu_item_order'); else $menu_item_order = '';

                                $errors['menu_item_name_empty'] = __('Required field', 'menu');
                            }

                            // Insert new menu item
                            if (count($errors) == 0) {
                                MenuAdmin::$menu->insert(array('name' => Request::post('menu_item_name'),
                                                               'link'       => Request::post('menu_item_link'),
                                                               'category'   => Security::safeName(Request::post('menu_item_category'), '-', true),
                                                               'target'     => Request::post('menu_item_target'),
                                                               'order'      => Request::post('menu_item_order')));

                                Request::redirect('index.php?id=menu');
                            }

                        } else { die('Request was denied because it contained an invalid security token. Please refresh the page and try again.'); }
                    }

                    // Display view
                    View::factory('box/menu/views/backend/add')
                            ->assign('menu_item_name', $menu_item_name)
                            ->assign('menu_item_link', $menu_item_link)
                            ->assign('menu_item_category', $menu_item_category)
                            ->assign('menu_item_target', $menu_item_target)
                            ->assign('menu_item_order', $menu_item_order)
                            ->assign('menu_item_target_array', $menu_item_target_array)
                            ->assign('menu_item_order_array', $menu_item_order_array)
                            ->assign('errors', $errors)
                            ->assign('categories', MenuAdmin::getCategories())
                            ->assign('pages_list', MenuAdmin::getPages())
                            ->assign('components_list', MenuAdmin::getComponents())
                            ->display();

                break;
            }

        } else {

            // Delete menu item
            if (Request::get('delete_item')) {
                MenuAdmin::$menu->delete((int) Request::get('delete_item'));
            }

            // Display view
            View::factory('box/menu/views/backend/index')
                    ->assign('categories', MenuAdmin::getCategories())
                    ->assign('menu', MenuAdmin::$menu)
                    ->display();

        }

    }

    /**
     * Get categories
     */
    public static function getCategories()
    {
        $categories = array();

        $_categories = MenuAdmin::$menu->select(null, 'all', null, array('category'));

        foreach ($_categories as $category) {
            $categories[] = $category['category'];
        }

        return array_unique($categories);
    }

    /**
     * Get pages
     */
    protected static function getPages()
    {
        // Init vars
        $pages_array = array();
        $count = 0;

        // Get pages table
        $pages = new Table('pages');

        // Get Pages List
        $pages_list = $pages->select('[slug!="error404" and status="published"]');

        foreach ($pages_list as $page) {

            $pages_array[$count]['title']   = Html::toText($page['title']);
            $pages_array[$count]['parent']  = $page['parent'];
            $pages_array[$count]['date']    = $page['date'];
            $pages_array[$count]['author']  = $page['author'];
            $pages_array[$count]['slug']    = ($page['slug'] == Option::get('defaultpage')) ? '' : $page['slug'] ;

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
        $_pages_list = Arr::subvalSort($pages_array, 'sort');

        // return
        return $_pages_list;
    }

    /**
     * Get components
     */
    protected static function getComponents()
    {
        $components = array();

        if (count(Plugin::$components) > 0) {
            foreach (Plugin::$components as $component) {
                if ($component !== 'pages' && $component !== 'sitemap') $components[] = Text::lowercase($component);
            }
        }

        return $components;
    }

}
