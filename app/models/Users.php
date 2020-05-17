<?php

use Phalcon\Mvc\Model;
use Phalcon\Filter;

class Users extends Base
{
    public $id;
    public $name;
    public $email;
    public $password;
    public $created_at;
    public $updated_at;

    public function initialize()
    {
        $this->hasMany('id', 'Orders', 'user_id', ['alias' => 'orders']);
    }

    public function saveOne($data)
    {
        $filter = new Filter();
        $this->name    = $filter->sanitize($data['name'], 'string');
        $this->email    = $filter->sanitize($data['email'], 'email');
        $this->password = $data['password'];

        // Store and check for errors
        return $this->save();
    }

}