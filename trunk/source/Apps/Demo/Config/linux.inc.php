<?php
require_once 'common.inc.php';
	

// mix global configuration
return array (
		'version' => '2.0 Beta',
		'app_name' => '精简PHP框架(linux php-fpm(php5.4) nginx mysqli)',
		'router'	=> array(
			'controllerDir'	=> 'Controllers',
			'viewDir'	=> 'Views',
			'controllerPrefix'	=> '_c',
			'actionPrefix' => '_a',
			'defaultController'	=> 'default',
			'defaultAction' => 'index',
			'controllerClassSuffix'	=> 'Controller',
			'actionClassSuffix'	=>'Action',
			'layoutDirPath'	=>  APPLICATION_PATH . '/Layouts',
		),
		'exception'	=>	array(
				'exceptionHandler'	=>	'Demo\Modules\Event\ExceptionHandler',
				'eventHandler'		=>	'Demo\Modules\Event\Handler',
		),
		'log'		=>	array(
				'logPath'			=> 	'/var/tmp/'.APPLICATION_DIR.'.log',
				'mailAddr'			=> 	'sunsky303@qq.com',
				
		),
		'cache'		=>	array(
				'cacheDir'			=> 	ROOT_PATH . '/Data/Cache/'.APPLICATION_DIR,
				'cachePrefix'		=> 	'html_',
				'cacheExpire'			=> 	-1,//second
				'cacheMode'			=> 	3,
				
		),
);