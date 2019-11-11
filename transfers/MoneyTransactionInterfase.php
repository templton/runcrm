<?php

namespace app\transfers;

interface MoneyTransactionInterfase
{
    public function startTransaction(array $transferKeyParams);
}