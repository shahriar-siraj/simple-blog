<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require '../../config.php';
require '../models/db.php';
require '../models/blog.php';


$blogs = Blog::get($_GET['id']);

$blog = $blogs[0];

http_response_code(200);
 
echo json_encode($blog);