<?php

namespace Rodineiti\SmartfastpaySdk\Factory;

use InvalidArgumentException;
use Rodineiti\SmartfastpaySdk\Strategy\Payment\BankTransfer\BankTransferPaymentStrategy;
use Rodineiti\SmartfastpaySdk\Strategy\Payment\Pix\PixPaymentStrategy;
use Rodineiti\SmartfastpaySdk\Strategy\Payment\Boleto\BoletoPaymentStrategy;
use Rodineiti\SmartfastpaySdk\Strategy\Payment\PicPay\PicPayPaymentStrategy;
use Rodineiti\SmartfastpaySdk\Strategy\Payment\Checkout\CheckoutPaymentStrategy;

class PaymentFactory
{
    const PAYMENTS_METHOD = [
        'pix' => PixPaymentStrategy::class,
        'boleto' => BoletoPaymentStrategy::class,
        'bank_transfer' => BankTransferPaymentStrategy::class,
        'picpay' => PicPayPaymentStrategy::class,
        'checkout' => CheckoutPaymentStrategy::class
    ];

    public static function createPayment($type)
    {
        if (!isset(self::PAYMENTS_METHOD[$type])) {
            throw new InvalidArgumentException("Type payment not supported: $type");
        }
        
        $type = self::PAYMENTS_METHOD[$type];

        if (!class_exists($type)) {
            throw new InvalidArgumentException("Type payment not supported or class not exists: $type");
        }

        return new $type();
    }
}
