<?php Chunk::get('header'); ?>
    <div class="container">

        <div>
            <?php Action::run('theme_pre_content'); ?>
        </div>

        <div>
            <?php echo Site::content(); ?>
        </div>

        <div>
            <?php Action::run('theme_post_content'); ?>
        </div>

        <hr>
<?php Chunk::get('footer'); ?>   
    