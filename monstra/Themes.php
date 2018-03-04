<?php
namespace Monstra;

/**
 * This file is part of the Monstra.
 *
 * (c) Romanenko Sergey / Awilum <awilum@msn.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

class Themes
{
    /**
     * @var Monstra
     */
    protected $monstra;

    /**
     * __construct
     */
    public function __construct(Monstra $c)
    {
        $this->monstra = $c;
    }

}
