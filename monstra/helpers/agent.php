<?php defined('MONSTRA_ACCESS') or die('No direct script access.');

/**
 *	Agent Helper
 *
 *	@package Monstra
 *	@subpackage Helpers
 *	@author Romanenko Sergey / Awilum
 *	@copyright 2012 Romanenko Sergey / Awilum
 *	@version $Id$
 *	@since 1.0.0
 *  @license http://opensource.org/licenses/gpl-license.php GNU Public License
 *  Monstra is free software. This version may have been modified pursuant
 *  to the GNU General Public License, and as distributed it includes or
 *  is derivative of works licensed under the GNU General Public License or
 *  other free or open source software licenses.
 *  See COPYING.txt for copyright notices and details.
 *  @filesource 
 */


class Agent {


	/**
	 * Mobiles
	 *
	 * @var array
	 */
	public static $mobiles = array (
		'ipad',
		'iphone',
		'ipod',
		'android',
		'windows ce',
		'windows phone',
		'mobileexplorer',
		'opera mobi',
		'opera mini',
		'fennec',
		'blackberry',
		'nokia',
		'kindle',
		'ericsson',
		'motorola',
		'minimo',
		'iemobile',
		'symbian',
		'webos',
		'hiptop',
		'palmos',
		'palmsource',
		'xiino',
		'avantgo',
		'docomo',
		'up.browser',
		'vodafone',
		'portable',
		'pocket',
		'mobile',
		'phone',
	);


	/**
	 * Robots
	 *
	 * @var array
	 */
	public static $robots = array(
		'googlebot',
		'msnbot',
		'slurp',
		'yahoo',
		'askjeeves',
		'fastcrawler',
		'infoseek',
		'lycos',
		'ia_archiver',
	);


	/** 
	 * Protected constructor since this is a static class.
	 *
	 * @access  protected
	 */  
	protected function __construct() {
		// Nothing here
	}


	/**
	 * Searches for a string in the user agent string.
	 *
	 * @param   array   $agents Array of strings to look for
	 * @return  boolean
	 */		
	protected static function find($agents) {

		// If isset HTTP_USER_AGENT ?
		if (isset($_SERVER['HTTP_USER_AGENT'])) {

			// Loop through $agents array 
			foreach($agents as $agent) {

				// If current user agent == agents[agent] then return true
				if(stripos($_SERVER['HTTP_USER_AGENT'], $agent) !== false) {
					return true;
				}
			}
		}

		// Else return false
		return false;
	}


	/**
	 * Returns true if the user agent that made the request is identified as a mobile device.
	 *
	 *	<code>
	 *		if (Agent::isMobile()) {
	 *			// Do something...
	 *  	}
	 *	</code>
	 *
	 * @return  boolean
	 */		
	public static function isMobile() {
		return Agent::find(Agent::$mobiles);
	}


	/**
	 * Returns true if the user agent that made the request is identified as a robot/crawler.
	 *
	 *	<code>
	 *		if (Agent::isRobot()) {
	 *			// Do something...
	 *  	}
	 *	</code>
	 *
	 * @return  boolean
	 */		
	public static function isRobot() {
		return Agent::find(Agent::$robots);
	}


	/**
	 * Returns TRUE if the string you're looking for exists in the user agent string and FALSE if not.
	 *
	 *	<code>
	 *		if (Agent::is('iphone')) {
	 *			// Do something...
	 *  	}
	 *
	 *		if (Agent::is(array('iphone', 'ipod'))) {
	 *			// Do something...
	 *  	}
	 *	</code>
	 *
	 * @param   mixed   $device String or array of strings you're looking for
	 * @return  boolean
	 */		
	public static function is($device) {
		return Agent::find((array) $device);
	}

}