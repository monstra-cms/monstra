<?php Chunk::get('header'); ?>
    <div class="container">

        <div class="row">
            <div class="span12">
                <?php Action::run('theme_pre_content'); ?>
            </div>
        </div>

        <!-- Main hero unit for a primary marketing message or call to action -->
        <div class="hero-unit">
            <?php echo Block::get('hero-unit'); ?>
        </div>

        <!-- Example row of columns -->
        <div class="row">
            <?php echo Block::get('marketing'); ?>
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
    