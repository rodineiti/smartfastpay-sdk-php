<?php

namespace Rodineiti\SmartfastpaySdk\Exceptions;

use Exception;
use GuzzleHttp\Exception\RequestException;

class GenericException extends Exception
{
    private $requestId;
    private $moreInformation;

    public function __construct($requestId, $moreInformation = [], $code = 0)
    {
        $this->requestId = $requestId;
        $this->moreInformation = $moreInformation;

        $message = json_encode([
            'requestId' => $this->requestId,
            'moreInformation' => $this->moreInformation,
        ]);

        parent::__construct($message, $code);
    }

    public function getRequestId()
    {
        return $this->requestId;
    }

    public function getMoreInformation()
    {
        return $this->moreInformation;
    }

    public static function fromRequestException(RequestException $e)
    {
        $response = $e->getResponse();
        $code = $e->getCode();
        $requestId = md5(uniqid());
        $moreInformation = [];

        if ($response) {
            $body = json_decode($response->getBody(), true);
            if (is_array($body)) {
                if (isset($body['requestId'], $body['moreInformation'])) {
                    $requestId = $body['requestId'];
                    $moreInformation = $body['moreInformation'];
                }

                if (isset($body['requestId'], $body['status'], $body['payload'])) {
                    $requestId = $body['requestId'];
                    $moreInformation = ['status' => $body['status'], 'payload' => $body['payload']];
                }
            }
        }

        return new self($requestId, $moreInformation, $code);
    }
}
