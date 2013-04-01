<h2><?php echo __('New Page', 'pages'); ?></h2>
<br />

<?php if (Notification::get('success')) Alert::success(Notification::get('success')); ?>

<?php
    echo (
        Form::open().
        Form::hidden('csrf', Security::token())
    );
?>

<ul class="nav nav-tabs">
    <li <?php if (Notification::get('page')) { ?>class="active"<?php } ?>><a href="#page" data-toggle="tab"><?php echo __('Page', 'pages'); ?></a></li>
    <li <?php if (Notification::get('metadata')) { ?>class="active"<?php } ?>><a href="#metadata" data-toggle="tab"><?php echo __('Metadata', 'pages'); ?></a></li>
    <li <?php if (Notification::get('settings')) { ?>class="active"<?php } ?>><a href="#settings" data-toggle="tab"><?php echo __('Settings', 'pages'); ?></a></li>
</ul>

<div class="tab-content tab-page">
    <div class="tab-pane <?php if (Notification::get('page')) { ?>active<?php } ?>" id="page">
        <?php
            echo (
                Form::label('page_title', __('Title', 'pages')).
                Form::input('page_title', $post_title, array('class' => (isset($errors['pages_empty_title'])) ? 'input-xxlarge error-field' : 'input-xxlarge'))
            );
            if (isset($errors['pages_empty_title'])) echo Html::nbsp(3).'<span style="color:red">'.$errors['pages_empty_title'].'</span>';

            echo (
                Html::br(2).
                Form::label('page_name', __('Name (slug)', 'pages')).
                Form::input('page_name', $post_name, array('class' => (isset($errors['pages_empty_name'])) ? 'input-xxlarge error-field' : 'input-xxlarge'))
            );

            if (isset($errors['pages_exists'])) echo Html::nbsp(3).'<span style="color:red">'.$errors['pages_exists'].'</span>';
            if (isset($errors['pages_empty_name'])) echo Html::nbsp(3).'<span style="color:red">'.$errors['pages_empty_name'].'</span>';
        ?>

    </div>
    <div class="tab-pane <?php if (Notification::get('metadata')) { ?>active<?php } ?>" id="metadata">
        <?php
            echo (
                Form::label('page_keywords', __('Keywords', 'pages')).
                Form::input('page_keywords', $post_keywords, array('class' => 'input-xxlarge')).
                Html::br(2).
                Form::label('page_description', __('Description', 'pages')).
                Form::textarea('page_description', $post_description, array('class' => 'input-xxlarge'))
            );
        ?>

        <?php
            echo (
                Html::br(2).
                Form::label('robots', __('Search Engines Robots', 'pages')).
                'no Index'.Html::nbsp().Form::checkbox('robots_index', 'index', $post_robots_index).Html::nbsp(2).
                'no Follow'.Html::nbsp().Form::checkbox('robots_follow', 'follow', $post_robots_follow)
            );
        ?>
    </div>
    <div class="tab-pane <?php if (Notification::get('settings')) { ?>active<?php } ?>" id="settings">
        <div class="row-fluid">
            <div class="span3">
            <?php
                echo (
                    Form::label('pages', __('Parent', 'pages')).
                    Form::select('pages', $pages_array, $parent_page)
                );
            ?>
            </div>
            <div class="span3">
            <?php
                echo (
                    Form::label('templates', __('Template', 'pages')).
                    Form::select('templates', $templates_array, $post_template)
                );
            ?>
            </div>
            <div class="span3">
            <?php
                echo (
                    Form::label('status', __('Status', 'pages')).
                    Form::select('status', $status_array, $post_status)
                );
            ?>
            </div>
            <div class="span3">
            <?php
                echo (
                    Form::label('access', __('Access', 'pages')).
                    Form::select('access', $access_array, $post_access)
                );
            ?>
            </div>
        </div>
    </div>
</div>

<br /><br />

<?php Action::run('admin_editor', array(Html::toText($post_content))); ?>

<br />

<div class="row-fluid">
    <div class="span6">
        <?php
            echo (
                Form::submit('add_page_and_exit', __('Save and Exit', 'pages'), array('class' => 'btn')).Html::nbsp(2).
                Form::submit('add_page', __('Save', 'pages'), array('class' => 'btn'))
            );
        ?>
    </div>
    <div class="span6">
        <div class="pull-right"><?php echo __('Published on', 'pages'); ?>: <?php echo Form::input('page_date', $date, array('class' => 'input-large')); ?></div>
        <?php echo Form::close(); ?>
    </div>
</div>
