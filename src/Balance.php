<?php

namespace Rodineiti\SmartfastpaySdk;

use GuzzleHttp\Exception\RequestException;
use Rodineiti\SmartfastpaySdk\Config\Config;
use Rodineiti\SmartfastpaySdk\Http\HttpClientAdapter;
use Rodineiti\SmartfastpaySdk\Traits\AuthenticateTrait;
use Rodineiti\SmartfastpaySdk\Contracts\WalletInterface;
use Rodineiti\SmartfastpaySdk\Exceptions\NotFoundException;

class Balance implements WalletInterface
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
    
    public function getBalance(string $currency = null)
    {
        try {
            $this->authenticate();

            $filters = ['currency' => $currency];

            $url = $this->config->getUrl() . "/balance?" . http_build_query($filters);
        
            $headers = [
                'Authorization' => 'Bearer ' . $this->access_token,
                'Content-Type' => 'application/json',
            ];
            
            return $this->httpClientAdapter->sendRequest('GET', $url, $headers);
        } catch (RequestException $e) {
            throw NotFoundException::fromRequestException($e);
        }
    }
}
