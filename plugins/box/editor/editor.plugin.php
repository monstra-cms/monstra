<?php

/**
 *  Editor plugin
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
                __('Editor', 'editor'),
                __('Editor plugin', 'editor'),
                '1.0.0',
                'Awilum',
                'http://monstra.org/',
                null,
                'box');

// Add action
Action::add('admin_editor', 'Editor::render', 10, array());

/**
 * Editor class
 */
class Editor
{
    /**
     * Render editor
     *
     * @param string $val editor data
     */
    public static function render($val = null)
    {
        echo ('<div id="editor_panel"></div><div><textarea id="editor_area" name="editor" style="width:100%; height:320px;">'.$val.'</textarea></div>');
    }

}
