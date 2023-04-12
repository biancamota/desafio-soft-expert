<?php

use App\Controllers\Product;
use App\Http\Response;

$router->get('/products', [
    function ($request) {
        return new Response(200, Product::index($request));
    }
]);

$router->get('/products/{id}', [
    function ($id) {
        return new Response(200, Product::getById());
    }
]);

$router->post('/products', [
    function ($request) {
        return new Response(200, Product::save($request));
    }
]);

$router->delete('/products/{id}', [
    function () {
        return new Response(200, Product::delete());
    }
]);