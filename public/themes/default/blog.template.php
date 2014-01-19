<?php Chunk::get('header'); ?>
    <div class="container">

        <div class="row">
            <div class="col-xs-12">
                <?php Action::run('theme_pre_content'); ?>
            </div>
        </div>

        <div class="row">
            <div class="col-xs-8">
                <?php echo Blog::getPosts(3); ?>
            </div>
            <div class="col-xs-4">
                <h3>Tags</h3>
                <?php echo Blog::getTags(); ?>
            </div>
        </div>

        <div class="row">
            <div class="col-xs-12">
                <?php Action::run('theme_post_content'); ?>
            </div>
        </div>

        <hr>
<?php Chunk::get('footer'); ?>
