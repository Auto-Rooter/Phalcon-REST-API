<?php

use Phalcon\Mvc\Model;

class Users extends Model
{
    public $id;
    public $name;
    public $email;

    
     /**
     * A User (can) has  many products
     */
    public function initialize()
    {
        $this->hasMany('id', 'Products', 'user_id');
    }
}