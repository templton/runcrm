<?php

namespace app\models;

use yii\db\ActiveRecord;

class Location extends ActiveRecord
{
    public function getAddress(){
        return $this->hasOne(Address::className(), ['id'=>'address_id']);
    }

    public function getTasks(){
        return $this->hasMany(Location::className(), ['id', 'location_id'])->inverseOf('location');
    }
}