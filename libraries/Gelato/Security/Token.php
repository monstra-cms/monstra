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

class Token
{
    /**
     * Key name for token storage
     *
     * @var  string
     */
    protected static $token_name = 'security_token';

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
     * Generate and store a unique token which can be used to help prevent
     * [CSRF](http://wikipedia.org/wiki/Cross_Site_Request_Forgery) attacks.
     *
     *  <code>
     *      $token = Token::generate();
     *  </code>
     *
     * You can insert this token into your forms as a hidden field:
     *
     *  <code>
     *      echo Form::hidden('csrf', Token::generate());
     *  </code>
     *
     * This provides a basic, but effective, method of preventing CSRF attacks.
     *
     * @param  boolean $new force a new token to be generated?. Default is false
     * @return string
     */
    public static function generate($new = false)
    {
        // Get the current token
        $token = Session::get(Token::$token_name);

        // Create a new unique token
        if ($new === true or ! $token) {

            // Generate a new unique token
            $token = sha1(uniqid(mt_rand(), true));

            // Store the new token
            Session::set(Token::$token_name, $token);
        }

        // Return token
        return $token;
    }

    /**
     * Check that the given token matches the currently stored security token.
     *
     *  <code>
     *     if (Token::check($token)) {
     *         // Pass
     *     }
     *  </code>
     *
     * @param  string  $token token to check
     * @return boolean
     */
    public static function check($token)
    {
        return Token::token() === $token;
    }

}
