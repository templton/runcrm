<?php

use yii\db\Migration;

class m191110_100218_create_courier_table extends Migration
{
    const TABLE_NAME='courier';

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable(self::TABLE_NAME, [
            'id' => $this->primaryKey(),
            'name'=>$this->string(),
            'surname'=>$this->string()
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable(self::TABLE_NAME);
    }
}
