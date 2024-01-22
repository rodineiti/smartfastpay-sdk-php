<?php

namespace Rodineiti\SmartfastpaySdk\Config;

class Config
{
    private $environment;
    private $url;
    private $client;
    private $secret;

    public function __construct($client, $secret, $environment = 'sandbox')
    {
        $this->environment = $environment;
        $this->client = $client;
        $this->secret = $secret;
        $this->setUrl();
    }

    private function setUrl()
    {
        $baseUrl = ($this->environment === 'sandbox') ? 'https://sandbox.smartfastpay.com' : 'https://api.smartfastpay.com';
        $this->url = $baseUrl;
    }

    public function getUrl()
    {
        return $this->url;
    }

    public function getClient()
    {
        return $this->client;
    }

    public function getSecret()
    {
        return $this->secret;
    }

    public function getEnvironment()
    {
        return $this->environment;
    }
}
