<?php Chunk::get('header'); ?>
    <div class="container">

        <div class="row">
            <div class="span12">
                <?php Action::run('theme_pre_content'); ?>
            </div>
        </div>

        <div class="row">
            <div class="span12">
                <?php echo Site::content(); ?>
            </div>
        </div>

        <div class="row">
            <div class="span12">
                <?php Action::run('theme_post_content'); ?>
            </div>
        </div>

        <hr>
<?php Chunk::get('footer'); ?>
