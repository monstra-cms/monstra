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
    public function readDir($path, $preserve_filepath = true, $root_path = null)
    {
        if ( ! $fp = @opendir($path)) {
            return false;
        }

        // Set the original directory root for child dir's to use as relative
        if ($root_path === null) {
            $root_path = dirname($path) . '/';
        }

        while (false !== ($file = readdir($fp))) {

            if (substr($file, 0, 1) == '.') {
                continue;
            }

            if (@is_dir($path.$file)) {
                $this->readDir($path.$file."/", $preserve_filepath, $root_path);
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

}
