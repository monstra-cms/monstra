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

class File
{
    /**
     * Mime type list
     *
     * @var array
     */
    public static $mime_types = array(
        'aac'        => 'audio/aac',
        'atom'       => 'application/atom+xml',
        'avi'        => 'video/avi',
        'bmp'        => 'image/x-ms-bmp',
        'c'          => 'text/x-c',
        'class'      => 'application/octet-stream',
        'css'        => 'text/css',
        'csv'        => 'text/csv',
        'deb'        => 'application/x-deb',
        'dll'        => 'application/x-msdownload',
        'dmg'        => 'application/x-apple-diskimage',
        'doc'        => 'application/msword',
        'docx'       => 'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
        'exe'        => 'application/octet-stream',
        'flv'        => 'video/x-flv',
        'gif'        => 'image/gif',
        'gz'         => 'application/x-gzip',
        'h'          => 'text/x-c',
        'htm'        => 'text/html',
        'html'       => 'text/html',
        'ini'        => 'text/plain',
        'jar'        => 'application/java-archive',
        'java'       => 'text/x-java',
        'jpeg'       => 'image/jpeg',
        'jpg'        => 'image/jpeg',
        'js'         => 'text/javascript',
        'json'       => 'application/json',
        'mid'        => 'audio/midi',
        'midi'       => 'audio/midi',
        'mka'        => 'audio/x-matroska',
        'mkv'        => 'video/x-matroska',
        'mp3'        => 'audio/mpeg',
        'mp4'        => 'application/mp4',
        'mpeg'       => 'video/mpeg',
        'mpg'        => 'video/mpeg',
        'odt'        => 'application/vnd.oasis.opendocument.text',
        'ogg'        => 'audio/ogg',
        'pdf'        => 'application/pdf',
        'php'        => 'text/x-php',
        'png'        => 'image/png',
        'psd'        => 'image/vnd.adobe.photoshop',
        'py'         => 'application/x-python',
        'ra'         => 'audio/vnd.rn-realaudio',
        'ram'        => 'audio/vnd.rn-realaudio',
        'rar'        => 'application/x-rar-compressed',
        'rss'        => 'application/rss+xml',
        'safariextz' => 'application/x-safari-extension',
        'sh'         => 'text/x-shellscript',
        'shtml'      => 'text/html',
        'swf'        => 'application/x-shockwave-flash',
        'tar'        => 'application/x-tar',
        'tif'        => 'image/tiff',
        'tiff'       => 'image/tiff',
        'torrent'    => 'application/x-bittorrent',
        'txt'        => 'text/plain',
        'wav'        => 'audio/wav',
        'webp'       => 'image/webp',
        'wma'        => 'audio/x-ms-wma',
        'xls'        => 'application/vnd.ms-excel',
        'xml'        => 'text/xml',
        'zip'        => 'application/zip',
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
     * Returns true if the File exists.
     *
     *  <code>
     *      if (File::exists('filename.txt')) {
     *          // Do something...
     *      }
     *  </code>
     *
     * @param  string  $filename The file name
     * @return boolean
     */
    public static function exists($filename)
    {
        // Redefine vars
        $filename = (string) $filename;

        // Return
        return (file_exists($filename) && is_file($filename));
    }

    /**
     * Delete file
     *
     *  <code>
     *      File::delete('filename.txt');
     *  </code>
     *
     * @param  mixed   $filename The file name or array of files
     * @return boolean
     */
    public static function delete($filename)
    {
        // Is array
        if (is_array($filename)) {

            // Delete each file in $filename array
            foreach ($filename as $file) {
                @unlink((string) $file);
            }

        } else {
            // Is string
            return @unlink((string) $filename);
        }

    }

    /**
     * Rename file
     *
     *  <code>
     *      File::rename('filename1.txt', 'filename2.txt');
     *  </code>
     *
     * @param  string  $from Original file location
     * @param  string  $to   Desitination location of the file
     * @return boolean
     */
    public static function rename($from, $to)
    {
        // Redefine vars
        $from = (string) $from;
        $to   = (string) $to;

        // If file exists $to than rename it
        if ( ! File::exists($to)) return rename($from, $to);

        // Else return false
        return false;
    }

    /**
     * Copy file
     *
     *  <code>
     *      File::copy('folder1/filename.txt', 'folder2/filename.txt');
     *  </code>
     *
     * @param  string  $from Original file location
     * @param  string  $to   Desitination location of the file
     * @return boolean
     */
    public static function copy($from, $to)
    {
        // Redefine vars
        $from = (string) $from;
        $to   = (string) $to;

        // If file !exists $from and exists $to then return false
        if ( ! File::exists($from) || File::exists($to)) return false;

        // Else copy file
        return copy($from, $to);
    }

    /**
     * Get the File extension.
     *
     *  <code>
     *      echo File::ext('filename.txt');
     *  </code>
     *
     * @param  string $filename The file name
     * @return string
     */
    public static function ext($filename)
    {
        // Redefine vars
        $filename = (string) $filename;

        // Return file extension
        return substr(strrchr($filename, '.'), 1);
    }

    /**
     * Get the File name
     *
     *  <code>
     *      echo File::name('filename.txt');
     *  </code>
     *
     * @param  string $filename The file name
     * @return string
     */
    public static function name($filename)
    {
        // Redefine vars
        $filename = (string) $filename;

        // Return filename
        return basename($filename, '.'.File::ext($filename));
    }

    /**
     * Get list of files in directory recursive
     *
     *  <code>
     *      $files = File::scan('folder');
     *      $files = File::scan('folder', 'txt');
     *      $files = File::scan('folder', array('txt', 'log'));
     *  </code>
     *
     * @param  string $folder Folder
     * @param  mixed  $type   Files types
     * @return array
     */
    public static function scan($folder, $type = null)
    {
        $data = array();
        if (is_dir($folder)) {
            $iterator = new RecursiveDirectoryIterator($folder);
            foreach (new RecursiveIteratorIterator($iterator) as $file) {
                if ($type !== null) {
                    if (is_array($type)) {
                        $file_ext = substr(strrchr($file->getFilename(), '.'), 1);
                        if (in_array($file_ext, $type)) {
                            if (strpos($file->getFilename(), $file_ext, 1)) {
                                $data[] = $file->getFilename();
                            }
                        }
                    } else {
                        if (strpos($file->getFilename(), $type, 1)) {
                            $data[] = $file->getFilename();
                        }
                    }
                } else {
                    if ($file->getFilename() !== '.' && $file->getFilename() !== '..') $data[] = $file->getFilename();
                }
            }

            return $data;
        } else {
            return false;
        }
    }

    /**
     * Fetch the content from a file or URL.
     *
     *  <code>
     *      echo File::getContent('filename.txt');
     *  </code>
     *
     * @param  string  $filename The file name
     * @return boolean
     */
    public static function getContent($filename)
    {
        // Redefine vars
        $filename = (string) $filename;

        // If file exists load it
        if (File::exists($filename)) {
            return file_get_contents($filename);
        }
    }

    /**
     * Writes a string to a file.
     *
     * @param  string  $filename   The path of the file.
     * @param  string  $content    The content that should be written.
     * @param  boolean $createFile Should the file be created if it doesn't exists?
     * @param  boolean $append     Should the content be appended if the file already exists?
     * @param  integer $chmod      Mode that should be applied on the file.
     * @return boolean
     */
    public static function setContent($filename, $content, $create_file = true, $append = false, $chmod = 0666)
    {
        // Redefine vars
        $filename    = (string) $filename;
        $content     = (string) $content;
        $create_file = (bool) $create_file;
        $append      = (bool) $append;

        // File may not be created, but it doesn't exist either
        if ( ! $create_file && File::exists($filename)) throw new RuntimeException(vsprintf("%s(): The file '{$filename}' doesn't exist", array(__METHOD__)));

        // Create directory recursively if needed
        Dir::create(dirname($filename));

        // Create file & open for writing
        $handler = ($append) ? @fopen($filename, 'a') : @fopen($filename, 'w');

        // Something went wrong
        if ($handler === false) throw new RuntimeException(vsprintf("%s(): The file '{$filename}' could not be created. Check if PHP has enough permissions.", array(__METHOD__)));

        // Store error reporting level
        $level = error_reporting();

        // Disable errors
        error_reporting(0);

        // Write to file
        $write = fwrite($handler, $content);

        // Validate write
        if($write === false) throw new RuntimeException(vsprintf("%s(): The file '{$filename}' could not be created. Check if PHP has enough permissions.", array(__METHOD__)));

        // Close the file
        fclose($handler);

        // Chmod file
        chmod($filename, $chmod);

        // Restore error reporting level
        error_reporting($level);

        // Return
        return true;
    }

    /**
     * Get time(in Unix timestamp) the file was last changed
     *
     *  <code>
     *      echo File::lastChange('filename.txt');
     *  </code>
     *
     * @param  string  $filename The file name
     * @return boolean
     */
    public static function lastChange($filename)
    {
        // Redefine vars
        $filename = (string) $filename;

        // If file exists return filemtime
        if (File::exists($filename)) {
            return filemtime($filename);
        }

        // Return
        return false;

    }

    /**
     * Get last access time
     *
     *  <code>
     *      echo File::lastAccess('filename.txt');
     *  </code>
     *
     * @param  string  $filename The file name
     * @return boolean
     */
    public static function lastAccess($filename)
    {
        // Redefine vars
        $filename = (string) $filename;

        // If file exists return fileatime
        if (File::exists($filename)) {
            return fileatime($filename);
        }

        // Return
        return false;
    }

    /**
     * Returns the mime type of a file. Returns false if the mime type is not found.
     *
     *  <code>
     *      echo File::mime('filename.txt');
     *  </code>
     *
     * @param  string  $file  Full path to the file
     * @param  boolean $guess Set to false to disable mime type guessing
     * @return string
     */
    public static function mime($file, $guess = true)
    {
        // Redefine vars
        $file  = (string) $file;
        $guess = (bool) $guess;

        // Get mime using the file information functions
        if (function_exists('finfo_open')) {

            $info = finfo_open(FILEINFO_MIME_TYPE);

            $mime = finfo_file($info, $file);

            finfo_close($info);

            return $mime;

        } else {

            // Just guess mime by using the file extension
            if ($guess === true) {

                $mime_types = File::$mime_types;

                $extension = pathinfo($file, PATHINFO_EXTENSION);

                return isset($mime_types[$extension]) ? $mime_types[$extension] : false;
            } else {
                return false;
            }
        }
    }

    /**
     * Forces a file to be downloaded.
     *
     *  <code>
     *      File::download('filename.txt');
     *  </code>
     *
     * @param string  $file         Full path to file
     * @param string  $content_type Content type of the file
     * @param string  $filename     Filename of the download
     * @param integer $kbps         Max download speed in KiB/s
     */
    public static function download($file, $content_type = null, $filename = null, $kbps = 0)
    {
        // Redefine vars
        $file         = (string) $file;
        $content_type = ($content_type === null) ? null : (string) $content_type;
        $filename     = ($filename === null) ? null : (string) $filename;
        $kbps         = (int) $kbps;

        // Check that the file exists and that its readable
        if (file_exists($file) === false || is_readable($file) === false) {
            throw new RuntimeException(vsprintf("%s(): Failed to open stream.", array(__METHOD__)));
        }

        // Empty output buffers
        while (ob_get_level() > 0) ob_end_clean();

        // Send headers
        if ($content_type === null) $content_type = File::mime($file);

        if ($filename === null) $filename = basename($file);

        header('Content-type: ' . $content_type);
        header('Content-Disposition: attachment; filename="' . $filename . '"');
        header('Content-Length: ' . filesize($file));

        // Read file and write it to the output
        @set_time_limit(0);

        if ($kbps === 0) {

            readfile($file);

        } else {

            $handle = fopen($file, 'r');

            while ( ! feof($handle) && !connection_aborted()) {

                $s = microtime(true);

                echo fread($handle, round($kbps * 1024));

                if (($wait = 1e6 - (microtime(true) - $s)) > 0) usleep($wait);

            }

            fclose($handle);
        }

        exit();
    }

    /**
     * Display a file in the browser.
     *
     *  <code>
     *      File::display('filename.txt');
     *  </code>
     *
     * @param string $file         Full path to file
     * @param string $content_type Content type of the file
     * @param string $filename     Filename of the download
     */
    public static function display($file, $content_type = null, $filename = null)
    {
        // Redefine vars
        $file         = (string) $file;
        $content_type = ($content_type === null) ? null : (string) $content_type;
        $filename     = ($filename === null) ? null : (string) $filename;

        // Check that the file exists and that its readable
        if (file_exists($file) === false || is_readable($file) === false) {
            throw new RuntimeException(vsprintf("%s(): Failed to open stream.", array(__METHOD__)));
        }

        // Empty output buffers
        while (ob_get_level() > 0) ob_end_clean();

        // Send headers
        if ($content_type === null) $content_type = File::mime($file);

        if($filename === null) $filename = basename($file);

        header('Content-type: ' . $content_type);
        header('Content-Disposition: inline; filename="' . $filename . '"');
        header('Content-Length: ' . filesize($file));

        // Read file and write to output
        readfile($file);

        exit();
    }

    /**
     * Tests whether a file is writable for anyone.
     *
     *  <code>
     *      if (File::writable('filename.txt')) {
     *          // do something...
     *      }
     *  </code>
     *
     * @param  string  $file File to check
     * @return boolean
     */
    public static function writable($file)
    {
        // Redefine vars
        $file = (string) $file;

        // Is file exists ?
        if ( ! file_exists($file)) throw new RuntimeException(vsprintf("%s(): The file '{$file}' doesn't exist", array(__METHOD__)));

        // Gets file permissions
        $perms = fileperms($file);

        // Is writable ?
        if (is_writable($file) || ($perms & 0x0080) || ($perms & 0x0010) || ($perms & 0x0002)) return true;
    }

}
