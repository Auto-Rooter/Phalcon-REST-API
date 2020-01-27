<?php

use Phalcon\Mvc\Model;

class Products extends Model
{
    public $id;
    public $name;
    public $code;
    public $description;
    public $price;
    public $user_id;


     /**
     * A product only has a User, but a User have many products
     */
    public function initialize()
    {
        $this->belongsTo('user_id', 'Users', 'id');
    }
}