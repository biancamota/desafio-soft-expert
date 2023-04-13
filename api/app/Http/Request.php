<?php

namespace App\Http;

class Request
{

    public function __construct(
        public array $queryParams,
        public array $postData,
        public array $cookies,
        public array $files,
        public array $server
    )
    {
        
    }

    public static function createFromGlobals(): static
    {
        return new static($_GET, $_POST, $_COOKIE, $_FILES, $_SERVER);
    }

    public function getPathInfo(): string
    {
        return strtok($this->server['REQUEST_URI'], '?');
    }

    public function getMethod(): string
    {
        return $this->server['REQUEST_METHOD'];
    }
}
