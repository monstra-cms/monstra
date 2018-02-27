<?php

// Monstra requires PHP 5.5.9 or greater
version_compare(PHP_VERSION, "5.5.9", "<") and exit("Monstra requires PHP 5.5.9 or greater.");

// Register the auto-loader.
require_once __DIR__ . '/vendor/autoload.php';

// Initialize Monstra Application
Monstra::init();
