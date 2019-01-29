<?php

namespace Multiple\Backend\Controllers;

use Phalcon\Mvc\Controller;

class ControllerBase extends Controller
{

    public function initialize()
    {
		$this->view->setTemplateAfter('backend');
    }

    public function indexAction()
    {

    }

    public function beforeExecuteRoute()
    {

    }

    public function afterExecuteRoute()
    {

    }
}
