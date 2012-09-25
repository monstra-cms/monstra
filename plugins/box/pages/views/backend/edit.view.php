<div class="row-fluid">

    <div class="span12">

        <h2>
        <?php
            if (Request::get('name') == 'error404') {
                echo __('Edit 404 page', 'pages'); 
            } else {
                echo __('Edit page', 'pages');
            }
        ?>
        </h2>

        <br />

        <?php if (Notification::get('success')) Alert::success(Notification::get('success')); ?>
        <?php if (isset($errors['pages_empty_name'])) $error_class1 = 'error'; else $error_class1 = ''; ?>
        <?php if (isset($errors['pages_exists'])) $error_class1 = 'error'; else $error_class1 = ''; ?>
        <?php if (isset($errors['pages_empty_title'])) $error_class2 = 'error'; else $error_class2 = ''; ?>


        <?php    
            echo (
                Form::open(null, array('class' => 'form-horizontal'))
            );
        ?>

        <?php echo (Form::hidden('csrf', Security::token())); ?>

            <?php
                echo (
                    Form::hidden('page_old_name', Request::get('name'))
                );
                if (Request::get('name') !== 'error404') {
                    echo (
                        Form::label('page_name', __('Name (slug)', 'pages'))
                    );
                }
            ?>

            <?php

                if (Request::get('name') == 'error404') {
                    echo Form::hidden('page_name', $slug_to_edit);
                } else {
                    echo (        
                        Form::input('page_name', $slug_to_edit, array('class' => 'span6'))
                    );
                }

                if (isset($errors['pages_empty_name'])) echo Html::nbsp(3).'<span style="color:red">'.$errors['pages_empty_name'].'</span>';
                if (isset($errors['pages_exists'])) echo Html::nbsp(3).'<span style="color:red">'.$errors['pages_exists'].'</span>';
            ?>

            <?php
                echo (
                    Html::br(2).
                    Form::label('page_title', __('Title', 'pages'))
                );
            ?>


            <?php   
                echo (
                    Form::input('page_title', $title_to_edit, array('class' => 'span6'))
                );
                if (isset($errors['pages_empty_title'])) echo Html::nbsp(3).'<span style="color:red">'.$errors['pages_empty_title'].'</span>';
            ?>


        <?php
            echo (
                Html::br(2).
                Form::label('page_description', __('Description', 'pages')).
                Form::input('page_description', $description_to_edit, array('class' => 'span8')).
                Html::br(2).
                Form::label('page_keywords', __('Keywords', 'pages')).
                Form::input('page_keywords', $keywords_to_edit, array('class' => 'span8')).
                Form::hidden('old_parent', $page['parent']).
                Form::hidden('page_id', $page['id'])
            );
        ?>

        <br /><br />

        <?php Action::run('admin_editor', array(Html::toText($to_edit))); ?>

        <br />

        <div class="row-fluid">
            <?php
                if (Request::get('name') == 'error404') {
                    echo Form::hidden('pages', $parent_page);
                } else {
            ?>
            <div class="span4">
            <?php 
                echo (
                    Form::label('pages', __('Parent', 'pages')).
                    Form::select('pages', $pages_array, $parent_page)
                );
            ?>
            </div>
            <?php } ?>
            <?php if (Request::get('name') != 'error404') { ?>
                <div class="span4">
            <?php } else { ?>
            <div>
            <?php } ?>
            <?php
                echo (
                    Form::label('templates', __('Template', 'pages')).
                    Form::select('templates', $templates_array, $template)
                ); 
            ?>
            </div>
            <?php 
                if(Request::get('name') == 'error404') {
                    echo Form::hidden('status', $status);
                } else {
            ?>
            <div class="span4">
            <?php 
                echo (
                    Form::label('status', __('Status', 'pages')).
                    Form::select('status', $status_array, $status)
                );
            ?>
            </div>
            <?php } ?>
        </div>

        <hr>

        <div class="row-fluid">
            <div class="span8">
                <?php
                    echo (
                        Form::label(__('Published on', 'pages'), __('Published on', 'pages')).
                        Form::input('year', $date[0], array('class' => 'input-mini')). ' ' .
                        Form::input('month', $date[1], array('class' => 'input-mini')). ' ' . 
                        Form::input('day', $date[2], array('class' => 'input-mini')). ' @ '.     
                        Form::input('minute', $date[3], array('class' => 'input-mini')). ' : '.
                        Form::input('second', $date[4], array('class' => 'input-mini'))
                    );
                ?>
            </div>
            <div class="span3">
            <?php 
                echo (     
                    Form::label('robots', __('Search Engines Robots', 'pages')).   
                    'no Index'.Html::nbsp().Form::checkbox('robots_index', 'index', $post_robots_index).Html::nbsp(2).
                    'no Follow'.Html::nbsp().Form::checkbox('robots_follow', 'follow', $post_robots_follow)
                );
            ?>
            </div>
        </div>

        <hr>

        <?php
            echo (
                Form::submit('edit_page_and_exit', __('Save and exit', 'pages'), array('class' => 'btn')).Html::nbsp(2).
                Form::submit('edit_page', __('Save', 'pages'), array('class' => 'btn')).        
                Form::close()
            );
        ?>

    </div>
</div>