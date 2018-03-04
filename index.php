<?php
namespace Monstra;

// Register the auto-loader.
$loader = require __DIR__ . '/vendor/autoload.php';

// Check PHP Version
version_compare($ver = PHP_VERSION, $req = '7.1.3', '<') and exit(sprintf('You are running PHP %s, but Monstra needs at least <strong>PHP %s</strong> to run.', $ver, $req));

// Get Monstra Instance
$app = Monstra::instance();

// Run Monstra Application
$app->run();
