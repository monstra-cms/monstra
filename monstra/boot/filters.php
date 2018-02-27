<?php

/**
 * This file is part of the Monstra.
 *
 * (c) Romanenko Sergey / Awilum <awilum@msn.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

// Add Shortcode parser filter
Filter::add('content', 'Shortcode::parse', 1);

// Add Parsedown parser filter
Filter::add('content', 'Markdown::parse', 2);
