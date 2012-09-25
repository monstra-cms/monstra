<?php defined('MONSTRA_ACCESS') or die('No direct script access.');

    /**
     *  Minify Helper
     *
     *  @package Monstra
     *  @subpackage Helpers
     *  @author Romanenko Sergey / Awilum
     *  @copyright 2012 Romanenko Sergey / Awilum
     *  @version $Id$
     *  @since 1.0.0
     *  @license http://opensource.org/licenses/gpl-license.php GNU Public License
     *  Monstra is free software. This version may have been modified pursuant
     *  to the GNU General Public License, and as distributed it includes or
     *  is derivative of works licensed under the GNU General Public License or
     *  other free or open source software licenses.
     *  See COPYING.txt for copyright notices and details.
     *  @filesource 
     */


	class Minify {
		

        /** 
         * Protected constructor since this is a static class.
         *
         * @access  protected
         */  
        protected function __construct() {
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
		public static function html($buffer)  {
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
		public static function css($buffer)  {

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