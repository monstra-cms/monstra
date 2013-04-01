<!-- System -->

<br />

<?php if (Notification::get('success')) Alert::success(Notification::get('success')); ?>

<?php echo Html::anchor(__('Create Sitemap', 'system'), 'index.php?id=system&sitemap=create&token='.Security::token(), array('class' => 'btn btn-small')).Html::nbsp(2); ?>
<?php echo Html::anchor(__('Delete Temporary Files', 'system'), 'index.php?id=system&temporary_files=delete&token='.Security::token(), array('class' => 'btn btn-small')).Html::nbsp(2); ?>
<?php if ('off' == Option::get('maintenance_status', 'system')) { ?>
<?php echo Html::anchor(__('Maintenance Mode On', 'system'), 'index.php?id=system&maintenance=on&token='.Security::token(), array('class' => 'btn btn-small')); ?>
<?php } else { ?>
<?php echo Html::anchor(__('Maintenance Mode Off', 'system'), 'index.php?id=system&maintenance=off&token='.Security::token(), array('class' => 'btn btn-small btn-danger')); ?>
<?php } ?>
<?php Action::run('admin_system_extra_buttons'); ?>

<hr />

<h2><?php echo __('Site Settings', 'system'); ?></h2>
<br />
<?php
    echo (
        Form::open().
        Form::hidden('csrf', Security::token()).
        Form::label('site_name', __('Site Name', 'system')).
        Form::input('site_name', Option::get('sitename'), array('class' => 'input-xxlarge')). Html::br().
        Form::label('site_description', __('Site Description', 'system')).
        Form::textarea('site_description', Option::get('description'), array('class' => 'input-xxlarge')). Html::br().
        Form::label('site_keywords', __('Site Keywords', 'system')).
        Form::input('site_keywords', Option::get('keywords'), array('class' => 'input-xxlarge')). Html::br().
        Form::label('site_slogan', __('Site Slogan', 'system')).
        Form::input('site_slogan', Option::get('slogan'), array('class' => 'input-xxlarge')). Html::br().
        Form::label('site_default_page', __('Default Page', 'system')).
        Form::select('site_default_page', $pages_array, Option::get('defaultpage'), array('class' => 'input-xlarge')). Html::br(2)
    );
?>

<h2><?php echo __('System Settings', 'system'); ?></h2>
<br />
<?php
    echo (
        Form::label('system_url', __('Site Url', 'system')).
        Form::input('system_url', Option::get('siteurl'), array('class' => 'input-xxlarge')). Html::br().
        Form::label('system_timezone', __('Time zone', 'system')).
        Form::select('system_timezone', Date::timezones(), Option::get('timezone'), array('class' => 'input-xxlarge')). Html::br().
        Form::label('system_language', __('Language', 'system')).
        Form::select('system_language', $languages_array, Option::get('language'), array('class' => 'input-xlarge')). Html::br().
        Form::label('system_email', __('Email', 'system')).
        Form::input('system_email', Option::get('system_email'), array('class' => 'input-xlarge')). Html::br().
        Form::label('site_maintenance_message', __('Maintenance Mode', 'system')).
        Form::textarea('site_maintenance_message', Html::toText(Option::get('maintenance_message')), array('class' => 'input-xxlarge', 'style' => 'height:160px;')). Html::br(2)
    );
?>

<?php
    echo (
        Form::submit('edit_settings', __('Save', 'system'), array('class' => 'btn')).
        Form::close()
    );
?>
<!-- /System -->

<?php
    // Custom code for this plugin
    Action::run('admin_system_extra_index_template_actions');
?>
