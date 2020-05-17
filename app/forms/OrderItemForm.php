<?php

use Phalcon\Forms\Form,
    Phalcon\Forms\Element\Text,
    Phalcon\Forms\Element\Password;
use Phalcon\Validation\Validator\PresenceOf;
use Phalcon\Validation\Validator\Email;
use Phalcon\Validation\Validator\Uniqueness;

class OrderItemForm extends Form
{
    public function initialize()
    {
        $this->setEntity($this);

        $product = new Text("product");
        $product->addValidator(new PresenceOf([
            'message' => 'Product is required'
        ]));
        $product->setAttribute('class','form-control');

        $qty = new Text('qty');
        $qty->addValidator(new PresenceOf([
            'message' => 'Quantity is required'
        ]));
        $qty->setAttribute('class','form-control');

        $price = new Text('price');
        $price->addValidator(new PresenceOf([
            'message' => 'Price is required'
        ]));
        $price->setAttribute('class','form-control');

        $this->add($product);
        $this->add($qty);
        $this->add($price);
    }
}