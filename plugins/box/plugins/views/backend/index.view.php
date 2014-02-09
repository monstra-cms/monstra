<h2><?php echo __('Plugins', 'plugins'); ?></h2>
<br>

<input type="hidden" id="fUploaderInit" value='<?php echo json_encode($fileuploader); ?>' />

<div class="tabbable">

    <!-- Plugins_tabs -->
    <ul class="nav nav-tabs">
        <li class="active"><a href="#installed" data-toggle="tab"><?php echo __('Installed', 'plugins'); ?></a></li>
        <li><a href="#installnew" data-toggle="tab"><?php echo __('Install New', 'plugins'); ?> <?php if (count($plugins_to_intall) > 0) { ?><span class="badge"><?php echo count($plugins_to_intall); ?></span><?php } ?></a></li>
        <li><a href="http://plugins.monstra.org" target="_blank"><?php echo __('Get More Plugins', 'plugins'); ?></a></li>
    </ul>
    <!-- /Plugins_tabs -->

    <div class="tab-content">

        <div class="tab-pane active" id="installed">
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
                            <?php echo Html::anchor(__('?', 'plugins'),
                                       '#'.$plugin['id'],
                                       array('class' => 'btn btn-info', 'data-toggle' => 'modal', 'data-target' => '#readme'));
                            ?>
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

         <div class="tab-pane" id="installnew">
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

        <div class="row">
            <div class="col-md-12">
                <?php
                    echo (
                        Form::open(null, array('enctype' => 'multipart/form-data', 'class' => 'form-inline')).
                        Form::hidden('csrf', Security::token())
                    );
                ?>
                <div class="fileupload fileupload-new fileupload-controls" data-provides="fileupload">
                    <button class="btn btn-default btn-file"><span class="fileupload-new"><?php echo __('Select file', 'plugins'); ?></span><span class="fileupload-exists"><?php echo __('Change', 'plugins'); ?></span><input type="file" name="file" /></button>
                        <?php
                            echo (
                                Form::submit('upload_file', __('Upload', 'plugins'), array('class' => 'btn btn-primary')).
                                Form::close()
                            );
                        ?>
                    <span class="fileupload-preview"></span>

                </div>
                <div id="uploadArea" class="upload-area">
                    <div id="fuProgress" class="upload-progress"></div>
                    <div id="fuPlaceholder" class="upload-file-pholder"><?php echo __('Drop File Here', 'plugins'); ?></div>
                </div>
                <div id="fileInfo" class="upload-file-info"></div>
            </div>
        </div>

        </div>
        <!-- /Plugins_to_install_list -->

    </div>

</div>


<!-- Modal -->
<div class="modal fade" id="readme" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" id="myModalLabel">Modal title</h4>
      </div>
      <div class="modal-body">
        
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Save changes</button>
      </div>
    </div>
  </div>
</div>
