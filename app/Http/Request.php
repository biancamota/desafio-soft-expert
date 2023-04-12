<?php

namespace App\Http;

class Request
{

    private $httpMethod;
    private $uri;
    private $queryParams;
    private $postData;
    private $headers;

    public function __construct()
    {
        $this->httpMethod = $_SERVER['REQUEST_METHOD'];
        $this->uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        $this->queryParams = $_GET;
        $this->postData = $_POST;
        $this->headers = getallheaders();
    }

    public function getHttpMethod()
    {
        return $this->httpMethod;
    }

    public function getUri()
    {
        return $this->uri;
    }

    public function getQueryParams()
    {
        return $this->queryParams;
    }

    public function getPostData()
    {
        return $this->postData;
    }

    public function getHeaders()
    {
        return $this->headers;
    }
}
