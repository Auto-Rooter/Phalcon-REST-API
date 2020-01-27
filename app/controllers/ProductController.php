<?php

use Phalcon\Mvc\Controller;
use Phalcon\Http\Response;
use Phalcon\Paginator\Adapter\NativeArray as PaginatorModel;


class ProductController extends Controller
{

    public function indexAction()
    {
        $response = new Response();
        $response->setStatusCode(404, 'Not Found');
        return $response;
    }


    public function listAction()
    {
        $response = new Response();
        
        if( $this->request->hasHeader('User-Id') 
            and ctype_digit ( $this->request->getHeaders()['User-Id'] ) 
            ){
                try{

                    $user = Users::findFirstById($this->request->getHeaders()['User-Id']);
                    
                    if($user){


                        $products = Products::find();
            
                            if($products){
                                    $data = [];
                
                                    foreach($products as $product){
                                        $ratings = Rating::find('product_id = '.$product->id);
                                        $AVG_Sum = 0;
                                        $AVG = 0;
                                        if($ratings->count()){
                                            foreach($ratings as $rating){
                                                $AVG_Sum += $rating->rating_value;
                                            }
                                            $AVG = $AVG_Sum/$ratings->count();
                                        }
                                        $data[] = [
                                            'id'          => $product->id,
                                            'name'        => $product->name,
                                            'code'        => $product->code,
                                            'description' => $product->description,
                                            'price'       => $product->price,
                                            'user_id'     => $product->user_id,
                                            'AVG_rating'  => $AVG
                                        ];
                                    }

                                    $currentPage = 1;
                                    $limit       = $products->count();

                                    if(isset($_GET['page'])){
                                        if(is_numeric($_GET['page'])){
                                            $currentPage = $_GET['page'];
                                            $limit = 2;
                                        }
                                        
                                    }

                                    if(isset($_GET['code'])){
                                        if(is_numeric($_GET['code']) and strlen((string)$_GET['code']) == 6){
                                            $filtered_Products = Products::find("code = ".$_GET['code']);
                                            
                                            if($filtered_Products->count() > 0){
                                                $currentPage = 1;
                                                $limit = 1;
                                                unset($data);
    
                                                $data = [];
                    
                                                foreach($filtered_Products as $product){
                                                    $ratings = Rating::find('product_id = '.$product->id);
                                                    $AVG_Sum = 0;
                                                    $AVG = 0;
                                                    if($ratings->count()){
                                                        foreach($ratings as $rating){
                                                            $AVG_Sum += $rating->rating_value;
                                                        }
                                                        $AVG = $AVG_Sum/$ratings->count();
                                                    }
                                                    $data[] = [
                                                        'id'          => $product->id,
                                                        'name'        => $product->name,
                                                        'code'        => $product->code,
                                                        'description' => $product->description,
                                                        'price'       => $product->price,
                                                        'user_id'     => $product->user_id,
                                                        'AVG_rating'  => $AVG
                                                    ];
                                            }
                                           
                                            }else{
                                                $response->setJsonContent(
                                                    [
                                                        'status' => '404',
                                                        'data'   => "The Code Number is invalid!"
                                                    ]
                                                );
                                                $response->setStatusCode(404, 'Not Found');
                                                return $response;
                                            }
                                        }
                                    }

                                    $paginator = new PaginatorModel(
                                        [
                                            'data'  => $data,
                                            'limit' => $limit,
                                            'page'  => $currentPage,
                                        ]
                                    );
                                    $page = $paginator->paginate();

                                    $response->setJsonContent(
                                        [
                                            'status' => 'OK',
                                            'data'   => $page
                                        ]
                                    );
                                    
                            }else{
                                $response->setStatusCode(204, 'No Content');
                            }
                    }else{
                        $response->setStatusCode(401, 'Unauthorized');
                    }

            }catch(\Exception $e){

                $response->setJsonContent(
                    [
                        'status'     => 'Internal Server Error',
                        'MSG'        => $e->getMessage(), 
                        'Error_Code' => $e->getCode(),
                        'Error_Body' => $e
                    ]
                );
            }

        }else{
            $response->setStatusCode(400, 'Bad Request');
            
        }

        return $response;
    }


