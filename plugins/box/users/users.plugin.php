<?php

/**
 *	Users plugin
 *
 *	@package Monstra
 *  @subpackage Plugins
 *	@author Romanenko Sergey / Awilum
 *	@copyright 2012-2014 Romanenko Sergey / Awilum
 *	@version 1.0.0
 *
 */

// Register plugin
Plugin::register( __FILE__,
                __('Users', 'users'),
                __('Users manager', 'users'),
                '1.0.0',
                'Awilum',
                'http://monstra.org/',
                'users',
                'box');

// Include Users Admin
Plugin::Admin('users', 'box');

// Add Plugin Javascript
Javascript::add('plugins/box/users/js/users.js', 'backend');

/**
 * Users class
 */
class Users extends Frontend
{
    /**
     * Users table
     */
    public static $users = null;

    /**
     * Sandbox main function
     */
    public static function main()
    {
        // Get users table
        Users::$users = new Table('users');

        // Logout
        if (Uri::segment(1) == 'logout') { Users::logout(); }

    }

    /**
     * Route
     */
    protected static function route()
    {
        /* /users */
        if (Uri::segment(0) == 'users' && !Uri::segment(1)) return 'list';
        /* /users/(int) */
        if (Uri::segment(1) && (Uri::segment(1) !== 'login' && Uri::segment(1) !== 'registration' && Uri::segment(1) !== 'password-reset' && Uri::segment(2) !== 'edit')) return 'profile';
        /* /users/login */
        if (Uri::segment(1) == 'login') return 'login';
        /* /users/registration */
        if (Uri::segment(1) == 'registration') return 'registration';
        /* /pusers/password-reset */
        if (Uri::segment(1) == 'password-reset') return 'password-reset';
        /* /users/(int) /edit */
        if ( ( Uri::segment(1) and (Uri::segment(1) !== 'login' && Uri::segment(1) !== 'registration' && Uri::segment(1) !== 'password-reset') ) and  Uri::segment(2) == 'edit') return 'edit';
        /* /users/logout */
        if (Uri::segment(1) == 'logout') return 'logout';
    }

    /**
     * Get users list
     */
    public static function getList()
    {
        View::factory('box/users/views/frontend/index')
            ->assign('users', Users::$users->select(null, 'all'))
            ->display();
    }

    /**
     * Get user profile
     */
    public static function getProfile($id)
    {
        View::factory('box/users/views/frontend/profile')
            ->assign('user', Users::$users->select("[id=".(int) $id."]", null))
            ->display();
    }

