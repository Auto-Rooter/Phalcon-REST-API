# 1- GET: /products #
   **Introduction**:<br>
            Returns the full list of products.
            Optional Features: (Pagination , Code filtering)

   **Overview**:<br>
            if you add the 'page' parameter in the url followed by the page number(http://localhost:8000/products?page=1) , then it will             return two products per page.
            if you dont add the 'page' parameter then all products will be loaded in one page.
            if you add 'code' parameter in the url followed by the product code ,
            (http://localhost:8000/products?code=123456) , then the product or all the products with the same code will be returned .(No               Pagination here)

   **Authentication**:<br>
            there is no Authentication , but you should include the user id (a valid user id ) in the HTTP header.
   
   **Error Codes**:<br>
   - 404 : if the code number is not valid.
   - 204 : if the products table is empty.
   - 401 : if the user id is not valid (not in the Database).
   - 400 : if the request is not valid (if the user_id is missing from the HTTP header )
   - 500 : if there is any error happen on the server

   **1. Request to be sent (without parameters) [with curl]:**<br>
   
```
curl --location --request GET 'http://localhost:8000/products' --header 'User_id: 2' --header 'Content-Type: application/x-www-form-urlencoded'
```
   **⋅⋅⋅The Response:**<br>

```
{
                    "status": "OK",
                    "data": {
                        "items": [
                            {
                                "id": "1",
                                "name": "product_1_1",
                                "code": "333476",
                                "description": "product_1_1 product_1_1 product_1_1 product_1_1 product_1_1 product_1_1 product_1_1",
                                "price": "555.9000",
                                "user_id": "1",
                                "AVG_rating": 5
                            },
                            {
                                "id": "2",
                                "name": "product_2_2",
                                "code": "333444",
                                "description": "product_2_2 product_2_2 product_2_2 product_2_2 product_2_2",
                                "price": "555.0000",
                                "user_id": "1",
                                "AVG_rating": 7.5
                            },
                            {
                                "id": "3",
                                "name": "product_3",
                                "code": "000999",
                                "description": "product_3 product_3 product_3 product_3 product_3 product_3 product_3 product_3",
                                "price": "233.8000",
                                "user_id": "2",
                                "AVG_rating": 0
                            },
                            {
                                "id": "4",
                                "name": "Product_4",
                                "code": "121233",
                                "description": "Product_4 Product_4 Product_4 Product_4 Product_4 Product_4 Product_4 Product_4 Product_4 Product_4 Product_4 Product_4",
                                "price": "244.0000",
                                "user_id": "1",
                                "AVG_rating": 0
                            },
                            {
                                "id": "5",
                                "name": "product_5_5",
                                "code": "333444",
                                "description": "product_5_5 product_5_5 product_5_5 product_5_5 product_5_5 product_5_5 product_5_5 product_5_5 product_5_5 product_5_5",
                                "price": "555.9000",
                                "user_id": "2",
                                "AVG_rating": 5
                            }
                        ],
                        "total_items": 5,
                        "limit": 5,
                        "first": 1,
                        "previous": 1,
                        "current": 1,
                        "next": 1,
                        "last": 1
                    }
                }
```
            - Request to be sent (with page=1 parameter) [with curl]:
                curl --location --request GET 'http://localhost:8000/products?page=1' --header 'User_id: 2' --header 'Content-Type: application/x-www-form-urlencoded'

                The Response:

                                    {
                    "status": "OK",
                    "data": {
                        "items": [
                            {
                                "id": "1",
                                "name": "product_1_1",
                                "code": "333476",
                                "description": "product_1_1 product_1_1 product_1_1 product_1_1 product_1_1 product_1_1 product_1_1",
                                "price": "555.9000",
                                "user_id": "1",
                                "AVG_rating": 5
                            },
                            {
                                "id": "2",
                                "name": "product_2_2",
                                "code": "333444",
                                "description": "product_2_2 product_2_2 product_2_2 product_2_2 product_2_2",
                                "price": "555.0000",
                                "user_id": "1",
                                "AVG_rating": 7.5
                            }
                        ],
                        "total_items": 5,
                        "limit": 2,
                        "first": 1,
                        "previous": 1,
                        "current": 1,
                        "next": 2,
                        "last": 3
                    }
                }

            - Request to be sent (with code parameter) [with curl]:
                curl --location --request GET 'http://localhost:8000/products?code=333476' --header 'User_id: 2' --header 'Content-Type: application/x-www-form-urlencoded'

                The Response:

                                {
                    "status": "OK",
                    "data": {
                        "items": [
                            {
                                "id": "1",
                                "name": "product_1_1",
                                "code": "333476",
                                "description": "product_1_1 product_1_1 product_1_1 product_1_1 product_1_1 product_1_1 product_1_1",
                                "price": "555.9000",
                                "user_id": "1",
                                "AVG_rating": 5
                            }
                        ],
                        "total_items": 1,
                        "limit": 1,
                        "first": 1,
                        "previous": 1,
                        "current": 1,
                        "next": 1,
                        "last": 1
                    }
                }


# 2- GET: /product/{productID}

        # Introduction
            Returns a specific product with a givin ID in the URL.

        # Overview
            if you add the product id in the url (http://localhost:8000/product/1) , then it will return information about this product

        # Authentication
            there is no Authentication , but you should include the user id (a valid user id ) in the HTTP header.

        # Error Codes
            404 : if the product id is not valid (or product id is missed from URL) / if the End-point address or HTTP protocl is not defined .
            401 : if the user id is not valid (not in the Database).
            400 : if the request is not valid (if the user_id is missing from the HTTP header )
            500 : if there is any error happen on the server


        - Request to be sent (with product id =1 ) [with curl]:
            curl --location --request GET 'http://localhost:8000/product/1' --header 'User_id: 2' --header 'Content-Type: application/x-www-form-urlencoded'

            The Response:   
                            {
                "status": "OK",
                "data": [
                    {
                        "id": "1",
                        "name": "product_1_1",
                        "code": "333476",
                        "description": "product_1_1 product_1_1 product_1_1 product_1_1 product_1_1 product_1_1 product_1_1",
                        "price": "555.9000",
                        "user_id": "1",
                        "AVG_rating": 5
                    }
                ]
                }





# 3- PUT: /product/{productID}

        # Introduction
            Update a specific product with a givin ID in the URL, also the user who send the request(the User id in the Http Header in the request) should be the creator of this product.

        # Overview
            you should add the product id in the url (http://localhost:8000/product/5) ,and include all product parameters (name, code, description and price)
            if the product is updated successfully it will return 204 Response code
        # Authentication
            there is no Authentication , but you should include the user id (a valid user id ) in the HTTP header.

        # Error Codes
            404 : if the product id is not valid (or product id is missed from URL) / if the End-point address or HTTP protocl is not defined .
            401 : if the user id is not valid (not in the Database), or the user id that been extracted from HTTP header not equal the user id for the user who created the product.
            400 : if the request is not valid (if the user_id is missing from the HTTP header or the product parameters are not valied or one of it is missed)
            500 : if there is any error happen on the server


        - Request to be sent (with product id =5 ) [with curl]:
            curl --location --request PUT 'http://localhost:8000/product/5' --header 'User_id: 2' --header 'Content-Type: application/x-www-form-urlencoded' --data-urlencode 'name=product_5_5' --data-urlencode 'code=333444' --data-urlencode 'description=product_5_5 product_5_5 product_5_5 product_5_5 product_5_5 product_5_5 product_5_5 product_5_5 product_5_5 product_5_5 ' --data-urlencode 'price=555.9'
        
            The Response:
                No Response , Just 204 status code



# 4- POST: /rate/{productID}

        ## Introduction
            Create a rate for a specific product with a givin ID in the URL.

        # Overview
            you should add the product id in the url (http://localhost:8000/rate/5) ,and include the rating parameter 'rating' (The rating value shoud be between [1 - 10]).
            if the rating is Created successfully it will return 201 Response code.

        # Authentication
            there is no Authentication , but you should include the user id (a valid user id ) in the HTTP header.

        # Error Codes
            404 : if the product id is not valid (or product id is missed from URL) / if the End-point address or HTTP protocl is not defined .
            401 : if the user id is not valid (not in the Database).
            400 : if the request is not valid (if the user_id is missing from the HTTP header, the rating value is not valid or missed ).
            500 : if there is any error happen on the server


        - Request to be sent (with product id =5 ) [with curl]:
            curl --location --request POST 'http://localhost:8000/rate/5' --header 'User_id: 2' --header 'Content-Type: application/x-www-form-urlencoded' --data-urlencode 'rating=10'

            The Response:
                No Response , Just 201 status code


