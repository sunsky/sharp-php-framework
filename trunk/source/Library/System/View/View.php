<?php
/**
 * Shark Framework
 *
 * @author wuqj <sunsky303@gmail.com>
 * @category System
 * @package System\Url
 * @copyright Copyright 2012-2013
 * @link https://mini-php-framework.googlecode.com/
 * @version $Id: View.php 17 2013-06-30 09:05:47Z sunsky303 $
 */
namespace System\View;
use System\View\Exception;
use System\Storage\Register;
/**
 * view
 * 
 * base view
 * 
 * @author wuqj <sunsky303@gmail.com>
 * @copyright Copyright 2012-2013
 * @link https://mini-php-framework.googlecode.com/
 */
class View {
	protected $_controller;
	protected $_action;
	protected $_viewPath;
	protected $_viewDir;	
	protected $_layout;
	public $content;
	/**
	 * @param string $controller
	 * @param string $action
	 * @param string $viewDir
	 * @param object $assignedData
	 */
	function __construct($controller, $action, $viewDir) {
		$this->_controller = $controller;
		$this->_action = $action;
		$this->_viewDir = $viewDir;
		$this->_viewPath = $this->_getViewPath();
	}
	
	public function assign($key,$value){
		if(!$key) throw new  Exception\InvalidArgsException('param key can not be empty!');
		$this->$key = $value;
	}

	public function run(){
		$fileId = rtrim(str_replace(array(APP_PATH.'/','/'), array('','_'), $this->_viewPath), '.php');
		$cache = Register::getCache();
		if($cache && null == $this->_layout){
			if($cache->hasCache($fileId)){
				echo $cache->get($fileId);
				return;
			}	
		}
		ob_start();
		try{
			require $this->_viewPath;
		}catch (\System\Event\Exception\Exception $ex){
			ob_end_clean();
			throw new Exception\ParseFailedException('parse failed!', $ex->getCode(), $ex);
		}
		
		$output =	ob_get_contents();
		ob_end_clean();
		
		if($cache){
			$cache->set($fileId, $output);
		}
		
		if(null != $this->_layout) {
			$this->content = $output;
			$this->_layout->run();
		}else{
			echo $output;
		}
	}
	
	public function setLayout($layoutFile){
		if(!isset($this->_config['router']['layoutDirPath'])) $this->_config['router']['layoutDirPath'] = APP_PATH . '/Layouts';
		$layoutPath = $this->_config['router']['layoutDirPath'] . '/' . $layoutFile;
		$this->_layout = new \System\View\Helper\Layout($layoutPath, $this);
	}
		
	public function _getViewPath(){
		return APP_PATH . DIRECTORY_SEPARATOR . $this->_viewDir . DIRECTORY_SEPARATOR . ucfirst($this->_controller) . DIRECTORY_SEPARATOR . ucfirst($this->_action) .'.php';
	}
	public function getViewPath(){
		return $this->_viewPath;
	}
	
}

?>