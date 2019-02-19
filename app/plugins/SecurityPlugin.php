<?php
namespace plugin;
use Phalcon\Mvc\Dispatcher;
use Phalcon\Events\Event;
class SecurityPlugin extends \Phalcon\Mvc\User\Plugin
{
    protected $_publicResources = [
        'loginout' => ['*']
    ];
    protected $_userResources = [
        'dashboard' => ['*']
    ];
    protected $_operatorResources = [
        'index' => ['*'],
        'member' => ['*'],
        'loginout' => ['*'],
        'board' => ['*'],
        'setup' => ['*']
    ];
    
    protected function _getAcl()
    {
        $this->persistent->destroy();
        if (!isset($this->persistent->acl)) {
            $acl = new \Phalcon\Acl\Adapter\Memory();
            $acl->setDefaultAction(\Phalcon\Acl::DENY);
            $roles = [
                'user' => new \Phalcon\Acl\Role('user'),
                'operator' => new \Phalcon\Acl\Role('operator'),
                'superior' => new \Phalcon\Acl\Role('superior'),
            ];
            
            foreach ($roles as $role) {
                $acl->addRole($role);
            }
            
            foreach ($this->_publicResources as $resource => $action) {
                $acl->addResource(new \Phalcon\Acl\Resource($resource), $action);
            }
            foreach ($this->_userResources as $resource => $action) {
                $acl->addResource(new \Phalcon\Acl\Resource($resource), $action);
            }
            foreach ($this->_operatorResources as $resource => $action) {
                $acl->addResource(new \Phalcon\Acl\Resource($resource), $action);
            }
            
            foreach ($roles as $role) {
                foreach ($this->_publicResources as $resource => $action) {
                    $acl->allow($role->getName(), $resource, '*');
                }
            }
            
            foreach ($this->_userResources as $resource => $actions) {
                foreach ($actions as $action) {
                    $acl->allow('user', $resource, $action);
                }
            }
            foreach ($this->_operatorResources as $resource => $actions) {
                foreach ($actions as $action) {
                    $acl->allow('operator', $resource, $action);
                }
            }
            
            
            $this->persistent->acl = $acl;
        }
        return $this->persistent->acl;
    }
    public function beforeExecuteRoute(Event $event, Dispatcher $dispatcher)
    {
        $role = $this->session->get('role');
        if (!$role) {
            $role = 'user';
        }
        $controller = $dispatcher->getControllerName();
        $action = $dispatcher->getActionName();
        $acl = $this->_getAcl();
        $allowed = $acl->isAllowed($role, $controller, $action);

        if ($allowed != \Phalcon\Acl::ALLOW) {
            $this->response->redirect('dashboard/login');
            return false;
        }
    }
}