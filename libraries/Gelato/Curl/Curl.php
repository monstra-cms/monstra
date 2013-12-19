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

class Curl
{
    /**
     * Default curl options.
     *
     * @var array
     */
    protected static $default_options = array(
        CURLOPT_USERAGENT      => 'Mozilla/5.0 (compatible; Monstra CMS; +http://monstra.org)',
        CURLOPT_RETURNTRANSFER => true
    );

    /**
     * Information about the last transfer.
     *
     * @var array
     */
    protected static $info;

    /**
     * Performs a curl GET request.
     *
     *  <code>
     *      $res = Curl::get('http://site.com/');
     *  </code>
     *
     * @param  string $url     The URL to fetch
     * @param  array  $options An array specifying which options to set and their values
     * @return string
     */
    public static function get($url, array $options = null)
    {
        // Redefine vars
        $url = (string) $url;

        // Check if curl is available
        if ( ! function_exists('curl_init')) throw new RuntimeException(vsprintf("%s(): This method requires cURL (http://php.net/curl), it seems like the extension isn't installed.", array(__METHOD__)));

        // Initialize a cURL session
        $handle = curl_init($url);

        // Merge options
        $options = (array) $options + Curl::$default_options;

        // Set multiple options for a cURL transfer
        curl_setopt_array($handle, $options);

        // Perform a cURL session
        $response = curl_exec($handle);

        // Set information regarding a specific transfer
        Curl::$info = curl_getinfo($handle);

        // Close a cURL session
        curl_close($handle);

        // Return response
        return $response;
    }

    /**
     * Performs a curl POST request.
     *
     *  <code>
     *      $res = Curl::post('http://site.com/login');
     *  </code>
     *
     * @param  string  $url       The URL to fetch
     * @param  array   $data      An array with the field name as key and field data as value
     * @param  boolean $multipart True to send data as multipart/form-data and false to send as application/x-www-form-urlencoded
     * @param  array   $options   An array specifying which options to set and their values
     * @return string
     */
    public static function post($url, array $data = null, $multipart = false, array $options = null)
    {
        // Redefine vars
        $url = (string) $url;

        // Check if curl is available
        if ( ! function_exists('curl_init')) throw new RuntimeException(vsprintf("%s(): This method requires cURL (http://php.net/curl), it seems like the extension isn't installed.", array(__METHOD__)));

        // Initialize a cURL session
        $handle = curl_init($url);

        // Merge options
        $options = (array) $options + Curl::$default_options;

        // Add options
        $options[CURLOPT_POST]       = true;
        $options[CURLOPT_POSTFIELDS] = ($multipart === true) ? (array) $data : http_build_query((array) $data);

        // Set multiple options for a cURL transfer
        curl_setopt_array($handle, $options);

        // Perform a cURL session
        $response = curl_exec($handle);

        // Set information regarding a specific transfer
        Curl::$info = curl_getinfo($handle);

        // Close a cURL session
        curl_close($handle);

        // Return response
        return $response;
    }

    /**
     * Gets information about the last transfer.
     *
     *  <code>
     *      $res = Curl::getInfo();
     *  </code>
     *
     * @param  string $value Array key of the array returned by curl_getinfo()
     * @return mixed
     */
    public static function getInfo($value = null)
    {
        if (empty(Curl::$info)) {
            return false;
        }

        return ($value === null) ? Curl::$info : Curl::$info[$value];
    }

}
