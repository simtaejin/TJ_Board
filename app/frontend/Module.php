<?php

namespace Multiple\Frontend;


use Phalcon\Loader;
use Phalcon\Mvc\View;
use Phalcon\Mvc\View\Engine\Php as PhpEngine;
use Phalcon\Mvc\View\Engine\Volt as VoltEngine;
use Phalcon\DiInterface;
use Phalcon\Events\Manager;
use Phalcon\Mvc\Dispatcher;
use Phalcon\Mvc\ModuleDefinitionInterface;


class Module implements ModuleDefinitionInterface
{
    /**
     * Registers the module auto-loader
     *
     * @param DiInterface $di
     */
    public function registerAutoloaders(DiInterface $di = null)
    {
        $loader = new Loader();

        $loader->registerNamespaces(
            [
                'Multiple\Frontend\Controllers' => APP_PATH . '/frontend/controllers/',
                'Multiple\Frontend\Models' => APP_PATH . '/frontend/models/',
            ]
        );

        $loader->register();
    }

    /**
     * Registers services related to the module
     *
     * @param DiInterface $di
     */

    public function registerServices(DiInterface $di)
    {
        // Registering a dispatcher
        $di->set('dispatcher', function () {
            $dispatcher = new Dispatcher();

            $eventManager = new Manager();

            // Attach a event listener to the dispatcher (if any)
            // For example:
            // $eventManager->attach('dispatch', new \My\Awesome\Acl('frontend'));

            $dispatcher->setEventsManager($eventManager);
            $dispatcher->setDefaultNamespace('Multiple\Frontend\Controllers\\');
            return $dispatcher;
        });

		$di->setShared('view', function () {
			$config = $this->getConfig();

			$view = new View();
			$view->setDI($this);
			$view->setViewsDir(APP_PATH . '/frontend/views/');

			$view->registerEngines([
				'.volt' => function ($view) {
					$config = $this->getConfig();

					$volt = new VoltEngine($view, $this);

					$volt->setOptions([
						'compiledPath' => $config->application->cacheDir,
						'compiledSeparator' => '_'
					]);

					return $volt;
				},
				'.phtml' => PhpEngine::class
			]);

			return $view;
		});

	}
	/*
    public function registerServices(DiInterface $di)
    {
        // Registering a dispatcher
        $di->set('dispatcher', function () {
            $dispatcher = new Dispatcher();

            $eventManager = new Manager();

            // Attach a event listener to the dispatcher (if any)
            // For example:
            // $eventManager->attach('dispatch', new \My\Awesome\Acl('frontend'));

            $dispatcher->setEventsManager($eventManager);
            $dispatcher->setDefaultNamespace('Multiple\Frontend\Controllers\\');
            return $dispatcher;
        });

        // Registering the view component
        $di->set('view', function () {
            $view = new View();
            $view->setViewsDir(APP_PATH . '/frontend/views/');
            return $view;
        });

        $di->set('db', function () {
            return new Mysql(
                [
                    "host" => "localhost",
                    "username" => "root",
                    "password" => "secret",
                    "dbname" => "invo"
                ]
            );
        });
    }
	*/
}

?>