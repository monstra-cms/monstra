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

class Image
{
    /**
     * Resizing contraint.
     *
     * @var integer
     */
    const AUTO = 1;

    /**
     * Resizing contraint.
     *
     * @var integer
     */
    const WIDTH = 2;

    /**
     * Resizing contraint.
     *
     * @var integer
     */
    const HEIGHT = 3;

    /**
     * Watermark position.
     */
    const TOP_LEFT = 4;

    /**
     * Watermark position.
     */
    const TOP_RIGHT = 5;

    /**
     * Watermark position.
     */
    const BOTTOM_LEFT = 6;

    /**
     * Watermark position.
     */
    const BOTTOM_RIGHT = 7;

    /**
     * Watermark position.
     */
    const CENTER = 8;

    /**
     * Holds info about the image.
     *
     * @var array
     */
    protected $image_info;

    /**
     * Get value
     *
     * @param  string $key Key
     * @return mixed
     */
    public function __get($key)
    {
        if (array_key_exists($key, $this->image_info)) return $this->image_info[$key];
    }

    /**
     * Set value for specific key
     *
     * @param string $key   Key
     * @param mixed  $value Value
     */
    public function __set($key, $value)
    {
        $this->image_info[$key] = $value;
    }

    /**
     * Image factory.
     *
     *  <code>
     *      $image = Image::factory('original.png');
     *  </code>
     *
     * @param  string $filename Filename
     * @return Image
     */
    public static function factory($filename)
    {
        return new Image($filename);
    }

    /**
     * Construct
     *
     * @param string $file Filename
     */
    public function __construct($file)
    {
        // Redefine vars
        $file = (string) $file;

        // Check if the file exists
        if (file_exists($file)) {

            // Extract attributes of the image file
            list($this->width, $this->height, $type, $a) = getimagesize($file);

            // Save image type
            $this->type = $type;

            // Create a new image
            $this->image = $this->createImage($file, $type);
        } else {
            throw new RuntimeException(vsprintf("%s(): The file '{$file}' doesn't exist", array(__METHOD__)));
        }
    }

    /**
     * Create a new image from file.
     *
     * @param  string   $file Path to the image file
     * @param  integer  $type Image type
     * @return resource
     */
    protected function createImage($file, $type)
    {
        // Create image from file
        switch ($type) {
            case IMAGETYPE_JPEG:
                return imagecreatefromjpeg($file);
            break;
            case IMAGETYPE_GIF:
                return imagecreatefromgif($file);
            break;
            case IMAGETYPE_PNG:
                return imagecreatefrompng($file);
            break;
            default:
                throw new RuntimeException(vsprintf("%s(): Unable to open '%s'. Unsupported image type.", array(__METHOD__, $type)));
        }
    }

