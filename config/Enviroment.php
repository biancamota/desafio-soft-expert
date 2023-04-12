<?php

namespace Config;

class Enviroment
{
    private static $env;

    public static function loadEnv()
    {
        $path = __DIR__ . '/../.env';

        if (!file_exists($path)) {
            throw new \Exception('.env file not found', 500);
        }

        $lines = file($path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        $env = [];

        foreach ($lines as $line) {
            list($name, $value) = explode('=', $line, 2);
            $env[$name] = $value;
        }

        self::$env = $env;
    }

    public static function getEnv(string $name)
    {
        if (!isset(self::$env)) {
            self::loadEnv();
        }

        return self::$env[$name] ?? null;
    }
}
