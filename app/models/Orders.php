<?php

use Phalcon\Mvc\Model;
use Phalcon\Filter;

class Orders extends Base
{
    public $order_number;
    public $description;
    public $total_price;
    public $status;

    const CREATED = 1;
    const PAID = 2;
    const STATUS = [
        self::CREATED => 'created',
        self::PAID => 'paid'
    ];


    public function initialize()
    {
        $this->filter = new Filter();
        $this->order_number = 'default';
        $this->belongsTo('user_id', 'Users', 'id');
        $this->hasMany('id', 'OrderItems', 'order_id', ['alias' => 'items']);
    }

    public function beforeCreate()
    {
        parent::beforeCreate();
        $this->order_number = date('YmdHis');
        $this->status = self::CREATED;
    }

    public function saveOne($data)
    {
        $this->description    = $this->filter->sanitize($data['description'], 'string');
        $this->total_price    = $this->filter->sanitize($data['total_price'], 'int');
        $this->user_id = $data['user_id'];

        // Store and check for errors
        return $this->save();
    }
}