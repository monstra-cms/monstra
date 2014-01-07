<div class="well dashboard-well">
	<div class="row">
		<div class="col-md-6">
			<a class="btn btn-link welcome-back">Welcome back, <strong>Monstra</strong></a>			
		</div>
		<div class="col-md-6">
			<div class="pull-right">
				<div class="btn-group">
				  <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">
				    Create New <span class="caret"></span>
				  </button>
				  <ul class="dropdown-menu" role="menu">
				    <li><a href="#">Page</a></li>
				    <li><a href="#">Block</a></li>
				    <li><a href="#">Snippet</a></li>
				  </ul>
				</div>

				<?php //echo ( Html::anchor(__('Create New Page', 'pages'), 'index.php?id=pages&action=add_page', array('title' => __('Create New Page', 'pages'), 'class' => 'btn btn-primary'))); ?>
				<?php echo ( Html::anchor(__('Upload File', 'pages'), 'index.php?id=pages&action=add_page', array('title' => __('Upload File', 'pages'), 'class' => 'btn btn-primary'))); ?>
			</div>
		</div>
	</div>
</div>

<div class="well dashboard-well">
	<div class="row">
		<div class="col-md-3">
			<h3>Content</h3>
			<ul class="list-unstyled">
				<?php Navigation::draw('content'); ?>
			</ul>
		</div>
		<div class="col-md-3">			
			<h3>Extends</h3>
			<ul class="list-unstyled">
				<?php Navigation::draw('extends'); ?>
			</ul>
		</div>			
		<div class="col-md-3">			
			<h3>System</h3>
			<ul class="list-unstyled">
				<?php Navigation::draw('system'); ?>
			</ul>
		</div>
		<div class="col-md-3">			
			<h3>Help</h3>
			<ul class="list-unstyled">
                <li><a href="http://monstra.org/documentation" target="_blank"><?php echo __('Documentation', 'system'); ?></a></li>              
                <li><a href="http://forum.monstra.org" target="_blank"><?php echo __('Official Support Forum', 'system'); ?></a></li>
			</ul>
		</div>
	</div>
</div>