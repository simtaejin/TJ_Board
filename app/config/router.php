<?php

$router = $di->getRouter();

// Define your routes here

$router->setDefaultModule("frontend");

$router->add('/', [
	'module'     => 'frontend',
	'controller' => 'index',
	'action'     => 'index',
]);

$router->add("/dashboard", [
	'module'     => 'backend',
	'controller' => 'index',
	'action'     => 'index',
]);

$router->handle();
