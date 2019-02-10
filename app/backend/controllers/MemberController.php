<?php

namespace Multiple\Backend\Controllers;

use Phalcon\Mvc\Model\Criteria;
use Phalcon\Paginator\Adapter\Model as Paginator;

class MemberController extends ControllerBase
{
    public function initialize()
    {
        parent::initialize();
       $this->view->setVar("userId", $this->session->get("id"));
		$this->view->setVar("userId", "test");
    }

    public function indexAction()
    {
        $this->persistent->parameters = null;

        if (!$this->request->getQuery("page", "int")) {
            $numberPage = 1;
        } else {
            $numberPage = $this->request->getQuery("page", "int");
        }

        $parameters["order"] = "idx desc";
        $member = \Multiple\Backend\Models\Member::find($parameters);

        $paginator = new Paginator([
            'data' => $member,
            'limit' => 10,
            'page' => $numberPage
        ]);

        $this->view->page = $paginator->getPaginate();		
    }

    public function selectAction($id) {
        $member = \Multiple\Backend\Models\Member::findFirstById($id);

        $this->tag->setDefault("id", $member->id);
        $this->view->setVar("id", $member->id);
        $this->view->setVar("email", $member->email);
    }

    public function createAction()
    {
        if ($this->request->isPost()) {
            $this->view->disable();

            //$this->component->helper->csrf("member/create");

            $temp =  \Multiple\Backend\Models\Member::findFirstById($this->request->getPost("id"));
            if ($temp) {
                //$this->component->helper->alert("이미 있는 ID 입니다.", "/member/");
            }

            $member = new \Multiple\Backend\Models\Member();
            $member->id = $this->request->getPost("id");
            $member->password = $this->request->getPost("password");
            $member->email = $this->request->getPost("email");
            $member->created = date('Y-m-d H:i:s');

            if (!$member->create()) {
                foreach ($member->getMessages() as $message) {
                    echo $message . "<br>";
                }
                return;
            }

            //$this->component->helper->alert("회원 등록 되었습니다.", "/member/");
        }
    }

    public function updateAction($id)
    {
        if ($this->request->isPost()) {
            $this->view->disable();

            //$this->component->helper->csrf("member/update/" . $this->request->getPost("id"));

            $member = \Multiple\Backend\Models\Member::findFirstById($this->request->getPost("id"));
            $member->password = $this->request->getPost("password");
            $member->email = $this->request->getPost("email");

            if (!$member->update()) {
                foreach ($member->getMessages() as $message) {
                    echo $message . "<br>";
                }
                return;
            }

            //$this->component->helper->alert("회원 수정 되었습니다.", "/member/select/".$id);
        } else {
            $member = \Multiple\Backend\Models\Member::findFirstById($id);

            $this->tag->setDefault("id", $member->id);
            $this->view->setVar("id", $member->id);
            $this->view->setVar("email", $member->email);
        }
    }	

    public function deleteAction($id)
    {
        $member = \Multiple\Backend\Models\Member::findFirstByid($id);
        
        if (!$member->delete()) {
            foreach ($member->getMessages() as $message) {
                echo $message . "<br>";
            }
            return;
        }

        //$this->component->helper->alert("회원 삭제 되었습니다.", "/member/");
    }

}