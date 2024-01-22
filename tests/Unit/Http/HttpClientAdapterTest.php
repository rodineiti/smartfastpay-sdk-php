<?php

namespace Unit\Http;

use PHPUnit\Framework\TestCase;
use Rodineiti\SmartfastpaySdk\Http\HttpClientAdapter;

class HttpClientAdapterTest extends TestCase
{
    public function testSendRequest()
    {
        $httpClientAdapterMock = $this->createMock(HttpClientAdapter::class);
        
        $httpClientAdapterMock
          ->expects($this->any())
          ->method('sendRequest')
          ->willReturn('Mocked response');

        $response = $httpClientAdapterMock->sendRequest('GET', 'https://example.com');

        $this->assertIsString($response);
    }
}