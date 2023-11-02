<?php

namespace DataDome\FraudSdkSymfony\Tests\Unit\Mocks;

use Symfony\Component\HttpFoundation\HeaderBag;
use Symfony\Component\HttpFoundation\Request;

class MockRequest
{
    public static function getValidMockRequest(): Request
    {
        $requestMock = Request::create("/example", "POST");
        $requestMock->headers = new HeaderBag([
            "Accept" => "application/json",
            "Accept-Charset" => "utf-8",
            "Accept-Encoding" => "gzip",
            "Accept-Language" => "en-US",
            "X-Real-IP" => "127.0.0.1",
            "X-Forwarded-For" => "127.0.0.1",
            "Referer" => "http://example.com",
            "User-Agent" => "PHPUnit User Agent",
            "From" => "info@example.com",
            "Origin" => "http://example.com",
            "Connection" => "keep-alive",
            "Content-Type" => "application/json"
        ]);

        $_SERVER["SERVER_NAME"] = "serverName";

        return $requestMock;
    }
}