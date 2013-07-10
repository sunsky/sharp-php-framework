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
 * @version $Id: Application.php 17 2013-06-30 09:05:47Z sunsky303 $
 +----------------------------------------------------------
 */
namespace SF\Mvc;

use SF\Loader;
use SF\Mvc\Bootstrap;
use SF\Mvc\Router;
/**
 * Application run
 * 
 * @author wuqj <sunsky303@gmail.com>
 * @copyright Copyright 2012-2013
 * @link https://mini-php-framework.googlecode.com/
 */
class Application {
	private static $_instance;
	private $_config;
	/**
	 * @param string $runEnvironment (development|production)
	 * @param array $config
	 */
	public function __construct($runEnvironment,$config) {
		$this->_config = $config;
		self::initLoader();
		$this->_addEventListener();
		
		
	}
	public static function  initLoader(){
		require ROOT_PATH . '/Library/SF/Loader/Loader.php';
		Loader::initLoader();
	}
	public static function  run($runEnvironment,$config){
		$self = self::getApp($runEnvironment, $config);
		$self->_bootstrap();
		
		Router::getInstance($config)->dispatch();
	}

	/**
	 * @param string $runEnvironment (development|production)
	 * @param array $config
	 * @return \SF\Application
	 */
	public static function getApp($runEnvironment,$config){
		if(!self::$_instance)
			self::$_instance = new self($runEnvironment,$config);
		return self::$_instance;
	}
	/**
	 * bootstrap
	 */
	protected function _bootstrap(){
		$_bootstrapFile = APP_PATH . DIRECTORY_SEPARATOR . Bootstrap::$filename;
		if(file_exists($_bootstrapFile)){
			require $_bootstrapFile;
			Bootstrap::$classname = '\\'. APP_DIR .'\\Bootstrap';
			if(class_exists(Bootstrap::$classname, false)){
				$_bootstrap = new Bootstrap::$classname($this->_config);
				if(!$_bootstrap instanceof  Bootstrap){
					throw new \SF\Event\Exception\Exception();
				}
			}
		}
	}
	
	protected function _addEventListener(){
		$exceptionHandlerClass = isset($this->_config['exception']) && isset($this->_config['exception']['exceptionHandler'])
		 ? $this->_config['exception']['exceptionHandler'] : '\SF\Event\Exception\Exception';
		$eventHandlerClass = isset($this->_config['exception']) && isset($this->_config['exception']['eventHandler'])
		 ? $this->_config['exception']['eventHandler'] : '\SF\Event\Error\Handler';
		
		$exceptionHandler = new $exceptionHandlerClass();
		$exceptionHandler->addEventListener();
		$handler = new $eventHandlerClass($exceptionHandler);
		$handler->addEventListener();
	}
	
}

?>