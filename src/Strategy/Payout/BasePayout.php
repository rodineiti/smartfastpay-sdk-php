<?php

namespace Rodineiti\SmartfastpaySdk\Strategy\Payout;

use Exception;
use GuzzleHttp\Exception\RequestException;
use Rodineiti\SmartfastpaySdk\Config\Config;
use Rodineiti\SmartfastpaySdk\Http\HttpClientAdapter;
use Symfony\Component\Cache\Adapter\FilesystemAdapter;
use Rodineiti\SmartfastpaySdk\Contracts\ParamsInterface;
use Rodineiti\SmartfastpaySdk\Contracts\FiltersInterface;
use Rodineiti\SmartfastpaySdk\Contracts\TransactionStrategyInterface;
use Rodineiti\SmartfastpaySdk\Exceptions\NotFoundPayoutException;

class BasePayout implements TransactionStrategyInterface
{
    protected $config;
    protected $httpClientAdapter;
    protected $access_token;
    protected $access_token_expires_at;
    protected $resource = 'payout';

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

    public function authenticate()
    {
        $this->validateAccessToken();

        try {
            $this->retrieveAccessToken();
        } catch (Exception $e) {
            throw new Exception('Failed to authenticate. ' . $e->getMessage());
        }
    }

    protected function validateAccessToken()
    {
        if ($this->access_token !== null && $this->access_token_expires_at > time()) {
            return;
        }

        $cachedToken = $this->getAccessTokenFromCache();

        if ($cachedToken !== null && $cachedToken['expires_at'] > time()) {
            $this->access_token = $cachedToken['token'];
            $this->access_token_expires_at = $cachedToken['expires_at'];
            return;
        }
    }

    protected function retrieveAccessToken()
    {
        $url = $this->config->getUrl() . '/oauth2/token';

        $base64Credentials = base64_encode($this->config->getClient() . ':' . $this->config->getSecret());

        $response = $this->httpClientAdapter->sendRequest('POST', $url, [
            'Authorization' => 'Basic ' . $base64Credentials,
            'Content-Type' => 'application/x-www-form-urlencoded',
        ]);

        $data = json_decode($response, true);

        if (isset($data['data']['access_token']) && isset($data['data']['expires_in'])) {
            $this->access_token = $data['data']['access_token'];
            $this->access_token_expires_at = time() + $data['data']['expires_in'];

            $this->saveAccessTokenToCache([
                'token' => $this->access_token,
                'expires_at' => $this->access_token_expires_at,
            ]);
        }
    }

    protected function getAccessTokenFromCache()
    {
        $cache = new FilesystemAdapter();

        $item = $cache->getItem('access_token');

        if ($item->isHit() && $item->get()['expires_at'] > time()) {
            return $item->get();
        }

        return null;
    }

    protected function saveAccessTokenToCache(array $tokenData)
    {
        $cache = new FilesystemAdapter();

        $item = $cache->getItem('access_token');
        $item->set($tokenData);
        $item->expiresAt(new \DateTime('@' . $tokenData['expires_at']));

        $cache->save($item);
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
            throw new NotFoundPayoutException('Failed to retrieve payout: ' . $e->getMessage());
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
            throw new NotFoundPayoutException('Failed to retrieve payouts: ' . $e->getMessage());
        }
    }
}