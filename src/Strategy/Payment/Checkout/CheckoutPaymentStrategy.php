<?php

namespace Rodineiti\SmartfastpaySdk\Strategy\Payment\Checkout;

use InvalidArgumentException;
use GuzzleHttp\Exception\RequestException;
use Rodineiti\SmartfastpaySdk\Strategy\Payment\BasePayment;
use Rodineiti\SmartfastpaySdk\Exceptions\PixPaymentException;
use Rodineiti\SmartfastpaySdk\Contracts\ParamsInterface;

class CheckoutPaymentStrategy extends BasePayment
{
    public function __construct()
    {
        parent::__construct();
        $this->resource = 'transaction';
    }

    public function process(ParamsInterface $params)
    {
        if (!$params instanceof CheckoutParams) {
            throw new InvalidArgumentException('The params must be an instance of CheckoutParams');
        }

        try {
            $this->authenticate();

            $url = $this->config->getUrl() . '/transaction/checkout';
        
            $headers = [
                'Authorization' => 'Bearer ' . $this->access_token,
                'Content-Type' => 'application/json',
            ];
            
            $data = $params->getParams();

            return $this->httpClientAdapter->sendRequest('POST', $url, $headers, json_encode($data));
        } catch (RequestException $e) {
            throw new PixPaymentException('Error to process pay with checkout: ' . $e->getMessage());
        }
    }
}
