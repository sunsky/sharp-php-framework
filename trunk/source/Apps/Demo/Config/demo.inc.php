<?php
require_once 'common.inc.php';

const VERSION = '2.0.1 Beta';
const APP_NAME = 'Sharp PHP Framework';

const APP_ENV_DEVELOPING = 1;
const APP_ENV_TESTING = 2;
const APP_ENV_PRODUCTION = 3;

define ( 'APP_ENV', APP_ENV_DEVELOPING );
switch (APP_ENV){
	case APP_ENV_DEVELOPING:
		error_reporting ( E_ALL | E_STRICT );
		break;
	case APP_ENV_TESTING:
		error_reporting ( E_ALL ^ E_STRICT);
		break;
	case APP_ENV_PRODUCTION:
		error_reporting ( 0 );
		break;
}

// mix global configuration
return array (
		'router'	=> array(
			'controllerDir'	=> 'Controllers',
			'viewDir'	=> 'Views',
			'controllerPrefix'	=> '_c',
			'actionPrefix' => '_a',
			'defaultController'	=> 'default',
			'defaultAction' => 'index',
			'controllerClassSuffix'	=> 'Controller',
			'actionClassSuffix'	=>'Action',
			'layoutDirPath'	=>  APP_PATH . '/Layouts',
		),
		'exception'	=>	array(
				'exceptionHandler'	=>	'Demo\Modules\Event\ExceptionHandler',
				'eventHandler'		=>	'Demo\Modules\Event\Handler',
		),
		'log'		=>	array(
				'logPath'			=> 	'/var/tmp/'.APP_DIR.'.log',
				'mailAddr'			=> 	'sunsky303@qq.com',
		),
		'cache'		=>	array(
				'cacheDir'			=> 	ROOT_PATH . '/Data/Cache/'.APP_DIR,
				'cachePrefix'		=> 	'html_',
				'cacheExpire'			=> 	1,//seconds
				'cacheMode'			=> 	3,
				
		),
);