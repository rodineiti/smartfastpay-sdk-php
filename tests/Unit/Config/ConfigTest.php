<?php

namespace Unit\Config;

use PHPUnit\Framework\TestCase;
use Rodineiti\SmartfastpaySdk\Config\Config;

class ConfigTest extends TestCase
{
    public function testConfig()
    {
        $config = new Config('seu-client-id', 'seu-client-secret', 'sandbox');
        $this->assertEquals('sandbox', $config->getEnvironment());
        $this->assertEquals('seu-client-id', $config->getClient());
        $this->assertEquals('seu-client-secret', $config->getSecret());
    }
}