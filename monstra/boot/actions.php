<?php

/**
 * This file is part of the Monstra.
 *
 * (c) Romanenko Sergey / Awilum <awilum@msn.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

// Set Monstra Meta Generator
Action::add('theme_meta', function () {
    echo('<meta name="generator" content="Powered by Monstra" />');
});
