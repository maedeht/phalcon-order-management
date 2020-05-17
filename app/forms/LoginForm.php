<?php

use Phalcon\Forms\Form,
    Phalcon\Forms\Element\Text,
    Phalcon\Forms\Element\Password;
use Phalcon\Validation\Validator\PresenceOf;

class LoginForm extends Form
{
    public function initialize()
    {
        $this->setEntity($this);

        $email = new Text("email");
        $email->addValidator(new PresenceOf([
            'message' => 'Email is required'
        ]));
        $email->setAttribute('class','form-control');

        $password = new Password('password');
        $password->setAttribute('class','form-control');
        $password->addValidator(new PresenceOf([
            'message' => 'Password is required'
        ]));

        $this->add($email);
        $this->add($password);
    }
}