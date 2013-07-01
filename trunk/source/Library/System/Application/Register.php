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
namespace System\Application;
/**
 * 注册类
 * 
 * 保存全局变量
 * 
 * @author wuqj <sunsky303@gmail.com>
 * @copyright Copyright 2012-2013
 * @link https://mini-php-framework.googlecode.com/
 */
class Register extends \ArrayObject {
	protected static $_instance;
	protected $_conf;
	protected $_cache;
	
	public static function getInstance(){
		if(!static::$_instance)
			static::$_instance = new static();
		return static::$_instance;
	}
	
	
	public static function setConfig($conf){
		$instance = static::getInstance();
		$instance->_conf = $conf;
		return $instance;
	}
	public static function getConfig(){
		$instance = static::getInstance();
		return $instance->_conf;
	}	
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

