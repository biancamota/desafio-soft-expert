<?php
header('Access-Control-Allow-Origin: http://localhost:5173');
header("Access-Control-Allow-Methods: POST, GET, PUT, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");

require_once '../bootstrap/app.php';

use App\Http\Kernel;
use App\Http\Request;

$request = Request::createFromGlobals();

$kernel = new Kernel();

$response = $kernel->handle($request);

$response->send();





