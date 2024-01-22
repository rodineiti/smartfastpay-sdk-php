<?php

namespace Rodineiti\SmartfastpaySdk\Contracts;

interface WalletInterface extends SettingsInterface
{
    public function getBalance(string $currency = null);
}
