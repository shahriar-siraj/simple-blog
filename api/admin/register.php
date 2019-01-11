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

// make sure data is not empty
if(
    !empty($data->email) &&
    !empty($data->password)
){
    $admin             = new Admin();
    $admin->name       = $data->name;
    $admin->email      = $data->email;
    $admin->password   = password_hash($data->password, PASSWORD_DEFAULT);
    $admin->created_at = date('Y-m-d H:i:s');
    $admin->updated_at = date('Y-m-d H:i:s');

    $auth = $admin->register();

    if (count($auth) > 0)
    {
        // set response code - 201 created
        http_response_code(201);
 
        // tell the user
        echo json_encode($auth[0]);
    }
    else
    {
        // set response code - 503 service unavailable
        http_response_code(503);
 
        // tell the user
        echo json_encode(array("message" => "Account already exists with this email address"));
    }
}
else
{
    // set response code - 400 bad request
    http_response_code(400);
 
    // tell the user
    echo json_encode(array("message" => "Failed to create admin"));
}