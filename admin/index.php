<?php

/**
 * Monstra Engine
 *
 * This source file is part of the Monstra Engine. More information,
 * documentation and tutorials can be found at http://monstra.org
 *
 * @package     Monstra
 *
 * @author      Romanenko Sergey / Awilum <awilum@msn.com>
 * @copyright   2012-2014 Romanenko Sergey / Awilum <awilum@msn.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

// Main engine defines
define('DS', DIRECTORY_SEPARATOR);
define('ROOT', rtrim(str_replace(array('admin'), array(''), dirname(__FILE__)), '\\/'));
define('BACKEND', true);
define('MONSTRA_ACCESS', true);

// Load Monstra engine _init.php file
require_once ROOT. DS .'engine'. DS .'_init.php';

// Errors var when users login failed
$login_error = '';

// Get users Table
$users = new Table('users');

// Admin login
if (Request::post('login_submit')) {

    if (Cookie::get('login_attempts') && Cookie::get('login_attempts') >= 5) {
        
        $login_error = __('You are banned for 10 minutes. Try again later', 'users');
    
    } else {

        $user = $users->select("[login='" . trim(Request::post('login')) . "']", null);
        if (count($user) !== 0) {
            if ($user['login'] == Request::post('login')) {
                if (trim($user['password']) == Security::encryptPassword(Request::post('password'))) {
                    if ($user['role'] == 'admin' || $user['role'] == 'editor') {
                        Session::set('admin', true);
                        Session::set('user_id', (int) $user['id']);
                        Session::set('user_login', (string) $user['login']);
                        Session::set('user_role', (string) $user['role']);
                        Request::redirect('index.php');
                    }
                } else {
                    $login_error = __('Wrong <b>username</b> or <b>password</b>', 'users');

                    if (Cookie::get('login_attempts')) {
                        if (Cookie::get('login_attempts') < 5) {
                            $attempts = Cookie::get('login_attempts') + 1;
                            Cookie::set('login_attempts', $attempts, 600);
                        } else {
                            $login_error = __('You are banned for 10 minutes. Try again later', 'users');
                        }
                    } else {
                        Cookie::set('login_attempts', 1, 600);
                    }

                }
            }
        } else {
            $login_error = __('Wrong <b>username</b> or <b>password</b>', 'users');

            if (Cookie::get('login_attempts')) {
                if (Cookie::get('login_attempts') < 5) {
                    $attempts = Cookie::get('login_attempts') + 1;
                    Cookie::set('login_attempts', $attempts, 600);
                } else {
                    $login_error = __('You are banned for 10 minutes. Try again later', 'users');
                }
            } else {
                Cookie::set('login_attempts', 1, 600);
            }
        }
    }
}

// Errors
$errors = array();

$site_url  = Option::get('siteurl');
$site_name = Option::get('sitename');

$user_login = trim(Request::post('login'));

// Reset Password Form Submit
if (Request::post('reset_password_submit')) {

    if (Option::get('captcha_installed') == 'true' && ! CryptCaptcha::check(Request::post('answer'))) $errors['users_captcha_wrong'] = __('Captcha code is wrong', 'users');
    if ($user_login == '') $errors['users_empty_field'] = __('Required field', 'users');
    if ($user_login != '' && ! $users->select("[login='".$user_login."']")) $errors['users_user_doesnt_exists'] = __('This user doesnt exist', 'users');

    if (count($errors) == 0) {

        // Get user
        $user = $users->select("[login='" . $user_login . "']", null);

        // Generate new hash
        $new_hash = Text::random('alnum', 12);

        // Update user hash
        $users->updateWhere("[login='" . $user_login . "']", array('hash' => $new_hash));

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
        Notification::set('reset_password', 'reset_password');

        // Redirect to password-reset page
        Request::redirect(Site::url().'admin');

    }

    Notification::setNow('reset_password', 'reset_password');
}

// If admin user is login = true then set is_admin = true
if (Session::exists('admin') && Session::get('admin') == true) {
    $is_admin = true;
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
        $area = Request::get('id');
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
    require 'themes'. DS . Option::get('theme_admin_name') . DS . 'index.template.php';

    // Backend post render
    Action::run('admin_post_render');

} else {

    // Display login template
    require 'themes'. DS . Option::get('theme_admin_name') . DS . 'login.template.php';

}

// Flush (send) the output buffer and turn off output buffering
ob_end_flush();
