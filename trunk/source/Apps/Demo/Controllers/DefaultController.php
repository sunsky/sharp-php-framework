<?php
namespace Demo\Controllers;
use SF\Storage\Register;
/**
 * @author wuqj
 *        
 */
class DefaultController extends  \SF\Controller\Controller {
	/**
	 */
	function __construct($controller, $action) {
		parent::__construct($controller, $action);
		$this->view->setLayout('BeforeLogin/Main.php');
	}
	/**
	 * index Action
	 */
	function indexAction(){
		$this->view->title = 'Hello world!';		
		$this->view->assign('name', 'Hello world!--页面');
	}
	/**
	 * show Action
	 */
	function showAction(){

	}
	
	
}
