<script type="text/javascript">
	(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
		(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
		m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
	})(window,document,'script','//www.google-analytics.com/analytics.js','_mga');

	_mga('create', '<?php echo Option::get('ga_tracking_id'); ?>', 'auto');
	_mga('send', 'pageview', {
		'page': '<?php echo Url::current(); ?>',
		'title': '<?php echo Site::title(); ?>'
	});
</script>