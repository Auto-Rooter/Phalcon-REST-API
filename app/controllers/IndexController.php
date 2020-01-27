<?php

use Phalcon\Mvc\Controller;
use Phalcon\Http\Response;

class IndexController extends Controller
{
    public function indexAction()
    {
        print_r("Welcome...!");
    }

    public function notFoundAction()
    {
        $response = new Response();
        $response->setStatusCode(404, 'Not Found');
        return $response;
    }
}