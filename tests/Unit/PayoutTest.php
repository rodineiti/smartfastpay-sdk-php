<?php

namespace Unit;

use Exception;
use PHPUnit\Framework\TestCase;
use Rodineiti\SmartfastpaySdk\Payout;
use Rodineiti\SmartfastpaySdk\Config\Config;
use Rodineiti\SmartfastpaySdk\Contracts\ParamsInterface;
use Rodineiti\SmartfastpaySdk\Contracts\TransactionStrategyInterface;

class PayoutTest extends TestCase
{
    public function testProcessPayout()
    {
        $config = new Config('seu-client-id', 'seu-client-secret');
        $paramsMock = $this->createMock(ParamsInterface::class);

        $payout = new Payout($config);

        $payoutStrategyMock = $this->getMockForAbstractClass(TransactionStrategyInterface::class);

        $payoutStrategyMock->expects($this->once())
            ->method('setConfig')
            ->with($config);

        $payout->setStrategy($payoutStrategyMock);

        try {
            $payout->processPayout($paramsMock);
        } catch (\Exception $e) {
            $this->assertInstanceOf(Exception::class, $e);
            $this->assertEquals('The strategy for payout was not defined. ' . $e->getMessage(), $e->getMessage());
        }
    }

    public function testGetPayout()
    {
        $config = new Config('seu-client-id', 'seu-client-secret');
        
        $payout = new Payout($config);

        $payoutStrategyMock = $this->getMockForAbstractClass(TransactionStrategyInterface::class);

        $payoutStrategyMock->expects($this->once())
            ->method('setConfig')
            ->with($config);

        $payout->setStrategy($payoutStrategyMock);

        try {
            $payout->getPayout('uid');
        } catch (\Exception $e) {
            $this->assertInstanceOf(Exception::class, $e);
            $this->assertEquals('The strategy for payout was not defined. ' . $e->getMessage(), $e->getMessage());
        }
    }
  }