<?php

namespace app\models;

use yii\db\ActiveRecord;

class Shipment extends ActiveRecord
{
    const STATUS_NEW = 0;         //Еще не взята в работу
    const STATUS_ACTIVE = 1;      //В пути
    const STATUS_DELIVERED = 2;   //Успешно доставлена
}