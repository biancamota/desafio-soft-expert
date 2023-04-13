<?php

namespace App\Models;

use Exception;

class PaymentMethods extends BaseModel
{
    public function getById(int $id)
    {
        if (!empty(parent::getById($id))) {
            return parent::update($id, self::getById($id));
        }

        throw new Exception("Payment Method Not Found", 404);
    }
}
