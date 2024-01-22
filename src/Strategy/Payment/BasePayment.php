<?php

namespace Rodineiti\SmartfastpaySdk\Strategy\Payment;

use GuzzleHttp\Exception\RequestException;
use Rodineiti\SmartfastpaySdk\Config\Config;
use Rodineiti\SmartfastpaySdk\Http\HttpClientAdapter;
use Rodineiti\SmartfastpaySdk\Contracts\ParamsInterface;
use Rodineiti\SmartfastpaySdk\Contracts\FiltersInterface;
use Rodineiti\SmartfastpaySdk\Contracts\TransactionStrategyInterface;
use Rodineiti\SmartfastpaySdk\Exceptions\NotFoundPaymentException;
use Rodineiti\SmartfastpaySdk\Traits\AuthenticateTrait;

class BasePayment implements TransactionStrategyInterface
{
    use AuthenticateTrait;
    
    protected $config;
    protected $httpClientAdapter;
    protected $access_token;
    protected $access_token_expires_at;
    protected $resource = 'payment';

    public function __construct()
    {
        $this->httpClientAdapter = new HttpClientAdapter();
    }

    public function setConfig(Config $config)
    {
        $this->config = $config;
    }

    public function setHttpClient(HttpClientAdapter $httpClientAdapter)
    {
        $this->httpClientAdapter = $httpClientAdapter;
    }

    public function setResource(string $resource)
    {
        $this->resource = $resource;
    }

    public function process(ParamsInterface $params)
    {}

    public function getByUid(string $uid)
    {
        try {
            $this->authenticate();

            $url = $this->config->getUrl() . "/{$this->resource}/{$uid}";
        
            $headers = [
                'Authorization' => 'Bearer ' . $this->access_token,
                'Content-Type' => 'application/json',
            ];
            
            return $this->httpClientAdapter->sendRequest('GET', $url, $headers);
        } catch (RequestException $e) {
            throw new NotFoundPaymentException('Failed to retrieve payment: ' . $e->getMessage());
        }
    }

    public function getAll(FiltersInterface $filters)
    {
        try {
            $this->authenticate();

            $url = $this->config->getUrl() . "/{$this->resource}s?" . http_build_query($filters->getFilters());
        
            $headers = [
                'Authorization' => 'Bearer ' . $this->access_token,
                'Content-Type' => 'application/json',
            ];
            
            return $this->httpClientAdapter->sendRequest('GET', $url, $headers);
        } catch (RequestException $e) {
            throw new NotFoundPaymentException('Failed to retrieve payments: ' . $e->getMessage());
        }
    }
}