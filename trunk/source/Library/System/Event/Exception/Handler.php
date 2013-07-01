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
namespace System\Event\Exception;

use System\Event as Event;
/**
 * exception
 *
 * @author wuqj <sunsky303@gmail.com>
 * @copyright Copyright 2012-2013
 * @link https://mini-php-framework.googlecode.com/
 */
class Handler implements Event\ListenerInterface{
	protected $_exceptionHandler = 'exceptionHandler';
	public $exception = null;
	/**
	 * @access protected
	 * @var array
	 */
	protected $_msgStack = array ();
	public function addEventListener() {
		set_exception_handler ( array (
				$this,
				$this->_exceptionHandler 
		) );
	}
	/**
	 * @param Exception $exception
	 */
	public function exceptionHandler(\Exception $e) {
		$this->exception = $e;
	}

}