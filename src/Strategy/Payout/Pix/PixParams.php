<?php

namespace Rodineiti\SmartfastpaySdk\Strategy\Payout\Pix;

use Rodineiti\SmartfastpaySdk\Strategy\BaseParams;

class PixParams extends BaseParams
{
    private $callback;
    private $transaction_id;
    private $payout_method = 'pix';
    private $pix_key;

    public function __construct(
        $customer_id,
        $name,
        $email,
        $document,
        $amount,
        $currency,
        $callback,
        $transaction_id,
        $pix_key
    )
    {
        parent::__construct($customer_id, $name, $email, $document, $amount, $currency);

        $this->callback = $callback;
        $this->transaction_id = $transaction_id;
        $this->pix_key = $pix_key;
    }

    public function getParams(): array
    {
        $baseParams = parent::getParams();

        return array_merge($baseParams, [
            'callback' => $this->callback,
            'payout_method' => $this->payout_method,
            'transaction' => [
                'id' => $this->transaction_id
            ],
            'pix' => [
                'key' => $this->pix_key
            ]
        ]);
    }
}
