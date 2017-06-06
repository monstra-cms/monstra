<script>$().ready(function(){$('[name=create_backup]').click(function(){$(this).button('loading');});});</script>

<div class="vertical-align margin-bottom-1">
    <div class="text-left row-phone">
        <h2><?php echo __('Backups', 'backup'); ?></h2>
    </div>
    <div class="text-right row-phone">
        <?php
            echo (
                Form::open(null, array('class' => 'form-inline')) .
                Form::hidden('csrf', Security::token()).
                Form::submit('create_backup', __('Create Backup', 'backup'), array('class' => 'btn btn-phone btn-primary', 'data-loading-text' => __('Creating...', 'backup'))).
                Form::close()
            );
        ?>
    </div>
</div>

<!-- Backup_list -->
<div class="table-responsive">
<table class="table table-bordered">
    <thead>
        <tr>
            <th><?php echo __('Backup', 'backup'); ?></th>
            <th class="visible-lg hidden-xs"><?php echo __('Size', 'backup'); ?></th>
            <th></th>
        </tr>
    </thead>
    <tbody>
    <?php if (count($backups_list) > 0) rsort($backups_list); foreach ($backups_list as $backup) { ?>
    <tr>
        <td>
            <?php $name = strtotime(str_replace('-', '', basename($backup, '.zip'))); ?>
            <?php echo Html::anchor(Date::format($name, 'F jS, Y - g:i A'), Option::get('siteurl').'/admin/index.php?id=backup&download='.$backup.'&token='.Security::token()); ?>
        </td>
        <td class="visible-lg hidden-xs"><?php echo Number::byteFormat(filesize(ROOT . DS . 'backups' . DS . $backup)); ?></td>
        <td>
            <div class="pull-right">
            <?php
				if (strtoupper(substr(PHP_OS, 0, 3)) !== 'WIN') {
					echo Html::anchor(__('Restore', 'backup'),
						'index.php?id=backup&restore='.$backup.'&token='.Security::token(),
							  array('class' => 'btn btn-primary'));
				}
            ?>
            <?php echo Html::anchor(__('Delete', 'backup'),
                      'index.php?id=backup&delete_file='.$backup.'&token='.Security::token(),
                       array('class' => 'btn btn-danger', 'onclick' => "return confirmDelete('".__('Delete backup: :backup', 'backup', array(':backup' => Date::format($name, 'F jS, Y - g:i A')))."')"));
            ?>
            </div>
        </td>
    </tr>
    <?php } ?>
    </tbody>
</table>
</div>
<!-- /Backup_list -->
