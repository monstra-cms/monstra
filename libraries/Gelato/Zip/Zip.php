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

class Zip
{
    public $zipdata    = '';
    public $directory  = '';
    public $entries    = 0;
    public $file_num   = 0;
    public $offset     = 0;
    public $now;

    private $_archive_info  = array();
    private $_zip_signature = "\x50\x4b\x03\x04";
    private $_dir_signature = "\x50\x4b\x01\x02";
    private $_central_signature_end = "\x50\x4b\x05\x06";
    private $farc = null;
    
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->now = time();
    }

    /**
     * Zip factory
     *
     *  <code>
     *      Zip::factory();
     *  </code>
     *
     * @return Zip
     */
    public static function factory()
    {
        return new Zip();
    }

    /**
     * Add Directory
     *
     *  <code>
     *      Zip::factory()->addDir('test');
     *  </code>
     *
     * @param mixed $directory The directory name. Can be string or array
     */
    public function addDir($directory)
    {
        foreach ((array) $directory as $dir) {

            if ( ! preg_match("|.+/$|", $dir)) {
                $dir .= '/';
            }

            $dir_time = $this->_get_mod_time($dir);

            $this->_add_dir($dir, $dir_time['file_mtime'], $dir_time['file_mdate']);
        }

        return $this;
    }

    /**
     *  Get file/directory modification time
     *
     *  @param  string $dir Full path to the dir
     *  @return array
     */
    protected function _get_mod_time($dir)
    {
        // If this is a newly created file/dir, we will set the time to 'now'
        $date = (@filemtime($dir)) ? filemtime($dir) : getdate($this->now);

        $time['file_mtime'] = ($date['hours'] << 11) + ($date['minutes'] << 5) + $date['seconds'] / 2;
        $time['file_mdate'] = (($date['year'] - 1980) << 9) + ($date['mon'] << 5) + $date['mday'];

        return $time;
    }

    /**
     * Add Directory
     *
     * @param string  $dir        The directory name
     * @param integer $file_mtime File mtime
     * @param integer $file_mdate File mdate
     */
    private function _add_dir($dir, $file_mtime, $file_mdate)
    {
        $dir = str_replace("\\", "/", $dir);

        $this->zipdata .=
            "\x50\x4b\x03\x04\x0a\x00\x00\x00\x00\x00"
            .pack('v', $file_mtime)
            .pack('v', $file_mdate)
            .pack('V', 0) // crc32
            .pack('V', 0) // compressed filesize
            .pack('V', 0) // uncompressed filesize
            .pack('v', strlen($dir)) // length of pathname
            .pack('v', 0) // extra field length
            .$dir
            // below is "data descriptor" segment
            .pack('V', 0) // crc32
            .pack('V', 0) // compressed filesize
            .pack('V', 0); // uncompressed filesize

        $this->directory .=
            "\x50\x4b\x01\x02\x00\x00\x0a\x00\x00\x00\x00\x00"
            .pack('v', $file_mtime)
            .pack('v', $file_mdate)
            .pack('V',0) // crc32
            .pack('V',0) // compressed filesize
            .pack('V',0) // uncompressed filesize
            .pack('v', strlen($dir)) // length of pathname
            .pack('v', 0) // extra field length
            .pack('v', 0) // file comment length
            .pack('v', 0) // disk number start
            .pack('v', 0) // internal file attributes
            .pack('V', 16) // external file attributes - 'directory' bit set
            .pack('V', $this->offset) // relative offset of local header
            .$dir;

        $this->offset = strlen($this->zipdata);
        $this->entries++;
    }

    /**
     * Add Data to Zip
     *
     *  <code>
     *      Zip::factory()->addData('test.txt', 'Some test text here');
     *  </code>
     *
     * Lets you add files to the archive. If the path is included
     * in the filename it will be placed within a directory.  Make
     * sure you use add_dir() first to create the folder.
     *
     * @param mixed  $filepath Full path to the file
     * @param string $data     Data
     */
    public function addData($filepath, $data = null)
    {
        if (is_array($filepath)) {
            foreach ($filepath as $path => $data) {
                $file_data = $this->_get_mod_time($path);
                $this->_add_data($path, $data, $file_data['file_mtime'], $file_data['file_mdate']);
            }
        } else {
            $file_data = $this->_get_mod_time($filepath);
            $this->_add_data($filepath, $data, $file_data['file_mtime'], $file_data['file_mdate']);
        }

        return $this;
    }

    /**
     * Add Data to Zip
     *
     * @param string  $filepath   Full path to the file
     * @param string  $data       The data to be encoded
     * @param integer $file_mtime File mtime
     * @param integer $file_mdate File mdate
     */
    private function _add_data($filepath, $data, $file_mtime, $file_mdate)
    {
        $filepath = str_replace("\\", "/", $filepath);

        $uncompressed_size = strlen($data);
        $crc32  = crc32($data);

        $gzdata = gzcompress($data);
        $gzdata = substr($gzdata, 2, -4);
        $compressed_size = strlen($gzdata);

        $this->zipdata .=
            "\x50\x4b\x03\x04\x14\x00\x00\x00\x08\x00"
            .pack('v', $file_mtime)
            .pack('v', $file_mdate)
            .pack('V', $crc32)
            .pack('V', $compressed_size)
            .pack('V', $uncompressed_size)
            .pack('v', strlen($filepath)) // length of filename
            .pack('v', 0) // extra field length
            .$filepath
            .$gzdata; // "file data" segment

        $this->directory .=
            "\x50\x4b\x01\x02\x00\x00\x14\x00\x00\x00\x08\x00"
            .pack('v', $file_mtime)
            .pack('v', $file_mdate)
            .pack('V', $crc32)
            .pack('V', $compressed_size)
            .pack('V', $uncompressed_size)
            .pack('v', strlen($filepath)) // length of filename
            .pack('v', 0) // extra field length
            .pack('v', 0) // file comment length
            .pack('v', 0) // disk number start
            .pack('v', 0) // internal file attributes
            .pack('V', 32) // external file attributes - 'archive' bit set
            .pack('V', $this->offset) // relative offset of local header
            .$filepath;

        $this->offset = strlen($this->zipdata);
        $this->entries++;
        $this->file_num++;
    }

    /**
     * Read the contents of a file and add it to the zip
     *
     *  <code>
     *      Zip::factory()->readFile('test.txt');
     *  </code>
     *
     * @param  string  $path              Path
     * @param  boolean $preserve_filepath Preserve filepath
     * @return mixed
     */
    public function readFile($path, $preserve_filepath = false)
    {
        if ( ! file_exists($path)) {
            return false;
        }

        if (false !== ($data = file_get_contents($path))) {

            $name = str_replace("\\", "/", $path);

            if ($preserve_filepath === false) {
                $name = preg_replace("|.*/(.+)|", "\\1", $name);
            }

            $this->addData($name, $data);

            return $this;
        }

        return false;
    }

    /**
     * Read a directory and add it to the zip.
     *
     *  <code>
     *      Zip::factory()->readDir('test/');
     *  </code>
     *
     * This function recursively reads a folder and everything it contains (including
     * sub-folders) and creates a zip based on it.  Whatever directory structure
     * is in the original file path will be recreated in the zip file.
     *
     * @param  string  $path              Path to source
     * @param  boolean $preserve_filepath Preserve filepath
     * @param  string  $root_path         Root path
     * @return mixed
     */
    public function readDir($path, $preserve_filepath = true, $root_path = null, $exclude_files = array())
    {
        if ( ! $fp = @opendir($path)) {
            return false;
        }

        // Set the original directory root for child dir's to use as relative
        if ($root_path === null) {
            $root_path = dirname($path) . '/';
        }

        while (false !== ($file = readdir($fp))) {

            if (substr($file, 0, 1) == '.' || in_array($path.$file, $exclude_files)) {
                continue;
            }

            if (@is_dir($path.$file)) {
                $this->readDir($path.$file."/", $preserve_filepath, $root_path, $exclude_files);
            } else {
                if (false !== ($data = file_get_contents($path.$file))) {
                    $name = str_replace("\\", "/", $path);

                    if ($preserve_filepath === false) {
                        $name = str_replace($root_path, '', $name);
                    }

                    $this->addData($name.$file, $data);
                }
            }
        }

        return $this;
    }


    /**
     * Get the Zip file
     *
     *  <code>
     *      Zip::factory()->getZip();
     *  </code>
     *
     * @return string
     */
    public function getZip()
    {
        // Is there any data to return?
        if ($this->entries == 0) {
            return false;
        }

        $zip_data  = $this->zipdata;
        $zip_data .= $this->directory."\x50\x4b\x05\x06\x00\x00\x00\x00";
        $zip_data .= pack('v', $this->entries); // total # of entries "on this disk"
        $zip_data .= pack('v', $this->entries); // total # of entries overall
        $zip_data .= pack('V', strlen($this->directory)); // size of central dir
        $zip_data .= pack('V', strlen($this->zipdata)); // offset to start of central dir
        $zip_data .= "\x00\x00"; // .zip file comment length

        return $zip_data;
    }


    /**
     * Write File to the specified directory
     *
     *  <code>
     *      Zip::factory()->readDir('test1/')->readDir('test2/')->archive('test.zip');
     *  </code>
     *
     * @param  string  $filepath The file name
     * @return boolean
     */
    public function archive($filepath)
    {
        if ( ! ($fp = @fopen($filepath, "w"))) {
            return false;
        }

        flock($fp, LOCK_EX);
        fwrite($fp, $this->getZip());
        flock($fp, LOCK_UN);
        fclose($fp);

        return true;
    }


    /**
     * Initialize Data
     *
     *  <code>
     *      Zip::factory()->clearData();
     *  </code>
     *
     * Lets you clear current zip data.  Useful if you need to create
     * multiple zips with different data.
     */
    public function clearData()
    {
        $this->zipdata      = '';
        $this->directory    = '';
        $this->entries      = 0;
        $this->file_num     = 0;
        $this->offset       = 0;
    }

    public function extract($zip_file, $target_dir = null)
    {
        $chmod = 0777;
        $this->_archive_info = array();

        $files = $this->_read_archive($zip_file);

        if (!$files) {
            return false;
        }

        $file_locations = array();
        foreach ($files as $file => $trash) {
            $dirname = pathinfo($file, PATHINFO_DIRNAME);

            $folders = explode('/', $dirname);
            $out_dn = $target_dir . '/' . $dirname;

            if ( !is_dir($out_dn)) {
                $str = '';
                foreach ($folders as $folder) {
                    $str = $str ? $str . '/' . $folder : $folder;
                    if ( !is_dir($target_dir . '/' . $str)) {
                        if ( ! @mkdir($target_dir . '/' . $str)) {
                            return false;
                        }

                        chmod($target_dir . '/' . $str, $chmod);
                    }
                }
            }

            if (substr($file, -1, 1) == '/') {
                continue;
            }

            $file_locations[] = $file_location = $target_dir . '/' . $file;

            $this->_extract_file($file, $file_location);
        }

        $this->_archive_info = array();

        return $file_locations;
    }

    private function _read_archive($zip_file)
    {
        if (sizeof($this->_archive_info)) {
            return $this->_archive_info;
        }

        $fh = fopen($zip_file, 'r');
        $this->farc = &$fh;

        if ( !$fh) {
            return false;
        }

        if ( !$this->_read_file_list_by_eof($fh)) {
            if ( !$this->_read_files_by_signatures($fh)) {
                return false;
            }
        }

        return $this->_archive_info;
    }

    private function _read_file_list_by_eof(&$fh)
    {
        for ($x = 0; $x < 1024; $x++) {
            fseek($fh, -22 - $x, SEEK_END);

            $signature = fread($fh, 4);

            if ($signature == $this->_central_signature_end) {
                $eodir['disk_number_this'] = unpack("v", fread($fh, 2));
                $eodir['disk_number'] = unpack("v", fread($fh, 2));
                $eodir['total_entries_this'] = unpack("v", fread($fh, 2));
                $eodir['total_entries'] = unpack("v", fread($fh, 2));
                $eodir['size_of_cd'] = unpack("V", fread($fh, 4));
                $eodir['offset_start_cd'] = unpack("V", fread($fh, 4));
                $zip_comment_lenght = unpack("v", fread($fh, 2));
                $eodir['zipfile_comment'] = $zip_comment_lenght[1] ? fread($fh, $zip_comment_lenght[1]) : '';

                fseek($fh, $eodir['offset_start_cd'][1]);
                $signature = fread($fh, 4);

                while ($signature == $this->_dir_signature) {
                    $dir['version_madeby'] = unpack("v", fread($fh, 2));
                    $dir['version_needed'] = unpack("v", fread($fh, 2));
                    $dir['general_bit_flag'] = unpack("v", fread($fh, 2));
                    $dir['compression_method'] = unpack("v", fread($fh, 2));
                    $dir['lastmod_time'] = unpack("v", fread($fh, 2));
                    $dir['lastmod_date'] = unpack("v", fread($fh, 2));
                    $dir['crc-32'] = fread($fh, 4);
                    $dir['compressed_size'] = unpack("V", fread($fh, 4));
                    $dir['uncompressed_size'] = unpack("V", fread($fh, 4));
                    $zip_file_length = unpack("v", fread($fh, 2));
                    $extra_field_length = unpack("v", fread($fh, 2));
                    $fileCommentLength = unpack("v", fread($fh, 2));
                    $dir['disk_number_start'] = unpack("v", fread($fh, 2));
                    $dir['internal_attributes'] = unpack("v", fread($fh, 2));
                    $dir['external_attributes1'] = unpack("v", fread($fh, 2));
                    $dir['external_attributes2'] = unpack("v", fread($fh, 2));
                    $dir['relative_offset'] = unpack("V", fread($fh, 4));
                    $dir['file_name'] = fread($fh, $zip_file_length[1]);
                    $dir['extra_field'] = $extra_field_length[1] ? fread($fh, $extra_field_length[1]) : '';
                    $dir['file_comment'] = $fileCommentLength[1] ? fread($fh, $fileCommentLength[1]) : '';

                    $binary_mod_date = str_pad(decbin($dir['lastmod_date'][1]), 16, '0', STR_PAD_LEFT);
                    $binary_mod_time = str_pad(decbin($dir['lastmod_time'][1]), 16, '0', STR_PAD_LEFT);
                    $last_mod_year = bindec(substr($binary_mod_date, 0, 7)) + 1980;
                    $last_mod_month = bindec(substr($binary_mod_date, 7, 4));
                    $last_mod_day = bindec(substr($binary_mod_date, 11, 5));
                    $last_mod_hour = bindec(substr($binary_mod_time, 0, 5));
                    $last_mod_minute = bindec(substr($binary_mod_time, 5, 6));
                    $last_mod_second = bindec(substr($binary_mod_time, 11, 5));

                    $central_dir_list[$dir['file_name']] = array(
                        'version_madeby' => $dir['version_madeby'][1],
                        'version_needed' => $dir['version_needed'][1],
                        'general_bit_flag' => str_pad(decbin($dir['general_bit_flag'][1]), 8, '0', STR_PAD_LEFT),
                        'compression_method' => $dir['compression_method'][1],
                        'lastmod_datetime' => mktime($last_mod_hour, $last_mod_minute, $last_mod_second, $last_mod_month, $last_mod_day, $last_mod_year),
                        'crc-32' => str_pad(dechex(ord($dir['crc-32'][3])), 2, '0', STR_PAD_LEFT) .
                            str_pad(dechex(ord($dir['crc-32'][2])), 2, '0', STR_PAD_LEFT) .
                            str_pad(dechex(ord($dir['crc-32'][1])), 2, '0', STR_PAD_LEFT) .
                            str_pad(dechex(ord($dir['crc-32'][0])), 2, '0', STR_PAD_LEFT),
                        'compressed_size' => $dir['compressed_size'][1],
                        'uncompressed_size' => $dir['uncompressed_size'][1],
                        'disk_number_start' => $dir['disk_number_start'][1],
                        'internal_attributes' => $dir['internal_attributes'][1],
                        'external_attributes1' => $dir['external_attributes1'][1],
                        'external_attributes2' => $dir['external_attributes2'][1],
                        'relative_offset' => $dir['relative_offset'][1],
                        'file_name' => $dir['file_name'],
                        'extra_field' => $dir['extra_field'],
                        'file_comment' => $dir['file_comment'],
                    );

                    $signature = fread($fh, 4);
                }

                if (isset($central_dir_list)) {
                    foreach ($central_dir_list as $filename => $details) {
                        $i = $this->_get_file_header($fh, $details['relative_offset']);

                        $this->_archive_info[$filename]['file_name'] = $filename;
                        $this->_archive_info[$filename]['compression_method'] = $details['compression_method'];
                        $this->_archive_info[$filename]['version_needed'] = $details['version_needed'];
                        $this->_archive_info[$filename]['lastmod_datetime'] = $details['lastmod_datetime'];
                        $this->_archive_info[$filename]['crc-32'] = $details['crc-32'];
                        $this->_archive_info[$filename]['compressed_size'] = $details['compressed_size'];
                        $this->_archive_info[$filename]['uncompressed_size'] = $details['uncompressed_size'];
                        $this->_archive_info[$filename]['lastmod_datetime'] = $details['lastmod_datetime'];
                        $this->_archive_info[$filename]['extra_field'] = $i['extra_field'];
                        $this->_archive_info[$filename]['contents_start_offset'] = $i['contents_start_offset'];
                    }
                }

                return true;
            }
        }
        return true;
    }

    private function _read_files_by_signatures(&$fh)
    {
        fseek($fh, 0);

        $return = false;
        for (;;) {
            $details = $this->_get_file_header($fh);

            if ( !$details) {
                fseek($fh, 12 - 4, SEEK_CUR);
                $details = $this->_get_file_header($fh);
            }

            if ( !$details) {
                break;
            }

            $filename = $details['file_name'];
            $this->_archive_info[$filename] = $details;
            $return = true;
        }

        return $return;
    }

    private function _get_file_header(&$fh, $start_offset = FALSE)
    {
        if ($start_offset !== false) {
            fseek($fh, $start_offset);
        }

        $signature = fread($fh, 4);

        if ($signature == $this->_zip_signature) {
            $file['version_needed'] = unpack("v", fread($fh, 2));
            $file['general_bit_flag'] = unpack("v", fread($fh, 2));
            $file['compression_method'] = unpack("v", fread($fh, 2));
            $file['lastmod_time'] = unpack("v", fread($fh, 2));
            $file['lastmod_date'] = unpack("v", fread($fh, 2));
            $file['crc-32'] = fread($fh, 4);
            $file['compressed_size'] = unpack("V", fread($fh, 4));
            $file['uncompressed_size'] = unpack("V", fread($fh, 4));
            $zip_file_length = unpack("v", fread($fh, 2));
            $extra_field_length = unpack("v", fread($fh, 2));
            $file['file_name'] = fread($fh, $zip_file_length[1]);
            $file['extra_field'] = $extra_field_length[1] ? fread($fh, $extra_field_length[1]) : '';
            $file['contents_start_offset'] = ftell($fh);

            fseek($fh, $file['compressed_size'][1], SEEK_CUR);

            $binary_mod_date = str_pad(decbin($file['lastmod_date'][1]), 16, '0', STR_PAD_LEFT);
            $binary_mod_time = str_pad(decbin($file['lastmod_time'][1]), 16, '0', STR_PAD_LEFT);

            $last_mod_year = bindec(substr($binary_mod_date, 0, 7)) + 1980;
            $last_mod_month = bindec(substr($binary_mod_date, 7, 4));
            $last_mod_day = bindec(substr($binary_mod_date, 11, 5));
            $last_mod_hour = bindec(substr($binary_mod_time, 0, 5));
            $last_mod_minute = bindec(substr($binary_mod_time, 5, 6));
            $last_mod_second = bindec(substr($binary_mod_time, 11, 5));

            return array(
                'file_name' => $file['file_name'],
                'compression_method' => $file['compression_method'][1],
                'version_needed' => $file['version_needed'][1],
                'lastmod_datetime' => mktime($last_mod_hour, $last_mod_minute, $last_mod_second, $last_mod_month, $last_mod_day, $last_mod_year),
                'crc-32' => str_pad(dechex(ord($file['crc-32'][3])), 2, '0', STR_PAD_LEFT) .
                    str_pad(dechex(ord($file['crc-32'][2])), 2, '0', STR_PAD_LEFT) .
                    str_pad(dechex(ord($file['crc-32'][1])), 2, '0', STR_PAD_LEFT) .
                    str_pad(dechex(ord($file['crc-32'][0])), 2, '0', STR_PAD_LEFT),
                'compressed_size' => $file['compressed_size'][1],
                'uncompressed_size' => $file['uncompressed_size'][1],
                'extra_field' => $file['extra_field'],
                'general_bit_flag' => str_pad(decbin($file['general_bit_flag'][1]), 8, '0', STR_PAD_LEFT),
                'contents_start_offset' => $file['contents_start_offset']
            );
        }

        return false;
    }

    private function _extract_file($compressed_file_name, $target_file_name = false)
    {
        if ( !sizeof($this->_archive_info)) {
            return false;
        }

        $fdetails = &$this->_archive_info[$compressed_file_name];

        if ( ! isset($this->_archive_info[$compressed_file_name])) {
            return false;
        }

        if (substr($compressed_file_name, -1) == '/') {
            return false;
        }

        if ( !$fdetails['uncompressed_size']) {
            return $target_file_name ? file_put_contents($target_file_name, '') : '';
        }

        fseek($this->farc, $fdetails['contents_start_offset']);
        $ret = $this->_uncompress(
            fread($this->farc, $fdetails['compressed_size']),
            $fdetails['compression_method'],
            $fdetails['uncompressed_size'],
            $target_file_name
        );

        if ($target_file_name) {
            chmod($target_file_name, 0644);
        }

        return $ret;
    }

    private function _uncompress($content, $mode, $uncompressed_size, $target_file_name = false)
    {
        switch ($mode) {
            case 0:
                return $target_file_name ? file_put_contents($target_file_name, $content) : $content;
            case 8:
                return $target_file_name
                    ? file_put_contents($target_file_name, gzinflate($content, $uncompressed_size))
                    : gzinflate($content, $uncompressed_size);
            case 12:
                return $target_file_name
                    ? file_put_contents($target_file_name, bzdecompress($content)) : bzdecompress($content);
            default:
                return false;
        }
    }
}
