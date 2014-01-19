<?php Chunk::get('header'); ?>
    <div class="container">

        <div class="row">
            <div class="col-xs-12">
                <?php Action::run('theme_pre_content'); ?>
            </div>
        </div>

        <div class="row">
            <div class="col-xs-12">
                <h3 class="monstra-blog-title"><?php echo Blog::getPostTitle(); ?></h3>
                <small class="monstra-blog-date"><?php echo Blog::getPostDate('d M Y'); ?> / <?php echo Blog::getPostAuthor(); ?></small>
                <div class="monstra-blog-post">
                    <?php echo Blog::getPost(); ?>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-xs-12">
                <?php Action::run('theme_post_content'); ?>
            </div>
        </div>

        <hr>
<?php Chunk::get('footer'); ?>
