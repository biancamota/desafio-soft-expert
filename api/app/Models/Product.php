<?php

namespace App\Models;

use Exception;

class Product extends BaseModel
{
    public function getById(int $id)
    {
        if (!empty(parent::getById($id))) {
            return parent::update($id, self::getById($id));
        }

        throw new Exception("Product Not Found", 404);
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

    public function parseRequest(array $product)
    {
        $parsedProduct = [
            "name" => $product["name"],
            "description" => $product["description"],
            "category_id" => $product["category_id"],
            "purchase_price" => (float) $product["purchase_price"],
            "sale_price" => (float) $product["sale_price"],
            "tax_value" => (float) $product["tax_value"],
        ];

        return $parsedProduct;
    }
}
