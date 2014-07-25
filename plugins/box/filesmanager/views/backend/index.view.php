<script type="text/javascript">
	$(document).ready(function(){
		$.monstra.fileuploader.init($.extend({}, {uploaderId:'DgDfileUploader'}, <?php echo json_encode($fileuploader); ?>));
		$(document).on('uploaded.fuploader', function(){
			location.href = $.monstra.fileuploader.conf.uploadUrl;
		});
	});
</script>

<h2 class="margin-bottom-1"><?php echo __('Files', 'filesmanager'); ?></h2>

<!-- Filesmanager_upload_files -->
    <div class="row">
    <?php
        echo (
            Form::open(null, array('enctype' => 'multipart/form-data', 'class' => 'form-inline')).
            Form::hidden('csrf', Security::token())
        );
    ?>    
    <div class="col-md-10">

    <div class="fileinput fileinput-new pull-left" data-provides="fileinput">
      <span class="btn btn-default btn-file"><span class="fileinput-new"><?php echo __('Select file', 'filesmanager'); ?></span><span class="fileinput-exists"><?php echo __('Change', 'filesmanager'); ?></span><input type="file" name="file"></span>
      <?php
          echo (
              Form::submit('upload_file', __('Upload', 'filesmanager'), array('class' => 'btn btn-primary')).
              Form::close()
          )
      ?>            
      <span class="fileinput-filename"></span>   
      <a href="#" class="close fileinput-exists" data-dismiss="fileinput" style="float: none">&times;</a>
    </div>

	<div id="DgDfileUploader" class="hidden-xs">
		<div class="upload-area">
			<div class="upload-progress"></div>
			<div class="upload-file-pholder"><?php echo __('Drop File Here', 'filesmanager'); ?></div>
		</div>
		<div class="upload-file-info"></div>
		<div class="btn btn-link file-size-max-upload hidden-sm hidden-md">
			<?php echo __('Maximum upload file size: :upload_max_filesize', 'filesmanager', array(':upload_max_filesize' => $upload_max_filesize)); ?>
		</div>
	</div>
    </div>
    <div class="col-md-2">
        <div class="pull-right create-new-dir">
        <button class="btn btn-primary" data-toggle="modal" data-target="#createNewDirectory">
          <?php echo __('Create New Directory', 'filesmanager'); ?>
        </button>
        </div>
    </div>
    </div>
<!-- /Filesmanager_upload_files -->

<!-- Filesmanger_path -->
<ol class="breadcrumb margin-top-1">

      <?php
        $path_parts = explode ('/',$path);

        foreach ($path_parts as $key => $value) {
            if ($path_parts[$key] == '') {
                unset($path_parts[$key]);
            }
        }

        $s = '';

        foreach ($path_parts as $p) {
            $s .= $p.'/';
            if($p == $current[count($current)-2]) $active = ' class="active"'; else $active = '';
            echo '<li'.$active.'><a href="index.php?id=filesmanager&path='.$s.'">'.$p.'</a></li>';
        }
    ?>
</ol>
<!-- /Filesmanger_path -->

<div class="table-responsive">
<table class="table table-bordered" id="filesDirsList">
    <thead>
        <tr>
            <th><?php echo __('Name', 'filesmanager'); ?></th>
            <th><?php echo __('Extension', 'filesmanager'); ?></th>
            <th><?php echo __('Size', 'filesmanager'); ?></th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        <?php if (isset($dir_list)) foreach ($dir_list as $dir) { ?>
        <tr>
            <td>
                <b><?php echo Html::anchor($dir, 'index.php?id=filesmanager&path='.$path.$dir.'/'); ?></b>
            </td>
            <td>

            </td>
            <td>
                <!-- Dir Size -->
            </td>
            <td>
            <div class="pull-right">
                <button class="btn btn-primary js-rename-dir" data-dirname="<?php echo $dir; ?>" data-path="<?php echo $path; ?>">
                    <?php echo __('Rename', 'filesmanager'); ?>
                </button>
                <?php echo Html::anchor(__('Delete', 'filesmanager'),
                           'index.php?id=filesmanager&delete_dir='.$dir.'&path='.$path.'&token='.Security::token(),
                           array('class' => 'btn btn-danger', 'onclick' => "return confirmDelete('".__('Delete directory: :dir', 'filesmanager', array(':dir' => $dir))."')"));
                ?>
            </div>
            </td>
        </tr>
        <?php } ?>
        <?php if (isset($files_list)) foreach ($files_list as $file) { $ext = File::ext($file); ?>
        <?php if ( ! in_array($ext, $forbidden_types)) {
			$dimension = '';
			if (in_array(strtolower($ext), $image_types)) {
				$dim = getimagesize($files_path. DS .$file);
				if (isset($dim[0]) && isset($dim[1])) { $dimension = $dim[1] .'x'. $dim[0] .' px'; }
			}
		?>
        <tr>
            <td<?php if (isset(File::$mime_types[$ext]) && preg_match('/image/', File::$mime_types[$ext])) echo ' class="image"'?>>
                <?php if (isset(File::$mime_types[$ext]) && preg_match('/image/', File::$mime_types[$ext])) { ?>
                    <?php echo Html::anchor(File::name($file), $site_url.'/public/' . $path.$file, array('rel' => $site_url.'/public/' . $path.$file, 'class' => 'chocolat', 'data-toggle' => 'lightbox'));?>
                <?php } else { ?>
                    <?php echo Html::anchor(File::name($file), $site_url.'/public/' . $path.$file, array('target'=>'_blank'));?>
                <?php } ?>
            </td>
            <td>
                <?php echo $ext; ?>
            </td>
            <td>
                <?php echo Number::byteFormat(filesize($files_path. DS .$file)); ?>
            </td>
            <td>
            <div class="pull-right">
				<button class="btn btn-info js-file-info"
					data-filename="<?php echo str_replace('"', '\'', htmlentities($file)); ?>"
					data-filetype="<?php echo $ext; ?>"
					data-filesize="<?php echo Number::byteFormat(filesize($files_path. DS .$file)); ?>"
					data-dimension="<?php echo htmlentities($dimension); ?>"
					data-link="<?php echo $site_url.'/public/' . $path.$file; ?>"
				>
					<?php echo __('Info', 'filesmanager'); ?>
				</button>
                <button class="btn btn-primary js-rename-file" data-filename="<?php echo $file; ?>" data-path="<?php echo $path; ?>">
                    <?php echo __('Rename', 'filesmanager'); ?>
                </button>
            <?php echo Html::anchor(__('Delete', 'filesmanager'),
                       'index.php?id=filesmanager&delete_file='.$file.'&path='.$path.'&token='.Security::token(),
                       array('class' => 'btn btn-danger', 'onclick' => "return confirmDelete('".__('Delete file: :file', 'filesmanager', array(':file' => $file))."')"));
            ?>
            </div>
            </td>
        </tr>
        <?php } } ?>
    </tbody>