    /**
     * Get New User Registration
     */
    public static function getRegistration()
    {
        if (Option::get('users_frontend_registration') == 'true') {

            // Is User Loged in ?
            if ( ! Session::get('user_id')) {

                $errors = array();

                $user_email = Request::post('email');
                $user_login = Request::post('login');
                $user_password = Request::post('password');

                // Register form submit
                if (Request::post('register')) {

                    // Check csrf
                    if (Security::check(Request::post('csrf'))) {

                        $user_email = trim($user_email);
                        $user_login = trim($user_login);
                        $user_password = trim($user_password);

                        if (Option::get('captcha_installed') == 'true' && ! CryptCaptcha::check(Request::post('answer'))) $errors['users_captcha_wrong'] = __('Captcha code is wrong', 'captcha');
                        if ($user_login == '')    $errors['users_empty_login']    = __('Required field', 'users');
                        if ($user_password == '') $errors['users_empty_password'] = __('Required field', 'users');
                        if ($user_email == '')    $errors['users_empty_email']    = __('Required field', 'users');
                        if ($user_email != '' && ! Valid::email($user_email)) $errors['users_invalid_email'] = __('User email is invalid', 'users');
                        if (Users::$users->select("[login='".$user_login."']")) $errors['users_this_user_alredy_exists'] = __('This user alredy exist', 'users');
                        if (Users::$users->select("[email='".$user_email."']")) $errors['users_this_email_alredy_exists'] = __('This email alredy exist', 'users');

                        if (count($errors) == 0) {

                            Users::$users->insert(array('login'    => Security::safeName($user_login),
                                                 'password'        => Security::encryptPassword(Request::post('password')),
                                                 'email'           => Request::post('email'),
                                                 'hash'            => Text::random('alnum', 12),
                                                 'date_registered' => time(),
                                                 'role'            => 'user'));

                            // Log in
                            $user = Users::$users->select("[id='".Users::$users->lastId()."']", null);
                            Session::set('user_id', (int) $user['id']);
                            Session::set('user_login', (string) $user['login']);
                            Session::set('user_role', (string) $user['role']);

                            $mail = new PHPMailer();
                            $mail->CharSet = 'utf-8';
                            $mail->ContentType = 'text/html';
                            $mail->SetFrom(Option::get('system_email'));
                            $mail->AddReplyTo(Option::get('system_email'));
                            $mail->AddAddress($user['email'], $user['login']);
                            $mail->Subject = Option::get('sitename');
                            $mail->MsgHTML(View::factory('box/users/views/emails/layout_email')
                                ->assign('site_name', Option::get('sitename'))
                                ->assign('user_login', $user['login'])
                                ->assign('view', 'new_user_email')
                                ->render());
                            $mail->Send();

                            // Redirect to user profile
                            Request::redirect(Option::get('siteurl').'users/'.Users::$users->lastId());
                        }

                    } else { die('Request was denied because it contained an invalid security token. Please refresh the page and try again.'); }
                }

                // Display view
                View::factory('box/users/views/frontend/registration')
                        ->assign('errors', $errors)
                        ->assign('user_email', $user_email)
                        ->assign('user_login', $user_login)
                        ->assign('user_password', $user_password)
                        ->display();

            } else {
                Request::redirect(Site::url().'users/'.Session::get('user_id'));
            }

        } else {
            echo __('User registration is closed.', 'users');
        }

    }

    /**
     * Get user panel
     */
    public static function getPanel()
    {
        View::factory('box/users/views/frontend/userspanel')->display();
    }

