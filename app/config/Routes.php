<?php

use Phalcon\Mvc\Router\Group;

class Routes extends Group
{
    public function initialize()
    {
        $this->add('/signup',[
            'controller' => 'auth',
            'action' => 'signupForm'
        ]);

        $this->add('/signup/process',[
            'controller' => 'auth',
            'action' => 'signup'
        ]);

        $this->add('/login',[
            'controller' => 'auth',
            'action' => 'loginForm'
        ]);

        $this->add('/login/process',[
            'controller' => 'auth',
            'action' => 'login'
        ]);

        $this->add('/logout',[
            'controller' => 'auth',
            'action' => 'logout'
        ]);

        $this->add('/orders/{id}/items',[
            'controller' => 'order_items',
            'action' => 'all'
        ]);

        $this->add('/orders/',[
            'controller' => 'orders',
            'action' => 'index'
        ]);

        $this->add('/orders/{id}/item',[
            'controller' => 'order_items',
            'action' => 'index'
        ]);

        $this->add('/orders/{id}/create',[
            'controller' => 'order_items',
            'action' => 'create'
        ]);


        $this->add('/orders/create',[
            'controller' => 'orders',
            'action' => 'create'
        ]);

        $this->add('/orders/all',[
            'controller' => 'orders',
            'action' => 'all'
        ]);

        $this->add('/home',[
            'controller' => 'home',
            'action' => 'index'
        ]);
    }
}


?>