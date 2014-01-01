<h3><?php echo __('Sitemap', 'sitemap'); ?></h3>
<hr>
<ul>
<?php


    // Display pages
    if (count($pages_list) > 0) {
        foreach ($pages_list as $page) {
            if (trim($page['parent']) !== '') $parent = $page['parent'].'/'; else $parent = '';
            if (trim($page['parent']) !== '') { echo '<ul>'."\n"; }
            echo '<li><a href="'.Option::get('siteurl').$parent.$page['slug'].'">'.$page['title'].'</a></li>'."\n";
            if (trim($page['parent']) !== '') { echo '</ul>'."\n"; }
        }
        if (count($components) == 0) { echo '<ul>'."\n"; }
    }



    // Display components
    if (count($components) > 0) {
        if (count($pages_list) == 0) { echo '<ul>'."\n"; }
        foreach ($components as $component) {
            echo '<li><a href="'.Option::get('siteurl').$component.'">'.__(ucfirst($component), $component).'</a></li>'."\n";
        }
        if (count($pages_list) == 0) { echo '</ul>'."\n"; }
    }

?>
</ul>
