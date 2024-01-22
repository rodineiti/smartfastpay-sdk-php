<?php

namespace Rodineiti\SmartfastpaySdk\Contracts;

interface TransactionStrategyInterface extends SettingsInterface
{
    public function process(ParamsInterface $params);
    public function getByUid(string $uid);
    public function getAll(FiltersInterface $filters);
}
