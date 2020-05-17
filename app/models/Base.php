<?php

use Phalcon\Mvc\Model;

Abstract class Base extends Model
{
    public function beforeCreate()
    {
        $this->created_at = date('Y-m-d H:i:s');
    }

    public function beforeUpdate()
    {
        $this->updated_at = date('Y-m-d H:i:s');
    }
}