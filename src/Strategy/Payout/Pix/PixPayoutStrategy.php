<?php

namespace Rodineiti\SmartfastpaySdk\Strategy\Payout\Pix;

use InvalidArgumentException;
use GuzzleHttp\Exception\RequestException;
use Rodineiti\SmartfastpaySdk\Strategy\Payout\BasePayout;
use Rodineiti\SmartfastpaySdk\Exceptions\PixPayoutException;
use Rodineiti\SmartfastpaySdk\Contracts\ParamsInterface;

class PixPayoutStrategy extends BasePayout
{
    public function __construct()
    {
        parent::__construct();
        $this->resource = 'payout';
    }
    
    public function process(ParamsInterface $params)
    {
        if (!$params instanceof PixParams) {
            throw new InvalidArgumentException('The params must be an instance of PixParams');
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
            throw new PixPayoutException('Error to process payout with pix: ' . $e->getMessage());
        }
    }
}
