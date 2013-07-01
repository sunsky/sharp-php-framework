<?php
// Define timezone
date_default_timezone_set ( 'Asia/Shanghai' );

defined ( 'ROOT_PATH' ) || define ( 'ROOT_PATH', realpath(APP_PATH . '/../../') );

defined ( 'APP_DIR' ) || define ( 'APP_DIR',  basename(APP_PATH));

// Ensure library/ is on include_path
set_include_path ( implode ( PATH_SEPARATOR, array (
	ROOT_PATH . '/Library',
	dirname(APP_PATH),
	get_include_path ()
) ) );