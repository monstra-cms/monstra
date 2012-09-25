<?php

    /**
     *	Admin module
     *
     *	@package Monstra
     *	@author Romanenko Sergey / Awilum [awilum@msn.com]
     *	@copyright 2012 Romanenko Sergey / Awilum
     *	@version $Id$
     *	@since 1.0.0
     *  @license http://opensource.org/licenses/gpl-license.php GNU Public License
     *  Monstra is free software. This version may have been modified pursuant
     *  to the GNU General Public License, and as distributed it includes or
     *  is derivative of works licensed under the GNU General Public License or
     *  other free or open source software licenses.
     *  See COPYING.txt for copyright notices and details.
     */


    // Main engine defines  
    define('DS', DIRECTORY_SEPARATOR);
    define('ROOT', rtrim(str_replace(array('admin'), array(''), dirname(__FILE__)), '\\/'));
    define('BACKEND', true);
    define('MONSTRA_ACCESS', true);

    // Load bootstrap file
    require_once(ROOT . DS . 'monstra' . DS . 'bootstrap.php');

    // Errors var when users login failed
    $login_error = '';

    // Admin login
    if (Request::post('login_submit')) {        
       
        // Sleep MONSTRA_LOGIN_SLEEP seconds for blocking Brute Force Attacks
        sleep(MONSTRA_LOGIN_SLEEP);  
       
        // Get users Table
        $users = new Table('users');
        $user  = $users->select("[login='" . trim(Request::post('login')) . "']", null);
        if (count($user) !== 0) {
            if ($user['login'] == Request::post('login')) {
                if (trim($user['password']) == Security::encryptPassword(Request::post('password'))) {
                    if ($user['role'] == 'admin' || $user['role'] == 'editor') {
                        Session::set('admin', true);
                        Session::set('user_id', (int)$user['id']);
                        Session::set('user_login', (string)$user['login']);
                        Session::set('user_role', (string)$user['role']);
                        Request::redirect('index.php');
                    }
                } else {
                    $login_error = __('Wrong <b>username</b> or <b>password</b>', 'users');
                }
            } 
        } else {
            $login_error = __('Wrong <b>username</b> or <b>password</b>', 'users');
        }
    }


    // Errors
    $errors = array();

    // Reset password
    if (Request::post('reset_password_submit')) {

        // Get users Table
        $users = new Table('users');

        // Get user
        $user = $users->select("[login='" . trim(Request::post('login')) . "']", null);

        // Check
        if (count($user) == 0) $errors['users_doesnt_exist'] = __('This user does not exist', 'users');
        if (Option::get('captcha_installed') == 'true' && ! CryptCaptcha::check(Request::post('answer'))) $errors['users_captcha_wrong'] = __('Captcha code is wrong', 'captcha');        

        // If Errors Count is 0
        if (count($errors) == 0) {
            
            // Generate new password
            $new_password = Text::random('alnum', 6);

            // Update user profile
            $users->updateWhere("[login='" . trim(Request::post('login')) . "']", array('password' => Security::encryptPassword($new_password)));

            // Message
            $message = "Login: {$user['login']}\nNew Password: {$new_password}";

            // Send
            @mail($user['email'], 'MonstraPasswordReset', $message);

        }

        Notification::setNow('reset_password_error', 'reset_password_error');   
    }

    // If admin user is login = true then set is_admin = true
    if (Session::exists('admin')) {
        if (Session::get('admin') == true) {
            $is_admin = true;
        }
    } else {
        $is_admin = false;
    }

    // Logout user from system
    if (Request::get('logout') && Request::get('logout') == 'do') {
        Session::destroy();
    }

    // If is admin then load admin area
    if ($is_admin) {        
        // If id is empty then redirect to default plugin PAGES
        if (Request::get('id')) {       
            if (Request::get('sub_id')) {
                $area = Request::get('sub_id');
            } else {
                $area = Request::get('id');
            }
        } else {
            Request::redirect('index.php?id=pages');
        }

        $plugins_registered = Plugin::$plugins;
        foreach ($plugins_registered as $plugin) {
            $plugins_registered_areas[] = $plugin['id'];
        }

        // Show plugins admin area only for registered plugins
        if (in_array($area, $plugins_registered_areas)) {
            $plugin_admin_area = true;
        } else {
            $plugin_admin_area = false;
        }

        // Backend pre render
        Action::run('admin_pre_render');

        // Display admin template
        require('themes' . DS . Option::get('theme_admin_name') . DS . 'index.template.php');

        // Backend post render
        Action::run('admin_post_render');

    } else {
        
        // Display login template
        require('themes' . DS . Option::get('theme_admin_name') . DS . 'login.template.php');

    }
    
    // Flush (send) the output buffer and turn off output buffering
    ob_end_flush();