    /**
     * Resizes the image to the chosen size.
     *
     *  <code>
     *      Image::factory('original.png')->resize(800, 600)->save('edited.png');
     *  </code>
     *
     * @param  integer $width        Width of the image
     * @param  integer $height       Height of the image
     * @param  integer $aspect_ratio Aspect ratio (Image::AUTO Image::WIDTH Image::HEIGHT)
     * @return Image
     */
    public function resize($width, $height = null, $aspect_ratio = null)
    {
        // Redefine vars
        $width        = (int) $width;
        $height       = ($height === null) ? null : (int) $height;
        $aspect_ratio = ($aspect_ratio === null) ? null : (int) $aspect_ratio;
        $xpos = $ypos = 0;

        // Resizes the image to {$width}% of the original size
        if ($height === null) {

            $new_width  = round($this->width  * ($width / 100));
            $new_height = round($this->height * ($width / 100));

        } else {

            // Resizes the image to the smalles possible dimension while maintaining aspect ratio
            if ($aspect_ratio === Image::AUTO || $aspect_ratio === null) {

                // Calculate smallest size based on given height and width while maintaining aspect ratio
                $percentage = min(($width / $this->width), ($height / $this->height));

                $new_width  = round($this->width * $percentage);
                $new_height = round($this->height * $percentage);
                
                if ($aspect_ratio === null) {
                    $xpos = (int)(($width - $new_width) / 2);
                    $ypos = (int)(($height - $new_height) / 2);
                }

            // Resizes the image using the width to maintain aspect ratio
            } elseif ($aspect_ratio === Image::WIDTH) {

                // Base new size on given width while maintaining aspect ratio
                $new_width  = $width;
                $new_height = round($this->height * ($width / $this->width));

            // Resizes the image using the height to maintain aspect ratio
            } elseif ($aspect_ratio === Image::HEIGHT) {

                // Base new size on given height while maintaining aspect ratio
                $new_width  = round($this->width * ($height / $this->height));
                $new_height = $height;

            // Resizes the image to a dimension of {$width}x{$height} pixels while ignoring the aspect ratio
            } else {

                $new_width  = $width;
                $new_height = $height;
            }
        }

        $old_image = $this->image;
        
        if ($aspect_ratio === null) {
            $this->image = imagecreatetruecolor($width, $height);
        } else {
            $this->image = imagecreatetruecolor($new_width, $new_height);
        }
        
        if ($this->type === IMAGETYPE_PNG) {
            $bgcolor = imagecolorallocatealpha($this->image, 0, 0, 0, 127);
        } else {
            $bgcolor = imagecolorallocate($this->image, 255, 255, 255);
        }
        
        imagefill($this->image, 0, 0, $bgcolor);

        // Copy and resize part of an image with resampling
        imagecopyresampled($this->image, $old_image, $xpos, $ypos, 0, 0, $new_width, $new_height, $this->width, $this->height);

        // Destroy an image
        imagedestroy($old_image);
        
        // Save new width and height
        $this->width = $new_width;
        $this->height = $new_height;

        return $this;
    }

    /**
     * Crops the image
     *
     *  <code>
     *      Image::factory('original.png')->crop(800, 600, 0, 0)->save('edited.png');
     *  </code>
     *
     * @param  integer $width  Width of the crop
     * @param  integer $height Height of the crop
     * @param  integer $x      The X coordinate of the cropped region's top left corner
     * @param  integer $y      The Y coordinate of the cropped region's top left corner
     * @return Image
     */
    public function crop($width, $height, $x, $y)
    {
        // Redefine vars
        $width  = (int) $width;
        $height = (int) $height;
        $x      = (int) $x;
        $y      = (int) $y;

        // Calculate
        if ($x + $width > $this->width)   $width = $this->width - $x;
        if ($y + $height > $this->height) $height = $this->height - $y;
        if ($width <= 0 || $height <= 0) return false;

        $old_image = $this->image;
        
        // Create a new true color image
        $this->image = imagecreatetruecolor($width, $height);
        
        $transparent = imagecolorallocatealpha($this->image, 0, 0, 0, 127);
        imagefill($this->image, 0, 0, $transparent);

        // Copy and resize part of an image with resampling
        imagecopyresampled($this->image, $old_image, 0, 0, $x, $y, $width, $height, $width, $height);

        // Destroy an image
        imagedestroy($old_image);
        
        // Save new width and height
        $this->width  = $width;
        $this->height = $height;

        return $this;
    }

    /**
      * Adds a watermark to the image.
     *
     * @param  string  $file     Path to the image file
     * @param  integer $position Position of the watermark
     * @param  integer $opacity  Opacity of the watermark in percent
     * @return Image
     */
    public function watermark($file, $position = null, $opacity = 100)
    {
        // Check if the image exists
        if ( ! file_exists($file)) {
            throw new RuntimeException(vsprintf("%s(): The image file ('%s') does not exist.", array(__METHOD__, $file)));
        }

        $watermark = $this->createImage($file, $this->type);

        $watermarkW = imagesx($watermark);
        $watermarkH = imagesy($watermark);

        // Make sure that opacity is between 0 and 100
        $opacity = max(min((int) $opacity, 100), 0);

        if ($opacity < 100) {

            if (GD_BUNDLED === 0) {
                throw new RuntimeException(vsprintf("%s(): Setting watermark opacity requires the 'imagelayereffect' function which is only available in the bundled version of GD.", array(__METHOD__)));
            }

            // Convert alpha to 0-127
            $alpha = min(round(abs(($opacity * 127 / 100) - 127)), 127);

            $transparent = imagecolorallocatealpha($watermark, 0, 0, 0, $alpha);

            imagelayereffect($watermark, IMG_EFFECT_OVERLAY);

            imagefilledrectangle($watermark, 0, 0, $watermarkW, $watermarkH, $transparent);
        }

        // Position the watermark.
        switch ($position) {
            case Image::TOP_RIGHT:
                $x = imagesx($this->image) - $watermarkW;
                $y = 0;
            break;
            case Image::BOTTOM_LEFT:
                $x = 0;
                $y = imagesy($this->image) - $watermarkH;
            break;
            case Image::BOTTOM_RIGHT:
                $x = imagesx($this->image) - $watermarkW;
                $y = imagesy($this->image) - $watermarkH;
            break;
            case Image::CENTER:
                $x = (imagesx($this->image) / 2) - ($watermarkW / 2);
                $y = (imagesy($this->image) / 2) - ($watermarkH / 2);
            break;
            default:
                $x = 0;
                $y = 0;
        }

        imagealphablending($this->image, true);

        imagecopy($this->image, $watermark, $x, $y, 0, 0, $watermarkW, $watermarkH);

        imagedestroy($watermark);

        // Return Image
        return $this;
    }

