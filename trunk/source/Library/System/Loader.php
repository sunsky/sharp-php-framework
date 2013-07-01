<?php
/**
 +---------------------------------------------------------+
 |  Sharp Framework										   |
 |  This is a free & open & mini & core & high performance |
 |php-framework, based on php version 5.3.                 |
 |                                                         |
 +---------------------------------------------------------+
 * Sharp Framework	
 +----------------------------------------------------------
 * @author wuqj <sunsky303@gmail.com>
 * @copyright Copyright 2012-2013
 * @link https://mini-php-framework.googlecode.com/
 * @version $Id: Loader.php 16 2013-06-18 00:51:50Z sunsky303 $
 +----------------------------------------------------------
 */
namespace System;

/**
 * 类自动加载器
 * 
 * 使用类前自动加载文件
 * 
 * @author wuqj <sunsky303@gmail.com>
 * @copyright Copyright 2012-2013
 * @link https://mini-php-framework.googlecode.com/
 */
final class Loader {
	private static $_loader;
	protected static $_importClassMethod = 'importSysClass';
	public function __construct(){ 
		spl_autoload_register(array($this, self::$_importClassMethod), true);
	}
	
	public static  function initLoader(){
		if(!self::$_loader){
			self::$_loader = new self();
		}
		return self::$_loader;
	}
	
	/**
	 * require once system file
	 * 
	 * @todo throw
	 * @param string $className
	 * @return string | bool
	 * @throws \System\Exception\SysException
	 */
	public static function importSysClass($className){
		try{
			if(!class_exists($className, false)){
				$filePath = str_replace('\\','/',$className).'.php';
				$resolvedPath = stream_resolve_include_path($filePath);
				if ($resolvedPath !== false) {
					return require $resolvedPath;
				}else{
					throw new InvalidClassException(sprintf('class %s is not found in %s:%u',$className,\System\Event\Error\Handler::getRelativePath(__FILE__)  ,__LINE__));
				}
			}
				
		}catch (\Exception $ex){
			throw $ex;
		}
		
	}
	
	
}
require 'Event/Exception/Exception.php';
class InvalidClassException extends Event\Exception\Exception{
}


