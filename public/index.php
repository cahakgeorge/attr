<?php
require "../bootstrap.php";

use AttractionsIo\Controllers\V1\UserController;

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: OPTIONS,POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$uri = explode( '/', $uri );

// all of our endpoints start with /user
// everything else results in a 404 Not Found
if ($uri[1] !== 'user') {
    header("HTTP/1.1 404 Not Found");
    $response['status_code_header'] = 'HTTP/1.1 404 Not Found';
    $response['body'] = json_encode([
        'status' => false, 'data'=> null, 'message' => ''
    ]);

    echo $response['body'];

    exit();
}

$requestMethod = $_SERVER["REQUEST_METHOD"];

// pass the request method to the UserController and process the HTTP request:
$controller = new UserController($requestMethod);
$controller->processRequest();