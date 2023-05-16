<?php

namespace App\Models;

use Exception;

class Product extends BaseModel
{
    protected $table = 'products';

    public function getAll()
    {
        return self::parseResponse(parent::getAll());
    }

    public function save(array $product)
    {
        return (int) parent::save(self::parseRequest($product));
    }

    public function update(int $id, array $product)
    {
        if (!empty(parent::getById($id))) {
            return parent::update($id, self::parseRequest($product));
        }

        throw new Exception("Product Not Found", 404);
    }

    public function delete(int $id)
    {
        if (!empty(parent::getById($id))) {
            return parent::delete($id);
        }

        throw new Exception("Product Not Found", 404);
    }

    public function parseResponse(array $products)
    {
        $parsedProducts = array_map(function ($product) {
            $parsedProduct = [
                "id" => $product["id"],
                "name" => $product["name"],
                "description" => $product["description"],
                "category_id" => $this->parseCategories($product["category_id"]),
                "purchase_price" => $product["purchase_price"],
                "sale_price" => $product["sale_price"],
                "tax" => $product["tax_value"],
            ];

            return $parsedProduct;
        }, $products);

        return $parsedProducts;
    }

    public function parseRequest(array $product)
    {
        $parsedProduct = [
            "name" => $product["name"],
            "description" => $product["description"],
            "category_id" => $this->parseCategory($product["category_id"]),
            "purchase_price" => (float) $product["purchase_price"],
            "sale_price" => (float) $product["sale_price"],
            "tax_value" => (float) $product["tax"],
        ];

        return $parsedProduct;
    }

    private function parseCategory(string $category): int
    {
        switch ($category) {
            case 'Electronics':
                # code...
                return 1;
            case 'Fashion':
                return 2;
            case 'Sports':
                return 3;
        }
    }

    private function parseCategories($category): string
    {
        switch ($category) {
            case 1:
                # code...
                return 'Electronics';
            case 2:
                return 'Fashion';
            case 3:
                return 'Sports';
        }
    }
}
