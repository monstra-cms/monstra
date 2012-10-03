<!-- Users_edit -->
<?php

    // Show template for exist user else show error
    if ($user !== null) {

    echo ( '<h2>'.__('Edit profile', 'users').'</h2>' );

?>

<br />

<?php if (Notification::get('success')) Alert::success(Notification::get('success')); ?>
<?php if (Notification::get('error'))   Alert::error(Notification::get('error')); ?>

<div>

    <div class="span7">    
    <?php

        echo (
            Form::open().
            Form::hidden('csrf', Security::token()).
            Form::hidden('user_id', Request::get('user_id'))
        );

        if (isset($_SESSION['user_role']) && in_array($_SESSION['user_role'], array('admin'))) {        
            echo Form::label('login', __('Username', 'users'));
            echo Form::input('login', $user['login'], array('class' => 'span6'));
        } else {
            echo Form::hidden('login', $user['login']);
        }

        echo (
            Html::br().
            Form::label('firstname', __('Firstname', 'users')).    
            Form::input('firstname', $user_firstname, array('class' => 'span6')).Html::br().
            Form::label('lastname', __('Lastname', 'users')).
            Form::input('lastname', $user_lastname, array('class' => 'span6')).Html::br().
            Form::label('email', __('Email', 'users')).
            Form::input('email', $user_email, array('class' => 'span6')).Html::br().
            Form::label('twitter', __('Twitter', 'users')).
            Form::input('twitter', $user_twitter, array('class' => 'span6')).Html::br().
            Form::label('skype', __('Skype', 'users')).
            Form::input('skype', $user_skype, array('class' => 'span6')).Html::br().
            Form::label('about_me', __('About Me', 'users')).
            Form::textarea('about_me', $user_about_me, array('class' => 'span6')).Html::br()
        );

        if (isset($_SESSION['user_role']) && in_array($_SESSION['user_role'], array('admin'))) {        
            echo Form::label('role', __('Role', 'users'));
            echo Form::select('role', array('admin' => __('Admin', 'users'), 'editor' => __('Editor', 'users'), 'user' => __('User', 'users')), $user['role'], array('class' => 'span3')). Html::br();
        } else {        
            echo Form::hidden('role', $_SESSION['user_role']);
        }


        echo (
            Html::br().
            Form::submit('edit_profile', __('Save', 'users'), array('class' => 'btn')).
            Form::close()
        );
      
    ?>
    </div>

    <div class="span5">
    <?php

        echo (
            Form::open().
            Form::hidden('csrf', Security::token()).
            Form::hidden('user_id', Request::get('user_id')).
            Form::label('new_password', __('New password', 'users')).
            Form::password('new_password', null, array('class' => 'span6')).Html::br().Html::br().
            Form::submit('edit_profile_password', __('Save', 'users'), array('class' => 'btn')).
            Form::close()
        );    
    ?>
    </div>

</div>

<div style="clear:both"></div>

<?php
    } else {
        echo '<div class="message-error">'.__('This user does not exist', 'users').'</div>';
    }
?>
<!-- /Users_edit -->