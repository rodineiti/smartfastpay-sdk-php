<?php

namespace Unit\Http;

use PHPUnit\Framework\TestCase;
use Rodineiti\SmartfastpaySdk\Factory\PaymentFactory;
use Rodineiti\SmartfastpaySdk\Contracts\TransactionStrategyInterface;

class PaymentFactoryTest extends TestCase
{
    public function testPaymentFactory()
    {
        $paymentFactory = PaymentFactory::createPayment('checkout');

        $this->assertInstanceOf(TransactionStrategyInterface::class, $paymentFactory);
    }
}