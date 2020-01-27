<?php 

use Phalcon\Mvc\Router;


	$router = new Router();

    //Remove trailing slashes automatically
    $router->removeExtraSlashes(true);

    
    //main route
    $router->add("/", array(
        'controller' => 'index',
        'action' => 'index'
    ));

    /*
      All Products listed in pagination way
      by default ----> 1 product per page
      by 
    */
    $router->addGet("/products", array(
        'controller' => 'Product',
        'action' => 'list'
    ));

    /*
      GET product by ID
    */
    $router->addGet("/product/([0-9]+)", array(
        'controller' => 'Product',
        'id'         => 1,
        'action' => 'find'
    ));

    // Create a rate for a specific product
    $router->addPost('/rate/([0-9]+)', array(
        'controller' => 'Product',
        'id'         => 1,
        'action'     => 'save'
    ));

    // Update a product
    $router->addPut("/product/([0-9]+)", array(
        'controller' => 'Product',
        'id'         => 1,
        'action' => 'update'
    ));


    $router->notFound(array(
        'controller' => 'index',
        'action' => 'notFound'
    ));
    
return $router;
