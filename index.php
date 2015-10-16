<?php

/**
 * Monstra
 *
 * @package Monstra
 * @author Romanenko Sergey / Awilum <awilum@msn.com>
 * @link http://monstra.org
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */


// Main engine defines
define('DS', DIRECTORY_SEPARATOR);
define('ROOT', rtrim(dirname(__FILE__), '\\/'));
define('BACKEND', false);
define('MONSTRA_ACCESS', true);

// First check for installer then go
if (file_exists('install.php')) {
    if (isset($_GET['install'])) {
        if ($_GET['install'] == 'done') {
            // Try to delete install file if not delete manually
            @unlink('install.php');
            // Redirect to main page
            header('location: index.php');
        }
    } else {
        include 'install.php';
    }
} else {

    // Load Engine init file
    require_once ROOT. DS . 'engine'. DS . '_init.php';

    // Check for maintenance mod
    if ('on' == Option::get('maintenance_status')) {

        // Set maintenance mode for all except admin and editor
        if ((Session::exists('user_role')) and (Session::get('user_role') == 'admin' or Session::get('user_role') == 'editor')) {
            // Monstra show this page :)
        } else {
            header('HTTP/1.1 503 Service Temporarily Unavailable');
            header('Status: 503 Service Temporarily Unavailable');
            header('Retry-After: 600');
            die(Text::toHtml(Option::get('maintenance_message')));
        }
    }

    // Frontend pre render
    Action::run('frontend_pre_render');

    // Load site template
    require MINIFY . DS . 'theme.' . Site::theme() . '.' . Site::template() . '.template.php';

    // Frontend pre render
    Action::run('frontend_post_render');

    // Flush (send) the output buffer and turn off output buffering
    ob_end_flush();
}
