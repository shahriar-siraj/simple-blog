<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");


require '../../config.php';
require '../models/db.php';
require '../models/blog.php';

$data = json_decode(file_get_contents("php://input"));

// make sure data is not empty
if(
    !empty($data->id) &&
    !empty($data->admin_id) &&
    !empty($data->title) &&
    !empty($data->content)
){
 
    $blog             = new Blog();
    $blog->id         = $data->id;
    $blog->title      = $data->title;
    $blog->content    = $data->content;
    $blog->admin_id   = $data->admin_id;
    $blog->updated_at =  date('Y-m-d H:i:s');

    if ($blog->update())
    {
        // set response code - 201 created
        http_response_code(201);
 
        // tell the user
        echo json_encode(array("message" => "Blog post was updated"));
    }
    else
    {
        // set response code - 503 service unavailable
        http_response_code(503);
 
        // tell the user
        echo json_encode(array("message" => "Unable to update blog"));
    }
}
else
{
 
    // set response code - 400 bad request
    http_response_code(400);
 
    // tell the user
    echo json_encode(array("message" => "Unable to update blog"));
}