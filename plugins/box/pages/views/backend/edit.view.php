<h2 class="margin-bottom-1"><?php if (Request::get('name') == 'error404') { echo __('Edit 404 Page', 'pages'); } else { echo __('Edit Page', 'pages'); } ?></h2>

<?php
    echo (
        Form::open().
        Form::hidden('csrf', Security::token()).
        Form::hidden('page_old_name', Request::get('name')).
        Form::hidden('old_parent', $page['parent']).
        Form::hidden('page_id', $page['id'])
    );
?>

<ul class="nav nav-tabs">
    <li <?php if (Notification::get('page')) { ?>class="active"<?php } ?>><a href="#page" data-toggle="tab"><?php echo __('Page', 'pages'); ?></a></li>
    <li <?php if (Notification::get('metadata')) { ?>class="active"<?php } ?>><a href="#metadata" data-toggle="tab"><?php echo __('Metadata', 'pages'); ?></a></li>
    <li <?php if (Notification::get('settings')) { ?>class="active"<?php } ?>><a href="#settings" data-toggle="tab"><?php echo __('Settings', 'pages'); ?></a></li>
</ul>

<div class="tab-content tab-page margin-bottom-1">
    <div class="tab-pane <?php if (Notification::get('page')) { ?>active<?php } ?>" id="page">
        <div class="form-group">
        <?php
            echo (
                Form::label('page_title', __('Name', 'pages')).
                Form::input('page_title', $title_to_edit, array('class' => (isset($errors['pages_empty_title'])) ? 'form-control error-field' : 'form-control'))
            );
            if (isset($errors['pages_empty_title'])) echo '<span class="error-message">'.$errors['pages_empty_title'].'</span>';
        ?>
        </div>
        <div class="form-group">
        <?php            

            if (Request::get('name') !== 'error404') {
                echo (
                    Form::label('page_name', __('Slug (url)', 'pages'))
                );
            }

            if (Request::get('name') == 'error404') {
                echo Form::hidden('page_name', $slug_to_edit);
            } else {
                echo (
                    Form::input('page_name', $slug_to_edit, array('class' => (isset($errors['pages_empty_name'])) ? 'form-control error-field' : 'form-control'))
                );
            }

            if (isset($errors['pages_empty_name'])) echo '<span class="error-message">'.$errors['pages_empty_name'].'</span>';
            if (isset($errors['pages_exists'])) echo '<span class="error-message">'.$errors['pages_exists'].'</span>';
        ?>
        </div>
    </div>
    <div class="tab-pane <?php if (Notification::get('metadata')) { ?>active<?php } ?>" id="metadata">
        <div class="form-group">
        <?php
            echo (
                Form::label('page_meta_title', __('Title', 'pages')).
                Form::input('page_meta_title', $meta_title_to_edit, array('class' => 'form-control'))
            );
        ?>
        </div>
        <div class="form-group">
        <?php
            echo (
                Form::label('page_keywords', __('Keywords', 'pages')).
                Form::input('page_keywords', $keywords_to_edit, array('class' => 'form-control'))
            );
        ?>
        </div>
        <div class="form-group">
        <?php
            echo(
                Form::label('page_description', __('Description', 'pages')).
                Form::textarea('page_description', $description_to_edit, array('class' => 'form-control'))
            );
        ?>
        </div>
        <div class="form-group">
        <?php
            echo (                
                Form::label('robots', __('Search Engines Robots', 'pages')).
                Html::br(1).
                'no Index'.Html::nbsp().Form::checkbox('robots_index', 'index', $post_robots_index).Html::nbsp(2).
                'no Follow'.Html::nbsp().Form::checkbox('robots_follow', 'follow', $post_robots_follow)
            );
        ?>
        </div>
    </div>
    <div class="tab-pane <?php if (Notification::get('settings')) { ?>active<?php } ?>" id="settings">        
            <?php
                if (Request::get('name') == 'error404') {
                    echo Form::hidden('pages', $parent_page);
                } else {
            ?>
            <div class="form-group">
            <?php
                echo (
                    Form::label('pages', __('Parent', 'pages')).
                    Form::select('pages', $pages_array, $parent_page, array('class' => 'form-control'))
                );
            ?>
            </div>
            <?php } ?>
            <?php if (Request::get('name') != 'error404') { ?>
                <div class="form-group">
            <?php } else { ?>
            <div>
            <?php } ?>
            <?php
                echo (
                    Form::label('templates', __('Template', 'pages')).
                    Form::select('templates', $templates_array, $template, array('class' => 'form-control'))
                );
            ?>
            </div>
            <?php
                if (Request::get('name') == 'error404') {
                    echo Form::hidden('status', $status);
                } else {
            ?>
            <div class="form-group">
            <?php
                echo (
                    Form::label('status', __('Status', 'pages')).
                    Form::select('status', $status_array, $status, array('class' => 'form-control'))
                );
            ?>
            </div>
            <?php } ?>
            <?php
                if (Request::get('name') == 'error404') {
                    echo Form::hidden('access', $access);
                } else {
            ?>
            <div class="form-group">
            <?php
                echo (
                    Form::label('access', __('Access', 'pages')).
                    Form::select('access', $access_array, $access, array('class' => 'form-control'))
                );
            ?>
            </div>
            <?php } ?>        
    </div>
</div>

<div class="row margin-bottom-1">
    <div class="col-xs-12">
        <?php Action::run('admin_editor', array(Html::toText($to_edit))); ?>
    </div>
</div>

<div class="row margin-top-1">
    <div class="col-xs-12">
        <div class="form-group">
            <div class="input-group">
                <?php    
                    echo (            
                        Form::input('page_tags', $tags_to_edit, array('class' => 'form-control'))
                    );
                ?>
                <span class="input-group-addon add-on">
                    <?php echo __('Tags', 'pages'); ?>
                </span>            
            </div>
        </div>
    </div>
</div>

<div class="row margin-top-1">
    <div class="col-sm-6">
        <?php
            echo (
                Form::submit('edit_page_and_exit', __('Save and Exit', 'pages'), array('class' => 'btn btn-phone btn-primary')).Html::nbsp(2).
                Form::submit('edit_page', __('Save', 'pages'), array('class' => 'btn btn-phone btn-primary')).Html::nbsp(2).
                Html::anchor(__('Cancel', 'pages'), 'index.php?id=pages', array('title' => __('Cancel', 'pages'), 'class' => 'btn btn-phone btn-default'))
            );
        ?>
    </div>
    <div class="col-sm-6 visible-sm visible-md visible-lg">
        <div class="pull-right">               
            <div class="input-group datapicker">
                <?php echo Form::input('page_date', $date, array('class' => 'form-control')); ?>
                <span class="input-group-addon add-on">
                    <span class="glyphicon glyphicon-calendar"></span>
                </span>            
            </div>           
        </div>
        <?php echo Form::close(); ?>
    </div>
</div>