    public function findAction()
    {
        $response = new Response();

        if( $this->request->hasHeader('User-Id') 
            and ctype_digit ( $this->request->getHeaders()['User-Id'] ) 
            and ctype_digit ( $this->dispatcher->getParam('id'))
        ){
            try{
            $user = Users::findFirstById($this->request->getHeaders()['User-Id']);
            if($user){

                    $product = Products::findFirstById($this->dispatcher->getParam('id'));

                  if($product){
                        $data = [];
                        $ratings = Rating::find('product_id = '.$product->id);
            
                        $AVG_Sum = 0;
                        $AVG = 0;
            
                        if($ratings->count()>0){
                            foreach($ratings as $rating){
                                $AVG_Sum += $rating->rating_value;
                            }
                            $AVG = $AVG_Sum/$ratings->count();
                        }
            
                        $data[] = [
                            'id'          => $product->id,
                            'name'        => $product->name,
                            'code'        => $product->code,
                            'description' => $product->description,
                            'price'       => $product->price,
                            'user_id'     => $product->user_id,
                            'AVG_rating'  => $AVG
                        ];

                        $response->setJsonContent(
                            [
                                'status' => 'OK',
                                'data'   => $data
                            ]
                        ); 
                        
            
                    }else{
                        $response->setStatusCode(404, 'Not Found');
                    }

            }else{
                $response->setStatusCode(401, 'Unauthorized');  
            }
        }catch(\Exception $e){

            $response->setJsonContent(
                [
                    'status'     => 'Internal Server Error',
                    'MSG'        => $e->getMessage(), 
                    'Error_Code' => $e->getCode(),
                    'Error_Body' => $e
                ]
            );
        }

        }else{
            $response->setStatusCode(400, 'Bad Request');
        }

        return $response;
    }


    public function saveAction()
    {
        $response = new Response();
        
        if($this->request->hasHeader('User-Id')
            and ctype_digit ( $this->request->getHeaders()['User-Id']) 
            and ctype_digit ( $this->dispatcher->getParam('id'))
            and ctype_digit ( $this->request->getPost('rating'))
            and ((int)$this->request->getPost('rating') >= 1 and (int)$this->request->getPost('rating') <= 10)
            ){
            try{
                    $user = Users::findFirstById($this->request->getHeaders()['User-Id']);

                    if($user){

                        if(Products::findFirstById($this->dispatcher->getParam('id'))){

                                    $phql = 'INSERT INTO Rating (user_id, product_id, rating_value) VALUES ('
                                    .$this->request->getHeaders()['User-Id'].', '
                                    .$this->dispatcher->getParam('id').', '
                                    .$this->request->getPost('rating')
                                    .')';

                                    $status = $this->modelsManager->executeQuery($phql);

                                    if ($status->success() === true) {
                                        $response->setStatusCode(201, 'Created');
                                    } else {
                                        $errors = [];
                            
                                        foreach ($status->getMessages() as $message) {
                                            $errors[] = $message->getMessage();
                                        }
                                        $response->setJsonContent(
                                            [
                                                'status' => 'Internal Server Error',
                                                'errors'   => $errors
                                            ]
                                        );
                                    }
                        }else{
                            $response->setStatusCode(404, 'Not Found');
                        }
            
                    }else{
                        $response->setStatusCode(401, 'Unauthorized');  
                    }
        }catch(\Exception $e){

            $response->setJsonContent(
                [
                    'status'     => 'Internal Server Error',
                    'MSG'        => $e->getMessage(), 
                    'Error_Code' => $e->getCode(),
                    'Error_Body' => $e
                ]
            );
        }
        }
        else{
            $response->setStatusCode(400, 'Bad Request');
        }

        return $response;
    }


    public function updateAction()
    {

      $response = new Response();

      if($this->request->hasHeader('User-Id') 
            and is_numeric($this->dispatcher->getParam('id'))
            and is_string($this->request->getPut('name'))
            and is_numeric($this->request->getPut('code'))
            and strlen((string)$this->request->getPut('code')) == 6
            and is_string($this->request->getPut('description'))
            and floatval($this->request->getPut('price'))
            ){

            try{

            $user = Users::findFirstById($this->request->getHeaders()['User-Id']);

            if($user){

                $product = Products::findFirstById($this->dispatcher->getParam('id'));

                if($product){

                    if($product->user_id === $user->id){

                        $product->name        = htmlentities ( trim ( $this->request->getPut('name')) , ENT_NOQUOTES );
                        $product->code        = $this->request->getPut('code');
                        $product->description = htmlentities ( trim ( $this->request->getPut('description') ) , ENT_NOQUOTES );
                        $product->price       = $this->request->getPut('price');
            
                        $product->save();

                        
                        $response->setStatusCode(204, 'No Content');

                    }else{
                        $response->setStatusCode(401, 'Unauthorized');
                    }
                }else{
                    $response->setStatusCode(404, 'Not Found');
                }

            }else{
                $response->setStatusCode(401, 'Unauthorized');
            }
        }catch(\Exception $e){

            $response->setJsonContent(
                [
                    'status'     => 'Internal Server Error',
                    'MSG'        => $e->getMessage(), 
                    'Error_Code' => $e->getCode(),
                    'Error_Body' => $e
                ]
            );
        }
        }

        else{
            $response->setStatusCode(400, 'Bad Request');
        } 

        return $response;
    }

    
}