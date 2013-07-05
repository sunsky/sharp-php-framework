<?php
/**
 * Shark-Framework
 *
 * @author wuqj <sunsky303@gmail.com>
 * @category System
 * @package System\Router
 * @copyright Copyright 2012-2013
 * @link https://mini-php-framework.googlecode.com/
 * @version $Id$
 */

namespace System\View\Helper;
use System\View\Exception;
use System\Storage\Register;
use System\View\View;
/**
 * 布局类
 * @author wuqj <sunsky303@gmail.com>
 */
class Layout {
	protected $_layoutFile = '';
	protected $view;
	/**
	 * @var $dir layout dir
	 */
	public  $dir;
	/**
	 * @param string $layoutFile path
	 * @param \System\View\View $view path
	 */
	public function __construct($layoutFile,  View $view){
		$this->view = $view;
		$this->_layoutFile = $layoutFile;
		$config = Register::getConfig();
		$this->dir = $config['router']['layoutDirPath'];
	}
	
	public function run(){
		$fileId = 'layout_'. rtrim(str_replace(array(APP_PATH.'/','/'), array('','_'), $this->view->getViewPath()), '.php');
		$cache = Register::getCache();
		
		if($cache){
			if($cache->hasCache($fileId)){
				echo $cache->get($fileId);
				return;
			}
		}
		require $this->_layoutFile;
		$output =	ob_get_contents();
		ob_end_clean();
		
		if($cache){
			$cache->set($fileId, $output);
		}
		echo $output;
		
	}
	
	/**
	 * @param string $filename
	 */
	public function importTemplate($filename){
		require $filename;
	}
}

?>