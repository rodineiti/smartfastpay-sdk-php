<?php

namespace Rodineiti\SmartfastpaySdk\Strategy\Payment\Checkout;

use Rodineiti\SmartfastpaySdk\Strategy\BaseParams;

class CheckoutParams extends BaseParams
{
    private $callback;
    private $transaction_id;
    private $redirect_url = null;
    private $redirect_type = 'URL';
    private $method = [];

    public function __construct(
        $customer_id,
        $name,
        $email,
        $document,
        $amount,
        $currency,
        $callback,
        $transaction_id,
        $redirect_url = null,
        $redirect_type = 'URL',
        $method = []
    )
    {
        parent::__construct($customer_id, $name, $email, $document, $amount, $currency);

        $this->callback = $callback;
        $this->transaction_id = $transaction_id;
        $this->redirect_url = $redirect_url;
        $this->redirect_type = $redirect_type;
        $this->method = $method;
    }

    public function getParams(): array
    {
        $baseParams = parent::getParams();

        $extraParams = [
            'callback' => $this->callback,
            'transaction' => [
                'id' => $this->transaction_id,
                'redirect' => [
                    'url' => $this->redirect_url ?? '',
                    'type' => $this->redirect_type
                ]
            ]
        ];

        if (!empty($this->method)) {
            $extraParams['payment'] = [
                'method' => $this->method
            ];
        }

        return array_merge($baseParams, $extraParams);
    }
}
