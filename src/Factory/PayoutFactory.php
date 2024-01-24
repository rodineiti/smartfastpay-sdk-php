<?php

namespace Rodineiti\SmartfastpaySdk\Factory;

use InvalidArgumentException;
use Rodineiti\SmartfastpaySdk\Strategy\Payout\BankTransfer\BankTransferPayoutStrategy;
use Rodineiti\SmartfastpaySdk\Strategy\Payout\Pix\PixPayoutStrategy;

class PayoutFactory
{
    const PAYOUTS_METHOD = [
        'pix' => PixPayoutStrategy::class,
        'bank_transfer' => BankTransferPayoutStrategy::class
    ];

    public static function createPayout($type)
    {
        if (!isset(self::PAYOUTS_METHOD[$type])) {
            throw new InvalidArgumentException("Type payout not supported: $type");
        }
        
        $type = self::PAYOUTS_METHOD[$type];

        if (!class_exists($type)) {
            throw new InvalidArgumentException("Type payout not supported or class not exists: $type");
        }

        return new $type();
    }
}
