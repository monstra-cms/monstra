<h3><?php echo __('Sitemap', 'sitemap'); ?></h3>
<hr>
<ul>
<?php

    // Display pages
    if (count($pages_list) > 0) {
        foreach ($pages_list as $page) {
            if (trim($page['parent']) !== '') $parent = $page['parent'].'/'; else $parent = '';
            if (trim($page['parent']) !== '') { echo '<ul>'; }
            echo '<li><a href="'.Option::get('siteurl').$parent.$page['slug'].'">'.$page['title'].'</a></li>';
            if (trim($page['parent']) !== '') { echo '</ul>'; }
        }
        if (count($components) == 0) { echo '<ul>'; }
    }

    // Display components
    if (count($components) > 0) {
        if (count($pages_list) == 0) { echo '<ul>'; }
        foreach ($components as $component) {
            echo '<li><a href="'.Option::get('siteurl').$component.'">'.__(ucfirst($component), $component).'</a></li>';
        }
        echo '</ul>';

    }

?>
</ul>
