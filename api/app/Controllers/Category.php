<?php

namespace App\Controllers;

use App\Http\Response;
use App\Models\Category as ModelsCategory;

class Category
{
    protected $categoryModel;

    public function __construct()
    {
        $this->categoryModel = new ModelsCategory('categories');
    }

    public function getAll()
    {
        try {
            $categories = $this->categoryModel->getAll();

            return new Response([
                'success' => true,
                'data' => [
                    'categories' => $categories
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
            $category = $this->categoryModel->getById($id);
            return new Response([
                'success' => true,
                'data' => [
                    'category' => $category
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
