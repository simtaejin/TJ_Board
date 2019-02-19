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

$router->add("/dashboard/login", ['module'=>'backend','controller'=>'loginout','action'=>'login',]);
$router->add("/dashboard/dologin", ['module'=>'backend','controller'=>'loginout','action'=>'dologin',]);
$router->add("/dashboard/dologout", ['module'=>'backend','controller'=>'loginout','action'=>'dologout',]);

/**
 * setup/board 메뉴
 */
$router->add('/dashboard/setup/board/{page}', [
    'module'     => 'backend',
    'controller' => 'setup',
    'action' => 'board'
]);

$router->add('/dashboard/setup/board/create', [
    'module'     => 'backend',
    'controller' => 'setup',
    'action' => 'board_create'
]);

$router->add('/dashboard/setup/board/update/{idx}', [
    'module'     => 'backend',
    'controller' => 'setup',
    'action' => 'board_update'
]);

$router->add('/dashboard/setup/board/delete/{idx}', [
    'module'     => 'backend',
    'controller' => 'setup',
    'action' => 'board_delete'
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

/**
 * board 메뉴
 */
$router->add('/dashboard/board/{board_id}/{page}', [
	'module'     => 'backend',
    'controller' => 'board',
    'action'	 => 'index'
]);

$router->add('/dashboard/board/{board_id}/create/', [
	'module'     => 'backend',
    'controller' => 'board',
    'action'	 => 'create'
]);

$router->add('/dashboard/board/{board_id}/select/{idx}', [
	'module'     => 'backend',
    'controller' => 'board',
    'action'	 => 'select'
]);

$router->add('/dashboard/board/{board_id}/update/{idx}', [
	'module'     => 'backend',
    'controller' => 'board',
    'action'	 => 'update'
]);

$router->add('/dashboard/board/{board_id}/delete/{idx}', [
	'module'     => 'backend',
    'controller' => 'board',
    'action'	 => 'delete'
]);

$router->add('/dashboard/board/{board_id}/replycreate/{idx}', [
	'module'     => 'backend',
    'controller' => 'board',
    'action'	 => 'replycreate'
]);

$router->add('/dashboard/board/{board_id}/commnetcreate/{idx}', [
	'module'     => 'backend',
    'controller' => 'board',
    'action'	 => 'commnetcreate'
]);

$router->add('/dashboard/board/{board_id}/commnetupdate/{idx}', [
	'module'     => 'backend',
    'controller' => 'board',
    'action'	 => 'commnetupdate'
]);

$router->add('/dashboard/board/{board_id}/commentdelete/{idx}', [
	'module'     => 'backend',
    'controller' => 'board',
    'action'	 => 'commentdelete'
]);

$router->handle();
