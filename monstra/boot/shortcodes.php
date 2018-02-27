<?php

/**
 * This file is part of the Monstra.
 *
 * (c) Romanenko Sergey / Awilum <awilum@msn.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

// Add {block name=block-name} shortcode
Shortcode::add('block', function ($attributes) {
    if (isset($attributes['name'])) {
        return Blocks::get($attributes['name']);
    }
});

// Add {site_url} shortcode
Shortcode::add('site_url', function () {
    return Url::getBase();
});
