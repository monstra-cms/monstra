<?php foreach($posts as $post) { ?>
       
<div class="panel panel-primary">
          <div class="panel-heading "><?php echo $post['title']; ?></div>
          <div class="panel-body ">
            	    <?php echo $post['content']; ?>
          </div>
          <div class="panel-footer">
          <a class="btn btn-sm btn-info" href="<?php echo Option::get('siteurl'); ?>/<?php echo Category::$parent_page_name; ?>/<?php echo $post['slug'] ?>">Lire la suite</a>
         </div>
</div>   
<?php } ?>			