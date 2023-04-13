<?php

namespace App\Models;

use Exception;

class Sales extends BaseModel
{
    public function getById(int $id)
    {
        if (!empty(parent::getById($id))) {
            return parent::update($id, self::getById($id));
        }

        throw new Exception("Sale Not Found", 404);
    }

    public function save(array $sale)
    {
        return (int) parent::save(self::parseRequest($sale));
    }

    public function update(int $id, array $sale)
    {
        if (!empty(parent::getById($id))) {
            return parent::update($id, self::parseRequest($sale));
        }

        throw new Exception("Sale Not Found", 404);
    }

    public function delete(int $id)
    {
        if (!empty(parent::getById($id))) {
            return parent::delete($id);
        }

        throw new Exception("Sale Not Found", 404);
    }

    public function parseRequest(array $product)
    {
        $parsedSale = [
            "name" => $product["name"],
            "description" => $product["description"],
            "category_id" => $product["category_id"],
            "purchase_price" => (float) $product["purchase_price"],
            "sale_price" => (float) $product["sale_price"],
            "tax_value" => (float) $product["tax_value"],
        ];

        return $parsedSale;
    }
}
