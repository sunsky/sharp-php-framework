<?php

/**
 * 异常类
 *
 * @author wuqj <sunsky303@gmail.com>
 * @category System
 * @package System\Exception
 * @copyright Copyright 2012-2013
 * @link https://mini-php-framework.googlecode.com/
 * @version $Id$
 */
namespace Demo\Modules\Event;
use \System\Event\Error as ERR;
/**
 * exception
 *
 * @author wuqj <sunsky303@gmail.com>
 * @copyright Copyright 2012-2013
 * @link https://mini-php-framework.googlecode.com/
 */
class Handler extends \System\Event\Error\Handler {
	public function eventProccess() {
		end($this->_msgStack);
		$lastErr = current($this->_msgStack);
		
		reset($this->_msgStack);
		if (0 == error_reporting () || APP_ENV == APP_ENV_PRODUCTION) {
			$errType = isset($lastErr['type']) && is_array($lastErr['type']) ? $lastErr['type'][0] : $lastErr['type'];
			if($errType == in_array($errType, array(ERR\Handler::getErrTypeName(ERR\Handler::ERROR_TYPE_FATAL), ERR\Handler::ERR_TYPE_EXCEPTION ))){
				$config = \System\Application\Register::getConfig ();
				\System\Url\Http\Request\Request::redirect ( '?' . http_build_query ( array (
						$config ['router'] ['controllerPrefix'] => 'error',
						$config ['router'] ['actionPrefix'] => 'parseFailed',
						'content' => $errType,
				) ) );
				exit ( - 1 );
			}
		} else {
			parent::eventPrint ();
		}
	}
	
	public function shutdownHandler() {
		if (($e = error_get_last ()) !== false && is_array ( $e )) {
			call_user_func_array ( array (
			$this,
			$this->_userErrorHandler
			), $e );
		}
		if (!empty($this->_exceptionHandler) && ($e = $this->_exceptionHandler->exception) != null) {
			$this->userExceptionHandler ( $e );
		}
		
		$this->eventLog ();
		$this->eventProccess ();
	}
}

