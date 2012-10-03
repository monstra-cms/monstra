<?php defined('MONSTRA_ACCESS') or die('No direct script access.');

    /**
     *  Form Helper
     *
     *  @package Monstra
     *  @subpackage Helpers
     *  @author Romanenko Sergey / Awilum based on Kohana Form helper
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


    class Form {


        /**
         * The registered custom macros.
         *
         * @var array
         */
        public static $macros = array();
        

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
         *      // Registering a Form macro
         *      Form::macro('my_field', function() {
         *          return '<input type="text" name="my_field">';
         *      });
         * 
         *      // Calling a custom Form macro
         *      echo Form::my_field();
         *
         *
         *      // Registering a Form macro with parameters
         *      Form::macro('my_field', function($value = '') {
         *          return '<input type="text" name="my_field" value="'.$value.'">';
         *      });
         * 
         *      // Calling a custom Form macro with parameters
         *      echo Form::my_field('Monstra');
         *   
         *  </code>
         *
         * @param  string   $name  Name
         * @param  Closure  $macro Macro
         */
        public static function macro($name, $macro) {
            Form::$macros[$name] = $macro;
        }
        

        /**
         * Create an opening HTML form tag.
         *
         *  <code>  
         *      // Form will submit back to the current page using POST
         *      echo Form::open();
         *
         *      // Form will submit to 'search' using GET
         *      echo Form::open('search', array('method' => 'get'));
         *
         *      // When "file" inputs are present, you must include the "enctype"
         *      echo Form::open(null, array('enctype' => 'multipart/form-data'));
         *  </code>
         *
         * @param  mixed $action      Form action, defaults to the current request URI.
         * @param  array $attributes  HTML attributes.
         * @uses   Url::base
         * @uses   Html::attributes
         * @return string
         */
        public static function open($action = null, array $attributes = null) {                
            
            if ( ! $action) {
             
                // Submits back to the current url
                $action = '';
                
            } elseif (strpos($action, '://') === false) {
             
                // Make the URI absolute
                $action = Url::base() . '/' . $action;
            }
            
            // Add the form action to the attributes
            $attributes['action'] = $action;

            if ( ! isset($attributes['method'])) {                
               
                // Use POST method
                $attributes['method'] = 'post';
            }

            return '<form'.Html::attributes($attributes).'>';
        }


        /**
         * Create a form input. 
         * Text is default input type.         
         *
         *  <code>
         *      echo Form::input('username', $username);
         *  </code>         
         *
         * @param  string $name       Input name
         * @param  string $value      Input value
         * @param  array  $attributes HTML attributes
         * @uses   Html::attributes
         * @return string
         */
        public static function input($name, $value = null, array $attributes = null) {
            
            // Set the input name
            $attributes['name'] = $name;

            // Set the input value
            $attributes['value'] = $value;

            if ( ! isset($attributes['type'])) {
                // Default type is text
                $attributes['type'] = 'text';
            }

            return '<input'.Html::attributes($attributes).' />';
        }


        /**
         * Create a hidden form input. 
         *
         *  <code>
         *      echo Form::hidden('user_id', $user_id);
         *  </code>         
         *
         * @param  string $name       Input name
         * @param  string $value      Input value
         * @param  array  $attributes HTML attributes
         * @uses   Form::input
         * @return string
         */
        public static function hidden($name, $value = null, array $attributes = null) {
            
            // Set the input type
            $attributes['type'] = 'hidden';
            
            return Form::input($name, $value, $attributes);
        }


        /**
         * Creates a password form input.
         *
         *  <code>
         *     echo Form::password('password');
         *  </code>
         *
         * @param  string $name       Input name
         * @param  string $value      Input value
         * @param  array  $attributes HTML attributes
         * @uses   Form::input
         * @return string
         */
        public static function password($name, $value = null, array $attributes = null) {

            // Set the input type
            $attributes['type'] = 'password';

            return Form::input($name, $value, $attributes);
        }


        /**
         * Creates a file upload form input.
         *
         *  <code>
         *      echo Form::file('image');
         *  </code>
         *
         * @param  string $name       Input name
         * @param  array  $attributes HTML attributes
         * @uses   Form::input
         * @return string
         */
        public static function file($name, array $attributes = null) {
            
            // Set the input type
            $attributes['type'] = 'file';
            
            return Form::input($name, null, $attributes);
        }


        /**
         * Creates a checkbox form input.
         *
         *  <code>
         *      echo Form::checkbox('i_am_not_a_robot');
         *  </code>
         *
         * @param  string  $name       Input name
         * @param  string  $input      Input value
         * @param  boolean $checked    Checked status
         * @param  array   $attributes HTML attributes
         * @uses   Form::input
         * @return string
         */
        public static function checkbox($name, $value = null, $checked = false, array $attributes = null) {
            
            // Set the input type
            $attributes['type'] = 'checkbox';
            
            if ($checked === true) {
                // Make the checkbox active
                $attributes['checked'] = 'checked';
            }

            return Form::input($name, $value, $attributes);
        }


        /**
         * Creates a radio form input.
         *
         *  <code>
         *      echo Form::radio('i_am_not_a_robot');
         *  </code>
         *
         * @param  string  $name       Input name
         * @param  string  $value      Input value
         * @param  boolean $checked    Checked status
         * @param  array   $attributes HTML attributes
         * @uses   Form::input
         * @return string
         */
        public static function radio($name, $value = null, $checked = null, array $attributes = null) {
            
            // Set the input type
            $attributes['type'] = 'radio';
            
            if ($checked === true) {
                // Make the radio active
                $attributes['checked'] = 'checked';
            }
            return Form::input($name, $value, $attributes);
        }


        /**
         * Creates a textarea form input.
         *  
         *  <code>
         *      echo Form::textarea('text', $text);
         *  </code>
         *
         * @param  string $name       Name
         * @param  string $body       Body
         * @param  array  $attributes HTML attributes         
         * @uses   Html::attributes
         * @return string
         */
        public static function textarea($name, $body = '', array $attributes = null) {
            
            // Set the input name
            $attributes['name'] = $name;

            return '<textarea'.Html::attributes($attributes).'>'.$body.'</textarea>';
        }


        /**
         * Creates a select form input.
         *  
         *  <code>
         *      echo Form::select('themes', array('default', 'classic', 'modern'));
         *  </code>
         *
         * @param  string $name       Name
         * @param  array  $options     Options array
         * @param  string $selected   Selected option
         * @param  array  $attributes HTML attributes
         * @uses   Html::attributes
         * @return string
         */
        public static function select($name, array $options = null, $selected = null, array $attributes = null) {
            
            // Set the input name
            $attributes['name'] = $name;
            
            $options_output = '';

            foreach ($options as $value => $name) {                
                if ($selected == $value) $current = ' selected '; else $current = '';
                $options_output .= '<option value="'.$value.'" '.$current.'>'.$name.'</option>';
            }

            return '<select'.Html::attributes($attributes).'>'.$options_output.'</select>';   
        }


        /**
         * Creates a submit form input.
         *
         *  <code>
         *      echo Form::submit('save', 'Save');
         *  </code>
         *
         * @param  string $name       Input name
         * @param  string $value      Input value
         * @param  array  $attributes HTML attributes
         * @uses   Form::input
         * @return string
         */
        public static function submit($name, $value, array $attributes = null) {
            
            // Set the input type
            $attributes['type'] = 'submit';
            
            return Form::input($name, $value, $attributes);
        }


        /**
         * Creates a button form input. 
         *
         *  <code>
         *      echo Form::button('save', 'Save Profile', array('type' => 'submit'));      
         *  </code>
         *
         * @param  string $name       Input name
         * @param  string $value      Input value
         * @param  array  $attributes HTML attributes
         * @uses   Html::attributes
         * @return string
         */
        public static function button($name, $body, array $attributes = null) {
            
            // Set the input name
            $attributes['name'] = $name;
            
            return '<button'.Html::attributes($attributes).'>'.$body.'</button>';
        }


        /**
         * Creates a form label.
         *
         *  <code>
         *      echo Form::label('username', 'Username');
         *  </code>
         *
         * @param  string $input     Target input
         * @param  string $text      Label text
         * @param  array $attributes HTML attributes
         * @uses   Html::attributes
         * @return string
         */
        public static function label($input, $text, array $attributes = null) {
            
            // Set the label target
            $attributes['for'] = $input;

            return '<label'.Html::attributes($attributes).'>'.$text.'</label>';
        }


        /**
         * Create closing form tag.
         *
         *  <code>  
         *      echo Form::close();
         *  </code>
         *
         * @return  string
         */
        public static function close() {
            return '</form>';
        }


        /**
         * Dynamically handle calls to custom macros.
         *
         * @param  string  $method
         * @param  array   $parameters
         * @return mixed
         */
        public static function __callStatic($method, $parameters) {

            if (isset(Form::$macros[$method])) {
                return call_user_func_array(Form::$macros[$method], $parameters);
            }

            throw new RuntimeException("Method [$method] does not exist.");
        }

    }