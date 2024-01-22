<?php

namespace Rodineiti\SmartfastpaySdk\Strategy\Payment\PicPay;

use InvalidArgumentException;
use GuzzleHttp\Exception\RequestException;
use Rodineiti\SmartfastpaySdk\Strategy\Payment\BasePayment;
use Rodineiti\SmartfastpaySdk\Exceptions\PixPaymentException;
use Rodineiti\SmartfastpaySdk\Contracts\ParamsInterface;

class PicPayPaymentStrategy extends BasePayment
{
    public function __construct()
    {
        parent::__construct();
        $this->resource = 'payment';
    }
    
    public function process(ParamsInterface $params)
    {
        if (!$params instanceof PicPayParams) {
            throw new InvalidArgumentException('The params must be an instance of PicPayParams');
        }

        try {
            $this->authenticate();

            $url = $this->config->getUrl() . '/picpay';
        
            $headers = [
                'Authorization' => 'Bearer ' . $this->access_token,
                'Content-Type' => 'application/json',
            ];
            
            $data = $params->getParams();

            return $this->httpClientAdapter->sendRequest('POST', $url, $headers, json_encode($data));
        } catch (RequestException $e) {
            throw new PixPaymentException('Error to process pay with picpay: ' . $e->getMessage());
        }
    }
}
