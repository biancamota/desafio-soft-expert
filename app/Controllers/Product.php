<?php

namespace App\Controllers;

use App\Http\Request;
use App\Http\Response;
use App\Models\Product as ModelsProduct;

class Product 
{
    protected $productModel;
    protected $response;

    public function __construct() {
        $this->productModel = new ModelsProduct('products');
        $this->response = new Response();
    }
    public function getAll(Request $request, $params)
    {
        $products = $this->productModel->getAll();
        $this->response->setBody($products);
        $this->response->setStatusCode(200);
        return $this->response;
    }

    public function getById(Request $request, $params)
    {
        dump($request, $params);die;
        $products = $this->productModel->getById(1);
        $this->response->setBody($products);
        $this->response->setStatusCode(200);
        return $this->response;
    }

    public function save(Request $request, $params)
    {
        $response = new Response();
        $response->setBody('Create a new product');
        return $response;
    }

    public function update(Request $request, $params)
    {
        $response = new Response();
        $response->setBody('Update product with id ' . $params['id']);
        return $response;
    }

    public function delete(Request $request, $params)
    {
        $response = new Response();
        $response->setBody('Delete product with id ' . $params['id']);
        return $response;
    }
}
