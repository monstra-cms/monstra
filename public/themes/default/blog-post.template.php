<?php Chunk::get('header'); ?>

<div class="container-wide">

    <div class="container">

        <div class="row">
            <div class="col-xs-12">
                <?php Action::run('theme_pre_content'); ?>
            </div>
        </div>

        <div class="row">
            <div class="col-xs-12">
                <div class="monstra-blog-post">
                    <?php echo Blog::getPost(); ?>
                </div>
                <small class="monstra-blog-date"><?php echo Blog::getPostDate('d M Y'); ?> / <?php echo Blog::getPostAuthor(); ?></small>
            </div>
        </div>

        <div class="row">
            <div class="col-xs-12">
                <?php Action::run('theme_post_content'); ?>
            </div>
        </div>

    </div>
    
</div>
<?php Chunk::get('footer'); ?>
