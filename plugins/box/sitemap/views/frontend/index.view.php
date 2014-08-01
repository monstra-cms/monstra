
<ul>
<?php

    $sitemap_html = '';
    
    // Display pages
    if (count($pages_list) > 0) {
        $children_started = false;
        $first = true;
        foreach ($pages_list as $page) {
            
            if (trim($page['parent']) === '' && $children_started) { 
                $children_started = false;
                $sitemap_html .= "</li></ul></li>\n";
            } elseif(!$first && (trim($page['parent']) !== '' && $children_started || trim($page['parent']) === '')) {
                $sitemap_html .= "</li>\n";
            }
        
            if (trim($page['parent']) !== '') $parent = $page['parent'].'/'; else $parent = '';
            if (trim($page['parent']) !== '' && !$children_started) { 
                $children_started = true;
                $sitemap_html .= "<ul>\n"; 
            }
            $sitemap_html .= '<li><a href="'.Option::get('siteurl').'/'.$parent.$page['slug'].'">'.$page['title'].'</a>';
            $first = false;
        }
        if (trim($page['parent']) === '' && $children_started) { 
            $sitemap_html .= "</li></ul></li>\n"; 
        } else {
            $sitemap_html .= "</li>\n";
        }
    }



    // Display components
    if (count($components) > 0) {
        foreach ($components as $component) {
            $sitemap_html .= '<li><a href="'.Option::get('siteurl').'/'.$component.'">'.__(ucfirst($component), $component).'</a></li>'."\n";
        }
    }

    echo $sitemap_html;

?>
</ul>
