<?php

namespace Rodineiti\SmartfastpaySdk;

use Exception;
use GuzzleHttp\Exception\RequestException;
use Rodineiti\SmartfastpaySdk\Exceptions\PixPayoutException;
use Rodineiti\SmartfastpaySdk\Exceptions\NotFoundPayoutException;
use Rodineiti\SmartfastpaySdk\Contracts\ParamsInterface;
use Rodineiti\SmartfastpaySdk\Contracts\FiltersInterface;
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
            throw new Exception('Error on request process payout: ' . $requestException->getMessage());
        } catch (Exception $exception) {
            throw new Exception('The strategy for payout was not defined. ' . $exception->getMessage());
        }
    }

    public function getPayout(string $uid)
    {
        try {
            return $this->strategy->getByUid($uid);
        } catch (NotFoundPayoutException $notFoundPayoutException) {
            throw $notFoundPayoutException;
        } catch (RequestException $requestException) {
            throw new Exception('Error on request process payout: ' . $requestException->getMessage());
        } catch (Exception $exception) {
            throw new Exception('The strategy for payout was not defined. ' . $exception->getMessage());
        }
    }

    public function getAllPayouts(FiltersInterface $filters)
    {
        try {
            return $this->strategy->getAll($filters);
        } catch (RequestException $requestException) {
            throw new Exception('Error on request process payout: ' . $requestException->getMessage());
        } catch (Exception $exception) {
            throw new Exception('The strategy for payout was not defined. ' . $exception->getMessage());
        }
    }
}
