<h2 class="margin-bottom-1"><?php echo __('Plugins', 'plugins'); ?></h2>

<div class="tabbable mobile-nav-tabs">

    <!-- Plugins_tabs -->
    <ul class="nav nav-tabs">
        <li class="active"><a href="#installed" data-toggle="tab"><?php echo __('Installed', 'plugins'); ?></a></li>
        <li><a href="#installnew" data-toggle="tab"><?php echo __('Install New', 'plugins'); ?> <?php if (count($plugins_to_intall) > 0) { ?><span class="badge"><?php echo count($plugins_to_intall); ?></span><?php } ?></a></li>
        <li><a href="http://monstra.org/download/plugins" target="_blank"><?php echo __('Get More Plugins', 'plugins'); ?></a></li>
    </ul>
    <!-- /Plugins_tabs -->

    <div class="tab-content">

        <div class="tab-pane active" id="installed">
            <div class="table-responsive">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th><?php echo __('Name', 'plugins'); ?></th>
                        <th class="hidden-phone"><?php echo __('Description', 'plugins'); ?></th>
                        <th><?php echo __('Author', 'plugins'); ?></th>
                        <th><?php echo __('Version', 'plugins'); ?></th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($installed_plugins as $plugin) { if ($plugin['privilege'] !== 'box') { ?>
                    <tr>
                        <td>
                            <?php echo $plugin['title']; ?>
                        </td>
                        <td class="hidden-phone">
                           <?php echo $plugin['description']; ?>
                        </td>
                        <td>
                           <a target="_blank" href="<?php echo $plugin['author_uri']; ?>"><?php echo $plugin['author']; ?></a>
                        </td>
                        <td>
                            <?php echo $plugin['version']; ?>
                        </td>
                        <td>
                            <div class="pull-right">
                            <?php if (File::exists(PLUGINS . DS . $plugin['id'] . DS . 'README.md')) { ?>
                            <?php echo Html::anchor(__('Info', 'plugins'),
                                       '#',
                                       array('class' => 'btn btn-info hidden-sm hidden-md readme_plugin', 'data-toggle' => 'modal', 'data-target' => '#readme', 'readme_plugin' => $plugin['id']));
                            ?>
                            <?php } ?>
                            <?php echo Html::anchor(__('Uninstall', 'plugins'),
                                       'index.php?id=plugins&delete_plugin='.$plugin['id'].'&token='.Security::token(),
                                       array('class' => 'btn btn-danger', 'onclick' => "return confirmDelete('".__('Delete plugin :plugin', 'plugins', array(':plugin' => $plugin['title']))."')"));
                            ?>
                            </div>
                        </td>
                    </tr>
                    <?php } } ?>
                </tbody>
            </table>
            </div>
        </div>

         <div class="tab-pane" id="installnew">
            <div class="table-responsive">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th><?php echo __('Name', 'plugins'); ?></th>
                        <th class="hidden-phone"><?php echo __('Description', 'plugins'); ?></th>
                        <th><?php echo __('Author', 'plugins'); ?></th>
                        <th><?php echo __('Version', 'plugins'); ?></th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>

                    <?php foreach ($plugins_to_intall as $plug) { $plugin_xml = XML::loadFile($plug['path']); ?>
                    <tr>
                        <td>
                            <?php echo $plugin_xml->plugin_name; ?>
                        </td>
                        <td class="hidden-phone">
                           <?php echo $plugin_xml->plugin_description; ?>
                        </td>
                        <td>
                           <a href="<?php echo $plugin_xml->plugin_author_uri; ?>"><?php echo $plugin_xml->plugin_author; ?></a>
                        </td>
                        <td>
                            <?php echo $plugin_xml->plugin_version; ?>
                        </td>
                        <td>
                            <div class="pull-right">
                            <?php if (File::exists(PLUGINS . DS . basename($plug['plugin'], '.manifest.xml') . DS . 'README.md')) { ?>
                            <?php echo Html::anchor(__('Info', 'plugins'),
                                       '#',
                                       array('class' => 'btn btn-info readme_plugin', 'data-toggle' => 'modal', 'data-target' => '#readme', 'readme_plugin' => basename($plug['plugin'], '.manifest.xml')));
                            ?>
                            <?php } ?>
                            <?php echo Html::anchor(__('Install', 'plugins'), 'index.php?id=plugins&install='.$plug['plugin'].'&token='.Security::token(), array('class' => 'btn btn-primary')); ?>
                            <?php echo Html::anchor(__('Delete', 'plugins'),
                                       'index.php?id=plugins&delete_plugin_from_server='.Text::lowercase(basename($plug['path'],'.manifest.xml')).'&token='.Security::token(),
                                       array('class' => 'btn btn-danger', 'onclick' => "return confirmDelete('".__('Delete plugin :plugin', 'plugins', array(':plugin' => $plugin_xml->plugin_name))."')"));
                             ?>
                            </div>
                        </td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
            </div>

		 <?php if (strtoupper(substr(PHP_OS, 0, 3)) !== 'WIN'): ?>
			<div class="row">
				<div class="col-md-12">
					<?php
						echo (
							Form::open(null, array('enctype' => 'multipart/form-data', 'class' => 'form-inline')).
							Form::hidden('csrf', Security::token())
						);
					?>
					<div class="fileinput fileinput-new pull-left" data-provides="fileinput">
						<span class="btn btn-default btn-file"><span class="fileinput-new"><?php echo __('Select file', 'filesmanager'); ?></span><span class="fileinput-exists"><?php echo __('Change', 'filesmanager'); ?></span><input type="file" name="file"></span>
							<?php
								echo (
									Form::submit('upload_file', __('Upload', 'plugins'), array('class' => 'btn btn-primary')).
									Form::close()
								);
							?>
						<span class="fileinput-filename"></span>
					</div>
					<div id="DgDfileUploader">
						<div class="upload-area">
							<div class="upload-progress"></div>
							<div class="upload-file-pholder"><?php echo __('Drop File Here', 'plugins'); ?></div>
						</div>
						<div class="upload-file-info"></div>
					</div>
				</div>
			</div>
		 <?php endif; ?>

        </div>
        <!-- /Plugins_to_install_list -->

    </div>

</div>

<script>
    $(document).ready(function () {
        $('.readme_plugin').click(function() {
            $.ajax({
                type:"post",
                data:"readme_plugin="+$(this).attr('readme_plugin'),
                url: "<?php echo Site::url(); ?>/admin/index.php?id=plugins",
                success: function(data){
                    $('#readme .modal-body').html(data);
                }
            });
        });
		$.monstra.fileuploader.init($.extend({}, {uploaderId:'DgDfileUploader'}, <?php echo json_encode($fileuploader); ?>));
		$(document).on('uploaded.fuploader', function(){
			location.href = $.monstra.fileuploader.conf.uploadUrl +'#installnew';
			window.location.reload(true);
		});
    });
</script>


<!-- Modal -->
<div class="modal fade" id="readme" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <div class="close" data-dismiss="modal">&times;</div>
        <h4 class="modal-title" id="myModalLabel">README.md</h4>
      </div>
      <div class="modal-body"></div>
    </div>
  </div>
</div>
