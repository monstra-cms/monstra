{* Bootstrap core JavaScript *}
{* Placed at the end of the document so the pages load faster *}
<script src="<?php echo Url::getBase(); ?>/themes/<?php echo Config::get('site.theme'); ?>/bower_components/jquery/dist/jquery.min.js"></script>
<script src="<?php echo Url::getBase(); ?>}/themes/<?php echo Config::get('site.theme'); ?>/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<?php Action::run('theme_footer'); ?>
