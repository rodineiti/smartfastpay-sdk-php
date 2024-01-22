<?php

namespace Unit\Strategy\Payout\Pix;

use PHPUnit\Framework\TestCase;
use Rodineiti\SmartfastpaySdk\Config\Config;
use Rodineiti\SmartfastpaySdk\Http\HttpClientAdapter;
use Rodineiti\SmartfastpaySdk\Strategy\Payout\BankTransfer\BankTransferParams;
use Rodineiti\SmartfastpaySdk\Strategy\Payout\BankTransfer\BankTransferPayoutStrategy;

class BankTransferPayoutStrategyTest extends TestCase
{
    public function testBankTransferPayoutProcess()
    {
        $httpClientAdapterMock = $this->createMock(HttpClientAdapter::class);

        $httpClientAdapterMock
            ->expects($this->any())
            ->method('sendRequest')
            ->willReturn('Mocked response');

        $payoutConfig = new Config('sandbox', 'seu-client-id', 'seu-client-secret');
        $amount = 100.00;
        $params = new BankTransferParams(
            '58f0c005-3b7d-4c75-81f3-93b9a6fee864',
            'John Doe',
            'john.doe@example.com',
            '12345678909',
            $amount,
            'BRL',
            'http://example.com/callback',
            'b08e3897-6505-4bb4-81a5-6e3a1d29e277',
            'aaa',
            'aaa',
            'aaa',
            'aaa',
            'aaa',
        );

        $payoutStrategy = new BankTransferPayoutStrategy();
        $payoutStrategy->setConfig($payoutConfig);
        $payoutStrategy->setHttpClient($httpClientAdapterMock);

        $response = $payoutStrategy->processPayout($params);

        $this->assertIsString($response);
    }

    public function testBankTransferGetPayoutByUid()
    {
        $httpClientAdapterMock = $this->createMock(HttpClientAdapter::class);

        $httpClientAdapterMock
            ->expects($this->any())
            ->method('sendRequest')
            ->willReturn('Mocked response');

        $payoutConfig = new Config('sandbox', 'seu-client-id', 'seu-client-secret');
        $payoutStrategy = new BankTransferPayoutStrategy();
        $payoutStrategy->setConfig($payoutConfig);
        $payoutStrategy->setHttpClient($httpClientAdapterMock);

        $response = $payoutStrategy->getByUid('58f0c005-3b7d-4c75-81f3-93b9a6fee864');

        $this->assertIsString($response);
    }
}