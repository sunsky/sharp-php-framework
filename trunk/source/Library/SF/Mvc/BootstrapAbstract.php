<?php
/**
 * 启动类
 *
 * @author wuqj <sunsky303@gmail.com>
 * @category SF
 * @package SF\Application
 * @copyright Copyright 2012-2013
 * @link https://mini-php-framework.googlecode.com/
 * @version $Id: BootstrapAbstract.php 13 2013-05-15 10:55:20Z sunsky303 $
 */
namespace SF\Mvc;

/**
 * 启动类
 *
 * @author wuqj
 *        
 */
abstract class BootstrapAbstract {
	public static $filename;
	protected $_autoExecuteMethodPrefix;
	
	abstract protected function _methodsRun();
	
}

?>