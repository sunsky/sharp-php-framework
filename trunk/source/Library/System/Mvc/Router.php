<?php

/**
 * 路由类
 *
 * @author wuqj <sunsky303@gmail.com>
 * @category System
 * @package System\Router
 * @copyright Copyright 2012-2013
 * @link https://mini-php-framework.googlecode.com/
 * @version $Id: Router.php 17 2013-06-30 09:05:47Z sunsky303 $
 */
namespace System\Mvc;
use System\Controller\Exception;
use System\Storage\Register;
use System\InvalidClassException;
use System\Controller\Exception\PageNotFoundException;
/**
 * 路由类
 * @author wuqj <sunsky303@gmail.com>
 * @copyright Copyright 2012-2013
 * @link https://mini-php-framework.googlecode.com/
 */
class Router {
	private static $_instance;
	protected $_config = array ();
	protected $_className;
	protected $_controller;
	protected $_action;
	protected $_controllerDir = 'Controllers';
	protected $_viewDir = 'Views';
	protected $_controllerInstance;
	/**
	 *
	 * @param array $config        	
	 */
	function __construct() {
		$config = Register::getConfig();
		$this->_className = str_replace ( array (
				__NAMESPACE__,
				'\\' 
		), '', __CLASS__ );
		
		$this->_config = isset ( $config ['router'] ) ? $config ['router'] : array ();
		isset ( $this->_config ['controllerDir'] ) ? $this->_controllerDir = $this->_config ['controllerDir'] : $this->_config ['controllerDir'] = $this->_controllerDir;
		isset ( $this->_config ['viewDir'] ) ? $this->_viewDir = $this->_config ['viewDir'] : $this->_config ['viewDir'] = $this->_viewDir;
		
	}
	
	/**
	 * 分发
	 * 
	 * @todo throw
	 */
	public function dispatch($controller = '', $action = '', $args = array()) {
		$this->_requestParse ($controller, $action);
		$controllerClass =  $this->getClassByController ($this->_controller) ;
		try{
			$this->_controllerInstance = new $controllerClass($this->_controller, $this->_action);
		}catch (InvalidClassException $ex){
			throw new PageNotFoundException ( $ex->getMessage(), $ex->getCode());
		}
		$method = $this->getMethodByAction($this->_action);
		if(!method_exists($this->_controllerInstance, $method)){
			throw new PageNotFoundException( sprintf('method %s of class %s is not found in %s:%u', $method, $controllerClass,  \System\Event\Error\Handler::getRelativePath(__FILE__)  ,__LINE__));
			exit(-1);
		}
		$this->_controllerInstance->before();
		try{
			call_user_func_array(array($this->_controllerInstance, $method), $args);
		}catch (\System\Event\Exception\Exception $ex){
			throw new Exception\ParseFailedException();
		}
		$this->_controllerInstance->after();
		$this->_controllerInstance->getView()->run();
		
		
	}
	
	
	/**
	 * parse requests
	 */
	protected function _requestParse($controller, $action) {
		$this->_controller = $controller ? $controller : $this->getController (isset($_REQUEST [$this->_config ['controllerPrefix']]) ? $_REQUEST [$this->_config ['controllerPrefix']] : '');
		$this->_action = $action ? $action : $this->getAction (isset($_REQUEST [$this->_config ['actionPrefix']]) ? $_REQUEST [$this->_config ['actionPrefix']] : '');
	}
	
	/**
	 * get Controller
	 *
	 * @param string $controller
	 * @return string
	 */
	public function getController($controller) {
		return !empty ( $controller ) ? $controller : $this->_config['defaultController'];
	}
	/**
	 * get Controller Class Name
	 *
	 * @param string $controller
	 * @return string
	 */
	public function getClassByController($controller) {
		return '\\' . APP_DIR . '\\' . $this->_controllerDir . '\\' . ucfirst($controller) . (isset ( $this->_config ['controllerClassSuffix'] ) ?  $this->_config ['controllerClassSuffix'] : 'Controller');
	}
	/**
	 * get Action
	 *
	 * @return string
	 */
	public function getAction($action) {
		return !empty ( $action ) ? $action : $this->_config ['defaultAction'];
	}
	/**
	 * get method by action
	 *
	 * @return string
	 */
	public function getMethodByAction($action) {
		return  lcfirst($action) . (isset ( $this->_config ['actionClassSuffix'] ) ? $this->_config ['actionClassSuffix'] : 'Action');
	}
	/**
	 *
	 * @param array $config        	
	 */
	public static function getInstance() {
		if (! self::$_instance)
			self::$_instance = new self (  );
		return self::$_instance;
	}

}

?>