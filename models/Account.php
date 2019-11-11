<?php

/**
 * Финансовый счет
 */

namespace app\models;

use yii\db\ActiveRecord;
use app\models\interfaces\AccountInterface;

class Account extends ActiveRecord implements AccountInterface
{
    public function plusAmount($amount)
    {
        // TODO: Implement plusAmount() method.
    }

    public function minusAmount($amount)
    {
        // TODO: Implement minusAmount() method.
    }
}