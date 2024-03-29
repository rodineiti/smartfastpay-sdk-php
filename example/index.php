<?php

header("Content-Type: application/json");

ini_set("display_errors", 1);
ini_set("error_reporting", E_ALL);
ini_set('xdebug.overload_var_dump', 1);

require __DIR__ . '/../vendor/autoload.php';

use Rodineiti\SmartfastpaySdk\Payout;
use Rodineiti\SmartfastpaySdk\Balance;

use Rodineiti\SmartfastpaySdk\Payment;
use Rodineiti\SmartfastpaySdk\Merchant;
use Rodineiti\SmartfastpaySdk\Config\Config;

use Rodineiti\SmartfastpaySdk\Strategy\BaseFilters;

use Rodineiti\SmartfastpaySdk\Strategy\Payout\BasePayout;
use Rodineiti\SmartfastpaySdk\Strategy\Payment\BasePayment;
use Rodineiti\SmartfastpaySdk\Strategy\Payout\Pix\PixPayoutStrategy;
use Rodineiti\SmartfastpaySdk\Strategy\Payment\Pix\PixPaymentStrategy;
use Rodineiti\SmartfastpaySdk\Strategy\Payout\Pix\PixParams as PixParamsPayout;
use Rodineiti\SmartfastpaySdk\Strategy\Payment\Pix\PixParams as PixParamsPayment;

$config = new Config('client_id', 'client_secret');

// PAYMENT
$payment = new Payment($config);
$payment->setStrategy(new PixPaymentStrategy());

// CREATE PAYMENT
try {
    $respose = $payment->processPayment(new PixParamsPayment(
        uniqid(),
        'Rodinei Developer',
        'email@teste.com',
        '12345678909',
        2.00,
        'BRL',
        'http://example.com/callback',
        uniqid()
    ));
    
    echo $respose;
} catch (Exception $e) {
    echo $e->getMessage();
}

// GET PAYMENT
try {
    $respose = $payment->getPayment('a1b13b56-9831-40ab-b405-ac4315ea851f');
    
    echo $respose;
} catch (Exception $e) {
    echo $e->getMessage();
}

// OR
$basePayment = new BasePayment();
$basePayment->setConfig($config);
$basePayment->setResource('payment'); // payment or transaction

try {
    $respose = $basePayment->getByUid('a1b13b56-9831-40ab-b405-ac4315ea851f');
    
    echo $respose;
} catch (Exception $e) {
    echo $e->getMessage();
}

// GET ALL PAYMENTS
$filters = new BaseFilters();
$filters->setCustomerId('65aa775c9a53c');

try {
    $respose = $basePayment->getAll($filters);
    
    echo $respose;
} catch (Exception $e) {
    echo $e->getMessage();
}


// PAYOUT
$payout = new Payout($config);
$payout->setStrategy(new PixPayoutStrategy());

// CREATE PAYOUT
try {
    $respose = $payout->processPayout(new PixParamsPayout(
        uniqid(),
        'John Doe',
        'john.doe@example.com',
        '12345678909',
        2.00,
        'BRL',
        'http://example.com/callback',
        uniqid(),
        '12345678909'
    ));
    
    echo $respose;
} catch (Exception $e) {
    echo $e->getMessage();
}

// GET PAYOUT
try {
    $respose = $payout->getPayout('7632f029-3fd7-4e92-97f9-adb62b11322d');
    
    echo $respose;
} catch (Exception $e) {
    echo $e->getMessage();
}

// OR
$basePayout = new BasePayout();
$basePayout->setConfig($config);
$basePayout->setResource('payout'); // payout or transaction

try {
    $respose = $basePayout->getByUid('7632f029-3fd7-4e92-97f9-adb62b11322d');
    
    echo $respose;
} catch (Exception $e) {
    echo $e->getMessage();
}

$filters = new BaseFilters();
$filters->setCustomerId('ce631aee-4e83-45bc-bf97-e77d2bdcacb2');

try {
    $respose = $basePayout->getAll($filters);
    
    echo $respose;
} catch (Exception $e) {
    echo $e->getMessage();
}

// BALANCE
$balance = new Balance($config);

// GET BALANCE
try {
    $respose = $balance->getBalance();
    
    echo $respose;
} catch (Exception $e) {
    echo $e->getMessage();
}

// GET BALANCE BY CURRENCY
try {
    $respose = $balance->getBalance('USD');
    
    echo $respose;
} catch (Exception $e) {
    echo $e->getMessage();
}

// MERCHANT
$merchant = new Merchant($config);

// GET MERCHANT SECRET
try {
    $respose = $merchant->getSecret();
    
    echo $respose;
} catch (Exception $e) {
    echo $e->getMessage();
}