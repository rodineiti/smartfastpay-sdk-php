<?php

namespace Unit;

use Exception;
use PHPUnit\Framework\TestCase;
use Rodineiti\SmartfastpaySdk\Merchant;
use Rodineiti\SmartfastpaySdk\Config\Config;

class MerchantTest extends TestCase
{
    public function testGetSecret()
    {
        $config = new Config('sandbox', 'seu-client-id', 'seu-client-secret');
        
        $merchant = new Merchant($config);

        try {
            $merchant->getSecret();
        } catch (\Exception $e) {
            $this->assertInstanceOf(Exception::class, $e);
        }
    }
  }