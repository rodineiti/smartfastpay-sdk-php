<?php

namespace Rodineiti\SmartfastpaySdk\Strategy;

use Rodineiti\SmartfastpaySdk\Contracts\ParamsInterface;

class BaseParams implements ParamsInterface
{
    private $customer_id;
    private $name;
    private $email;
    private $document;
    private $amount;
    private $currency;

    public function __construct($customer_id, $name, $email, $document, $amount, $currency)
    {
        $this->customer_id = $customer_id;
        $this->name = $name;
        $this->email = $email;
        $this->document = $document;
        $this->amount = $amount;
        $this->currency = $currency;
    }

    public function getParams(): array
    {
        return [
            'customer_id' => $this->customer_id,
            'name' => $this->name,
            'email' => $this->email,
            'document' => $this->document,
            'amount' => $this->amount,
            'currency' => $this->currency,
        ];
    }
}