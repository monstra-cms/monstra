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


class Navigation
{
    /**
     * Items
     *
     * @var array
     */
    public static $items = array();

    /**
     * Navigation types
     */
    const LEFT = 1;
    const TOP  = 2;

    /**
     * Add new item
     *
     *  <code>
     *      // Add link for left navigation
     *      Navigation::add(__('Blog'), 'content', 'blog', 11);
     *
     *      // Add link for top navigation
     *      Navigation::add(__('View site'), 'top', 'http://site.com/', 11, Navigation::TOP, true);
     *  <code>
     *
     * @param string  $name     Name
     * @param string  $category Category
     * @param stirng  $link     Link
     * @param integer $priority Priority. Default is 10
     * @param integer $type     Type. Default is LEFT
     * @param bool    $external External or not. Default is false
     */
    public static function add($name, $category, $id, $priority = 10, $type = Navigation::LEFT, $external = false)
    {
        Navigation::$items[] = array(
            'name'      => (string) $name,
            'category'  => (string) $category,
            'id'        => (string) $id,
            'priority'  => (int) $priority,
            'type'      => (int) $type,
            'external'  => (bool) $external,
        );
    }

    /**
     * Draw items
     *
     *  <code>
     *      Navigation::draw('content');
     *      Navigation::draw('top', Navigation::TOP);
     *  <code>
     *
     * @param string  $category Category
     * @param integer $type     Type. Default is LEFT
     */
    public static function draw($category, $type = Navigation::LEFT)
    {
        // Sort items by priority
        $items = Arr::subvalSort(Navigation::$items, 'priority');

        // Draw left navigation
        if ($type == Navigation::LEFT) {

            // Loop trough the items
            foreach ($items as $item) {

                // If current plugin id == selected item id then set class to current
                if (Request::get('id') == $item['id'] && $item['external'] == false) {
                    $class = 'class = "current" ';
                } else {
                    $class = '';
                }

                // If current category == item category and navigation type is left them draw this item
                if ($item['category'] == $category && $item['type'] == Navigation::LEFT) {

                    // Is external item id or not ?
                    if ($item['external'] == false) {
                        echo '<li><a '.$class.'href="index.php?id='.$item['id'].'">'.$item['name'].'</a></li>';
                    } else {
                        echo '<li><a target="_blank" href="'.$item['id'].'">'.$item['name'].'</a></li>';
                    }
                }
            }
        } elseif ($type == Navigation::TOP) {
            // Draw top navigation
            foreach ($items as $item) {
                if ($item['category'] == $category && $item['type'] == Navigation::TOP) {
                    if ($item['external'] == false) {
                        echo '<a class="btn btn-small btn-inverse" href="index.php?id='.$item['id'].'">'.$item['name'].'</a>'.Html::nbsp(2);
                    } else {
                        echo '<a target="_blank" class="btn btn-small btn-inverse" href="'.$item['id'].'">'.$item['name'].'</a>'.Html::nbsp(2);
                    }
                }
            }
        }
    }

    /**
     * Draw items
     *
     *  <code>
     *      Navigation::draw('content');
     *      Navigation::draw('top', Navigation::TOP);
     *  <code>
     *
     * @param string  $category Category
     * @param integer $type     Type. Default is LEFT
     */
    public static function get($category, $type = Navigation::LEFT)
    {
        // Sort items by priority
        $items = Arr::subvalSort(Navigation::$items, 'priority');

        // Draw left navigation
        if ($type == Navigation::LEFT) {

            // Loop trough the items
            foreach ($items as $item) {

                // If current plugin id == selected item id then set class to current
                if (Request::get('id') == $item['id'] && $item['external'] == false) {
                    $class = 'class = "current" ';
                } else {
                    $class = '';
                }

                // If current category == item category and navigation type is left them draw this item
                if ($item['category'] == $category && $item['type'] == Navigation::LEFT) {

                    // Is external item id or not ?
                    if ($item['external'] == false) {
                        echo '<li><a '.$class.'href="index.php?id='.$item['id'].'">'.$item['name'].'</a></li>';
                    } else {
                        echo '<li><a target="_blank" href="'.$item['id'].'">'.$item['name'].'</a></li>';
                    }
                }
            }
        } elseif ($type == Navigation::TOP) {
            // Draw top navigation
            foreach ($items as $item) {
                if ($item['category'] == $category && $item['type'] == Navigation::TOP) {
                    if ($item['external'] == false) {
                        echo '<a class="btn btn-small btn-inverse" href="index.php?id='.$item['id'].'">'.$item['name'].'</a>'.Html::nbsp(2);
                    } else {
                        echo '<a target="_blank" class="btn btn-small btn-inverse" href="'.$item['id'].'">'.$item['name'].'</a>'.Html::nbsp(2);
                    }
                }
            }
        }
    }

    /**
     * Draw dropdown items
     *
     *  <code>
     *      Navigation::getDropdown('content');
     *  <code>
     *
     * @param string $category Category
     */
    public static function getDropdown($category)
    {
        // Sort items by priority
        $items = Arr::subvalSort(Navigation::$items, 'priority');

        // Loop trough the items
        foreach ($items as $item) {

            // If current plugin id == selected item id then set class to current
            if (Request::get('id') == $item['id'] && $item['external'] == false) {
                $class = 'selected = "selected" ';
            } else {
                $class = '';
            }

            // If current category == item category and navigation type is left them draw this item
            if ($item['category'] == $category && $item['type'] == Navigation::LEFT) {

                // Is external item id or not ?
                if ($item['external'] == false) {
                    echo '<option '.$class.'rel="index.php?id='.$item['id'].'">'.$item['name'].'</option>';
                }
            }
        }
    }
}
