<?php

namespace Multiple\Backend\Controllers;

class LoginoutController extends ControllerBase
{
    public function initialize()
    {
        parent::initialize();
        $this->view->setTemplateAfter('backend');
    }
    public function indexAction()
    {
        $this->persistent->parameters = null;
    }
    /**
     * 회원로그인
     */
    public function loginAction()
    {
        $this->assets->collection('extra')->addCss('bootstrap/signin.css');
        $this->view->disableLevel(\Phalcon\Mvc\View::LEVEL_AFTER_TEMPLATE);
    }
    /**
     * 회원로그인 처리
     */
    public function dologinAction()
    {
        $this->view->disable();
        $this->component->ComponentsPlugin->csrf("/dashboard/login");

        $id = $this->request->getPost('inputId');
        $password = $this->request->getPost('inputPassword');
        $member = \Multiple\Backend\Models\Member::findFirstById($id);
        if ($member) {
            if ($this->security->checkHash($password, $member->password)) {
                $login = \Multiple\Backend\Models\Loginout::findFirstById($id);
                $login->update();
                $this->session->set('id', $member->id);
                $this->session->set('role', $member->role);
                $this->response->redirect("dashboard");
            } else {
                $this->component->ComponentsPlugin->alert("패스워드를 확인 하세요.", "/dashboard/login");
            }
        } else {
            $this->component->ComponentsPlugin->alert("아이디 또는 패스워드를 확인 하세요.", "/dashboard/login");
        }
    }
    /**
     * 회원로그아웃
     */
    public function dologoutAction()
    {
        $this->session->destroy();
        $this->response->redirect("dashboard/login");
    }
}