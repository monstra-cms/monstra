<br><br>
<?php

    if (Request::get('tag')) $tag = '&tag='.Request::get('tag'); else $tag = '';

    $neighbours = 6;
    $left_neighbour = $page - $neighbours;
    if ($left_neighbour < 1) $left_neighbour = 1;

    $right_neighbour = $page + $neighbours;
    if ($right_neighbour > $pages) $right_neighbour = $pages;

    if ($page > 1) {
        echo ' <a href="?page=1'.$tag.'">'.__('begin', 'blog').'</a> ... <a href="?page=' . ($page-1) . $tag.'"> '.__('prev', 'blog').'</a> ';
    }

    for ($i=$left_neighbour; $i<=$right_neighbour; $i++) {
        if ($i != $page) {
            echo ' <a href="?page=' . $i . $tag.'">' . $i . '</a> ';
        } else {
            echo ' <b>' . $i . '</b> ';
        }
    }

    if ($page < $pages) {
        echo  ' <a href="?page=' . ($page+1) . $tag.'">'.__('next', 'blog').'</a> ... <a href="?page=' . $pages . $tag.'">'.__('end', 'blog').'</a> ';
    }

?>
