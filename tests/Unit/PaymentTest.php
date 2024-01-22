<?php

namespace Unit;

use Exception;
use PHPUnit\Framework\TestCase;
use Rodineiti\SmartfastpaySdk\Payment;
use Rodineiti\SmartfastpaySdk\Config\Config;
use Rodineiti\SmartfastpaySdk\Contracts\ParamsInterface;
use Rodineiti\SmartfastpaySdk\Contracts\TransactionStrategyInterface;

class PaymentTest extends TestCase
{
    public function testProcessPayment()
    {
        $config = new Config('sandbox', 'seu-client-id', 'seu-client-secret');
        $paramsMock = $this->createMock(ParamsInterface::class);

        $payment = new Payment($config);

        $paymentStrategyMock = $this->getMockForAbstractClass(TransactionStrategyInterface::class);

        $paymentStrategyMock->expects($this->once())
            ->method('setConfig')
            ->with($config);

        $payment->setStrategy($paymentStrategyMock);

        try {
            $payment->processPayment($paramsMock);
        } catch (\Exception $e) {
            $this->assertInstanceOf(Exception::class, $e);
            $this->assertEquals('The strategy for payment was not defined. ' . $e->getMessage(), $e->getMessage());
        }
    }

    public function testGetPayment()
    {
        $config = new Config('sandbox', 'seu-client-id', 'seu-client-secret');
        
        $payment = new Payment($config);

        $paymentStrategyMock = $this->getMockForAbstractClass(TransactionStrategyInterface::class);

        $paymentStrategyMock->expects($this->once())
            ->method('setConfig')
            ->with($config);

        $payment->setStrategy($paymentStrategyMock);

        try {
            $payment->getPayment('uid');
        } catch (\Exception $e) {
            $this->assertInstanceOf(Exception::class, $e);
            $this->assertEquals('The strategy for payment was not defined. ' . $e->getMessage(), $e->getMessage());
        }
    }
  }