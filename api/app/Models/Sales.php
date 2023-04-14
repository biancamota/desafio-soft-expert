<?php

namespace App\Models;

use App\Models\Product;
use Exception;
use PDO;
use PDOException;

class Sales extends BaseModel
{
    protected $table = "sales";

    public function getById(int $id)
    {
        $qb = $this->qb->select('
                sales.id, 
                sales.payment_method_id,
                sales.total_amount,
                sales.total_taxes,
                sales.created_at,
                sales.deleted_at,
                si.product_id,
                si.price,
                si.quantity
            ')
            ->join('sale_items si', 'si.sale_id', '=', 'sales.id')
            ->where('sales.id', '=', $id)
            ->orderBy('sales.id')
            ->get();

        if (!empty($qb)) {
            return $this->parseResponse($qb);
        }

        throw new Exception("Sale Not Found", 404);
    }

    public function save(array $sale)
    {
        try {
            $parsedSale = self::parseRequest($sale);
            $saleItems = $parsedSale['products'];
            unset($parsedSale['products']);

            parent::beginTransaction();

            $saleId = (int) $this->qb->setTable('sales')->insert($parsedSale);

            if ($saleId) {
                foreach ($saleItems as $item) {
                    $item['sale_id'] = $saleId;
                    $this->qb->setTable('sale_items')->insert($item);
                }
            }

            parent::commit();

            return $saleId;
        } catch (PDOException $e) {
            parent::rollback();
            throw $e;
        }
    }

    public function update(int $id, array $sale)
    {
        try {
            $this->getById($id);

            $parsedSale = self::parseRequest($sale);
            $saleItems = $parsedSale['products'];
            unset($parsedSale['products']);

            parent::beginTransaction();

            $saleId = (int) $this->qb->setTable('sales')->update($id, $parsedSale);

            if ($saleId) {
                $this->qb->setTable('sale_items')->deleteWhere('sale_id = ' . $saleId);
                foreach ($saleItems as $item) {
                    $item['sale_id'] = $saleId;
                    $this->qb->setTable('sale_items')->insert($item);
                }
            }

            parent::commit();

            return $saleId;
        } catch (PDOException $e) {
            parent::rollback();
            throw $e;
        }
    }

    public function delete(int $id)
    {
        if (!empty(parent::getById($id))) {
            return parent::delete($id);
        }

        throw new Exception("Sale Not Found", 404);
    }

    private function parseRequest(array $sale)
    {
        $parsedSale = [
            "payment_method_id" => $sale["payment_method_id"],
            "total_amount" => $sale["total_amount"],
            "total_taxes" => (float) $sale["total_taxes"],
            "products" => $this->parseProducts($sale['products'])
        ];

        return $parsedSale;
    }

    private function parseProducts(array $products): array
    {
        $this->validateItems($products);
        $parsedProducts = array_map(function ($product) {
            return [
                "product_id" => (int) $product->id,
                "price" => (float) $product->price,
                "quantity" => (int) $product->quantity,
            ];
        }, $products);

        return $parsedProducts;
    }

    private function parseResponse(array $sales)
    {
        $parsedProducts = array_map(function ($product) {
            return [
                "product_id" => (int) $product["product_id"],
                "price" => (float) $product["price"],
                "quantity" => (int) $product["quantity"],
            ];
        }, $sales);

        $parsedSale = [
            "id" => $sales[0]["id"],
            "payment_method_id" => $sales[0]["payment_method_id"],
            "total_amount" => (float)$sales[0]["total_amount"],
            "total_taxes" => (float) $sales[0]["total_taxes"],
            "products" => $parsedProducts
        ];

        return $parsedSale;
    }

    private function validateItems(array $items)
    {
        $productIds = implode(',', array_column($items, 'id'));

        $find = "SELECT id FROM products WHERE id IN ($productIds)";

        $result = $this->qb->execute($find)->fetchAll(PDO::FETCH_COLUMN);

        $diff = array_diff(array_column($items, 'id'), $result);

        if (!empty($diff)) {
            throw new Exception("Product (id: " . implode(',', $diff) . ") not found", 404);
        }
    }
}
