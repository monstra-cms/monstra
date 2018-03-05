<?php
/**
 * This file is part of the Monstra.
 *
 * (c) Romanenko Sergey / Awilum <awilum@msn.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Monstra;

// Register the auto-loader.
$autoload = __DIR__ . '/vendor/autoload.php';

// Ensure vendor libraries exist
!is_file($autoload) and exit("Please run: <i>composer install</i>");

// Register the auto-loader.
$loader = require_once $autoload;

// Check PHP Version
version_compare($ver = PHP_VERSION, $req = '7.1.3', '<') and exit(sprintf('You are running PHP %s, but Monstra needs at least <strong>PHP %s</strong> to run.', $ver, $req));

// Get Monstra Instance
$app = Monstra::instance();

// Run Monstra Application
$app->run();
