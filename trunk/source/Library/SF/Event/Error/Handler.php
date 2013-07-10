<?php

/**
 * error handler
 *
 * @author wuqj <sunsky303@gmail.com>
 * @category SF
 * @package SF\Exception
 * @copyright Copyright 2012-2013
 * @link https://mini-php-framework.googlecode.com/
 * @version $Id$
 */
namespace SF\Event\Error;

use SF\Event as Event;
use SF\Storage\ConfigRegister;

/**
 * exception
 *
 * @author wuqj <sunsky303@gmail.com>
 * @copyright Copyright 2012-2013
 * @link https://mini-php-framework.googlecode.com/
 */
class Handler implements Event\EventInterface, Event\ListenerInterface {
	protected $_userErrorHandler = 'userErrorHandler';
	// /**
	// * @access protected
	// * @var array
	// */
	protected $_shutdownHandler = 'shutdownHandler';
	/**
	 *
	 * @var does throw an exception
	 */
// 	protected $_hasException = false;
	const ERR_TYPE_EXCEPTION = 'EXCEPTION';
	
	/**
	 *
	 * @access protected
	 * @var array
	 */
	protected $_msgStack = array ();
	/**
	 *
	 * @var core fatal error
	 */
	const ERROR_TYPE_FATAL = 1;
	/**
	 *
	 * @var user custom fatal error
	 */
	// const ERROR_TYPE_USR_FATAL = 2;
	/**
	 *
	 * @var warning
	 */
	const ERROR_TYPE_WARNING = 3;
	/**
	 *
	 * @var notice
	 */
	const ERROR_TYPE_NOTICE = 4;
	/**
	 *
	 * @var deprecated
	 */
	const ERROR_TYPE_DEPRECATED = 5;
	/**
	 *
	 * @var suggestion
	 */
	const ERROR_TYPE_SUGGESTION = 6;
	/**
	 *
	 * @var user custom type
	 */
	const ERROR_TYPE_CUSTOM = 20;
	protected $_exceptionHandler = null;
	public function __construct(Event\Exception\Handler &$exceptionHandler = null) {
		$this->_exceptionHandler = $exceptionHandler;
	}
	public static function getErrTypeName($errno) {
		switch ($errno) {
			case self::ERROR_TYPE_FATAL :
				$type = 'FATAL';
				break;
			case self::ERROR_TYPE_WARNING :
				$type = 'WARNING';
				break;
			case self::ERROR_TYPE_NOTICE :
				$type = 'NOTICE';
				break;
			case self::ERROR_TYPE_SUGGESTION :
				$type = 'SUGGESTION';
				break;
			case self::ERROR_TYPE_DEPRECATED :
				$type = 'DEPRECATED';
				break;
			default :
				$type = 'CUSTOM';
		}
		return $type;
	}
	public function addEventListener() {
		set_error_handler ( array (
				$this,
				$this->_userErrorHandler 
		) );
		register_shutdown_function ( array (
				$this,
				$this->_shutdownHandler 
		) );
	}
	
	/**
	 *
	 * @param integer $errno        	
	 * @param string $errstr        	
	 * @param integer $errfile        	
	 * @param integer $errline        	
	 * @param array $errcontext
	 *        	:track
	 * @return bool
	 */
	public function userErrorHandler($errno, $errstr, $errfile, $errline, $errcontext = array()) {
		// print_r(func_get_args());
		$this->_msgStack [] = $this->_errorFormat ( $errno, $errstr, $errfile, $errline, $errcontext );
		return true;
	}
	/**
	 *
	 * @param Exception e        	
	 * @return bool
	 */
	public function userExceptionHandler(\Exception $e) {
		$this->_exceptionFormat ( $e );
		return true;
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
		$this->eventPrint ();
		$this->eventLog ();
	}
	public function eventPrint() {
		$stack = array_reverse ( $this->_msgStack );
		if (! $stack)
			return;
		$table = '<table width="100%"><tr style="background:#F4A460"><th>type</th><th>errno</th><th>errstr</th><th>errline</th><th>errfile</th></tr>';
		foreach ( $stack as $k => $v ) {
			if (isset ( $v ['type'] ) && is_array ( $v ['type'] )) { // has exception track
						$table .= '<tr style="background:#E6E6FA"><td>' . implode('<br/>', $v ['type']) . '</td><td>' . implode('<br/>', $v ['errno']) . '</td><td>' .  implode('<br/>', $v ['errstr']) . '</td><td>' .  implode('<br/>', $v ['errline']). '</td><td>' .  implode('<br/>', $v ['errfile']). '</td></tr>';
			} else {
				$table .= '<tr style="background:#E6E6FA"><td>' . $v ['type'] . '</td><td>' . $v ['errno'] . '</td><td>' . $v ['errstr'] . '</td><td>' . $v ['errline'] . '</td><td>' . $v ['errfile'] . '</td></tr>';
			}
		}
		$table .= '</table>';
		echo $table;
	}
	public function eventLog() {
		$config = ConfigRegister::getConfig ();
		if (! isset ( $config ['log'] ))
			return;
		$logPath = isset ( $config ['log'] ['logPath'] ) ? $config ['log'] ['logPath'] : '/var/log/' . APP_DIR . '.log';
		$stack = array_reverse ( $this->_msgStack );
		if (! $stack)
			return;
		$logStr = '';
		foreach ( $stack as $k => $v ) {
			array_unshift ( $v, '<b>$s</b> [%d] %s on line <b>%s</b> in file <b>%s</b><br/>' );
			if(is_array($v)) continue;
			$logStr .= call_user_func ( 'sprintf', $v );
		}
		$logStr .= PHP_EOL;
		error_log ( $logStr, 3, $logPath );
	}
	
