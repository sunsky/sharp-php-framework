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
namespace Demo;

use System\Storage\ConfigRegister;
use System\Storage\CacheRegister;
/**
 * 启动
 *
 * 启动时运行
 *
 * @author wuqj <sunsky303@gmail.com>
 * @copyright Copyright 2012-2013
 * @link https://mini-php-framework.googlecode.com/
 */
class Bootstrap extends \System\Mvc\Bootstrap {
	protected function _initRegister() {
		ConfigRegister::setConfig ( $this->_config );
	}
	protected function _initCache() {
		CacheRegister::setCache ( new Modules\Cache\HtmlCache ( $this->_config ['cache'] ['cacheDir'], $this->_config ['cache'] ['cachePrefix'], $this->_config ['cache'] ['cacheExpire'], $this->_config ['cache'] ['cacheMode'], '.html' ) );
	}
}

?>