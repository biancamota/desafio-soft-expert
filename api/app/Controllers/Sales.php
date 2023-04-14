<?php

namespace App\Controllers;

use App\Http\Response;
use App\Models\Sales as ModelsSales;
use Exception;

class Sales
{

    protected $saleModel;

    public function __construct()
    {
        $this->saleModel = new ModelsSales('sales');
    }

    public function getAll()
    {
        try {
            $sales = $this->saleModel->getAll();

            if (empty($sales)) {
                throw new Exception("No record found", 404);
            }

            return new Response([
                'success' => true,
                'data' => [
                    'sales' => $sales
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
            $sale = $this->saleModel->getById($id);

            if (empty($sale)) {
                throw new Exception("Sale not found", 404);
            }

            return new Response([
                'success' => true,
                'data' => [
                    'sale' => $sale
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
            $id = $this->saleModel->save((array) $request);
            
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
            $id = $this->saleModel->update((int) $args['id'], (array) $request);
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
            $id = $this->saleModel->delete($id);
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
