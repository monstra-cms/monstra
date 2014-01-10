<h2><?php echo __('Files', 'filesmanager'); ?></h2>
<br>

<!-- Filesmanager_upload_files -->
    <div class="row">
    <?php
        echo (
            Form::open(null, array('enctype' => 'multipart/form-data', 'class' => 'form-inline')).
            Form::hidden('csrf', Security::token())
        );
    ?>    
    <div class="col-md-6">
    <div class="fileupload fileupload-new" data-provides="fileupload">
      <button class="btn btn-default btn-file"><span class="fileupload-new"><?php echo __('Select file', 'filesmanager'); ?></span><span class="fileupload-exists"><?php echo __('Change', 'filesmanager'); ?></span><input type="file" name="file" /></button>
    <?php
        echo (
            Form::submit('upload_file', __('Upload', 'filesmanager'), array('class' => 'btn btn-primary')).
            Form::close()
        )
    ?>      
      <span class="fileupload-preview"></span>
      <a href="#" class="close fileupload-exists" data-dismiss="fileupload">×</a>
    </div>
    </div>
    <div class="col-md-6">
        <div class="pull-right">
        <button class="btn btn-primary" data-toggle="modal" data-target="#createNewFile">
          Create New File
        </button>
        <button class="btn btn-primary" data-toggle="modal" data-target="#createNewDirectory">
          Create New Directory
        </button>
        </div>
    </div>
    </div>
<!-- /Filesmanager_upload_files -->

<br>
<!-- Filesmanger_path -->
<ol class="breadcrumb">

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


<table class="table table-bordered">
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
            <?php echo Html::anchor(__('Delete', 'filesmanager'),
                       'index.php?id=filesmanager&delete_dir='.$dir.'&path='.$path.'&token='.Security::token(),
                       array('class' => 'btn btn-danger', 'onclick' => "return confirmDelete('".__('Delete directory: :dir', 'filesmanager', array(':dir' => $dir))."')"));
            ?>
            <div>
            </td>
        </tr>
        <?php } ?>
        <?php if (isset($files_list)) foreach ($files_list as $file) { $ext = File::ext($file); ?>
        <?php if ( ! in_array($ext, $forbidden_types)) { ?>
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


<div id="createNewFile" class="modal fade" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" id="myModalLabel">Create New File</h4>
      </div>
      <div class="modal-body">
        <form role="form">        
            <label for="directoryName">File Name</label>
            <input type="text" class="form-control" id="directoryName">        
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
        <button type="button" class="btn btn-primary">Create</button>
      </div>
    </div>
  </div>
</div>

<div id="createNewDirectory" class="modal fade" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" id="myModalLabel">Create New Directory</h4>
      </div>
      <form role="form" method="POST">
        <?php echo Form::hidden('csrf', Security::token()); ?>
        <div class="modal-body">
        
            <label for="directoryName">Directory Name</label>
            <input type="hidden" name="path" value="<?php echo $path; ?>" />
            <input type="text" class="form-control" id="directoryName" name="directory_name" />
        
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
            <button type="submit" class="btn btn-primary">Create</button>
        
          </div>
      </form>
    </div>
  </div>
</div>
