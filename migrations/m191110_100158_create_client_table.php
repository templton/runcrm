<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%clients}}`.
 */
class m191110_100158_create_client_table extends Migration
{
    const TABLE_NAME='client';
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
