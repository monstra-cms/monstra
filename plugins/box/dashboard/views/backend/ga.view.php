
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
				<div class="col-md-4">
					<form method="POST">
						<?php echo Form::hidden('csrf', Security::token()); ?>						
						<div class="form-group">
							<label><?php echo __('Client ID', 'system'); ?></label><input name="ga_client_id" class="form-control" value="<?php echo Option::get('ga_client_id'); ?>">
						</div>					
						<div class="form-group">	
							<label><?php echo __('API key', 'system'); ?></label><input name="ga_api_key" class="form-control" value="<?php echo Option::get('ga_api_key'); ?>">
						</div>												
						<div class="form-group">	
							<label><?php echo __('View ID', 'system'); ?></label><input name="ga_view_id" class="form-control" value="<?php echo Option::get('ga_view_id'); ?>">
						</div>						
						<div class="form-group">	
							<label><?php echo __('Tracking ID', 'system'); ?></label><input name="ga_tracking_id" class="form-control" value="<?php echo Option::get('ga_tracking_id'); ?>">
						</div>						
						<input type="hidden" name="ga_settings_update" value="1" />
						<div class="form-group">
							<button type="submit" class="btn btn-primary"><?php echo __('Save', 'system'); ?></button>
						</div>
					</form>
				</div>
			</div>

            <div id="gaHelpLink" class="row hide">
                <div class="col-md-12">
                    Google Analytics help page: <a href="https://support.google.com/analytics/?hl=en" target="_blank">https://support.google.com/analytics/?hl=en</a>
                </div>
            </div>

		</div>
	</div>
</div>
