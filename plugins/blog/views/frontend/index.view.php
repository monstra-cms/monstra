<?php foreach($posts as $post) { ?>
    <a href="<?php echo Option::get('siteurl'); ?>/<?php echo Blog::$parent_page_name; ?>/<?php echo $post['slug'] ?>"><?php echo $post['title']; ?></a> <small  class="monstra-blog-date"><?php echo Date::format($post['date'], 'd M Y'); ?></small><br>
    <?php echo $post['content']; ?>
    <br><br>
<?php } ?>
