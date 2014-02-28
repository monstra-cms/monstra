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
				<?php echo ( Html::anchor(__('Upload File', 'dashboard'), 'index.php?id=filesmanager', array('title' => __('Upload File', 'dashboard'), 'class' => 'btn btn-primary'))); ?>
			</div>
		</div>
	</div>
</div>

<script type="text/javascript" src="https://www.google.com/jsapi"></script>
<script type="text/javascript">
    google.load("visualization", "1", {packages:["corechart"]});
</script>
<input type="hidden" id="gaInitData" value='<?php echo json_encode(array(
    'clientId'  => Option::get('ga_client_id'),
    'apiKey'    => Option::get('ga_api_key'),
    'viewId'    => Option::get('ga_view_id')
)); ?>' />
<script src="https://apis.google.com/js/client.js?onload=glibOnloadHandle"></script>

<div class="well dashboard-well">
	<div class="row">
        <div class="col-md-10"><h4><?php echo __('Goggle Analytics', 'system'); ?></h4></div>
        <div class="col-md-2"><a href="#" class="gaSettingsLink"><?php echo __('Settings', 'system'); ?></a></div>
    </div>
	<div class="row">
		<div class="col-md-12">

			<div class="row alert-warning"><div class="col-md-12" id="gaAlerts"></div></div>

			<div class="row" id="gaLoading">
				<div class="col-md-12">Loading...</div>
			</div>

			<div id="authOk" class="row hide">
			    <div class="col-md-9">
			        
			        <div class="row">
			            <div class="col-md-12">
			                <div id="reportRange" class="pull-right">
                                <span class="glyphicon glyphicon-calendar"><?php echo date("F j, Y", strtotime('-30 day')); ?> - <?php echo date("F j, Y"); ?></span> <b class="caret"></b>
                            </div>
                        </div>
			        </div>
			        
			        <div class="row">
			            <div class="col-md-12">
			                <div id="gaChart" style="height:350px;"></div>
		                </div>
	                </div>
			    </div>
			    <div class="col-md-3">
			        <div><h3>Today</h3></div>
			            <div>Visits:<span id="gaVisits"></span></div>
			            <div>Visitors:<span id="gaVisitors"></span></div>
			            <div>Pageviews:<span id="gaPageviews"></span></div>
			    </div>
			</div>

			<div id="authFail" class="row hide">
				<div class="col-md-12">
					<button class="btn btn-default" id="authorizeButton"><?php echo __('Authorize', 'system'); ?></button>
				</div>
			</div>

            <div id="reauthError" class="row hide">
                <div class="col-md-12">
                    <?php echo __('Please check your analytics settings then exit from google account and authorize with right google analytics account.', 'system'); ?>
                </div>
            </div>

			<div id="gaSettings" class="row hide">
				<div class="col-md-12">
					<form method="POST">
						<?php echo Form::hidden('csrf', Security::token()); ?>
						
						<label><?php echo __('Client ID', 'system'); ?><input name="ga_client_id" value="<?php echo Option::get('ga_client_id'); ?>" placeholder="<?php echo __('Client ID', 'system'); ?>" /></label>
						
						<label><?php echo __('API key', 'system'); ?><input name="ga_api_key" value="<?php echo Option::get('ga_api_key'); ?>" placeholder="<?php echo __('API key', 'system'); ?>" /></label>
						
						<label><?php echo __('View ID', 'system'); ?><input name="ga_view_id" value="<?php echo Option::get('ga_view_id'); ?>" placeholder="<?php echo __('View ID', 'system'); ?>" /></label>
						
						<label><?php echo __('Tracking ID', 'system'); ?><input name="ga_tracking_id" value="<?php echo Option::get('ga_tracking_id'); ?>" placeholder="<?php echo __('Tracking ID', 'system'); ?>" /></label>
						
						<input type="hidden" name="ga_settings_update" value="1" />
						<button type="submit" class="btn btn-default"><?php echo __('Save', 'system'); ?></button>
					</form>
				</div>
			</div>

            <div id="gaHelpLink" class="row hide">
                <div class="col-md-12">
                    <br />Google Analytics help page: <a href="https://support.google.com/analytics/?hl=en" target="_blank">https://support.google.com/analytics/?hl=en</a>
                </div>
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
