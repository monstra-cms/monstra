<div class="row-fluid">

    <div class="span6">

        <h2><?php echo __('Site theme', 'themes'); ?></h2>
        <br />

        <!-- Themes_selector -->
        <?php
            echo (
                Form::open().
                Form::hidden('csrf', Security::token()).
                Form::label('themes', __('Select theme', 'themes')).
                Form::select('themes', $themes_site, $current_site_theme, array('class' => 'span6')). Html::br().
                Form::submit('save_site_theme', __('Save', 'themes'), array('class' => 'btn')).
                Form::close()
            );
        ?>
        <!-- /Themes_selector -->

    </div>


    <div class="span6">

        <h2><?php echo __('Admin theme', 'themes'); ?></h2>
        <br />

        <!-- Themes_selector -->
        <?php
            echo (
                Form::open().
                Form::hidden('csrf', Security::token()).
                Form::label('themes', __('Select theme', 'themes')).
                Form::select('themes', $themes_admin, $current_admin_theme, array('class' => 'span6')). Html::br().
                Form::submit('save_admin_theme', __('Save', 'themes'), array('class' => 'btn')).
                Form::close()
            );
        ?>
        <!-- /Themes_selector -->

    </div>

</div>

<hr>

<div class="row-fluid">

    <div class="span12">

<?php    
    echo (
        Html::heading(__('Current site theme', 'themes') . ': '. $current_site_theme, 2). Html::br()
    );
?>


<?php echo (Html::anchor(__('Create new template', 'themes'), 'index.php?id=themes&action=add_template', array('title' => __('Create new template'), 'class' => 'btn btn-small')).Html::br(2)); ?>

<!-- Templates_list -->
<table class="table table-bordered">
    <thead>
        <tr><td><?php echo __('Templates', 'themes'); ?></td><td width="40%"><?php echo __('Actions', 'themes'); ?></td></tr>
    </thead>
    <tbody>
    <?php if (count($templates) != 0) foreach ($templates as $template) { ?>
    <tr>
        <td><?php echo basename($template, '.template.php'); ?></td>        
        <td>        
            <div class="btn-toolbar">
                <div class="btn-group">
                    <?php echo Html::anchor(__('Edit', 'themes'), 'index.php?id=themes&action=edit_template&filename='.basename($template, '.template.php'), array('class' => 'btn btn-actions')); ?>
                    <a class="btn dropdown-toggle btn-actions" data-toggle="dropdown" href="#" style="font-family:arial;"><span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <li><?php echo Html::anchor(__('Clone', 'themes'), 'index.php?id=themes&action=clone_template&filename='.basename($template, '.template.php').'&token='.Security::token(), array('title' => __('Clone'))); ?></li>
                    </ul>            
                    <?php echo Html::anchor(__('Delete', 'themes'),
                               'index.php?id=themes&action=delete_template&filename='.basename($template, '.template.php').'&token='.Security::token(),
                               array('class' => 'btn btn-actions btn-actions-default', 'onclick' => "return confirmDelete('".__('Delete template: :name', 'themes', array(':name' => basename($template, '.template.php')))."')"));
                    ?>
                </div>
            </div>
        </td>
    </tr>
    <?php } ?>
    </tbody>
</table>
<!-- /Templates_list -->

<?php echo (Html::anchor(__('Create new chunk', 'themes'), 'index.php?id=themes&action=add_chunk', array('title' => __('Create new chnuk', 'themes'), 'class' => 'btn btn-small')).Html::br(2)); ?>

<!-- Chunks_list -->
<table class="table table-bordered">
    <thead>
        <tr><td><?php echo __('Chunks', 'themes'); ?></td><td width="40%"><?php echo __('Actions', 'themes'); ?></td></tr>
    </thead>
    <tbody>
    <?php if (count($chunks) != 0) foreach ($chunks as $chunk) { ?>
    <tr>
        <td><?php echo basename($chunk, '.chunk.php'); ?></td>        
        <td>    
            <div class="btn-toolbar">
                <div class="btn-group">
                    <?php echo Html::anchor(__('Edit', 'themes'), 'index.php?id=themes&action=edit_chunk&filename='.basename($chunk, '.chunk.php'), array('class' => 'btn btn-actions')); ?>
                    <a class="btn dropdown-toggle btn-actions" data-toggle="dropdown" href="#" style="font-family:arial;"><span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <li><?php echo Html::anchor(__('Clone', 'themes'), 'index.php?id=themes&action=clone_chunk&filename='.basename($chunk, '.chunk.php').'&token='.Security::token(), array('title' => __('Clone', 'themes'))); ?></li>
                    </ul>            
                    <?php echo Html::anchor(__('Delete', 'themes'),
                               'index.php?id=themes&action=delete_chunk&filename='.basename($chunk, '.chunk.php').'&token='.Security::token(),
                               array('class' => 'btn btn-actions btn-actions-default', 'onclick' => "return confirmDelete('".__('Delete chunk: :name', 'themes', array(':name' => basename($chunk, '.chunk.php')))."')"));
                    ?>
                </div>
            </div>
        </td>
    </tr>
    <?php } ?>
    </tbody>
