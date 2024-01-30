<?php

namespace Rodineiti\SmartfastpaySdk;

use Exception;
use GuzzleHttp\Exception\RequestException;
use Rodineiti\SmartfastpaySdk\Contracts\ParamsInterface;
use Rodineiti\SmartfastpaySdk\Contracts\FiltersInterface;
use Rodineiti\SmartfastpaySdk\Exceptions\GenericException;
use Rodineiti\SmartfastpaySdk\Exceptions\PixPayoutException;
use Rodineiti\SmartfastpaySdk\Exceptions\NotFoundPayoutException;
use Rodineiti\SmartfastpaySdk\Exceptions\BankTransferPayoutException;

class Payout extends BaseSDK
{
    public function processPayout(ParamsInterface $params)
    {
        try {
            return $this->strategy->process($params);
        } catch (PixPayoutException $pixException) {
            throw $pixException;
        } catch (BankTransferPayoutException $bankTransferException) {
            throw $bankTransferException;
        } catch (RequestException $requestException) {
            throw $requestException;
        } catch (GenericException $genericException) {
            throw $genericException;
        } catch (Exception $exception) {
            throw $exception;
        }
    }

    public function getPayout(string $uid)
    {
        try {
            return $this->strategy->getByUid($uid);
        } catch (NotFoundPayoutException $notFoundPayoutException) {
            throw $notFoundPayoutException;
        } catch (RequestException $requestException) {
            throw $requestException;
        } catch (Exception $exception) {
            throw $exception;
        }
    }

    public function getAllPayouts(FiltersInterface $filters)
    {
        try {
            return $this->strategy->getAll($filters);
        } catch (RequestException $requestException) {
            throw $requestException;
        } catch (GenericException $genericException) {
            throw $genericException;
        } catch (Exception $exception) {
            throw $exception;
        }
    }
}
