<?php

namespace SF\Db;
use SF\Db\DriverFactoryInterface;
use SF\Db\Adapter\Adapter;
/**
 * Shark Framework
 *
 * @author wuqj <sunsky303@gmail.com>
 * @copyright Copyright 2012-2013
 * @link https://mini-php-framework.googlecode.com/
 * @version $Id$
 */

class DriverFactory implements DriverFactoryInterface {

	
	protected $_driver = '';
	
	/**
	 * @param string $driverType
	 * @param mix $options db config
	 * @return SF\Db\Connection\DbInterface\DbInterface
	 */
	public function getDriver($driverType = self::DRIVER_TYPE_MYSQLI, $options = null){
		return new Adapter();
	}
	
}