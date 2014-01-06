<?php if ($parent) { ?>
    <a href="<?php echo Site::url().'/'.$page['parent']; ?>"><?php echo $parent_page['title']; ?></a>&nbsp;<span>&rarr;</span>&nbsp;<a href="<?php echo Site::url().'/'.$page['parent'].'/'.$page['slug']; ?>"><?php echo $page['title']; ?></a>
<?php } else { ?>
    <a href="<?php echo Site::url().'/'.$page['slug']; ?>"><?php echo $page['title']; ?></a>
<?php }
