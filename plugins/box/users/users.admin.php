<?php

// Add plugin navigation link
Navigation::add(__('Users', 'users'), 'system', 'users', 2);

/**
 * Users Admin Class
 */
class UsersAdmin extends Backend
{
    /**
     * Users admin
     */
    public static function main()
    {
        // Users roles
        $roles = array('admin'  => __('Admin', 'users'),
                       'editor' => __('Editor', 'users'),
                       'user'   => __('User', 'users'));

        // Get uses table
        $users = new Table('users');

        if (Option::get('users_frontend_registration') === 'true') {
            $users_frontend_registration = true;
        } else {
            $users_frontend_registration = false;
        }

        if (Request::post('users_frontend_submit')) {

            if (Security::check(Request::post('csrf'))) {

                if (Request::post('users_frontend_registration')) $users_frontend_registration = 'true'; else $users_frontend_registration = 'false';
                
                if (Option::update('users_frontend_registration', $users_frontend_registration)) {
                    Notification::set('success', __('Your changes have been saved.', 'users'));
                } else {
                    Notification::set('error', __('Your changes was not saved.', 'users'));
                }

                Request::redirect('index.php?id=users');

            } else { die('Request was denied because it contained an invalid security token. Please refresh the page and try again.'); }
        }

        // Check for get actions
        // ---------------------------------------------
        if (Request::get('action')) {

            // Switch actions
            // -----------------------------------------
            switch (Request::get('action')) {

                // Add
                // -------------------------------------
                case "add":

                    if (Session::exists('user_role') && in_array(Session::get('user_role'), array('admin'))) {

                        // Errors
                        $errors = array();

                        if (Request::post('register')) {

                            if (Security::check(Request::post('csrf'))) {

                                $user_login    = trim(Request::post('login'));
                                $user_password = trim(Request::post('password'));
                                $user_email    = trim(Request::post('email'));

                                if ($user_login == '')    $errors['users_empty_login']    = __('Required field', 'users');
                                if ($user_password == '') $errors['users_empty_password'] = __('Required field', 'users');
                                if ($user_email == '')    $errors['users_empty_email']    = __('Required field', 'users');
                                if ($users->select("[login='".$user_login."']")) $errors['users_this_user_already_exists']  = __('This user already exists', 'users');
                                if ($users->select("[email='".$user_email."']")) $errors['users_this_email_already_exists'] = __('This email already exists', 'users');

                                if (count($errors) == 0) {

                                    if ($users->insert(array('login'           => Security::safeName($user_login),
                                                             'password'        => Security::encryptPassword(Request::post('password')),
                                                             'email'           => Request::post('email'),
                                                             'hash'            => Text::random('alnum', 12),
                                                             'date_registered' => time(),
                                                             'role'            => Request::post('role')))) {
                                        Notification::set('success', __('New user have been registered.', 'users'));
                                    } else {
                                        Notification::set('error', __('New user was not registered.', 'users'));
                                    }

                                    Request::redirect('index.php?id=users');
                                }

                            } else { die('Request was denied because it contained an invalid security token. Please refresh the page and try again.'); }
                        }

                        // Display view
                        View::factory('box/users/views/backend/add')
                                ->assign('roles', $roles)
                                ->assign('errors', $errors)
                                ->display();

                    } else {
                        Request::redirect('index.php?id=users&action=edit&user_id='.Session::get('user_id'));
                    }

                break;

                // Edit
                // -------------------------------------
                case "edit":

                    // Get current user record
                    $user = $users->select("[id='".(int) Request::get('user_id')."']", null);

                    if (isset($user['firstname'])) $user_firstname = $user['firstname']; else $user_firstname = '';
                    if (isset($user['lastname']))  $user_lastname  = $user['lastname'];  else $user_lastname  = '';
                    if (isset($user['email']))     $user_email = $user['email']; else $user_email = '';
                    if (isset($user['twitter']))   $user_twitter = $user['twitter']; else $user_twitter = '';
                    if (isset($user['skype']))     $user_skype = $user['skype']; else $user_skype = '';
                    if (isset($user['about_me']))  $user_about_me = $user['about_me']; else $user_about_me = '';

                    if (Session::exists('user_role') && in_array(Session::get('user_role'), array('admin', 'editor'))) {

                        if ((Request::post('edit_profile')) and
                             (((int) Session::get('user_id') == (int) Request::get('user_id')) or
                               (in_array(Session::get('user_role'), array('admin'))))){

                                if (Security::check(Request::post('csrf'))) {

                                    if (Security::safeName(Request::post('login')) != '') {

                                        if ($users->update(Request::post('user_id'), array('login' => Security::safeName(Request::post('login')),
                                                                                      'firstname' => Request::post('firstname'),
                                                                                      'lastname'  => Request::post('lastname'),
                                                                                      'email'     => Request::post('email'),
                                                                                      'skype'     => Request::post('skype'),
                                                                                      'twitter'   => Request::post('twitter'),
                                                                                      'about_me'  => Request::post('about_me'),
                                                                                      'role'      => Request::post('role')))) {
                                            Notification::set('success', __('Your changes have been saved.', 'users'));
                                        } else {
                                            Notification::set('error', __('Your changes was not saved.', 'users'));
                                        }
                                        
                                        Request::redirect('index.php?id=users&action=edit&user_id='.Request::post('user_id'));
                                        
                                    } 

                                } else { die('Request was denied because it contained an invalid security token. Please refresh the page and try again.'); }

                        }

                        if (Request::post('edit_profile_password')) {

                            if (Security::check(Request::post('csrf'))) {

                                if (trim(Request::post('new_password')) != '') {
                                    
                                    if ($users->update(Request::post('user_id'), array('password' => Security::encryptPassword(trim(Request::post('new_password')))))) {
                                        Notification::set('success', __('Your changes have been saved.', 'users'));
                                    } else {
                                        Notification::set('error', __('Your changes was not saved.', 'users'));
                                    }
                    
                                    Request::redirect('index.php?id=users&action=edit&user_id='.Request::post('user_id'));
                                }

                            } else { die('Request was denied because it contained an invalid security token. Please refresh the page and try again.'); }
                        }

                        if ( ((int) Session::get('user_id') == (int) Request::get('user_id')) or (in_array(Session::get('user_role'), array('admin')) && count($user) != 0) ) {

                            // Display view
                            View::factory('box/users/views/backend/edit')
                                    ->assign('user', $user)
                                    ->assign('user_firstname', $user_firstname)
                                    ->assign('user_lastname', $user_lastname)
                                    ->assign('user_email', $user_email)
                                    ->assign('user_twitter', $user_twitter)
                                    ->assign('user_skype', $user_skype)
                                    ->assign('user_about_me', $user_about_me)
                                    ->assign('roles', $roles)
                                    ->display();

                        } else {
                            echo __('Monstra says: This is not your profile...', 'users');
                        }

                    }

                break;

                // Delete
                // -------------------------------------
                case "delete":

                    if (Session::exists('user_role') && in_array(Session::get('user_role'), array('admin')) && (int)$_SESSION['user_id'] != (int)Request::get('user_id')) {

                        if (Security::check(Request::get('token'))) {

                            $user = $users->select('[id="'.Request::get('user_id').'"]', null);
                            if ($users->delete(Request::get('user_id'))) {
                                Notification::set('success', __('User <i>:user</i> have been deleted.', 'users', array(':user' => $user['login'])));
                            } else {
                                Notification::set('error', __('User <i>:user</i> was not deleted.', 'users', array(':user' => $user['login'])));
                            }
                            
                            Request::redirect('index.php?id=users');

                        } else { die('Request was denied because it contained an invalid security token. Please refresh the page and try again.'); }

                    }

                break;
            }
        } else {

            if (Session::exists('user_role') && in_array(Session::get('user_role'), array('admin'))) {

                // Dislay view
                View::factory('box/users/views/backend/index')
                        ->assign('roles', $roles)
                        ->assign('users_list', $users->select())
                        ->assign('users_frontend_registration', $users_frontend_registration)
                        ->display();

            } else {
                Request::redirect('index.php?id=users&action=edit&user_id='.Session::get('user_id'));
            }
        }

    }
}
