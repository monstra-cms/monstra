<?php

/**
 * Gelato Library
 *
 * This source file is part of the Gelato Library. More information,
 * documentation and tutorials can be found at http://gelato.monstra.org
 *
 * @package     Gelato
 *
 * @author      Romanenko Sergey / Awilum <awilum@msn.com>
 * @copyright   2012-2014 Romanenko Sergey / Awilum <awilum@msn.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

class MinifyHTML
{
    /**
     * Minify html
     *
     *  <code>
     *      echo MinifyHTML::process($html);
     *  </code>
     *
     * @param  string $buffer html
     * @return string
     */
    public static function process($html)
    {
        // Remove HTML comments (not containing IE conditional comments).
        $html = preg_replace_callback('/<!--([\\s\\S]*?)-->/', 'MinifyHTML::_comments', $html);

        // Trim each line.
        $html = preg_replace('/^\\s+|\\s+$/m', '', $html);

        // Return HTML
        return $html;
    }

    protected static function _comments($m)
    {
        return (0 === strpos($m[1], '[') || false !== strpos($m[1], '<![')) ? $m[0] : '';
    }

}
