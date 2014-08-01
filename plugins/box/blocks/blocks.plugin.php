<?php

/**
 *	Blocks plugin
 *
 *	@package Monstra
 *  @subpackage Plugins
 *	@author Romanenko Sergey / Awilum
 *	@copyright 2012-2014 Romanenko Sergey / Awilum
 *	@version 1.0.0
 *
 */

// Register plugin
Plugin::register( __FILE__,
                __('Blocks', 'blocks'),
                __('Blocks manager plugin', 'blocks'),
                '1.0.0',
                'Awilum',
                'http://monstra.org/',
                null,
                'box');

if (Session::exists('user_role') && in_array(Session::get('user_role'), array('admin', 'editor'))) {

    // Include Admin
    Plugin::admin('blocks', 'box');

}

// Add Plugin Javascript
Javascript::add('plugins/box/blocks/js/blocks.js', 'backend');

// Add shortcode {block get="blockname"}
Shortcode::add('block', 'Block::_content');

// Add shortcode {block_inline name="blockname"}
Shortcode::add('block_inline', 'Block::_inlineBlock');

// Add shortcode {block_inline_create name="blockname"} Block content here {/block_inline_create}
Shortcode::add('block_inline_create', 'Block::_createInlineBlock');

/**
 * Block Class
 */
class Block
{
    /**
     * Inline Blocks
     *
     * @var array
     */
    public static $inline_blocks = array();

    /**
     * Create Inline Block
     */
    public static function _createInlineBlock($attributes, $content)
    {
        if (isset($attributes['name'])) {
            Block::$inline_blocks[Security::safeName($attributes['name'], '_', true)] = array(
                'content'  => (string) $content,
            );
        }
    }

    /**
     * Draw Inline Block
     */
    public static function _inlineBlock($attributes)
    {
        if (isset($attributes['name']) && isset(Block::$inline_blocks[$attributes['name']])) {
            $content = Filter::apply('content', Text::toHtml(Block::$inline_blocks[$attributes['name']]['content']));

            return $content;
        } else {
            return '';
        }
    }

    /**
     * Get block
     *
     * @param string $name Block file name
     */
    public static function get($name)
    {
        return Block::_content(array('get' => $name));
    }

    /**
     * Returns block content for shortcode {block get="blockname"}
     *
     * @param array $attributes block filename
     */
    public static function _content($attributes)
    {
        if (isset($attributes['get'])) $name = (string) $attributes['get']; else $name = '';

        $block_path = STORAGE . DS . 'blocks' . DS . $name . '.block.html';

        if (File::exists($block_path)) {
            ob_start();
            include $block_path;
            $block_contents = ob_get_contents();
            ob_end_clean();

            return Filter::apply('content', Text::toHtml($block_contents));
        } else {
            if (Session::exists('admin') && Session::get('admin') == true) {
                return __('<b>Block <u>:name</u> is not found!</b>', 'blocks', array(':name' => $name));
            }
        }
    }
}
