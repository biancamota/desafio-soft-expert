<?php
require_once '../bootstrap/app.php';

use App\Http\Kernel;
use App\Http\Request;

$request = Request::createFromGlobals();

$kernel = new Kernel();

$response = $kernel->handle($request);

$response->send();





