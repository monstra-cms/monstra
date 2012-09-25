<?php defined('MONSTRA_ACCESS') or die('No direct script access.');

    /**
     *  Captcha Helper
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



    class Captcha {
        

        /**
         * Creates the question from random variables, which are also saved to the session.
         *
         *  <code>
         *      <form method="post">
         *      <?php echo Captcha::getMathQuestion(); ?>
         *      <input type="text" name="answer" />
         *      <input type="submit" name="sumbmit" />
         *      </form>
         *  </code>
         *
         * @return string
         */
        public static function getMathQuestion() {

            if ( ! isset($_SESSION["math_question_v1"]) && ! isset($_SESSION["math_question_v2"])) {
                $v1 = rand(1,9);
                $v2 = rand(1,9);
                $_SESSION["math_question_v1"] = $v1;
                $_SESSION["math_question_v2"] = $v2;
            } else {
                $v1 = $_SESSION["math_question_v1"];
                $v2 = $_SESSION["math_question_v2"];
            }

            return sprintf("%s + %s = ", $v1, $v2);
        }


        /**
         * Checks the given answer if it matches the addition of the saved session variables.
         *
         *  <code>
         *      if (isset($_POST['submit'])) {
         *          if (Captcha::correctAnswer($_POST['answer'])) {
         *              // Do something...
         *          }
         *      }
         *  </code>
         *
         * @param integer $answer User answer
         */
        public static function correctAnswer($answer){

            $v1 = $_SESSION["math_question_v1"];
            $v2 = $_SESSION["math_question_v2"];
            
            unset($_SESSION['math_question_v1']);
            unset($_SESSION['math_question_v2']);
            
            if (($v1 + $v2) == $answer) {
                return true;
            }

            return false;
            
        }
    
    }
