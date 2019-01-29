<?php

use Multiple\Frontend\Module as FrontendModule;
use Multiple\Backend\Module as BackendModule;

// Register the installed modules
$application->registerModules([
	'frontend' => [
		'className' => FrontendModule::class,
		'path'      => APP_PATH . '/frontend/Module.php'
	],
	'backend'  => [
		'className' => BackendModule::class,
		'path'      => APP_PATH . '/backend/Module.php'
	]
]);

?>