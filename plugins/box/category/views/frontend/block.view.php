<?php foreach($posts as $post) { ?>
    
<div class="panel panel-default">
          <div class="panel-heading "><a href="<?php echo Option::get('siteurl'); ?>/<?php echo Blog::$parent_page_name; ?>/<?php echo $post['slug'] ?>"><?php echo $post['title']; ?></a></div>
          <div class="panel-body ">
            	    <?php echo $post['content']; ?>
          </div>
</div>  
<?php } ?>	