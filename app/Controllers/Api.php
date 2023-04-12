<?php 

namespace App\Controllers;

use App\Http\Request;
use WilliamCosta\DatabaseManager\Pagination;

class Api {

    public static function getDetails($request)
    {
        return [
            'nome' => 'API - BMDEV',
            'versao' => 'v1.0.0',
            'autor' => 'Bianca Mota',
            'email' => 'bmsistemasti@gmail.com'
        ];
    }

    protected static function getPagination(Request $request, Pagination $paginate)
    {
        $queryParams = $request->getQueryParams();
        $pages = $paginate->getPages();

        return [
            'currentPage' => isset($queryParams['page']) ? (int) $queryParams['page'] : 1,
            'total' => !empty($pages) ? count($pages) : 1
        ];
    }
}