    /**
     * Convert image into grayscale
     *
     *  <code>
     *      Image::factory('original.png')->grayscale()->save('edited.png');
     *  </code>
     *
     * @return Image
     */
    public function grayscale()
    {
        imagefilter($this->image, IMG_FILTER_GRAYSCALE);

        return $this;
    }

    /**
     * Convert image into sepia
     *
     *  <code>
     *      Image::factory('original.png')->sepia()->save('edited.png');
     *  </code>
     *
     * @return Image
     */
    public function sepia()
    {
        imagefilter($this->image, IMG_FILTER_GRAYSCALE);
        imagefilter($this->image, IMG_FILTER_COLORIZE, 112, 66, 20);

        return $this;
    }

    /**
     * Convert image into brightness
     *
     *  <code>
     *      Image::factory('original.png')->brightness(60)->save('edited.png');
     *  </code>
     *
     * @param  integer $level Level. From -255(min) to 255(max)
     * @return Image
     */
    public function brightness($level = 0)
    {
        imagefilter($this->image, IMG_FILTER_BRIGHTNESS, (int) $level);

        return $this;
    }

    /**
     * Convert image into colorize
     *
     *  <code>
     *      Image::factory('original.png')->colorize(60, 0, 0)->save('edited.png');
     *  </code>
     *
     * @param  integer $red   Red
     * @param  integer $green Green
     * @param  integer $blue  Blue
     * @return Image
     */
    public function colorize($red, $green, $blue)
    {
        imagefilter($this->image, IMG_FILTER_COLORIZE, (int) $red, (int) $green, (int) $blue);

        return $this;
    }

    /**
     * Convert image into contrast
     *
     *  <code>
     *      Image::factory('original.png')->contrast(60)->save('edited.png');
     *  </code>
     *
     * @param  integer $level Level. From -100(max) to 100(min)	note the direction!
     * @return Image
     */
    public function contrast($level)
    {
        imagefilter($this->image, IMG_FILTER_CONTRAST, (int) $level);

        return $this;
    }

    /**
     * Creates a color based on a hex value.
     *
     * @param  string  $hex       Hex code of the color
     * @param  integer $alpha     Alpha. Default is 100
     * @param  boolean $returnRGB FALSE returns a color identifier, TRUE returns a RGB array
     * @return integer
     */
    protected function createColor($hex, $alpha = 100, $return_rgb = false)
    {
        // Redefine vars
        $hex   		= (string) $hex;
        $alpha 		= (int) $alpha;
        $return_rgb = (bool) $return_rgb;

        $hex = str_replace('#', '', $hex);

        if (preg_match('/^([a-f0-9]{3}){1,2}$/i', $hex) === 0) {
            throw new RuntimeException(vsprintf("%s(): Invalid color code ('%s').", array(__METHOD__, $hex)));
        }

        if (strlen($hex) === 3) {

            $r = hexdec(str_repeat(substr($hex, 0, 1), 2));
            $g = hexdec(str_repeat(substr($hex, 1, 1), 2));
            $b = hexdec(str_repeat(substr($hex, 2, 1), 2));

        } else {

            $r = hexdec(substr($hex, 0, 2));
            $g = hexdec(substr($hex, 2, 2));
            $b = hexdec(substr($hex, 4, 2));

        }

        if ($return_rgb === true) {
            return array('r' => $r, 'g' => $g, 'b' => $b);

        } else {

            // Convert alpha to 0-127
            $alpha = min(round(abs(($alpha * 127 / 100) - 127)), 127);

            return imagecolorallocatealpha($this->image, $r, $g, $b, $alpha);
        }
    }

