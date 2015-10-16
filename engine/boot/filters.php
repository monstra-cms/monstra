<?php defined('MONSTRA_ACCESS') or die('No direct script access.');

/**
 * Evaluate a string as PHP code
 */
if (MONSTRA_EVAL_PHP) {
    Filter::add('content', 'evalPHP');
}
function obEval($mathes)
{
    ob_start();
    eval($mathes[1]);
    $mathes = ob_get_contents();
    ob_end_clean();

    return $mathes;
}
function evalPHP($str)
{
    return preg_replace_callback('/\[php\](.*?)\[\/php\]/ms', 'obEval', $str);
}

/**
 * Add shortcode parser filter
 */
Filter::add('content', 'Shortcode::parse', 11);
