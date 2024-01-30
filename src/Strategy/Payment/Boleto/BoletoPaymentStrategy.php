<?php

namespace Rodineiti\SmartfastpaySdk\Strategy\Payment\Boleto;

use InvalidArgumentException;
use GuzzleHttp\Exception\RequestException;
use Rodineiti\SmartfastpaySdk\Strategy\Payment\BasePayment;
use Rodineiti\SmartfastpaySdk\Exceptions\BoletoPaymentException;
use Rodineiti\SmartfastpaySdk\Contracts\ParamsInterface;

class BoletoPaymentStrategy extends BasePayment
{
    public function __construct()
    {
        parent::__construct();
        $this->resource = 'payment';
    }
    
    public function process(ParamsInterface $params)
    {
        if (!$params instanceof BoletoParams) {
            throw new InvalidArgumentException('The params must be an instance of BoletoParams');
        }

        try {
            $this->authenticate();

            $url = $this->config->getUrl() . '/boleto';
        
            $headers = [
                'Authorization' => 'Bearer ' . $this->access_token,
                'Content-Type' => 'application/json',
            ];
            
            $data = $params->getParams();

            return $this->httpClientAdapter->sendRequest('POST', $url, $headers, json_encode($data));
        } catch (RequestException $e) {
            throw BoletoPaymentException::fromRequestException($e);
        }
    }
}
