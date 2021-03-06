<?php

namespace Multiple\Backend\Controllers;

use Phalcon\Mvc\Controller;

class ControllerBase extends Controller
{
    public $BaseBoardDate;

    public function initialize()
    {
		$this->view->setTemplateAfter('backend');

        $this->view->setVar("userId", $this->session->get("id"));
        
        $BaseBoard = new \Multiple\Backend\Models\SetupBoard();
                
        $BaseBoard->setSource("board");
        $BaseBoardDate = $BaseBoard->find(['order' =>'idx desc']);
        $this->BaseBoardDate = $BaseBoardDate;
        $this->view->setVar("bbd", $this->BaseBoardDate);
        $this->view->setVar("context_prefix", $_SERVER['CONTEXT_PREFIX']);
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
