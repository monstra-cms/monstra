<h2><?php echo __('Files', 'filesmanager'); ?></h2>
<br />

<!-- Filesmanager_upload_files -->
    <?php
        echo (
            Form::open(null, array('enctype' => 'multipart/form-data')).
            Form::hidden('csrf', Security::token()).
            Form::input('file', null, array('type' => 'file', 'size' => '25')).Html::br().
            Form::submit('upload_file', __('Upload', 'filesmanager'), array('class' => 'btn')).
            Form::close()
        )
    ?>
<!-- /Filesmanager_upload_files -->

<!-- Filesmanger_path -->
<ul class="breadcrumb">

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
            echo '<li'.$active.'><a href="index.php?id=filesmanager&path='.$s.'">'.$p.'</a> <span class="divider">/</span></li>';     
        }    
    ?>
</ul>
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
                <?php echo Number::byteFormat(Dir::size(UPLOADS . DS . $dir)); ?>
            </td>
            <td>
            <div class="pull-right">
            <?php echo Html::anchor(__('Delete', 'filesmanager'),
                       'index.php?id=filesmanager&delete_dir='.$dir.'&path='.$path.'&token='.Security::token(),
                       array('class' => 'btn btn-small', 'onclick' => "return confirmDelete('".__('Delete directory: :dir', 'filesmanager', array(':dir' => $dir))."')"));
            ?>
            <div>
            </td>
        </tr>
        <?php } ?>    
        <?php if (isset($files_list)) foreach ($files_list as $file) { $ext = File::ext($file); ?>
        <?php if ( ! in_array($ext, $forbidden_types)) { ?>
        <tr>        
            <td<?php if (isset(File::$mime_types[$ext]) && preg_match('/image/', File::$mime_types[$ext])) echo ' class="image"'?>>
                <?php echo Html::anchor(File::name($file), $site_url.'public/' . $path.$file, array('target'=>'_blank'));?>
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
                       array('class' => 'btn btn-small', 'onclick' => "return confirmDelete('".__('Delete file: :file', 'filesmanager', array(':file' => $file))."')"));
            ?>                      
            </div>
            </td>
        </tr>        
        <?php } } ?> 
    </tbody>
</table>

<div id="showImage" class="modal hide fade">
    <div class="modal-header">
        <a class="close" data-dismiss="modal">×</a>
        <h3><?php echo __('Image:', 'filesmanager')?> <span></span></h3>
    </div>
    <div class="modal-body">
        <p align="center"><img /></p>
    </div>
</div>