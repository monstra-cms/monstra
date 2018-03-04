<?php
namespace Monstra;

use Arr;

/**
 * This file is part of the Monstra.
 *
 * (c) Romanenko Sergey / Awilum <awilum@msn.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

class Pages extends Page
{
    /**
     * @var Monstra
     */
    protected $monstra;

    /**
     * Construct
     */
    public function __construct(Monstra $c)
    {
        $this->monstra = $c;
    }

    /**
     * getPage
     */
    public function getPages($url = '', $raw = false, $order_by = 'date', $order_type = 'DESC', $ignore = ['404', 'index'], $limit = null)
    {
        // Get pages list for current $url
        $pages_list = $this->monstra['finder']->files()->name('*.md')->in(CONTENT_PATH . '/pages/' . $url);

        // Go trough pages list
        foreach ($pages_list as $key => $page) {
            $pages[$key] = $this->getPage($page->getPathname(), $raw, true);
        }

        // Sort and Slice pages if !$raw
        if (!$raw) {
            $pages = Arr::subvalSort($pages, $order_by, $order_type);

            if ($limit != null) {
                $pages = array_slice($_pages, null, $limit);
            }
        }

        return $pages;
    }
}
