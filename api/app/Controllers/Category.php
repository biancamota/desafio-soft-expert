<?php

namespace App\Controllers;

use App\Http\Response;
use App\Models\Category as ModelsCategory;
use Exception;

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

            if (empty($categories)) {
                throw new Exception("No record found", 404);
            }

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

            if (empty($category)) {
                throw new Exception("Category not found", 404);
            }

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
