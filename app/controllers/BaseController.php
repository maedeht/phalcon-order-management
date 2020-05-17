<?php

use Phalcon\Mvc\Controller;


class BaseController extends Controller
{
    public function initialize()
    {
        $this->assets->collection('style')
                    ->addCss('third-party/css/bootstrap.min.css', false, false)
                    ->setTargetPath('css/production.css')
                    ->setTargetUri('css/production.css')
                    ->join(true)
                    ->addFilter(new \Phalcon\Assets\Filters\Cssmin());

        $this->assets->collection('js')
                    ->addJs('third-party/js/jquery.min.js', false, false)
                    ->addJs('js/script.js')
                    ->addJs('third-party/js/bootstrap.min.js', false, false)
                    ->setTargetPath('js/production.js')
                    ->setTargetUri('js/production.js')
                    ->join(true)
                    ->addFilter(new \Phalcon\Assets\Filters\Jsmin());

        $this->tag->setTitle('Home');
        $this->view->setTemplateAfter('default');
    }

    protected function flashEntityErrorMessages($entity)
    {
        foreach($entity->getMessages() as $message){
            $this->flashSession->error($message->getMessage());
        }
    }

    protected function isCsrfTokenPosted()
    {
        if($this->security->checkToken() == false)
        {
            $this->flashSession->error('Invalid csrf Token');
            return false;
        }
        return true;
    }
}