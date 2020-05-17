<?php

use Phalcon\Mvc\Model;
use Phalcon\Filter;

class OrderItems extends Base
{
    public function initialize()
    {
        $this->filter = new Filter();
        $this->belongsTo('order_id', 'Orders', 'id');
    }

    public function saveOne($data)
    {
        $this->product    = $this->filter->sanitize($data['product'], 'string');
        $this->price    = $this->filter->sanitize($data['price'], 'int');
        $this->qty    = $this->filter->sanitize($data['qty'], 'int');
        $this->order_id = $data['order_id'];

        // Store and check for errors
        return $this->save();
    }
}