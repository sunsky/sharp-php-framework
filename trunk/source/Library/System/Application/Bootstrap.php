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
 * @version $Id: Bootstrap.php 15 2013-05-17 01:36:13Z sunsky303 $
 +----------------------------------------------------------
 */
namespace System\Application;

/**
 * 启动文件
 * 
 * system Bootstrap
 * 
 * @author wuqj <sunsky303@gmail.com>
 * @copyright Copyright 2012-2013
 * @link https://mini-php-framework.googlecode.com/
 */
class Bootstrap extends BootstrapAbstract {
	public static $filename = 'Bootstrap.php';
	public static $classname = 'Bootstrap';
	protected $_autoExecuteMethodPrefix = '_init';
	protected $_config;
	
	public function __construct($config){
		$this->_config = $config;
		$this->_methodsRun();
	}
	
	/**
	 * auto run methods
	 * 
	 * @return \System\Bootstrap
	 */
	protected function _methodsRun(){
		if($this->_autoExecuteMethodPrefix){
			$methods = (array)get_class_methods($this);
		
			foreach ($methods as $m){
				if(false !== strstr($m, $this->_autoExecuteMethodPrefix)){
					$this->$m();
				}
			}
		}
		return $this;
	}
}

?>