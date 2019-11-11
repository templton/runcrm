<?php

namespace app\models\interfaces;

use app\models\interfaces\AccountInterface;

interface AccountGettingInterface
{
    public function getAccount():AccountInterface;
}