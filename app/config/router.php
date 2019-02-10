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

$router->add("/dashboard/login", [
	'module'     => 'backend',
	'controller' => 'loginout',
	'action'     => 'login',
]);

$router->add("/dashboard/dologin", [
	'module'     => 'backend',
	'controller' => 'loginout',
	'action'     => 'dologin',
]);

/**
 * member 메뉴
 */
$router->add("/dashboard/member/", [
	'module'     => 'backend',
	'controller' => 'member',
	'action'     => 'index',
]);

$router->add("/dashboard/member/select/{id}", [
	'module'     => 'backend',
	'controller' => 'member',
	'action'     => 'select',
]);

$router->add("/dashboard/member/create", [
	'module'     => 'backend',
	'controller' => 'member',
	'action'     => 'create',
]);

$router->add("/dashboard/member/update/{id}", [
	'module'     => 'backend',
	'controller' => 'member',
	'action'     => 'update',
]);

$router->add("/dashboard/member/delete/{id}", [
	'module'     => 'backend',
	'controller' => 'member',
	'action'     => 'delete',
]);

$router->handle();
