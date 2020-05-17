<?php

use Phalcon\Mvc\User\Plugin;
use Phalcon\Mvc\Dispatcher,
    Phalcon\Events\Event;
use Phalcon\Acl\Adapter\Memory;
use Phalcon\Acl;
use Phalcon\Acl\Role;
use Phalcon\Acl\Resource;


class Permission extends Plugin
{
    const GUEST = 'guest';
    const USER = 'user';

    protected $_guestResources = [
        'index' => ['index'],
        'auth' => ['signupForm', 'signup', 'loginForm', 'login']
    ];

    protected $_userResources = [
        'index' => ['index'],
        'auth' => ['logout'],
        'orders' => ['index', 'create', 'all'],
        'order_items' => ['index', 'create', 'all']
    ];

    protected function _getAcl()
    {
//        $this->session->destroy();
        if(!isset($this->persistent->acl))
        {
            $acl = new Memory();
            $acl->setDefaultAction(Acl::DENY);

            $roles = [
                'guest' => new Role(self::GUEST),
                'user' => new Role(self::USER)
            ];

            foreach($roles as $role)
            {
                $acl->addRole($role);
            }

            // Guest Resources
            foreach($this->_guestResources as $resource => $action)
            {
                $acl->addResource(new Resource($resource), $action);
            }

            // User Resources
            foreach($this->_userResources as $resource => $action)
            {
                $acl->addResource(new Resource($resource), $action);
            }

            // Allow Guest to access the Guest Resources
            foreach($this->_guestResources as $resource => $actions)
            {
                foreach($actions as $action)
                {
                    $acl->allow(self::GUEST, $resource, $action);
                }
            }

            // Allow User to access the User Resources
            foreach($this->_userResources as $resource => $actions)
            {
                foreach($actions as $action)
                {
                    $acl->allow(self::USER, $resource, $action);
                }
            }

            $this->persistent->acl = $acl;
        }
        return $this->persistent->acl;
    }

    public function beforeExecuteRoute(Event $event, Dispatcher $dispatcher)
    {
        $role = $this->session->get('role') ?: self::GUEST;

        // Get the current controller/action from the dispatcher
        $controller = $dispatcher->getControllerName();
        $action = $dispatcher->getActionName();

        // Get the Acl Rule List
        $acl = $this->_getAcl();
        $allowed = $acl->isAllowed($role, $controller, $action);

        // See if they have permission
        if($allowed != Acl::ALLOW)
        {
            $this->flash->error('You do not have permission to access this area');
            $this->response->redirect('/');

            // Stops the dispatcher at the current operation
            return false;
        }
    }
}