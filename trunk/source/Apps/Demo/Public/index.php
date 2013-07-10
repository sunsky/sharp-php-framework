<?php
/**
 * Shark Framework
 *
 * @author wuqj <sunsky303@gmail.com>
 * @copyright Copyright 2012-2013
 * @link https://mini-php-framework.googlecode.com/
 * @version $Id$
 */

/**
 * 入口文件
 *
 * @author wuqj
 */
// Define path to application directory
defined ( 'APP_PATH' ) || define ( 'APP_PATH', dirname(__DIR__));

$__CONF__ = require APP_PATH  . '/Config/demo.inc.php';
require 'SF/Mvc/Application.php';

\SF\Mvc\Application::run(APP_ENV, $__CONF__);

