<?php foreach($posts as $post) { ?>
    <h3 class="monstra-blog-title"><a href="<?php echo Option::get('siteurl'); ?>/<?php echo Blog::$parent_page_name; ?>/<?php echo $post['slug'] ?>"><?php echo $post['title']; ?></a></h3>
    <small class="monstra-blog-date"><?php echo Date::format($post['date'], 'd M Y'); ?> / <?php echo $post['author']; ?></small>
    <div class="monstra-blog-post">
	    <?php echo $post['content']; ?>
    </div>    
<?php } ?>