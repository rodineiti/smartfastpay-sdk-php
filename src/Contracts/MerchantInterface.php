<?php

namespace Rodineiti\SmartfastpaySdk\Contracts;

interface MerchantInterface extends SettingsInterface
{
    public function getSecret();
}
