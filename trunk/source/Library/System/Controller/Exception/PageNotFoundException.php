<?php
/**
 * Shark Framework
 *
 * @author wuqj <sunsky303@gmail.com>
 * @category System
 * @package System\Url
 * @copyright Copyright 2012-2013
 * @link https://mini-php-framework.googlecode.com/
 * @version $Id$
 */
namespace System\Controller\Exception;

/**
 *
 * @author wuqj
 *        
 */
class PageNotFoundException extends  \System\InvalidClassException {
// 	public function __construct($message = null, $code = null, $previous = null){
// 		$controller = 'error';$action = 'pageNotFound';
// 		$router = \System\Url\Router::getInstance();
// 		$router->dispatch($controller,$action, func_get_args());die;
// 		\System\Url\Http\Request\Request::redirect('/error/pageNotFound');
// 		exit(-1);
// 	}
	
}

?>