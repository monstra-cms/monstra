<?php defined('MONSTRA_ACCESS') or die('No direct script access.');

/**
 * Set meta generator
 */
Action::add('theme_meta', 'setMetaGenerator');
function setMetaGenerator() { echo '<meta name="generator" content="Powered by Monstra '.Monstra::VERSION.'" />'."\n"; }
