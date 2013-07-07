<?php
/**
 +---------------------------------------------------------+
 |  Sharp Framework										   |
 |  This is a free & open & mini & core & high performance |
 |php-framework, based on php version 5.3.                 |
 |                                                         |
 +---------------------------------------------------------+
 * @author wuqj <sunsky303@gmail.com>
 * @copyright Copyright 2012-2013
 * @link https://mini-php-framework.googlecode.com/
 * @version $Id: Register.php 15 2013-05-17 01:36:13Z sunsky303 $
 +----------------------------------------------------------
 */
namespace System\Storage;
/**
 * 注册类
 * 
 * 保存全局变量
 * 
 * @author wuqj <sunsky303@gmail.com>
 * @copyright Copyright 2012-2013
 * @link https://mini-php-framework.googlecode.com/
 */
class CacheRegister extends Register {
	protected $_cache;
	public static function setCache($cache){
		$instance = static::getInstance();
		$instance->_cache = $cache;
		return $instance;
	}
	public static function getCache(){
		$instance = static::getInstance();
		return $instance->_cache;
	}	
}

