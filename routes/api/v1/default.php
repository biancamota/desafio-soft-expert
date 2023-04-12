<?php

use App\Controllers\Api;
use App\Controllers\Auth;
use App\Controllers\Product;
use App\Controllers\User;
use App\Http\Response;

$router->get('/api/v1', [
    function ($request) {
        return new Response(200, Api::getDetails($request), 'application/json');
    }
]);

$router->get('/api/v1/auth', [
    function ($request) {
        return new Response(201, Auth::generateToken($request), 'application/json');
    }
]);

$router->post('/api/v1/users', [
    function ($request) {
        return new Response(201, User::save($request), 'application/json');
    }
]);

$router->get('/api/v1/users/me', [
    'middlewares' => [
        'jwt-auth'
    ],
    function ($request) {
        return new Response(201, ['success' => true], 'application/json');
    }
]);

$router->get('/api/v1/products', [
    function ($request) {
        return new Response(200, Product::getAll($request), 'application/json');
    }
]);

$router->get('/api/v1/products/{id}', [
    function ($id) {
        return new Response(200, Product::getById($id), 'application/json');
    }
]);

$router->post('/api/v1/products', [
    function ($request) {
        return new Response(201, Product::save($request), 'application/json');
    }
]);