    /**
     * Rotates the image using the given angle in degrees.
     *
     *  <code>
     *      Image::factory('original.png')->rotate(90)->save('edited.png');
     *  </code>
     *
     * @param  integer $degrees Degrees to rotate the image
     * @return Image
     */
    public function rotate($degrees)
    {
        if (GD_BUNDLED === 0) {
            throw new RuntimeException(vsprintf("%s(): This method requires the 'imagerotate' function which is only available in the bundled version of GD.", array(__METHOD__)));
        }

        // Redefine vars
        $degrees = (int) $degrees;

        // Get image width and height
        $width  = imagesx($this->image);
        $height = imagesy($this->image);

        // Allocate a color for an image
        $transparent = imagecolorallocatealpha($this->image, 0, 0, 0, 127);

        // Rotate gif image
        if ($this->image_info['type'] === IMAGETYPE_GIF) {

            // Create a new true color image
            $temp = imagecreatetruecolor($width, $height);

            // Flood fill
            imagefill($temp, 0, 0, $transparent);

            // Copy part of an image
            imagecopy($temp, $this->image, 0, 0, 0, 0, $width, $height);

            // Destroy an image
            imagedestroy($this->image);

            // Save temp image
            $this->image = $temp;
        }

        // Rotate an image with a given angle
        $this->image = imagerotate($this->image, (360 - $degrees), $transparent);

        // Define a color as transparent
        imagecolortransparent($this->image, $transparent);

        return $this;
    }

    /**
     * Adds a border to the image.
     *
     *  <code>
     *      Image::factory('original.png')->border('#000', 5)->save('edited.png');
     *  </code>
     *
     * @param  string  $color     Hex code for the color
     * @param  integer $thickness Thickness of the frame in pixels
     * @return Image
     */
    public function border($color = '#000', $thickness = 5)
    {
        // Redefine vars
        $color 	   = (string) $color;
        $thickness = (int) $thickness;

        // Get image width and height
        $width  = imagesx($this->image);
        $height = imagesy($this->image);

        // Creates a color based on a hex value
        $color = $this->createColor($color);

        // Create border
        for ($i = 0; $i < $thickness; $i++) {

            if ($i < 0) {

                $x = $width + 1;
                $y = $hidth + 1;

            } else {

                $x = --$width;
                $y = --$height;

            }

            imagerectangle($this->image, $i, $i, $x, $y, $color);
        }

        return $this;
    }

    /**
     * Save image
     *
     *  <code>
     *      Image::factory('original.png')->save('edited.png');
     *  </code>
     *
     * @param  string  $dest    Desitination location of the file
     * @param  integer $quality Image quality. Default is 100
     * @return Image
     */
    public function save($file, $quality = 100)
    {
        // Redefine vars
        $file 	 = (string) $file;
        $quality = (int) $quality;

        $path_info = pathinfo($file);

        if ( ! is_writable($path_info['dirname'])) {
            throw new RuntimeException(vsprintf("%s(): '%s' is not writable.", array(__METHOD__, $path_info['dirname'])));
        }

        // Make sure that quality is between 0 and 100
        $quality = max(min((int) $quality, 100), 0);

        // Save image
        switch ($path_info['extension']) {
            case 'jpg':
            case 'jpeg':
                imagejpeg($this->image, $file, $quality);
            break;
            case 'gif':
                imagegif($this->image, $file);
            break;
            case 'png':
                imagealphablending($this->image, true);
                imagesavealpha($this->image, true);
                imagepng($this->image, $file, (9 - (round(($quality / 100) * 9))));
            break;
            default:
                throw new RuntimeException(vsprintf("%s(): Unable to save to '%s'. Unsupported image format.", array(__METHOD__, $path_info['extension'])));
        }

        // Return Image
        return $this;
    }

    /**
     * Destructor
     */
    public function __destruct()
    {
        imagedestroy($this->image);
    }

}
