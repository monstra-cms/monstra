<?php defined('MONSTRA_ACCESS') or die('No direct script access.');

/**
 * Monstra
 *
 * @package Monstra
 * @author Romanenko Sergey / Awilum <awilum@msn.com>
 * @link http://monstra.org
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
     * @param integer $seconds Seconds
     */
    public static function success($message, $seconds = 3)
    {
        // Redefine vars
        $message = (string) $message;
        $seconds    = (int) $seconds;

        echo '<script type="text/javascript">
                Messenger().post({
                    type: "success",
                    message : "'.$message.'",                    
                    hideAfter: '.$seconds.'
                });
             </script>';
    }

    /**
     * Show warning message
     *
     *  <code>
     *      Alert::warning('Message here...');
     *  </code>
     *
     * @param string  $message Message
     * @param integer $seconds Seconds
     */
    public static function warning($message, $seconds = 3)
    {
        // Redefine vars
        $message = (string) $message;
        $seconds    = (int) $seconds;

        echo '<script type="text/javascript">
                Messenger().post({
                    type: "info",
                    message : "'.$message.'",
                    hideAfter: '.$seconds.'
                });
             </script>';
    }

    /**
     * Show error message
     *
     *  <code>
     *      Alert::error('Message here...');
     *  </code>
     *
     * @param string  $message Message
     * @param integer $seconds Seconds
     */
    public static function error($message, $seconds = 3)
    {
        // Redefine vars
        $message = (string) $message;
        $seconds    = (int) $seconds;

        echo '<script type="text/javascript">
                Messenger().post({
                    type: "error",
                    message : "'.$message.'",
                    hideAfter: '.$seconds.'
                });
             </script>';
    }
}