    /**
     * Is User Loged
     */
    public static function isLoged()
    {
        if ((Session::get('user_id')) and (((int) Session::get('user_id') == Uri::segment(1)) or (in_array(Session::get('user_role'), array('admin'))))) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Logout
     */
    public static function logout()
    {
        Session::destroy();
        Request::redirect($_SERVER["HTTP_REFERER"]);
    }

    /**
     * Edit user profile
     */
    public static function getProfileEdit($id)
    {
        // Is Current User Loged in ?
        if (Users::isLoged()) {

            $user = Users::$users->select("[id='".(int) $id."']", null);

            // Edit Profile Submit
            if (Request::post('edit_profile')) {

                // Check csrf
                if (Security::check(Request::post('csrf'))) {

                    if (Security::safeName(Request::post('login')) != '') {
                        if (Users::$users->update(Request::post('user_id'),
                                                                array('login' => Security::safeName(Request::post('login')),
                                                                      'firstname' => Request::post('firstname'),
                                                                      'lastname'  => Request::post('lastname'),
                                                                      'email'     => Request::post('email'),
                                                                      'skype'     => Request::post('skype'),
                                                                      'about_me'  => Request::post('about_me'),
                                                                      'twitter'   => Request::post('twitter')))) {

                            // Change password
                            if (trim(Request::post('new_password')) != '') {
                                Users::$users->update(Request::post('user_id'), array('password' => Security::encryptPassword(trim(Request::post('new_password')))));
                            }

                            Notification::set('success', __('Your changes have been saved.', 'users'));
                            Request::redirect(Site::url().'users/'.$user['id']);
                        }
                    } else { }

                } else { die('Request was denied because it contained an invalid security token. Please refresh the page and try again.'); }

            }

            View::factory('box/users/views/frontend/edit')
                ->assign('user', $user)
                ->display();

        } else {
            Request::redirect(Site::url().'users/login');
        }
    }

    /**
     * Get Password Reset
     */
    public static function getPasswordReset()
    {
        // Is User Loged in ?
        if ( ! Session::get('user_id')) {

            $errors = array();

            $site_url  = Option::get('siteurl');
            $site_name = Option::get('sitename');

            // Reset Password from hash
            if (Request::get('hash')) {

                // Get user with specific hash
                $user = Users::$users->select("[hash='" . Request::get('hash') . "']", null);

                // If user exists
                if ((count($user) > 0) && ($user['hash'] == Request::get('hash'))) {

                    // Generate new password
                    $new_password = Text::random('alnum', 6);

                    // Update user profile
                    // Set new hash and new password
                    Users::$users->updateWhere("[login='" . $user['login'] . "']", array('hash' => Text::random('alnum', 12), 'password' => Security::encryptPassword($new_password)));

                    $mail = new PHPMailer();
                    $mail->CharSet = 'utf-8';
                    $mail->ContentType = 'text/html';
                    $mail->SetFrom(Option::get('system_email'));
                    $mail->AddReplyTo(Option::get('system_email'));
                    $mail->AddAddress($user['email'], $user['login']);
                    $mail->Subject = __('Your new password for :site_name', 'users', array(':site_name' => $site_name));
                    $mail->MsgHTML(View::factory('box/users/views/emails/layout_email')
                        ->assign('site_url', $site_url)
                        ->assign('site_name', $site_name)
                        ->assign('user_id', $user['id'])
                        ->assign('user_login', $user['login'])
                        ->assign('new_password', $new_password)
                        ->assign('view', 'new_password_email')
                        ->render());
                    $mail->Send();

                    // Set notification
                    Notification::set('success', __('New password has been sent', 'users'));

                    // Redirect to password-reset page
                    Request::redirect(Site::url().'users/password-reset');

                }
            }

            // Reset Password Form Submit
            if (Request::post('reset_password_submit')) {

                $user_login = trim(Request::post('login'));

                // Check csrf
                if (Security::check(Request::post('csrf'))) {

                    if (Option::get('captcha_installed') == 'true' && ! CryptCaptcha::check(Request::post('answer'))) $errors['users_captcha_wrong'] = __('Captcha code is wrong', 'users');
                    if ($user_login == '') $errors['users_empty_field'] = __('Required field', 'users');
                    if ($user_login != '' && ! Users::$users->select("[login='".$user_login."']")) $errors['users_user_doesnt_exists'] = __('This user doesnt exist', 'users');

                    if (count($errors) == 0) {

                        // Get user
                        $user = Users::$users->select("[login='" . $user_login . "']", null);

                        // Generate new hash
                        $new_hash = Text::random('alnum', 12);

                        // Update user hash
                        Users::$users->updateWhere("[login='" . $user_login . "']", array('hash' => $new_hash));

                        $mail = new PHPMailer();
                        $mail->CharSet = 'utf-8';
                        $mail->ContentType = 'text/html';
                        $mail->SetFrom(Option::get('system_email'));
                        $mail->AddReplyTo(Option::get('system_email'));
                        $mail->AddAddress($user['email'], $user['login']);
                        $mail->Subject = __('Your login details for :site_name', 'users', array(':site_name' => $site_name));
                        $mail->MsgHTML(View::factory('box/users/views/emails/layout_email')
                            ->assign('site_url', $site_url)
                            ->assign('site_name', $site_name)
                            ->assign('user_id', $user['id'])
                            ->assign('user_login', $user['login'])
                            ->assign('new_hash', $new_hash)
                            ->assign('view', 'reset_password_email')
                            ->render());
                        $mail->Send();

                        // Set notification
                        Notification::set('success', __('Your login details for :site_name has been sent', 'users', array(':site_name' => $site_name)));

                        // Redirect to password-reset page
                        Request::redirect(Site::url().'users/password-reset');

                    }

                } else { die('Request was denied because it contained an invalid security token. Please refresh the page and try again.'); }

            }

            View::factory('box/users/views/frontend/password_reset')
                ->assign('errors', $errors)
                ->assign('user_login', trim(Request::post('login')))
                ->display();

        }
    }

    /**
     * Get User login
     */
    public static function getLogin()
    {
        // Is User Loged in ?
        if ( ! Session::get('user_id')) {

            // Login Form Submit
            if (Request::post('login_submit')) {

                if (Cookie::get('login_attempts') && Cookie::get('login_attempts') >= 5) {
                    
                    Notification::setNow('error', __('You are banned for 10 minutes. Try again later', 'users'));

                } else {

                    // Check csrf
                    if (Security::check(Request::post('csrf'))) {

                        $user = Users::$users->select("[login='" . trim(Request::post('username')) . "']", null);

                        if (count($user) !== 0) {
                            if ($user['login'] == Request::post('username')) {
                                if (trim($user['password']) == Security::encryptPassword(Request::post('password'))) {
                                    if ($user['role'] == 'admin' || $user['role'] == 'editor') {
                                        Session::set('admin', true);
                                    }
                                    Session::set('user_id', (int) $user['id']);
                                    Session::set('user_login', (string) $user['login']);
                                    Session::set('user_role', (string) $user['role']);
                                    Request::redirect(Site::url().'users/'.Session::get('user_id'));
                                } else {
                                    Notification::setNow('error', __('Wrong <b>username</b> or <b>password</b>', 'users'));

                                    if (Cookie::get('login_attempts')) {
                                        if (Cookie::get('login_attempts') < 5) {
                                            $attempts = Cookie::get('login_attempts') + 1;
                                            Cookie::set('login_attempts', $attempts , 600);
                                        } else {
                                            Notification::setNow('error', __('You are banned for 10 minutes. Try again later', 'users'));
                                        }
                                    } else {
                                        Cookie::set('login_attempts', 1, 600);
                                    }
                                }
                            }
                        } else {
                            Notification::setNow('error', __('Wrong <b>username</b> or <b>password</b>', 'users'));

                            if (Cookie::get('login_attempts')) {
                                if (Cookie::get('login_attempts') < 5) {
                                    $attempts = Cookie::get('login_attempts') + 1;
                                    Cookie::set('login_attempts', $attempts , 600);
                                } else {
                                    Notification::setNow('error', __('You are banned for 10 minutes. Try again later', 'users'));
                                }
                            } else {
                                Cookie::set('login_attempts', 1, 600);
                            }
                        }

                    } else { die('Request was denied because it contained an invalid security token. Please refresh the page and try again.'); }
                }
            }

            View::factory('box/users/views/frontend/login')->display();
        } else {
            Request::redirect(Site::url().'users/'.Session::get('user_id'));
        }
    }

    /**
     * Set title
     */
    public static function title()
    {
        switch (Users::route()) {
            case 'list':   return __('Users', 'users'); break;
            case 'profile': return __('Users - Profile', 'users'); break;
            case 'edit': return __('Users - Edit Profile', 'users'); break;
            case 'login':   return __('Users - Login', 'users'); break;
            case 'registration':   return __('Users - Registration', 'users'); break;
            case 'password-reset': return __('Users - Password Recover', 'users'); break;
        }
    }

    /**
     * Set content
     */
    public static function content()
    {
        switch (Users::route()) {
            case 'list':    Users::getList(); break;
            case 'profile': Users::getProfile(Uri::segment(1)); break;
            case 'edit': Users::getProfileEdit(Uri::segment(1)); break;
            case 'login':   Users::getLogin(); break;
            case 'registration': Users::getRegistration(); break;
            case 'password-reset': Users::getPasswordReset(); break;

        }
    }

    /**
     * Set template
     */
    public static function template()
    {
        return 'index';
    }

    /**
     * Get Gravatar
     */
    public static function getGravatarURL($email, $size)
    {
        return 'http://www.gravatar.com/avatar.php?gravatar_id='.md5($email).'&rating=PG'.'&size='.$size;
    }

}
