<?php

namespace App\Utils;

class View
{
    private static array $params = [];

    public static function init(array $params = [])
    {
        self::$params = $params;
    }

    private static function getContentView(string $view)
    {
        $file = __DIR__ . '/../Views/' . $view . '.html';

        return file_exists($file) ? file_get_contents($file) : '';
    }

    public static function render(string $view, array $params = [])
    {
        $contentView = self::getContentView($view);

        $params = array_merge(self::$params, $params);

        $keys = array_keys($params);
        $keys = array_map(function ($param) {
            return '{{' . $param . '}}';
        }, $keys);

        return str_replace($keys, array_values($params), $contentView);
    }
}
