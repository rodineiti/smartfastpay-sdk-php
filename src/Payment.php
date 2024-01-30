<?php

namespace Rodineiti\SmartfastpaySdk;

use Exception;
use GuzzleHttp\Exception\RequestException;
use Rodineiti\SmartfastpaySdk\Contracts\ParamsInterface;
use Rodineiti\SmartfastpaySdk\Contracts\FiltersInterface;
use Rodineiti\SmartfastpaySdk\Exceptions\PixPaymentException;
use Rodineiti\SmartfastpaySdk\Exceptions\BoletoPaymentException;
use Rodineiti\SmartfastpaySdk\Exceptions\CheckoutPaymentException;
use Rodineiti\SmartfastpaySdk\Exceptions\PicPayPaymentException;
use Rodineiti\SmartfastpaySdk\Exceptions\BankTransferPaymentException;
use Rodineiti\SmartfastpaySdk\Exceptions\GenericException;
use Rodineiti\SmartfastpaySdk\Exceptions\NotFoundPaymentException;

class Payment extends BaseSDK
{
    public function processPayment(ParamsInterface $params)
    {
        try {
            return $this->strategy->process($params);
        } catch (PixPaymentException $pixException) {
            throw $pixException;
        } catch (BoletoPaymentException $boletoException) {
            throw $boletoException;
        } catch (BankTransferPaymentException $bankTransferException) {
            throw $bankTransferException;
        } catch (PicPayPaymentException $picPayException) {
            throw $picPayException;
        } catch (CheckoutPaymentException $checkoutException) {
            throw $checkoutException;
        } catch (RequestException $requestException) {
            throw $requestException;
        } catch (GenericException $genericException) {
            throw $genericException;
        } catch (Exception $exception) {
            throw $exception;
        }
    }

    public function getPayment(string $uid)
    {
        try {
            return $this->strategy->getByUid($uid);
        } catch (NotFoundPaymentException $notFoundPaymentException) {
            throw $notFoundPaymentException;
        } catch (RequestException $requestException) {
            throw $requestException;
        } catch (GenericException $genericException) {
            throw $genericException;
        } catch (Exception $exception) {
            throw $exception;
        }
    }

    public function getAllPayments(FiltersInterface $filters)
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
