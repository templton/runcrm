<?php

use yii\db\Migration;

/**
 * Class m191110_083150_create_table_address
 */
class m191110_083150_create_address_table extends Migration
{

    const TABLE_NAME='address';

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable(self::TABLE_NAME, [
            'id'=>$this->primaryKey(),
            'town'=>$this->string(),
            'street'=>$this->string(),
            'house'=>$this->integer()
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