</table>
<!-- /Chunks_list -->

<?php echo (Html::anchor(__('Create new styles', 'themes'), 'index.php?id=themes&action=add_styles', array('title' => __('Create new style', 'themes'), 'class' => 'btn btn-small')).Html::br(2)); ?>

<!-- Styles_list -->
<table class="table table-bordered">
    <thead>
        <tr><td><?php echo __('Styles', 'themes'); ?></td><td width="40%"><?php echo __('Actions', 'themes'); ?></td></tr>
    </thead>
    <tbody>
    <?php if (count($styles) != 0) foreach ($styles as $style) { ?>
    <tr>
        <td><?php echo basename($style, '.css'); ?></td>        
        <td>            
            <div class="btn-toolbar">
                <div class="btn-group">
                    <?php echo Html::anchor(__('Edit', 'themes'), 'index.php?id=themes&action=edit_styles&filename='.basename($style, '.css'), array('class' => 'btn btn-actions')); ?>
                    <a class="btn dropdown-toggle btn-actions" data-toggle="dropdown" href="#" style="font-family:arial;"><span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <li><?php echo Html::anchor(__('Clone', 'themes'), 'index.php?id=themes&action=clone_styles&filename='.basename($style, '.css').'&token='.Security::token(), array('title' => __('Clone', 'themes'))); ?></li>
                    </ul>            
                    <?php echo Html::anchor(__('Delete', 'themes'),
                               'index.php?id=themes&action=delete_styles&filename='.basename($style, '.css').'&token='.Security::token(),
                               array('class' => 'btn btn-actions btn-actions-default', 'onclick' => "return confirmDelete('".__('Delete styles: :name', 'themes', array(':name' => basename($style, '.css')))."')"));
                    ?>
                </div>
            </div>
        </td>
    </tr>
    <?php } ?>
    </tbody>
</table>
<!-- /Styles_list -->

<?php echo (Html::anchor(__('Create new script', 'themes'), 'index.php?id=themes&action=add_script', array('title' => __('Create new script', 'themes'), 'class' => 'btn btn-small')).Html::br(2)); ?>

<!-- Scripts_list -->
<table class="table table-bordered">
    <thead>
        <tr><td><?php echo __('Scripts', 'themes'); ?></td><td width="40%"><?php echo __('Actions', 'themes'); ?></td></tr>
    </thead>
    <tbody>
    <?php if (count($scripts) != 0) foreach ($scripts as $script) { ?>
    <tr>
        <td><?php echo basename($script, '.js'); ?></td>        
        <td>            
            <div class="btn-toolbar">
                <div class="btn-group">
                    <?php echo Html::anchor(__('Edit', 'themes'), 'index.php?id=themes&action=edit_script&filename='.basename($script, '.js'), array('class' => 'btn btn-actions')); ?>
                    <a class="btn dropdown-toggle btn-actions" data-toggle="dropdown" href="#" style="font-family:arial;"><span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <li><?php echo Html::anchor(__('Clone', 'themes'), 'index.php?id=themes&action=clone_script&filename='.basename($script, '.js').'&token='.Security::token(), array('title' => __('Clone', 'themes'))); ?></li>
                    </ul>            
                    <?php echo Html::anchor(__('Delete', 'themes'),
                               'index.php?id=themes&action=delete_script&filename='.basename($script, '.js').'&token='.Security::token(),
                               array('class' => 'btn btn-actions btn-actions-default', 'onclick' => "return confirmDelete('".__('Delete script: :name', 'themes', array(':name' => basename($script, '.js')))."')"));
                    ?>
                </div>
            </div>
        </td>
    </tr>
    <?php } ?>
    </tbody>
</table>
<!-- /Scripts_list -->


<?php  // All exept Pages, Users and Sitemap plugins  
if(count(Plugin::$components) > 3) {           
?>
    <h2><?php echo __('Components templates', 'themes'); ?></h2><br />
<?php
    // Its mean that you can add your own actions for this plugin
    Action::run('admin_themes_extra_index_template_actions');
}
?>

    </div>
</div>