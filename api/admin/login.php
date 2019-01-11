<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require '../../config.php';
require '../models/db.php';
require '../models/admin.php';

// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

$data = json_decode(file_get_contents("php://input"));

if(
    !empty($data->email) &&
    !empty($data->password)
){
 
    $admin = new Admin();
    $admin->email = $data->email;

    $auth = $admin->authenticate();

    if (count($auth) > 0 && password_verify($data->password, $auth[0]['password']))
    {
        // set response code - 201 created
        http_response_code(201);

        // hide password attribute
        unset($auth[0]['password']);
 
        // tell the user
        echo json_encode($auth[0]);
    }
 
    else
    {
        // set response code - 503 service unavailable
        http_response_code(503);
 
        // tell the user
        echo json_encode(array("message" => "Email address and password do not match"));
    }
}
else
{
    // set response code - 400 bad request
    http_response_code(400);
 
    // tell the user
    echo json_encode(array("message" => "Email address and password do not match"));
}