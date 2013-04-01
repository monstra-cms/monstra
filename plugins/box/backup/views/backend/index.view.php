<h2><?php echo __('Backups', 'backup'); ?></h2>
<br />

<?php if (Notification::get('success')) Alert::success(Notification::get('success')); ?>

<script>
$().ready(function(){$('[name=create_backup]').click(function(){$(this).button('loading');});});
</script>

<?php
    echo (
        Form::open() .
        Form::hidden('csrf', Security::token()).
        Form::checkbox('add_storage_folder', null, true, array('disabled' => 'disabled')) . ' ' . __('storage', 'backup') . ' ' . Html::nbsp(2) .
        Form::checkbox('add_public_folder') . ' ' . __('public', 'backup') . ' ' . Html::nbsp(2) .
        Form::checkbox('add_plugins_folder') . ' ' . __('plugins', 'backup') . ' ' . Html::nbsp(2) .
        Form::submit('create_backup', __('Create Backup', 'backup'), array('class' => 'btn', 'data-loading-text' => __('Creating...', 'backup'))).
        Form::close()
    );
?>

<!-- Backup_list -->
<table class="table table-bordered">
    <thead>
        <tr>
            <th><?php echo __('Backup', 'backup'); ?></th>
            <th><?php echo __('Size', 'backup'); ?></th>
            <th></th>
        </tr>
    </thead>
    <tbody>
    <?php if (count($backups_list) > 0) rsort($backups_list); foreach ($backups_list as $backup) { ?>
    <tr>
        <td>
            <?php $name = strtotime(str_replace('-', '', basename($backup, '.zip'))); ?>
            <?php echo Html::anchor(Date::format($name, 'F jS, Y - g:i A'), Option::get('siteurl').'admin/index.php?id=backup&download='.$backup.'&token='.Security::token()); ?>
        </td>
        <td><?php echo Number::byteFormat(filesize(ROOT . DS . 'backups' . DS . $backup)); ?></td>
        <td>
            <div class="pull-right">
            <?php echo Html::anchor(__('Delete', 'backup'),
                      'index.php?id=backup&delete_file='.$backup.'&token='.Security::token(),
                       array('class' => 'btn btn-small', 'onclick' => "return confirmDelete('".__('Delete backup: :backup', 'backup', array(':backup' => Date::format($name, 'F jS, Y - g:i A')))."')"));
            ?>
            </div>
        </td>
    </tr>
    <?php } ?>
    </tbody>
</table>
<!-- /Backup_list -->
