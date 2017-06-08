<?php if ($parent) { ?>
    <a href="<?php echo Site::url()."/".$page['parent']; ?><?php if(Notification::get('tag')) { ?>?tag=<?php echo Notification::get('tag'); ?><?php } ?>"><?php echo $parent_page['title']; ?></a>&nbsp;<span>&rarr;</span>&nbsp;<a href="<?php echo Site::url().$page['parent'].'/'.$page['slug']; ?>"><?php echo $page['title']; ?></a>
<?php } else { ?>
    <a href="<?php echo Site::url()."/".$page['slug']; ?><?php if(Notification::get('tag')) { ?>?tag=<?php echo Notification::get('tag'); ?><?php } ?>"><?php echo $page['title']; ?></a>
<?php } ?>