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
 * @copyright   2012-2013 Romanenko Sergey / Awilum <awilum@msn.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

class Minify
{
    /**
     * Protected constructor since this is a static class.
     *
     * @access  protected
     */
    protected function __construct()
    {
        // Nothing here
    }

    /**
     * Minify html
     *
     *  <code>
     *      echo Minify::html($buffer);
     *  </code>
     *
     * @param  string $buffer html
     * @return string
     */
    public static function html($buffer)
    {
        return preg_replace('/^\\s+|\\s+$/m', '', $buffer);
    }

    /**
     * Minify css
     *
     *  <code>
     *      echo Minify::css($buffer);
     *  </code>
     *
     * @param  string $buffer css
     * @return string
     */
    public static function css($buffer)
    {
        // Remove comments
        $buffer = preg_replace('!/\*[^*]*\*+([^/][^*]*\*+)*/!', '', $buffer);

        // Remove tabs, spaces, newlines, etc.
        $buffer = str_replace(array("\r\n", "\r", "\n", "\t", '  ', '    ', '    '), '', $buffer);

        // Preserve empty comment after '>' http://www.webdevout.net/css-hacks#in_css-selectors
        $buffer = preg_replace('@>/\\*\\s*\\*/@', '>/*keep*/', $buffer);

        // Preserve empty comment between property and value
        // http://css-discuss.incutio.com/?page=BoxModelHack
        $buffer = preg_replace('@/\\*\\s*\\*/\\s*:@', '/*keep*/:', $buffer);
        $buffer = preg_replace('@:\\s*/\\*\\s*\\*/@', ':/*keep*/', $buffer);

        // Remove ws around { } and last semicolon in declaration block
        $buffer = preg_replace('/\\s*{\\s*/', '{', $buffer);
        $buffer = preg_replace('/;?\\s*}\\s*/', '}', $buffer);

        // Remove ws surrounding semicolons
        $buffer = preg_replace('/\\s*;\\s*/', ';', $buffer);

        // Remove ws around urls
        $buffer = preg_replace('/url\\(\\s*([^\\)]+?)\\s*\\)/x', 'url($1)', $buffer);

        // Remove ws between rules and colons
        $buffer = preg_replace('/\\s*([{;])\\s*([\\*_]?[\\w\\-]+)\\s*:\\s*(\\b|[#\'"])/x', '$1$2:$3', $buffer);

        // Minimize hex colors
        $buffer = preg_replace('/([^=])#([a-f\\d])\\2([a-f\\d])\\3([a-f\\d])\\4([\\s;\\}])/i', '$1#$2$3$4$5', $buffer);

        // Replace any ws involving newlines with a single newline
        $buffer = preg_replace('/[ \\t]*\\n+\\s*/', "\n", $buffer);

        return $buffer;
    }

}
