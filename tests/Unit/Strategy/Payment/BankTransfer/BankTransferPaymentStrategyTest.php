<?php

namespace Unit\Strategy\Payment\Pix;

use PHPUnit\Framework\TestCase;
use Rodineiti\SmartfastpaySdk\Config\Config;
use Rodineiti\SmartfastpaySdk\Http\HttpClientAdapter;
use Rodineiti\SmartfastpaySdk\Strategy\Payment\BankTransfer\BankTransferParams;
use Rodineiti\SmartfastpaySdk\Strategy\Payment\BankTransfer\BankTransferPaymentStrategy;

class BankTransferPaymentStrategyTest extends TestCase
{
    public function testBankTransferPaymentProcess()
    {
        $httpClientAdapterMock = $this->createMock(HttpClientAdapter::class);

        $httpClientAdapterMock
            ->expects($this->any())
            ->method('sendRequest')
            ->willReturn('Mocked response');

        $paymentConfig = new Config('seu-client-id', 'seu-client-secret');
        $amount = 100.00;
        $params = new BankTransferParams(
            '58f0c005-3b7d-4c75-81f3-93b9a6fee864',
            'John Doe',
            'john.doe@example.com',
            '12345678909',
            $amount,
            'BRL',
            'http://example.com/callback',
            'b08e3897-6505-4bb4-81a5-6e3a1d29e277'
        );

        $paymentStrategy = new BankTransferPaymentStrategy();
        $paymentStrategy->setConfig($paymentConfig);
        $paymentStrategy->setHttpClient($httpClientAdapterMock);

        $response = $paymentStrategy->processPayment($params);

        $this->assertIsString($response);
    }

    public function testBankTransferGetPaymentByUid()
    {
        $httpClientAdapterMock = $this->createMock(HttpClientAdapter::class);

        $httpClientAdapterMock
            ->expects($this->any())
            ->method('sendRequest')
            ->willReturn('Mocked response');

        $paymentConfig = new Config('seu-client-id', 'seu-client-secret');
        $paymentStrategy = new BankTransferPaymentStrategy();
        $paymentStrategy->setConfig($paymentConfig);
        $paymentStrategy->setHttpClient($httpClientAdapterMock);

        $response = $paymentStrategy->getByUid('58f0c005-3b7d-4c75-81f3-93b9a6fee864');

        $this->assertIsString($response);
    }
}