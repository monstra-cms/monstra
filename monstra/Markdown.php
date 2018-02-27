<?php

/**
 * This file is part of the Monstra.
 *
 * (c) Romanenko Sergey / Awilum <awilum@msn.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

class Markdown
{
    /**
     * Parsedown Extra Object
     *
     * @var object
     * @access  protected
     */
    protected static $markdown;

    /**
     * Markdown parser
     *
     *  <code>
     *      $content = Markdown::parse($content);
     *  </code>
     *
     * @access  public
     * @param  string $content Content to parse
     * @return string Formatted content
     */
    public static function parse($content)
    {
        !static::$markdown and static::$markdown = new ParsedownExtra();

        return static::$markdown->text($content);
    }
}
