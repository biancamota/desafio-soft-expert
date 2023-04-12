<?php

namespace App\Controllers;

use App\Utils\View;

class Category extends Template
{

    public static function getProduct() {
        $content = View::render('category/index', [
            'teste' => 'deu bom'
        ]);

        return parent::getTemplate('Product', $content);
    }
}
