<?php

$router = $di->getRouter();

// Define your routes here

$router->setDefaultModule("frontend");

$router->add('/frontend', [
	'module'     => 'frontend',
	'controller' => 'index',
	'action'     => 'index',
]);

$router->add("/backend", [
	'module'     => 'backend',
	'controller' => 'index',
	'action'     => 'index',
]);

$router->handle();
