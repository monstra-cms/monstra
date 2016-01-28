<?php

/**
 *  Markdown plugin
 *
 *  @package Monstra
 *  @subpackage Plugins
 *  @author Romanenko Sergey / Awilum
 *  @copyright 2014 Romanenko Sergey / Awilum
 *  @version 1.0.0
 *
 */

// Register plugin
Plugin::register(__FILE__,
                __('Markdown'),
                __('Markdown markup language plugin for Monstra'),
                '1.0.0',
                'Awilum',
                'http://monstra.org/');

// Uncomment code below to use Markdown on Site Content
Filter::add('content', 'markdown', 1);

use \Michelf\MarkdownExtra;

include PLUGINS . '/markdown/php-markdown/Michelf/Markdown.php';
include PLUGINS . '/markdown/php-markdown/Michelf/MarkdownExtra.php';

function markdown($content)
{
    return MarkdownExtra::defaultTransform($content);
}
