<?php

namespace app\models\interfaces;

interface AccountInterface
{
    //Снять со счета
    public function minusAmount($amount);

    //Зачислить на счет
    public function plusAmount($amount);
}