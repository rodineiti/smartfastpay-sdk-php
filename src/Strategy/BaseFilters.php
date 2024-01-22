<?php

namespace Rodineiti\SmartfastpaySdk\Strategy;

use Rodineiti\SmartfastpaySdk\Contracts\FiltersInterface;

class BaseFilters implements FiltersInterface
{
    private $type;
    private $transaction_id;
    private $status;
    private $sort;
    private $start_time;
    private $end_time;
    private $customer_id;
    private $limit = 10;
    private $page = 1;

    public function __construct($customer_id = null, $type = null, $transaction_id = null, $status = null, $sort = null, $start_time = null, $end_time = null, $limit = 10, $page = 1)
    {
        $this->customer_id = $customer_id;
        $this->type = $type;
        $this->transaction_id = $transaction_id;
        $this->status = $status;
        $this->sort = $sort;
        $this->start_time = $start_time;
        $this->end_time = $end_time;
        $this->limit = $limit;
        $this->page = $page;
    }

    public function setCustomerId($customer_id)
    {
        $this->customer_id = $customer_id;
    }

    public function setType($type)
    {
        $this->type = $type;
    }

    public function setTransactionId($transaction_id)
    {
        $this->transaction_id = $transaction_id;
    }

    public function setStatus($status)
    {
        $this->status = $status;
    }

    public function setSort($sort)
    {
        $this->sort = $sort;
    }

    public function setStartTime($start_time)
    {
        $this->start_time = $start_time;
    }

    public function setEndTime($end_time)
    {
        $this->end_time = $end_time;
    }

    public function setLimit($limit)
    {
        $this->limit = $limit;
    }

    public function setPage($page)
    {
        $this->page = $page;
    }

    public function getFilters(): array
    {
        return [
            'customer_id' => $this->customer_id,
            'type' => $this->type,
            'transaction_id' => $this->transaction_id,
            'status' => $this->status,
            'sort' => $this->sort,
            'start_time' => $this->start_time,
            'end_time' => $this->end_time,
            'limit' => $this->limit,
            'page' => $this->page,
        ];
    }
}