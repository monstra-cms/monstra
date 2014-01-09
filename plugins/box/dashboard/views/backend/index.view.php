<div class="well dashboard-well">
	<div class="row">
		<div class="col-md-6">
			<a class="btn btn-link welcome-back"><?php echo __('Welcome back', 'dashboard'); ?>, <strong><?php echo Session::get('user_login'); ?></strong></a>
		</div>
		<div class="col-md-6">
			<div class="pull-right">
				<div class="btn-group">
				  <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">
				    <?php echo __('Create New', 'dashboard'); ?> <span class="caret"></span>
				  </button>
				  <ul class="dropdown-menu" role="menu">
				    <li><?php echo ( Html::anchor(__('Page', 'pages'), 'index.php?id=pages&action=add_page', array('title' => __('Page', 'pages')))); ?></li>
				    <li><?php echo ( Html::anchor(__('Blocks', 'blocks'), 'index.php?id=blocks&action=add_block', array('title' => __('Block', 'pages')))); ?></li>
				    <li><?php echo ( Html::anchor(__('Snippets', 'snippets'), 'index.php?id=snippets&action=add_snippet', array('title' => __('Snippet', 'pages')))); ?></li>
				  </ul>
				</div>			
				<?php echo ( Html::anchor(__('Upload File', 'filesmanager'), 'index.php?id=filesmanager', array('title' => __('Upload File', 'filesmanager'), 'class' => 'btn btn-primary'))); ?>
			</div>
		</div>
	</div>
</div>

<div class="well dashboard-well">
	<div class="row">
		<div class="col-md-3">
			<h3><?php echo __('Content', 'pages'); ?></h3>
			<ul class="list-unstyled">
				<?php Navigation::draw('content'); ?>
			</ul>
		</div>
		<div class="col-md-3">			
			<h3><?php echo __('Extends', 'system'); ?></h3>
			<ul class="list-unstyled">
				<?php Navigation::draw('extends'); ?>
			</ul>
		</div>			
		<div class="col-md-3">			
			<h3><?php echo __('System', 'system'); ?></h3>
			<ul class="list-unstyled">
				<?php Navigation::draw('system'); ?>
			</ul>
		</div>
		<div class="col-md-3">			
			<h3><?php echo __('Help', 'system'); ?></h3>
			<ul class="list-unstyled">
                <li><a href="http://monstra.org/documentation" target="_blank"><?php echo __('Documentation', 'system'); ?></a></li>              
                <li><a href="http://forum.monstra.org" target="_blank"><?php echo __('Official Support Forum', 'system'); ?></a></li>
			</ul>
		</div>
	</div>
</div>