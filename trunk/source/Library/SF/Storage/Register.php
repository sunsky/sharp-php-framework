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
namespace SF\Storage;
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
	
	/**
	 * @param string $name
	 * @param mix $args
	 * @return mix
	 */
	public static function __callstatic($name, $args){
		$instance = static::getInstance();
		$name = strtolower($name);
		if(property_exists($instance, $name) && empty($args)){//get
			return $instance->$name;
		}
		if(!empty($args)){//set
			$instance->$name = $args[0];
		}
		return ;
	}

	public static function getInstance(){
		if(!static::$_instance)
			static::$_instance = new static();
		return static::$_instance;
	}

	
}

