<?php

namespace App\Http;

class Response
{
    public function __construct(
        private ?array $body = [],
        private int $statusCode = 200,
        private array $headers = []
    ) {
    }

    public function send()
    {
        header('Content-Type: application/json');
        http_response_code($this->statusCode);
        echo json_encode($this->getBody());
    }

    public function setBody($body): void
    {
        $this->body = $body;
    }

    public function setStatusCode(int $statusCode): void
    {
        $this->statusCode = $statusCode;
    }

    public function setHeaders(array $headers): void
    {
        $this->headers = $headers;
    }

    public function getBody()
    {
        return $this->body;
    }

    public function getStatusCode(): int
    {
        return $this->statusCode;
    }

    public function getHeaders(): array
    {
        return $this->headers;
    }

    public function addHeader(string $header, string $value): void
    {
        $this->headers[$header] = $value;
    }

    public function json(): void
    {
        header('Content-Type: application/json');
        http_response_code($this->statusCode);
        echo json_encode($this->getBody());
    }

    private function getErrorMessage($errorCode)
    {
        $httpErrors = [
            400 => 'Bad Request',
            401 => 'Unauthorized',
            403 => 'Forbidden',
            404 => 'Not Found',
            405 => 'Method Not Allowed',
            408 => 'Request Timeout',
            500 => 'Internal Server Error',
            502 => 'Bad Gateway',
            503 => 'Service Unavailable',
            504 => 'Gateway Timeout'
        ];

        $this->setBody([
            'error' => $errorCode,
            'message' => isset($httpErrors[$errorCode]) ? $httpErrors[$errorCode] : $httpErrors[500]
        ]);
    }

    public function getErros(int $statusCode)
    {
        $this->setStatusCode($statusCode);
        $this->getErrorMessage($statusCode);
        $this->json();
    }
}
