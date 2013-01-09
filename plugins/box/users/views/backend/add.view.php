<!-- Users_add -->
<?php
    echo ( '<h2>'.__('New User Registration', 'users').'</h2>' );

    echo (
        Html::br().
        Form::open().
        Form::hidden('csrf', Security::token()).
        Form::label('login', __('Username', 'users')).
        Form::input('login', null, array('class' => (isset($errors['users_this_user_alredy_exists']) || isset($errors['users_empty_login'])) ? 'input-xlarge error-field' : 'input-xlarge'))
    );

    if (isset($errors['users_this_user_alredy_exists'])) echo Html::nbsp(3).'<span style="color:red">'.$errors['users_this_user_alredy_exists'].'</span>';
    if (isset($errors['users_empty_login'])) echo Html::nbsp(3).'<span style="color:red">'.$errors['users_empty_login'].'</span>';

    echo (
        Form::label('password', __('Password', 'users')).
        Form::password('password', null, array('class' => (isset($errors['users_empty_password'])) ? 'input-xlarge error-field' : 'input-xlarge'))
    );

    if (isset($errors['users_empty_password'])) echo Html::nbsp(3).'<span style="color:red">'.$errors['users_empty_password'].'</span>';

    echo (
        Form::label('email', __('Email', 'users')).
        Form::input('email', null, array('class' => (isset($errors['users_this_email_alredy_exists']) || isset($errors['users_empty_email'])) ? 'input-xlarge error-field' : 'input-xlarge'))
    );

    if (isset($errors['users_this_email_alredy_exists'])) echo Html::nbsp(3).'<span class="error">'.$errors['users_this_email_alredy_exists'].'</span>';
    if (isset($errors['users_empty_email'])) echo Html::nbsp(3).'<span style="color:red">'.$errors['users_empty_email'].'</span>';

    echo(
        Form::label('role', __('Role', 'users')).
        Form::select('role', array('admin' => __('Admin', 'users'), 'editor' => __('Editor', 'users'), 'user' => __('User', 'users')), null, array('class' => 'input-xlarge')). Html::br(2).
        Form::submit('register', __('Register', 'users'), array('class' => 'btn default')).
        Form::close()
    );
?>
<!-- /Users_add -->
