<?php

namespace Rodineiti\SmartfastpaySdk;

use Rodineiti\SmartfastpaySdk\Config\Config;
use Rodineiti\SmartfastpaySdk\Contracts\TransactionStrategyInterface;

abstract class BaseSDK
{
    protected $config;
    protected $strategy;

    public function __construct(Config $config)
    {
        $this->config = $config;
    }

    public function setStrategy(TransactionStrategyInterface $strategy)
    {
        $this->strategy = $strategy;
        
        $this->strategy->setConfig($this->config);
    }
}