
        <footer>
            <p>            
                <div style="float:left;"><?php echo Chunk::get('footer-links'); ?></div>
                <div style="float:right;"><?php Action::run('theme_footer'); ?><?php echo Site::powered(); ?></div>
            </p>            
        </footer>

    </div> <!-- /container -->

    <!-- Javascript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script type="text/javascript" src="<?php echo Option::get('siteurl'); ?>public/assets/js/jquery.js"></script>
    <script type="text/javascript" src="<?php echo Option::get('siteurl'); ?>public/assets/js/bootstrap.js"></script>
    <?php Javascript::load(); ?>

  </body>
</html>
