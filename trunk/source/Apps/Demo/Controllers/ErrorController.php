<?php
namespace Demo\Controllers;
/**
 * @author wuqj
 *        
 */
class ErrorController extends  \SF\Controller\Controller {
	/**
	 */
	function __construct($controller, $action) {
		parent::__construct($controller, $action);
		$this->view->setLayout('Error/Error.php');
	}
	/**
	 * index Action
	 */
	function parseFailedAction(){
		header('HTTP/1.1 500 Internal Server Error');
		$this->view->title = 'Internal Server Error!';
		$this->view->assign('errorCode', 500);
		$this->view->assign('errorType', '服务器内部错误!');
		$this->view->assign('errorDetail', '<pre>'.print_r(func_get_args(), true).'</pre>');
		
	}
	function pageNotFoundAction(){
		header('HTTP/1.1 404 Not Found');
		$this->view->title = 'Page Not Found!';
		$this->view->assign('errorCode', 404);
		$this->view->assign('errorType', '找不到页面!');
		$this->view->assign('errorDetail', '<pre>'.print_r(func_get_args(), true).'</pre>');
	}
}

