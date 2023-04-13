<?php

namespace App\Controllers;

use App\Http\Response;
use App\Models\Product as ModelsProduct;

class Product
{

    protected $productModel;

    public function __construct()
    {
        $this->productModel = new ModelsProduct('products');
    }

    public function getAll()
    {
        try {
            $products = $this->productModel->getAll();

            return new Response([
                'success' => true,
                'data' => [
                    'products' => $products
                ]
            ]);
        } catch (\Throwable $th) {
            return new Response([
                'error' => $th->getCode(),
                'message' => $th->getMessage()
            ], $th->getCode());
        }
    }

    public function getById(int $id)
    {
        try {   
            $product = $this->productModel->getById($id);
            return new Response([
                'success' => true,
                'data' => [
                    'product' => $product
                ]
            ]);
        } catch (\Throwable $th) {
            return new Response([
                'error' => $th->getCode(),
                'message' => $th->getMessage()
            ], $th->getCode());
        }
    }

    public function save($request)
    {
        try {
            $id = $this->productModel->save((array) $request);
            return new Response([
                'success' => true,
                'data' => [
                    'id' => $id
                ]
            ]);
        } catch (\Throwable $th) {
            return new Response([
                'error' => $th->getCode(),
                'message' => $th->getMessage()
            ], $th->getCode());
        }
    }

    public function update($request, $args)
    {
        try {
            $id = $this->productModel->update((int) $args['id'], (array) $request);
            return new Response([
                'success' => true,
                'data' => [
                    'product' => $id
                ]
            ]);
        } catch (\Throwable $th) {
            return new Response([
                'error' => $th->getCode(),
                'message' => $th->getMessage()
            ], $th->getCode());
        }
    }

    public function delete(int $id)
    {
        try {
            $id = $this->productModel->delete($id);
            return new Response([
                'success' => true,
                'data' => [
                    'product' => $id
                ]
            ]);
        } catch (\Throwable $th) {
            return new Response([
                'error' => $th->getCode(),
                'message' => $th->getMessage()
            ], $th->getCode());
        }
    }
}
