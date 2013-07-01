<?php
/**
 * mini-php-framework
 * 
 * @author wuqj <sunsky303@gmail.com>
 * @version $Id: index.php 17 2013-06-30 09:05:47Z sunsky303 $
 * @link https://mini-php-framework.googlecode.com/
 * @copyright Copyright &copy; 2012-2013
 * @package system
 */

/**
 * 入口文件
 *
 * @author wuqj
 */
// Define path to application directory
defined ( 'APP_PATH' ) || define ( 'APP_PATH', dirname(__DIR__));

$__CONF__ = require APP_PATH  . '/Config/app.inc.php';
require 'System/Application.php';

System\Application::run(APP_ENV, $__CONF__);

