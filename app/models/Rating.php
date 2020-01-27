<?php

use Phalcon\Mvc\Model;

class Rating extends Model
{
    public $id;
    public $user_id;
    public $product_id;
    public $rating_value;


    public function initialize()
    {
        $this->belongsTo("user_id", "Users", "id", array(
            "foreignKey" => true
        ));

        $this->belongsTo("product_id", "Products", "id", array(
            "foreignKey" => true
        ));
    }
}