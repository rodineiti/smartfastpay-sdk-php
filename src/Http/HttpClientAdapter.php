<?php

namespace Rodineiti\SmartfastpaySdk\Http;

use Exception;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;

class HttpClientAdapter
{
    private $client;
    private $retryAttempts;

    public function __construct($retryAttempts = 3)
    {
        $this->client = new Client();
        $this->retryAttempts = $retryAttempts;
    }

    public function sendRequest($method, $url, $headers = [], $body = null)
    {
        $retryCount = 0;

        do {
            try {
                $response = $this->client->request($method, $url, [
                    'headers' => $headers,
                    'body' => $body,
                ]);

                return $response->getBody()->getContents();
            } catch (RequestException $e) {
                if ($this->shouldRetry($e, $retryCount)) {
                    // wait for a short time before retrying
                    usleep(500000); // 500ms
                    $retryCount++;
                    continue;
                }

                throw $e;
            }
        } while ($retryCount < $this->retryAttempts);

        throw new Exception('Number of retries exceeded.');
    }

    private function shouldRetry(RequestException $e, $retryCount)
    {
        $retryCodes = [502, 503, 504];
        return in_array($e->getResponse()->getStatusCode(), $retryCodes) && $retryCount < $this->retryAttempts;
    }
}
