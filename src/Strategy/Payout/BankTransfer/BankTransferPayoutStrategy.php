<?php

namespace Rodineiti\SmartfastpaySdk\Strategy\Payout\BankTransfer;

use InvalidArgumentException;
use GuzzleHttp\Exception\RequestException;
use Rodineiti\SmartfastpaySdk\Strategy\Payout\BasePayout;
use Rodineiti\SmartfastpaySdk\Exceptions\BankTransferPayoutException;
use Rodineiti\SmartfastpaySdk\Contracts\ParamsInterface;

class BankTransferPayoutStrategy extends BasePayout
{
    public function __construct()
    {
        parent::__construct();
        $this->resource = 'payout';
    }

    public function processPayout(ParamsInterface $params)
    {
        if (!$params instanceof BankTransferParams) {
            throw new InvalidArgumentException('The params must be an instance of BankTransferParams');
        }

        try {
            $this->authenticate();

            $url = $this->config->getUrl() . '/' . $this->resource;
        
            $headers = [
                'Authorization' => 'Bearer ' . $this->access_token,
                'Content-Type' => 'application/json',
            ];
            
            $data = $params->getParams();

            return $this->httpClientAdapter->sendRequest('POST', $url, $headers, json_encode($data));
        } catch (RequestException $e) {
            throw new BankTransferPayoutException('Error to process payout with bank transfer: ' . $e->getMessage());
        }
    }
}
