<?php

namespace Rodineiti\SmartfastpaySdk;

use Exception;
use GuzzleHttp\Exception\RequestException;
use Rodineiti\SmartfastpaySdk\Config\Config;
use Rodineiti\SmartfastpaySdk\Contracts\MerchantInterface;
use Rodineiti\SmartfastpaySdk\Http\HttpClientAdapter;
use Rodineiti\SmartfastpaySdk\Traits\AuthenticateTrait;

class Merchant implements MerchantInterface
{
    use AuthenticateTrait;

    protected $config;
    protected $httpClientAdapter;
    protected $access_token;

    public function __construct(Config $config)
    {
        $this->httpClientAdapter = new HttpClientAdapter();
        $this->setConfig($config);
    }

    public function setConfig(Config $config)
    {
        $this->config = $config;
    }

    public function setHttpClient(HttpClientAdapter $httpClientAdapter)
    {
        $this->httpClientAdapter = $httpClientAdapter;
    }
    
    public function getSecret()
    {
        try {
            $this->authenticate();

            $url = $this->config->getUrl() . "/webhook/secret";
        
            $headers = [
                'Authorization' => 'Bearer ' . $this->access_token,
                'Content-Type' => 'application/json',
            ];
            
            return $this->httpClientAdapter->sendRequest('GET', $url, $headers);
        } catch (RequestException $e) {
            throw new Exception('Failed to retrieve payments: ' . $e->getMessage());
        }
    }
}
