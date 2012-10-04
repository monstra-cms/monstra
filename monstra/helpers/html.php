<?php defined('MONSTRA_ACCESS') or die('No direct script access.');

    /**
     *	HTML Helper
     *
     *	@package Monstra
     *	@subpackage Helpers
     *	@author Romanenko Sergey / Awilum based on Kohana HTML helper
     *	@copyright 2012 Romanenko Sergey / Awilum
     *	@version $Id$
     *	@since 1.0.0
     *  @license http://opensource.org/licenses/gpl-license.php GNU Public License
     *  Monstra is free software. This version may have been modified pursuant
     *  to the GNU General Public License, and as distributed it includes or
     *  is derivative of works licensed under the GNU General Public License or
     *  other free or open source software licenses.
     *  See COPYING.txt for copyright notices and details.
     *  @filesource 
     */


	class Html {
		

		/**
		 * Preferred order of attributes
		 *
		 * @var array  
		 */
		public static $attribute_order = array (
			'action', 'method', 'type', 'id', 'name', 'value',
			'href', 'src', 'width', 'height', 'cols', 'rows',
			'size', 'maxlength', 'rel', 'media', 'accept-charset',
			'accept', 'tabindex', 'accesskey', 'alt', 'title', 'class',
			'style', 'selected', 'checked', 'readonly', 'disabled',
		);


        /** 
         * Protected constructor since this is a static class.
         *
         * @access  protected
         */  
        protected function __construct() {
            // Nothing here
        }


        /**
         * Registers a custom macro.
         *
         *  <code> 
         * 
         *      // Registering a Htmlk macro
         *      Html::macro('my_element', function() {
         *          return '<element id="monstra">';
         *      });
         * 
         *      // Calling a custom Html macro
         *      echo Html::my_element();
         *
         *
         *      // Registering a Html macro with parameters
         *      Html::macro('my_element', function(id = '') {
         *      	return '<element id="'.$id.'">';
         *      });
         * 
         *      // Calling a custom Html macro with parameters
         *      echo Html::my_element('monstra');
         *   
         *  </code>
         *
         * @param  string   $name  Name
         * @param  Closure  $macro Macro
         */
        public static function macro($name, $macro) {
            Html::$macros[$name] = $macro;
        }
        
        
		/**
		 * Convert special characters to HTML entities. All untrusted content
		 * should be passed through this method to prevent XSS injections.
		 * 
		 *	<code>
		 *		echo Html::chars($username);
		 *	</code>
		 *
		 * @param   string $value 		   String to convert
		 * @param   boolean $double_encode Encode existing entities
		 * @return  string
		 */
		public static function chars($value, $double_encode = true) {
			return htmlspecialchars((string)$value, ENT_QUOTES, 'utf-8', $double_encode);
		}


		/**
		 * Compiles an array of HTML attributes into an attribute string.
		 * Attributes will be sorted using Html::$attribute_order for consistency.
		 *
		 *	<code>
		 *		echo '<div'.Html::attributes($attrs).'>'.$content.'</div>';
		 *	</code>
		 *
		 * @param   array $attributes Attribute list
		 * @return  string
		 */
		public static function attributes(array $attributes = null) {

			if (empty($attributes)) return '';

			// Init var
			$sorted = array();

			foreach (Html::$attribute_order as $key) {

				if (isset($attributes[$key])) {
					// Add the attribute to the sorted list
					$sorted[$key] = $attributes[$key];
				}

			}

			// Combine the sorted attributes
			$attributes = $sorted + $attributes;

			$compiled = '';
			foreach ($attributes as $key => $value) {

				if ($value === NULL) {
					// Skip attributes that have NULL values
					continue;
				}

				if (is_int($key)) {
					// Assume non-associative keys are mirrored attributes
					$key = $value;
				}

				// Add the attribute value
				$compiled .= ' '.$key.'="'.Html::chars($value).'"';
			}

			return $compiled;
		}


	    /**
	     * Create br tags
	     *
	     *	<code>
	     *	 	echo Html::br(2);
	     *	</code>
	     *
	     * @param integer $num Count of line break tag
	     * @return string
	     */		
	    public static function br($num = 1) {
	        return str_repeat("<br />",(int)$num);
	    }
	

	    /**
	     * Create &nbsp;
	     *
	     *	<code>
	     *		echo Html::nbsp(2);
	     *	</code>
	     *
	     * @param integer $num Count of &nbsp;
	     * @return string
	     */
	    public static function nbsp($num = 1) {
	        return str_repeat("&nbsp;", (int)$num);
	    }


	    /**
	     * Create an arrow
	     *
	     *	<code>
	     *		echo Html::arrow('right');
	     *	</code>
	     *
	     * @param string $direction Arrow direction [up,down,left,right]
	     * @param boolean $render   If this option is true then render html object else return it
	     * @return string
	     */	
	    public static function arrow($direction) {
	        switch ($direction) {
	            case "up": 	  $output = '<span class="arrow">&uarr;</span>'; break;
	            case "down":  $output = '<span class="arrow">&darr;</span>'; break;
	            case "left":  $output = '<span class="arrow">&larr;</span>'; break;
	            case "right": $output = '<span class="arrow">&rarr;</span>'; break;
	        }
	       	return $output;
	    }


	    /**
	     * Create HTML link anchor.
	     *
	     *	<code>
	     *		echo Html::anchor('About', 'http://sitename.com/about');
	     *	</code>
	     *
	     * @param string $title 	 Anchor title
	     * @param string $url  		 Anchor url
	 	 * @param array  $attributes Anchor attributes
	 	 * @uses  Html::attributes
	 	 * @return string
	     */
	    public static function anchor($title, $url = null, array $attributes = null) {
	    	
	    	// Add link
	    	if ($url !== null) $attributes['href'] = $url;

	    	return '<a'.Html::attributes($attributes).'>'.$title.'</a>';
	    }
	

	    /**
	     * Create HTML <h> tag
		 *
		 *	<code>
	     *		echo Html::heading('Title', 1);
	     *	</code>
	     *
	     * @param string $title 	 Text
	     * @param integer $h 		 Number [1-6]	 
	     * @param array  $attributes Heading attributes
	     * @uses  Html::attributes    
	     * @return string
	     */
	    public static function heading($title, $h = 1, array $attributes = null) {
	        
	        $output = '<h'.(int)$h.Html::attributes($attributes).'>'.$title.'</h'.(int)$h.'>';
	        
	        return $output;
	    }


	    /**
	     * Generate document type declarations
	     *
	     *	<code>
	     *		echo Html::doctype('html5');
	     *	</code>
	     *
	     * @param  string $type Doctype to generated
	     * @return mixed
	     */
	    public static function doctype($type = 'html5') {

			$doctypes = array('xhtml11' => '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">',
					  'xhtml1-strict' => '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">',
					  'xhtml1-trans'  => '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">',
					  'xhtml1-frame'  => '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Frameset//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-frameset.dtd">',
					  'html5'	  => '<!DOCTYPE html>',
					  'html4-strict'  => '<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">',
					  'html4-trans'	  => '<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">',
					  'html4-frame'	  => '<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Frameset//EN" "http://www.w3.org/TR/html4/frameset.dtd">');
			
			if (isset($doctypes[$type])) return $doctypes[$type]; else return false;

	    }


	    /**
	     * Create image
	     *
	     *	<code>
	     *  	echo Html::image('data/files/pic1.jpg');
	     * 	</code>
	     *
	     * @param array $attributes Image attributes
	     * @param string $file 		File
	     * @uses  Url::base
	     * @return string
	     */		    
	    public static function image($file, array $attributes = null) {
			
			if (strpos($file, '://') === FALSE) {				
				$file = Url::base().'/'.$file;
			}
	
			// Add the image link
			$attributes['src'] = $file;
			$attributes['alt'] = (isset($attributes['alt'])) ? $attributes['alt'] : pathinfo($file, PATHINFO_FILENAME);
			
			return '<img'.Html::attributes($attributes).' />';
	    }


	    /**
	     * Convert html to plain text
	     *
	     *	<code>
	     *  	echo Html::toText('test');
	     * 	</code>
	     *
	     * @param string $str String
	     * @return string
	     */
	    public static function toText($str) {
	        return htmlspecialchars($str, ENT_QUOTES, 'utf-8');        
	    }
	    
	    
        /**
         * Dynamically handle calls to custom macros.
         *
         * @param  string  $method
         * @param  array   $parameters
         * @return mixed
         */
        public static function __callStatic($method, $parameters) {

            if (isset(Html::$macros[$method])) {
                return call_user_func_array(Html::$macros[$method], $parameters);
            }

            throw new RuntimeException("Method [$method] does not exist.");
        }

	}