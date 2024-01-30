<?php

namespace Rodineiti\SmartfastpaySdk\Traits;

use GuzzleHttp\Exception\RequestException;
use Symfony\Component\Cache\Adapter\FilesystemAdapter;
use Rodineiti\SmartfastpaySdk\Exceptions\NotFoundClientException;

trait AuthenticateTrait
{
    public function authenticate()
    {
        $this->validateAccessToken();

        try {
            $this->retrieveAccessToken();
        } catch (RequestException $e) {
            throw NotFoundClientException::fromRequestException($e);
        }
    }

    protected function validateAccessToken()
    {
        $cachedToken = $this->getAccessTokenFromCache();

        if ($cachedToken !== null && $cachedToken['expires_at'] > time()) {
            $this->access_token = $cachedToken['token'];
            $this->access_token_expires_at = $cachedToken['expires_at'];
            return;
        }
    }

    protected function retrieveAccessToken()
    {
        try {
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
        } catch (RequestException $e) {
            throw NotFoundClientException::fromRequestException($e);
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
}