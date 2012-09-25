<?php defined('MONSTRA_ACCESS') or die('No direct script access.');

    /**
     *  Alert Helper
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


    class Alert {
        

        /** 
         * Protected constructor since this is a static class.
         *
         * @access  protected
         */  
        protected function __construct() {
            // Nothing here
        }

        
        /**
         * Show success message
         *
         *  <code>
         *      Alert::success('Message here...');
         *  </code>
         *
         * @param string  $message Message
         * @param integer $time    Time
         */
        public static function success($message, $time = 3000) {        
            
            // Redefine vars
            $message = (string) $message;
            $time    = (int)    $time;
             
            echo '<div class="alert alert-info">'.$message.'</div>
                  <script type="text/javascript">setTimeout(\'$(".alert").slideUp("slow")\', '.$time.'); </script>';    
        }


        /**
         * Show warning message
         *
         *  <code>
         *      Alert::warning('Message here...');
         *  </code>
         *
         * @param string  $message Message
         * @param integer $time    Time
         */
        public static function warning($message, $time = 3000) {
            
            // Redefine vars
            $message = (string) $message;
            $time    = (int)    $time;
            
            echo '<div class="alert alert-warning">'.$message.'</div>
                  <script type="text/javascript">setTimeout(\'$(".alert").slideUp("slow")\', '.$time.'); </script>';      
        }


        /**
         * Show error message
         *
         *  <code>
         *      Alert::error('Message here...');
         *  </code>
         *
         * @param string  $message Message
         * @param integer $time    Time
         */
        public static function error($message, $time = 3000) {

            // Redefine vars
            $message = (string) $message;
            $time    = (int)    $time;
            
            echo '<div class="alert alert-error">'.$message.'</div>
                  <script type="text/javascript">setTimeout(\'$(".alert").slideUp("slow")\', '.$time.'); </script>';
        }        

    }