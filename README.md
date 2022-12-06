

## About API

This is Sample API for the ecommerce test given by Threls

End Points 


Product Import

{{url}}/product/import

Request Body : {
    
"file":file path,

}

Register

{{url}}/auth/register

Request Body : {
    
"name": "Name",
"email:: "Email",
"password" : "Password"

}

Login

{{url}}/auth/login

Request Body : {
    
"email:: "Email",
"password" : "Password"

}

Logout

{{url}}/auth/logout

Add To Cart

{{url}}/cart/addToCart

Request Body : {
    
"user_id:: "User ID",
"product_id" : "Product ID"
"product_price" : "Product Price"
"qty" : "Quantity"

}

Remove From Cart

{{url}}/cart/delete

Request Body : {
    
"user_id:: "User ID",
"product_id" : "Product ID"


}



