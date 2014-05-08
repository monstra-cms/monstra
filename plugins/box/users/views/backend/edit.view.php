<?php
    // Show template for exist user else show error
    if ($user !== null) {
?>
<h2 class="margin-bottom-1"><?php echo __('Edit profile', 'users'); ?></h2>

<div class="row">
    <div class="col-md-6">
    <?php

        echo (
            Form::open().
            Form::hidden('csrf', Security::token()).
            Form::hidden('user_id', Request::get('user_id'))
        );

        if (Session::exists('user_role') && in_array(Session::get('user_role'), array('admin'))) {
    ?>
        <div class="form-group">
    <?php
            echo Form::label('login', __('Username', 'users'));
            echo Form::input('login', $user['login'], array('class' => 'form-control'));
    ?>
        </div>
    <?php
        } else {
            echo Form::hidden('login', $user['login']);
        }
    ?>
        <div class="form-group">
    <?php            
        echo (            
            Form::label('firstname', __('Firstname', 'users')).
            Form::input('firstname', $user_firstname, array('class' => 'form-control'))
        );
    ?>
        </div>
        <div class="form-group">
    <?php 
        echo (
            Form::label('lastname', __('Lastname', 'users')).
            Form::input('lastname', $user_lastname, array('class' => 'form-control'))
        );
    ?>
        </div>
        <div class="form-group">
    <?php
        echo (
            Form::label('email', __('Email', 'users')).
            Form::input('email', $user_email, array('class' => 'form-control'))
        );
    ?>
        </div>
        <div class="form-group">
    <?php
        echo (
            Form::label('twitter', __('Twitter', 'users')).
            Form::input('twitter', $user_twitter, array('class' => 'form-control'))
        );
    ?>
        </div>
        <div class="form-group">
    <?php
        echo (
            Form::label('skype', __('Skype', 'users')).
            Form::input('skype', $user_skype, array('class' => 'form-control'))
        );
    ?>
        </div>
        <div class="form-group">
    <?php 
        echo (
            Form::label('about_me', __('About Me', 'users')).
            Form::textarea('about_me', $user_about_me, array('class' => 'form-control'))
        );
    ?>
        </div>
    <?php
        if (Session::exists('user_role') && in_array(Session::get('user_role'), array('admin'))) {
    ?>
        <div class="form-group">
    <?php
            echo Form::label('role', __('Role', 'users'));
            echo Form::select('role', array('admin' => __('Admin', 'users'), 'editor' => __('Editor', 'users'), 'user' => __('User', 'users')), $user['role'], array('class' => 'form-control'))
    ?>
        </div>
    <?php
        } else {
            echo Form::hidden('role', Session::get('user_role'));
        }

        echo (
            Html::br().
            Form::submit('edit_profile', __('Save', 'users'), array('class' => 'btn btn-phone btn-primary')).Html::nbsp(2).
            Html::anchor(__('Cancel', 'users'), 'index.php?id=users', array('title' => __('Cancel', 'users'), 'class' => 'btn btn-phone btn-cancel btn-default')).
            Form::close()
        );

    ?>
    </div>

    <div class="col-md-6">
    <?php
        echo (
            Form::open().
            Form::hidden('csrf', Security::token()).
            Form::hidden('user_id', Request::get('user_id'))
        );
    ?>
        <div class="form-group">
    <?php
        echo (
            Form::label('new_password', __('New password', 'users')).
            Form::password('new_password', null, array('class' => 'form-control'))
        );
    ?>
        </div>
    <?php
        echo (    
            Form::submit('edit_profile_password', __('Save', 'users'), array('class' => 'btn btn-phone btn-primary')).
            Form::close()
        );
    ?>
    </div>

</div>


<?php
    } else {
        echo '<div class="error-message">'.__('This user does not exist', 'users').'</div>';
    }
?>
