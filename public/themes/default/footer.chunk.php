        <footer>
                <div class="pull-left"><?php echo Chunk::get('footer-links'); ?></div>
                <div class="pull-right"><?php Action::run('theme_footer'); ?><?php echo Site::powered(); ?></div>
        </footer>

    </div> <!-- /container -->

    <?php echo Snippet::get('google-analytics'); ?>
  </body>
</html>
