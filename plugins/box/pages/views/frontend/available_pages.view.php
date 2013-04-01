<ul>
<?php foreach ($pages as $page) { ?>
    <li><a href="<?php echo $page['parent'].'/'.$page['slug']; ?>"><?php echo $page['title']; ?></a></li>
<?php } ?>
</ul>
