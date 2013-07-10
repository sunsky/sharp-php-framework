<?php

/**
 * Shark Framework
 *
 * @author wuqj <sunsky303@gmail.com>
 * @category SF
 * @package SF\Http
 * @copyright Copyright 2012-2013
 * @link https://mini-php-framework.googlecode.com/
 * @version $Id$
 */
namespace SF\Http\Request;

/**
 *
 * @author wuqj
 *        
 */
class Request {
	public static function redirect($url, $statusCode = 302) {
		if (strpos ( $url, '/' ) === 0 && strpos ( $url, '//' ) !== 0)
			$url = self::getCurrentHost() . $url;
		header ( 'Location: ' . $url, true, $statusCode );
	}
	public static function getCurrentUrl() {
		$query = isset ( $_SERVER ['argv'] ) ? substr ( $_SERVER ['argv'] [0], strpos ( $_SERVER ['argv'] [0], ';' ) + 1 ) : '';
		$toret =  self::getCurrentHost(). (empty ( $query ) ? '' : '?' . $query);
		return $toret;
	}
	public static function getCurrentHost(){
		$protocol = 'http';
		if ($_SERVER ['SERVER_PORT'] == 443 || (! empty ( $_SERVER ['HTTPS'] ) && $_SERVER ['HTTPS'] == 'on')) {
			$protocol .= 's';
			$protocol_port = $_SERVER ['SERVER_PORT'];
		} else {
			$protocol_port = 80;
		}
		
		$host = $_SERVER ['HTTP_HOST'];
		$port = $_SERVER ['SERVER_PORT'];
		$request = $_SERVER ['PHP_SELF'];
		$toret = $protocol . '://' . $host . ($port == $protocol_port ? '' : ':' . $port) . $request;
		
		return $toret;
		
	}
}

?>