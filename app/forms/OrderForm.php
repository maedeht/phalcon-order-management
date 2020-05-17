<?php

use Phalcon\Forms\Form,
    Phalcon\Forms\Element\Text,
    Phalcon\Forms\Element\Password;
use Phalcon\Validation\Validator\PresenceOf;
use Phalcon\Validation\Validator\Email;
use Phalcon\Validation\Validator\Uniqueness;

class OrderForm extends Form
{
    public function initialize()
    {
        $this->setEntity($this);

        $total_price = new Text("total_price");
        $total_price->addValidator(new PresenceOf([
            'message' => 'Order number is required'
        ]));
        $total_price->setAttribute('class','form-control');

        $description = new Text('description');
        $description->addValidator(new PresenceOf([
            'message' => 'Description is required'
        ]));
        $description->setAttribute('class','form-control');

        $this->add($total_price);
        $this->add($description);
    }
}