	/**
	 *
	 * @param integer $errno        	
	 * @param string $errstr        	
	 * @param integer $errfile        	
	 * @param integer $errline        	
	 * @param array $errcontext
	 *        	:track
	 * @return array string
	 */
	protected function _errorFormat($errno, $errstr, $errfile, $errline, $errcontext = array()) {
		$errfile = str_replace ( ROOT_PATH, '', $errfile );
		$errLvl = error_reporting ();
		
		$varStr = '';
		if (! empty ( $errcontext )) {
			if (isset ( $errcontext ['exception'] )) { // throw exception error
				return $this->_exceptionFormat ( $errcontext ['exception'] );
			} else if (is_array ( $errcontext )) {
				$errcontext = self::filterArgs ( $errcontext );
				$varStr = '<pre>' . print_r ( $errcontext, true ) . '</pre>';
			}
		}
		switch ($errno) {
			case E_USER_ERROR :
			case E_ERROR :
			case E_CORE_ERROR :
			case E_COMPILE_ERROR :
			case E_PARSE :
				$errorType = self::ERROR_TYPE_FATAL;
				break;
			case E_USER_WARNING :
			case E_WARNING :
			case E_CORE_WARNING :
			case E_COMPILE_WARNING :
			case E_RECOVERABLE_ERROR :
				if (! $errLvl)
					return '';
				$errorType = self::ERROR_TYPE_WARNING;
				break;
			
			case E_USER_NOTICE :
			case E_NOTICE :
				if (! $errLvl)
					return '';
				$errorType = self::ERROR_TYPE_NOTICE;
				break;
			case E_STRICT :
				if (! $errLvl)
					return '';
				$errorType = self::ERROR_TYPE_SUGGESTION;
				break;
			case E_DEPRECATED :
			case E_USER_DEPRECATED :
				if (! $errLvl)
					return '';
				$errorType = self::ERROR_TYPE_DEPRECATED;
				break;
			default :
				if (! $errLvl)
					return '';
				$errorType = self::ERROR_TYPE_CUSTOM;
		}
		$msg = array (
				'type' => self::getErrTypeName ( $errorType ),
				'errno' => $errno,
				'errstr' => $errstr . $varStr,
				'errline' => $errline,
				'errfile' => $errfile 
		);
		
		return $msg;
	}
	
	/**
	 *
	 * @param \Exception $exception        	
	 * @return array(string,...)
	 */
	protected function _exceptionFormat(\Exception $e) {
		if (! $e)
			return '';
		$tracks = array ();
		do {
			$tracks [] = $e;
		} while ( ($e = $e->getPrevious ()) != null );
		$errType = array ();
		$code = array ();
		$file = array ();
		$line = array ();
		$msg = array ();
		$tracks = array_reverse($tracks);
		foreach ( $tracks as $k => $e ) {
			$errType [] = self::ERR_TYPE_EXCEPTION;
			$code [] = $e->getCode ();
			$file [] = self::getRelativePath ( $e->getFile () );
			$line [] = $e->getLine ();
			$msg [] = $e->getMessage ();
		}
		$this->_msgStack []= array (
				'type' => $errType,
				'errno' => $code,
				'errstr' => $msg,
				'errline' => $line,
				'errfile' => $file 
		);
		
		
	}
	
	/**
	 * get Relative Path
	 *
	 * @param string $path        	
	 */
	public static function getRelativePath($path) {
		return str_replace ( ROOT_PATH, '', $path );
	}
	
	/**
	 *
	 * @param array $args        	
	 * @return array 一维数组
	 */
	public static function filterArgs($args) {
		if (! $args)
			return array ();
		$return = array ();
		foreach ( $args as $arg ) {
			if (is_array ( $arg ))
				$arg = 'Array';
			else if (is_object ( $arg )) {
				$arg = get_class ( $arg );
			}
			$return [] = $arg;
		}
		return $return;
	}
	
	/**
	 *
	 * @param
	 *        	integer type
	 * @return string number
	 */
	public static function getFriendlyErrorType($type) {
		switch ($type) {
			case E_ERROR : // 1 //
				return 'E_ERROR';
			case E_WARNING : // 2 //
				return 'E_WARNING';
			case E_PARSE : // 4 //
				return 'E_PARSE';
			case E_NOTICE : // 8 //
				return 'E_NOTICE';
			case E_CORE_ERROR : // 16 //
				return 'E_CORE_ERROR';
			case E_CORE_WARNING : // 32 //
				return 'E_CORE_WARNING';
			case E_CORE_ERROR : // 64 //
				return 'E_COMPILE_ERROR';
			case E_CORE_WARNING : // 128 //
				return 'E_COMPILE_WARNING';
			case E_USER_ERROR : // 256 //
				return 'E_USER_ERROR';
			case E_USER_WARNING : // 512 //
				return 'E_USER_WARNING';
			case E_USER_NOTICE : // 1024 //
				return 'E_USER_NOTICE';
			case E_STRICT : // 2048 //
				return 'E_STRICT';
			case E_RECOVERABLE_ERROR : // 4096 //
				return 'E_RECOVERABLE_ERROR';
			case E_DEPRECATED : // 8192 //
				return 'E_DEPRECATED';
			case E_USER_DEPRECATED : // 16384 //
				return 'E_USER_DEPRECATED';
			case E_ALL ^ E_STRICT : //
				return 'E_ALL^E_STRICT';
			case E_ALL : // 30719
				return 'E_ALL';
			default :
				return 'UNKNOWN';
		}
	}
}


