<?php

namespace Rodineiti\SmartfastpaySdk\Strategy\Payout\BankTransfer;

use Rodineiti\SmartfastpaySdk\Strategy\BaseParams;

class BankTransferParams extends BaseParams
{
    private $callback;
    private $transaction_id;
    private $payout_method = 'bank_transfer';
    private $bankName;
    private $bankCode;
    private $bankAgency;
    private $bankAccount;
    private $bankAccountOperation;

    public function __construct(
        $customer_id,
        $name,
        $email,
        $document,
        $amount,
        $currency,
        $callback,
        $transaction_id,
        $bankName,
        $bankCode,
        $bankAgency,
        $bankAccount,
        $bankAccountOperation
    )
    {
        parent::__construct($customer_id, $name, $email, $document, $amount, $currency);

        $this->callback = $callback;
        $this->transaction_id = $transaction_id;
        $this->bankName = $bankName;
        $this->bankCode = $bankCode;
        $this->bankAgency = $bankAgency;
        $this->bankAccount = $bankAccount;
        $this->bankAccountOperation = $bankAccountOperation;
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
            'bank' => [
                'name' => $this->bankName,
                'code' => $this->bankCode,
                'agency' => $this->bankAgency,
                'account' => $this->bankAccount,
                'account_operation' => $this->bankAccountOperation
            ]
        ]);
    }
}
