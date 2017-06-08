<?php foreach($tags as $tag) { ?>
    <a href="<?php echo Option::get('siteurl'); ?>/<?php echo Category::$parent_page_name; ?>?tag=<?php echo $tag; ?>" class="monstra-Category-tag"><span class="label label-primary"><?php echo $tag; ?></span></a>
<?php } ?>