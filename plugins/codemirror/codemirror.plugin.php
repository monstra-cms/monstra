<?php

/**
 *	CodeMirror plugin
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
                __('CodeMirror', 'codemirror'),
                __('CodeMirror is a versatile text editor implemented in JavaScript for the browser.', 'codemirror'),
                '1.0.0',
                'Awilum',
                'http://monstra.org/');

// Add hooks
Action::add('admin_header', 'CodeMirror::headers');

/**
 * Codemirror Class
 */
class CodeMirror
{
    
    public static $theme = 'mdn-like';

    /**
     * Set editor headers
     */
    public static function headers()
    {
        echo ('
            <link rel="stylesheet" type="text/css" href="'.Option::get('siteurl').'/plugins/codemirror/codemirror/lib/codemirror.css" />
            <script type="text/javascript" src="'.Option::get('siteurl').'/plugins/codemirror/codemirror/lib/codemirror.js"></script>
            <script type="text/javascript" src="'.Option::get('siteurl').'/plugins/codemirror/codemirror/addon/edit/matchbrackets.js"></script>
            <script type="text/javascript" src="'.Option::get('siteurl').'/plugins/codemirror/codemirror/mode/htmlmixed/htmlmixed.js"></script>
            <script type="text/javascript" src="'.Option::get('siteurl').'/plugins/codemirror/codemirror/mode/xml/xml.js"></script>
            <script type="text/javascript" src="'.Option::get('siteurl').'/plugins/codemirror/codemirror/mode/javascript/javascript.js"></script>
            <script type="text/javascript" src="'.Option::get('siteurl').'/plugins/codemirror/codemirror/mode/css/css.js"></script>
            <script type="text/javascript" src="'.Option::get('siteurl').'/plugins/codemirror/codemirror/mode/clike/clike.js"></script>
            <script type="text/javascript" src="'.Option::get('siteurl').'/plugins/codemirror/codemirror/mode/php/php.js"></script>
            <script type="text/javascript" src="'.Option::get('siteurl').'/plugins/codemirror/codemirror/addon/selection/active-line.js"></script>
            <link rel="stylesheet" href="'.Option::get('siteurl').'/plugins/codemirror/codemirror/theme/'.CodeMirror::$theme.'.css">
            <style>
                .CodeMirror {
                    height:400px!important; 
                    border: 1px solid #ccc;
                    color: #555;
                    font-family: monospace;
                    font-size: 15px;
                    line-height: 1;
                    padding: 6px 9px;
                }
            </style>
        ');

        if (Request::get('id') == 'themes' || Request::get('id') == 'snippets' || Request::get('id') == 'emails') { 
            
            if (Request::get('action') == 'edit_styles') {
                $mode = 'text/css';
            } else {
                $mode = 'application/x-httpd-php';
			}
            
            echo ('<script>
                        $(document).ready(function() {
                            var editor = CodeMirror.fromTextArea(document.getElementById("content"), {
                                lineNumbers: false,
                                styleActiveLine: true,
                                matchBrackets: true,
                                indentUnit: 4,
                                mode:  "'.$mode.'",
                                indentWithTabs: true,
                                theme: "'.CodeMirror::$theme.'"                        
                            });
                        });
                </script>');
        }
    }
}
