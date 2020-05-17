<?php

use Phalcon\Forms\Form,
    Phalcon\Forms\Element\Text,
    Phalcon\Forms\Element\Password;
use Phalcon\Validation\Validator\PresenceOf;
use Phalcon\Validation\Validator\Email;
use Phalcon\Validation\Validator\Uniqueness;
use Phalcon\Validation\Validator\StringLength;
use Phalcon\Validation\Validator\Regex;
use Phalcon\Validation\Validator\Confirmation;

class SignupForm extends Form
{
    public function initialize()
    {
        $this->setEntity($this);

        $name = new Text("name");
        $name->addValidator(new PresenceOf([
            'message' => 'Name is required'
        ]));
        $name->setAttribute('class','form-control');


        $email = new Text("email");
        $email->addValidator(new PresenceOf([
            'message' => 'Email is required'
        ]));
        $email->addValidator(new Email([
            'message' => 'Email is not valid'
        ]));
        $email->addValidator(new Uniqueness([
            "model"   => new Users,
            "message" => "Email already exist",
        ]));
        $email->setAttribute('class','form-control');


        $password = new Password('password');
        $password->addValidator(new PresenceOf([
            'message' => 'Password is required'
        ]));
        $password->addValidator(new StringLength([
            'min' => 6,
            'message' => 'Password is too short'
        ]));
        $password->addValidator(new Regex([
            'pattern' => '/^(?=.*[a-z]+)(?=.*[A-Z]+)(?=.*[0-9]+).*$/',
            'message' => 'Password must contain at least one number, one uppercase, and one lowercase character, and no other characters'
        ]));
        $password->addValidator(new Confirmation([
            'with' => 'password_confirmation',
            'message' => 'Password doesn\'t match confirmation'
        ]));
        $password->setAttribute('class','form-control');

        $this->add($name);
        $this->add($email);
        $this->add($password);
    }
}