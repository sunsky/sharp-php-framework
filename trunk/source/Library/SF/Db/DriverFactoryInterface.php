<?php
/**
 * Shark Framework
 *
 * @author wuqj <sunsky303@gmail.com>
 * @copyright Copyright 2012-2013
 * @link https://mini-php-framework.googlecode.com/
 * @version $Id$
 */

namespace SF\Db;


interface DriverFactoryInterface
{

	/**
	 * @return \SF\Db\Adapter\AdapterInterface
	*/
	public function getDriver($driverType, $options = null);

}
