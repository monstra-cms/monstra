<ul>
<?php
    foreach ($pages as $page) {
        if ($page['status'] == 'published') {
?>
    <li><a href="<?php echo $page['parent'].'/'.$page['slug']; ?>"><?php echo $page['title']; ?></a></li>
<?php
        }
    }
?>
</ul>
