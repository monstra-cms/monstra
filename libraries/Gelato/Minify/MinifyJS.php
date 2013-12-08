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

class MinifyJS
{
    /**
     * Minify js
     *
     *  <code>
     *      echo MinifyJS::process($js);
     *  </code>
     *
     * @param  string $buffer html
     * @return string
     */
    public static function process($js)
    {
        // newlines > linefeed
        $js = str_replace(array("\r\n", "\r", "\n"), "\n", $js);

        // empty lines > collapse
        $js = preg_replace('/^[ \t]*|[ \t]*$/m', '', $js);
        $js = preg_replace('/\n+/m', "\n", $js);
        $js = trim($js);

        // redundant whitespace > remove
        $js = preg_replace('/(?<=[{}\[\]\(\)=><&\|;:,\?!\+-])[ \t]*|[ \t]*(?=[{}\[\]\(\)=><&\|;:,\?!\+-])/i', '', $js);
        $js = preg_replace('/[ \t]+/', ' ', $js);

        // redundant semicolons (followed by another semicolon or closing curly bracket) > remove
        $js = preg_replace('/;\s*(?=[;}])/s', '', $js);

        // Return JS
        return $js;
    }
}
