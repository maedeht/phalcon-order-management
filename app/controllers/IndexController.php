<?php

use Phalcon\Mvc\Controller;


class IndexController extends BaseController
{
    public function indexAction()
    {
        $this->tag->setTitle('Home');
        if($this->session->get('role') == 'user')
        {
            $this->view->pick('home/index');
        }
    }
}