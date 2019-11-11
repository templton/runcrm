<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%task}}`.
 */
class m191110_101845_create_task_table extends Migration
{
    const TABLE_NAME='task';

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable(self::TABLE_NAME, [
            'id' => $this->primaryKey(),
            'courier_id'=>$this->integer(),
            'location_id'=>$this->integer(),
            'title'=>$this->string(),
            'in_process'=>"ENUM('0','1','2') DEFAULT '0'"
        ]);

        $this->addForeignKey(
            'fk-'.self::TABLE_NAME.'-courier_id',
            self::TABLE_NAME,
            'courier_id',
            'courier',
            'id',
            'CASCADE'
        );

        $this->addForeignKey(
            'fk-'.self::TABLE_NAME.'-location_id',
            self::TABLE_NAME,
            'location_id',
            'location',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk-'.self::TABLE_NAME.'-courier_id', self::TABLE_NAME);
        $this->dropForeignKey('fk-'.self::TABLE_NAME.'-location_id', self::TABLE_NAME);
        $this->dropTable(self::TABLE_NAME);
    }
}
