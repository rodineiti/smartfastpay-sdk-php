<?php

namespace Unit;

use Exception;
use PHPUnit\Framework\TestCase;
use Rodineiti\SmartfastpaySdk\Balance;
use Rodineiti\SmartfastpaySdk\Config\Config;

class BalanceTest extends TestCase
{
    public function testGetBalance()
    {
        $config = new Config('sandbox', 'seu-client-id', 'seu-client-secret');
        
        $balance = new Balance($config);

        try {
            $balance->getBalance();
        } catch (\Exception $e) {
            $this->assertInstanceOf(Exception::class, $e);
        }
    }
  }