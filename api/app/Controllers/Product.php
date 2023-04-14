<?php

namespace App\Controllers;

use App\Http\Response;
use App\Models\Product as ModelsProduct;
use Exception;

class Product
{

    protected $productModel;

    public function __construct()
    {
        $this->productModel = new ModelsProduct();
    }

    public function getAll()
    {
        try {
            $products = $this->productModel->getAll();

            if (empty($products)) {
                throw new Exception("No record found", 404);
            }

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

            if (empty($product)) {
                throw new Exception("Product not found", 404);
            }

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

            if (!$id) {
                throw new Exception("Unable to save product. Please try again later or contact support", 500);
            }
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
