<?php

/**
 * Gelato Library
 *
 * This source file is part of the Gelato Library. More information,
 * documentation and tutorials can be found at http://gelato.monstra.org
 *
 * @package     Gelato
 *
 * @author      Romanenko Sergey / Awilum <awilum@msn.com>
 * @copyright   2012-2014 Romanenko Sergey / Awilum <awilum@msn.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

class ErrorHandler
{

    /**
     * Error Levels
     */
    public static $levels = array (        
        E_ERROR             => 'Fatal Error',
        E_PARSE             => 'Parse Error',
        E_COMPILE_ERROR     => 'Compile Error',
        E_COMPILE_WARNING   => 'Compile Warning',
        E_STRICT            => 'Strict Mode Error',
        E_NOTICE            => 'Notice',
        E_WARNING           => 'Warning',
        E_RECOVERABLE_ERROR => 'Recoverable Error',        
        E_USER_NOTICE       => 'Notice',
        E_USER_WARNING      => 'Warning',
        E_USER_ERROR        => 'Error',
        /*E_DEPRECATED        => 'Deprecated',*/ /* PHP 5.3 only */
        /*E_USER_DEPRECATED   => 'Deprecated'*/ /* PHP 5.3 only */
    );

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
     * Returns an array of lines from a file.
     *
     * @access  public
     * @param  string $file    File in which you want to highlight a line
     * @param  int    $line    Line number to highlight
     * @param  int    $padding (optional) Number of padding lines
     * @return array
     */
    protected static function highlightCode($file, $line, $padding = 6)
    {
        if ( ! is_readable($file)) {
            return false;
        }

        $handle      = fopen($file, 'r');
        $lines       = array();
        $currentLine = 0;

        while ( ! feof($handle)) {
            $currentLine++;

            $temp = fgets($handle);

            if ($currentLine > $line + $padding) {
                break; // Exit loop after we have found what we were looking for
            }

            if ($currentLine >= ($line - $padding) && $currentLine <= ($line + $padding)) {
                $lines[] = array
                (
                    'number'      => str_pad($currentLine, 4, ' ', STR_PAD_LEFT),
                    'highlighted' => ($currentLine === $line),
                    'code'        => ErrorHandler::highlightString($temp),
                );
            }
        }

        fclose($handle);

        return $lines;
    }

    /**
     * Converts errors to ErrorExceptions.
     *
     * @param  integer $code    The error code
     * @param  string  $message The error message
     * @param  string  $file    The filename where the error occurred
     * @param  integer $line    The line number where the error occurred
     * @return boolean
     */
    public static function error($code, $message, $file, $line)
    {
        // If isset error_reporting and $code then throw new error exception
        if ((error_reporting() & $code) !== 0) {

            /**
             * Dont thow NOTICE exception for PRODUCTION Environment. Just write to log.
             */
            if (GELATO_DEVELOPMENT == false && $code == 8) {

                // Get exception info
                $error['code']    = $code;
                $error['message'] = $message;
                $error['file']    = $file;
                $error['line']    = $line;
                $error['type']    = 'ErrorException: ';

                $codes = array (
                    E_USER_NOTICE       => 'Notice',
                );

                $error['type'] .= in_array($error['code'], array_keys($codes)) ? $codes[$error['code']] : 'Unknown Error';

                // Write to log
                Log::write("{$error['type']}: {$error['message']} in {$error['file']} at line {$error['line']}");

            } else {
                throw new ErrorException($message, $code, 0, $file, $line);
            }
        }

        // Don't execute PHP internal error handler
        return true;
    }

    /**
     * Highlight string
     *
     * @param  string $string String
     * @return string
     */
    protected static function highlightString($string)
    {
        $search  = array("\r\n", "\n\r", "\r", "\n", '<code>', '</code>', '<span style="color: #0000BB">&lt;?php&nbsp;', '#$@r4!/*');
        $replace = array('', '', '', '', '', '', '<span style="color: #0000BB">', '/*');

        return str_replace($search, $replace, highlight_string('<?php ' . str_replace('/*', '#$@r4!/*', $string), true));
    }

    /**
     * Modifies the backtrace array.
     *
     * @access  protected
     * @param  array $backtrace Array returned by the getTrace() method of an exception object
     * @return array
     */
    protected static function formatBacktrace($backtrace)
    {
        if (is_array($backtrace) === false || count($backtrace) === 0) {
            return $backtrace;
        }

        /**
         * Remove unnecessary info from backtrace
         */
        if ($backtrace[0]['function'] == '{closure}') {
            unset($backtrace[0]);
        }

        /**
         * Format backtrace
         */
        $trace = array();

        foreach ($backtrace as $entry) {

            /**
             * Function
             */
            $function = '';

            if (isset($entry['class'])) {
                $function .= $entry['class'] . $entry['type'];
            }

            $function .= $entry['function'] . '()';

            /**
             * Arguments
             */
            $arguments = array();

            if (isset($entry['args']) && count($entry['args']) > 0) {
                foreach ($entry['args'] as $arg) {
                    ob_start();

                    var_dump($arg);

                    $arg = htmlspecialchars(ob_get_contents());

                    ob_end_clean();

                    $arguments[] = $arg;
                }
            }

            /**
             * Location
             */
            $location = array();

            if (isset($entry['file'])) {
                $location['file'] = $entry['file'];
                $location['line'] = $entry['line'];
                $location['code'] = self::highlightCode($entry['file'], $entry['line']);
            }

            /**
             * Compile into array
             */
            $trace[] = array
            (
                'function'  => $function,
                'arguments' => $arguments,
                'location'  => $location,
            );
        }

        return $trace;
    }

    /**
     * Convert errors not caught by the error handler to ErrorExceptions.
     */
    public static function fatal()
    {
        $e = error_get_last();

        if ($e !== null && (error_reporting() & $e['type']) !== 0) {
            ErrorHandler::exception(new ErrorException($e['message'], $e['type'], 0, $e['file'], $e['line']));

            exit(1);
        }
    }

    /**
     * Handles uncaught exceptions and returns a pretty error screen.
     *
     * @access  public
     * @param Exception $exception An exception object
     */
    public static function exception($exception)
    {
        try {

            // Empty output buffers
            while(ob_get_level() > 0) ob_end_clean();

            // Get exception info
            $error['code']    = $exception->getCode();
            $error['message'] = $exception->getMessage();
            $error['file']    = $exception->getFile();
            $error['line']    = $exception->getLine();

            // Determine error type
            if ($exception instanceof ErrorException) {
                $error['type'] = 'ErrorException: ';
                $error['type'] .= in_array($error['code'], array_keys(ErrorHandler::$levels)) ? ErrorHandler::$levels[$error['code']] : 'Unknown Error';
            } else {
                $error['type'] = get_class($exception);
            }

            // Write to log
            Log::write("{$error['type']}: {$error['message']} in {$error['file']} at line {$error['line']}");

            // Send headers and output
            @header('Content-Type: text/html; charset=UTF-8');

            if (GELATO_DEVELOPMENT) {

                $error['backtrace'] = $exception->getTrace();

                if ($exception instanceof ErrorException) {
                    $error['backtrace'] = array_slice($error['backtrace'], 1); //Remove call to error handler from backtrace
                }

                $error['backtrace']   = self::formatBacktrace($error['backtrace']);
                $error['highlighted'] = self::highlightCode($error['file'], $error['line']);

                @header('HTTP/1.1 500 Internal Server Error');
                include 'Resources/Views/Errors/exception.php';

            } else {

                @header('HTTP/1.1 500 Internal Server Error');
                include 'Resources/Views/Errors/production.php';

            }

        } catch (Exception $e) {

            // Empty output buffers
            while(ob_get_level() > 0) ob_end_clean();

            echo $e->getMessage() . ' in ' . $e->getFile() . ' (line ' . $e->getLine() . ').';
        }

        exit(1);
    }
}
