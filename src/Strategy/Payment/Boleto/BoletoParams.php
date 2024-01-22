<?php

namespace Rodineiti\SmartfastpaySdk\Strategy\Payment\Boleto;

use Rodineiti\SmartfastpaySdk\Strategy\BaseParams;

class BoletoParams extends BaseParams
{
    private $callback;
    private $transaction_id;
    private $address_1;
    private $address_2;
    private $number;
    private $neighborhood;
    private $city;
    private $state;
    private $postal_code;

    public function __construct(
        $customer_id,
        $name,
        $email,
        $document,
        $amount,
        $currency,
        $callback,
        $transaction_id,
        $address_1,
        $address_2,
        $number,
        $neighborhood,
        $city,
        $state,
        $postal_code
    )
    {
        parent::__construct($customer_id, $name, $email, $document, $amount, $currency);

        $this->callback = $callback;
        $this->transaction_id = $transaction_id;
        $this->address_1 = $address_1;
        $this->address_2 = $address_2;
        $this->number = $number;
        $this->neighborhood = $neighborhood;
        $this->city = $city;
        $this->state = $state;
        $this->postal_code = $postal_code;
    }

    public function getParams(): array
    {
        $baseParams = parent::getParams();

        return array_merge($baseParams, [
            'callback' => $this->callback,
            'transaction' => [
                'id' => $this->transaction_id
            ],
            'address' => [
                'address_1' => $this->address_1,
                'address_2' => $this->address_2,
                'number' => $this->number,
                'neighborhood' => $this->neighborhood,
                'city' => $this->city,
                'state' => $this->state,
                'postal_code' => $this->postal_code,
            ]
        ]);
    }
}
