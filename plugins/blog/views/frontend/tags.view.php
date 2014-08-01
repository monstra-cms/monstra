<?php foreach($tags as $tag) { ?>
    <a href="<?php echo Option::get('siteurl'); ?>/<?php echo Blog::$parent_page_name; ?>?tag=<?php echo $tag; ?>" class="monstra-blog-tag"><span class="label label-primary"><?php echo $tag; ?></span></a>
<?php } ?>