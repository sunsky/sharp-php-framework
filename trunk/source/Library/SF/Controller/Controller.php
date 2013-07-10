<?php
/**
 * Shark Framework
 *
 * @author wuqj <sunsky303@gmail.com>
 * @category SF
 * @package SF\Url
 * @copyright Copyright 2012-2013
 * @link https://mini-php-framework.googlecode.com/
 * @version $Id: Controller.php 16 2013-06-18 00:51:50Z sunsky303 $
 */
namespace SF\Controller;

use SF\Storage\ConfigRegister;
/**
 * Controller
 * 
 * system Controller
 * 
 * @author wuqj <sunsky303@gmail.com>
 * @copyright Copyright 2012-2013
 * @link https://mini-php-framework.googlecode.com/
 */
class Controller {
	public  $view;
	protected $_controller;
	protected $_action;
	protected $_controllerDir;
	protected $_config;
	/**
	 * @param string $controller
	 * @param string $action
	 */
	function __construct($controller, $action) {
		$this->_config = \SF\Storage\ConfigRegister::getConfig();
		$this->_controller = $controller;
		$this->_action = $action;
		$this->_controllerDir = $this->_config['router']['controllerDir'];
		$this->view = new \SF\View\View($this->_controller, $this->_action, $this->_config['router']['viewDir']);
	}
	
	public function getView(){
		return $this->view;
	}
	public function before(){
	}
	
	public function after(){
	}

	
}

?>