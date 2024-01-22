<?php

namespace Rodineiti\SmartfastpaySdk\Contracts;

use Rodineiti\SmartfastpaySdk\Config\Config;
use Rodineiti\SmartfastpaySdk\Http\HttpClientAdapter;

interface SettingsInterface
{
    public function setConfig(Config $config);
    public function setHttpClient(HttpClientAdapter $httpClientAdapter);
}
