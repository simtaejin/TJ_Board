<?php

$loader = new Phalcon\Loader();

/**
 * We're a registering a set of directories taken from the configuration file
 */
 /*
$loader->registerDirs(
    [
        $config->application->controllersDir,
        $config->application->modelsDir
    ]
)->register();
*/

$loader->registerNamespaces(
    [
        'Multiple\Backend\Controllers' => APP_PATH . '/backend/controllers/',
        'Multiple\Backend\Models' => APP_PATH . '/backend/models/',
    ]
)->register();

$loader->registerClasses(
    [
        'Plugin\ComponentsPlugin' => $config->application['pluginsDir'].'ComponentsPlugin.php',
        'Plugin\SecurityPlugin' => $config->application['pluginsDir'].'SecurityPlugin.php'
    ]
)->register();