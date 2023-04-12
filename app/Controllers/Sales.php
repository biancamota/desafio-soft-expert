<?php

namespace App\Controllers;

use App\Utils\View;

class Order extends Template
{

    public static function getProduct() {
        $content = View::render('order/index', [
            'teste' => 'deu bom'
        ]);

        return parent::getTemplate('Product', $content);
    }
}