</table>
</div>

<div id="createNewDirectory" class="modal fade" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <div class="close" data-dismiss="modal">&times;</div>
        <h4 class="modal-title" id="myModalLabel"><?php echo __('Create New Directory', 'filesmanager'); ?></h4>
      </div>
      <form role="form" method="POST">
        <?php echo Form::hidden('csrf', Security::token()); ?>
          <div class="modal-body">
            <label for="directoryName"><?php echo __('Directory Name', 'filesmanager'); ?></label>
            <input type="hidden" name="path" value="<?php echo $path; ?>" />
            <input type="text" class="form-control" id="directoryName" name="directory_name" />        
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo __('Cancel', 'filesmanager'); ?></button>
            <button type="submit" class="btn btn-primary"><?php echo __('Create', 'filesmanager'); ?></button>        
          </div>
      </form>
    </div>
  </div>
</div>

<div id="renameDialog" class="modal fade" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <div class="close" data-dismiss="modal">&times;</div>
        <h4 class="modal-title"><?php echo __('Rename', 'filesmanager'); ?></h4>
      </div>
      <form role="form" method="POST">
        <?php echo Form::hidden('csrf', Security::token()); ?>
        <div class="modal-body">
            <label for="renameTo">
                <span id="dirRenameType"><?php echo __('Directory:', 'filesmanager'); ?></span>
                <span id="fileRenameType"><?php echo __('File:', 'filesmanager'); ?></span>
                <strong id="renameToHolder"></strong>
            </label>
            <input type="hidden" name="path" value="" />
            <input type="hidden" name="rename_type" value="" />
            <input type="hidden" name="rename_from" value="" />
            <input type="text" class="form-control" id="renameTo" name="rename_to" />
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo __('Cancel', 'filesmanager'); ?></button>
          <button type="submit" class="btn btn-primary"><?php echo __('Rename', 'filesmanager'); ?></button>
        </div>
      </form>
    </div>
  </div>
</div>

<div id="fileInfoDialog" class="modal fade" tabindex="-1">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<div class="close" data-dismiss="modal">&times;</div>
				<h4 class="modal-title"><?php echo __('File Information', 'filesmanager'); ?></h4>
			</div>
			<div class="modal-body">
				<div class="row">
					<div class="col-md-3"><?php echo __('Filename', 'filesmanager'); ?>:</div>
					<div class="col-md-9 js-filename"></div>
				</div>
				<div class="row">
					<div class="col-md-3"><?php echo __('Filetype', 'filesmanager'); ?>:</div>
					<div class="col-md-9 js-filetype"></div>
				</div>
				<div class="row">
					<div class="col-md-3"><?php echo __('Filesize', 'filesmanager'); ?>:</div>
					<div class="col-md-9 js-filesize"></div>
				</div>
				<div class="row js-dimension-blck">
					<div class="col-md-3"><?php echo __('Dimension', 'filesmanager'); ?>:</div>
					<div class="col-md-9 js-dimension"></div>
				</div>
				<div class="row">
					<div class="col-md-3"><?php echo __('Link', 'filesmanager'); ?>:</div>
					<div class="col-md-9 js-link"></div>
				</div>
			</div>
		</div>
	</div>
</div>