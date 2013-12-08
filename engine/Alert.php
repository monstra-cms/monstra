<?php defined('MONSTRA_ACCESS') or die('No direct script access.');

/**
 * Monstra Engine
 *
 * This source file is part of the Monstra Engine. More information,
 * documentation and tutorials can be found at http://monstra.org
 *
 * @package     Monstra
 *
 * @author      Romanenko Sergey / Awilum <awilum@msn.com>
 * @copyright   2012-2014 Romanenko Sergey / Awilum <awilum@msn.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

class Alert
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
     * Show success message
     *
     *  <code>
     *      Alert::success('Message here...');
     *  </code>
     *
     * @param string  $message Message
     * @param integer $time    Time
     */
    public static function success($message, $time = 3000)
    {
        // Redefine vars
        $message = (string) $message;
        $time    = (int) $time;

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
    public static function warning($message, $time = 3000)
    {
        // Redefine vars
        $message = (string) $message;
        $time    = (int) $time;

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
    public static function error($message, $time = 3000)
    {
        // Redefine vars
        $message = (string) $message;
        $time    = (int) $time;

        echo '<div class="alert alert-error">'.$message.'</div>
              <script type="text/javascript">setTimeout(\'$(".alert").slideUp("slow")\', '.$time.'); </script>';
    }

}
