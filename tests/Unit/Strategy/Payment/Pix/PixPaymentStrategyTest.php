<?php

namespace Unit\Strategy\Payment\Pix;

use PHPUnit\Framework\TestCase;
use Rodineiti\SmartfastpaySdk\Config\Config;
use Rodineiti\SmartfastpaySdk\Http\HttpClientAdapter;
use Rodineiti\SmartfastpaySdk\Strategy\Payment\Pix\PixParams;
use Rodineiti\SmartfastpaySdk\Strategy\Payment\Pix\PixPaymentStrategy;

class PixPaymentStrategyTest extends TestCase
{
    public function testPixPaymentProcess()
    {
        $httpClientAdapterMock = $this->createMock(HttpClientAdapter::class);

        $httpClientAdapterMock
            ->expects($this->any())
            ->method('sendRequest')
            ->willReturn('Mocked response');

        $paymentConfig = new Config('seu-client-id', 'seu-client-secret');
        $amount = 100.00;
        $params = new PixParams(
            '58f0c005-3b7d-4c75-81f3-93b9a6fee864',
            'John Doe',
            'john.doe@example.com',
            '12345678909',
            $amount,
            'BRL',
            'http://example.com/callback',
            'b08e3897-6505-4bb4-81a5-6e3a1d29e277'
        );

        $paymentStrategy = new PixPaymentStrategy();
        $paymentStrategy->setConfig($paymentConfig);
        $paymentStrategy->setHttpClient($httpClientAdapterMock);

        $response = $paymentStrategy->process($params);

        $this->assertIsString($response);
    }
}