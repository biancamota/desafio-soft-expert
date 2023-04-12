<?php

namespace App\Controllers;

use App\Http\Request;
use App\Utils\View;
use WilliamCosta\DatabaseManager\Pagination;

class Template
{
    private static function getHeader()
    {
        return View::render('header');
    }

    private static function getFooter()
    {
        return View::render('footer');
    }

    public static function getPagination(Request $request, Pagination $paginate)
    {
        $pages = $paginate->getPages();

        if (count($pages) <= 1) return '';

        $links = '';
        $url = $request->getRouter()->getCurrentUrl();
        $queryParams = $request->getQueryParams();

        foreach ($pages as $page) {
            $queryParams['page'] = $page['page'];
            $link = $url.'?'.http_build_query($queryParams);

            $links .= View::render('pagination/link', [
                'page' =>$page['page'],
                'link' => $link
            ]);
        }
    }

    public static function getTemplate(string $title, $content)
    {
        return View::render('base', [
            'title' => $title,
            'header' => self::getHeader(),
            'content' => $content,
            'footer' => self::getFooter(),
        ]);
    }
}
