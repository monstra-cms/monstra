<ul class="pagination pagination-sm" style="margin: auto">
<?php

    if (Request::get('tag')) $tag = '&tag='.Request::get('tag'); else $tag = '';

    $neighbours = 6;
    $left_neighbour = $page - $neighbours;
    if ($left_neighbour < 1) $left_neighbour = 1;

    $right_neighbour = $page + $neighbours;
    if ($right_neighbour > $pages) $right_neighbour = $pages;

    if ($page > 1) {
     // echo '<li><a href="?page=1'.$tag.'"> << </a></li>';
      echo '<li><a href="?page=' . ($page-1) . $tag.'"> < </a></li>';
    }else{
    //  echo '<li class="disabled"><a href="#"> << </a></li>';      
      echo '<li class="disabled"><a href="#"> < </a></li>';

    }

    for ($i=$left_neighbour; $i<=$right_neighbour; $i++) {
        if ($i != $page) {
            echo '<li><a href="?page=' . $i . $tag.'">' . $i . '</a></li>';
        } else {
            echo '<li class="active"><a href="#"><b>' . $i . '</b></a></li>';
        }
    }

    if ($page < $pages) {
        echo  '<li><a href="?page=' . ($page+1) . $tag.'"> > </a></li>';
     //   echo  '<li><a href="?page=' . $pages . $tag.'"> >> </a></li>';
    }else{

          echo  '<li class="disabled"><a href="#"> > </a></li>';
     //   echo  '<li class="disabled"><a href="#"> >> </a></li>';
    }

?>

</ul>
				