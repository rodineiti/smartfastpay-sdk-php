<?php

namespace Rodineiti\SmartfastpaySdk\Strategy\Payment\BankTransfer;

use Rodineiti\SmartfastpaySdk\Strategy\BaseParams;

class BankTransferParams extends BaseParams
{
    private $callback;
    private $transaction_id;
    private $payment_method = 'bank_transfer';

    public function __construct(
        $customer_id,
        $name,
        $email,
        $document,
        $amount,
        $currency,
        $callback,
        $transaction_id
    )
    {
        parent::__construct($customer_id, $name, $email, $document, $amount, $currency);

        $this->callback = $callback;
        $this->transaction_id = $transaction_id;
    }

    public function getParams(): array
    {
        $baseParams = parent::getParams();

        return array_merge($baseParams, [
            'callback' => $this->callback,
            'payment_method' => $this->payment_method,
            'transaction' => [
                'id' => $this->transaction_id
            ]
        ]);
    }
}
