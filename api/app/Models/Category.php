<?php

namespace App\Models;

use Exception;

class Category extends BaseModel
{
    public function getById(int $id)
    {
        if (!empty(parent::getById($id))) {
            return parent::update($id, self::getById($id));
        }

        throw new Exception("Category Not Found", 404);
    }
}
