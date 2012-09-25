<?php

    // Check if is user is logged in then set variables for welcome button
    if (Session::exists('user_id')) {
        $user_id = Session::get('user_id');
        $user_login = Session::get('user_login');        
    } else {
        $user_id = '';
        $user_login = '';
    }

    Navigation::add(__('Users', 'users'), 'system', 'users', 2);

    Action::add('admin_header', 'UsersAdmin::headers');
    
    class UsersAdmin extends Backend {


        public static function headers() {
            echo ('
                <script>
                $(document).ready(function(){
                    $("[name=users_frontend_registration] , [name=users_frontend_authorization]").click(function() {
                        $("[name=users_frontend]").submit();
                    });     
                });
                </script>           
            ');
        }

        /**
         * Users admin
         */
        public static function main() {

            // Users roles
            $roles = array('admin'  => __('Admin', 'users'),
                           'editor' => __('Editor', 'users'),
                           'user'   => __('User', 'users'));

            // Get uses table
            $users = new Table('users');

            if (Option::get('users_frontend_registration') == 'true') {
                $users_frontend_registration = true;
            } else {
                $users_frontend_registration = false;
            }

            if (Request::post('users_frontend_submit')) {
                if (Request::post('users_frontend_registration')) $users_frontend_registration = 'true'; else $users_frontend_registration = 'false';
                Option::update('users_frontend_registration', $users_frontend_registration);
                Request::redirect('index.php?id=users');
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

                            $errors = array();
                            if (Request::post('register')) {

                                if (Security::check(Request::post('csrf'))) {

                                    $user_login = trim(Request::post('login'));
                                    $user_password = trim(Request::post('password'));
                                    if ($user_login == '')    $errors['users_empty_login']    = __('This field should not be empty', 'users');
                                    if ($user_password == '') $errors['users_empty_password'] = __('This field should not be empty', 'users');
                                    $user = $users->select("[login='".$user_login."']");
                                    if ($user != null) $errors['users_this_user_alredy_exists'] = __('This user alredy exist', 'users');
                                    
                                    if (count($errors) == 0) {
                                        $users->insert(array('login'           => Security::safeName($user_login),
                                                             'password'        => Security::encryptPassword(Request::post('password')),
                                                             'email'           => Request::post('email'),
                                                             'date_registered' => time(),
                                                             'role'            => Request::post('role')));

                                        Notification::set('success', __('New user have been registered.', 'users')); 
                                        Request::redirect('index.php?id=users');
                                    }

                                } else { die('csrf detected!'); }
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
                        $user = $users->select("[id='".(int)Request::get('user_id')."']", null);
                        
                        if (isset($user['firstname'])) $user_firstname = $user['firstname']; else $user_firstname = '';
                        if (isset($user['lastname']))  $user_lastname  = $user['lastname'];  else $user_lastname  = '';
                        if (isset($user['email']))     $user_email = $user['email']; else $user_email = '';
                        if (isset($user['twitter']))   $user_twitter = $user['twitter']; else $user_twitter = '';
                        if (isset($user['skype']))     $user_skype = $user['skype']; else $user_skype = '';

                        if (Session::exists('user_role') && in_array(Session::get('user_role'), array('admin', 'editor'))) {

                            if ((Request::post('edit_profile')) and
                                 (((int)Session::get('user_id') == (int)Request::get('user_id')) or
                                   (in_array(Session::get('user_role'), array('admin'))))){

                                    if (Security::check(Request::post('csrf'))) {

                                        if (Security::safeName(Request::post('login')) != '') {                                       
                                            if ($users->update(Request::post('user_id'), array('login' => Security::safeName(Request::post('login')),
                                                                                          'firstname' => Request::post('firstname'),
                                                                                          'lastname'  => Request::post('lastname'),
                                                                                          'email'     => Request::post('email'),
                                                                                          'skype'     => Request::post('skype'),
                                                                                          'twitter'   => Request::post('twitter'),
                                                                                          'role'      => Request::post('role')))) { 
                                                
                                                Notification::set('success', __('Your changes have been saved.', 'users'));                                            
                                                Request::redirect('index.php?id=users&action=edit&user_id='.Request::post('user_id'));
                                            }
                                        } else { }  

                                    } else { die('csrf detected!'); }
                                
                            }

                            if (Request::post('edit_profile_password')) {

                                if (Security::check(Request::post('csrf'))) {

                                    if (trim(Request::post('new_password')) != '') {
                                        $users->update(Request::post('user_id'), array('password' => Security::encryptPassword(trim(Request::post('new_password')))));
                                        Notification::set('success', __('Your changes have been saved.', 'users'));                                            
                                        Request::redirect('index.php?id=users&action=edit&user_id='.Request::post('user_id'));
                                    }

                                } else { die('csrf detected!'); }
                            }

                            if ( ((int)Session::get('user_id') == (int)Request::get('user_id')) or (in_array(Session::get('user_role'), array('admin')) && count($user) != 0) ) {

                                // Display view
                                View::factory('box/users/views/backend/edit')
                                        ->assign('user', $user)
                                        ->assign('user_firstname', $user_firstname)
                                        ->assign('user_lastname', $user_lastname)
                                        ->assign('user_email', $user_email)
                                        ->assign('user_twitter', $user_twitter)
                                        ->assign('user_skype', $user_skype)
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

                        if (Session::exists('user_role') && in_array(Session::get('user_role'), array('admin'))) {
                            $user = $users->select('[id="'.Request::get('user_id').'"]', null);
                            $users->delete(Request::get('user_id'));
                            Notification::set('success', __('User <i>:user</i> have been deleted.', 'users', array(':user' => $user['login']))); 
                            Request::redirect('index.php?id=users');
                        }

                    break;
                }
            } else {

                if (Session::exists('user_role') && in_array(Session::get('user_role'), array('admin'))) {
                    
                    // Get all records from users table
                    $users_list = $users->select();
                    
                    // Dislay view
                    View::factory('box/users/views/backend/index')
                            ->assign('roles', $roles)
                            ->assign('users_list', $users_list)
                            ->assign('users_frontend_registration', $users_frontend_registration)
                            ->display();

                } else {
                    Request::redirect('index.php?id=users&action=edit&user_id='.Session::get('user_id'));
                }
            }
            
        }
    }