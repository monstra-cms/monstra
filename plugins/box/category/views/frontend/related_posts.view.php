
<div class="row">
<div class="col-md-12">
<h2>Articles Similaires</h2>
<?php 
$i = 0;
foreach($posts as $post) { 

if($i%2 == 0){?>
<div class="row">
<?php } ?>

<div class="col-md-6">
<div class="panel panel-default">
          <div class="panel-heading "><?php echo $post['title']; ?></div>
          <div class="panel-body ">
              <?php echo $post['content']; ?>
          </div>
          <div class="panel-footer">
          <a class="btn btn-sm btn-info" href="<?php echo Option::get('siteurl'); ?>/<?php echo Category::$parent_page_name; ?>/<?php echo $post['slug'] ?>">Lire la suite</a>
         </div>
</div>   
</div>
<?php if($i%2 == 0){?>
</div>
<?php } 
$i ++;
} ?>
</div>
</div>