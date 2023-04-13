<?php

namespace App\Controllers;

use App\Http\Request;
use App\Http\Response;
use WilliamCosta\DatabaseManager\Pagination;

class Api
{

    public static function getDetails(): Response
    {
        return new Response([
            'nome' => 'API - BMDEV',
            'versao' => 'v1.0.0',
            'autor' => 'Bianca Mota',
            'email' => 'bmsistemasti@gmail.com'
        ], 200);
    }
}
