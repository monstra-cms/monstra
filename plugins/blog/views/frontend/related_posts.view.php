<br><br>
<b><?php echo __('Related posts', 'blog'); ?>:</b>
<div>
<?php foreach($related_posts as $related_post) { ?>
<a href="<?php echo Option::get('siteurl'); ?>/<?php echo Blog::$parent_page_name; ?>/<?php echo $related_post['slug']; ?>"><?php echo $related_post['title']; ?></a><br>
<?php } ?>
</div>