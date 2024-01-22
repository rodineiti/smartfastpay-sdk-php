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
    public static function createPayment($type)
    {
        switch ($type) {
            case 'pix':
                return new PixPaymentStrategy();
            case 'boleto':
                return new BoletoPaymentStrategy();
            case 'bank_transfer':
                return new BankTransferPaymentStrategy();
            case 'picpay':
                return new PicPayPaymentStrategy();
            case 'checkout':
                return new CheckoutPaymentStrategy();
            default:
                throw new InvalidArgumentException("Type payment not supported: $type");
        }
    }
}
