<?php

use yii\db\Migration;

/**
 * Class m191110_083548_create_table_locations
 */
class m191110_083548_create_location_table extends Migration
{

    const TABLE_NAME='location';

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable(self::TABLE_NAME, [
            'id'=>$this->primaryKey(),
            'title'=>$this->string(),
            'address_id'=>$this->integer()
        ]);

        $this->addForeignKey(
            'fk-'.self::TABLE_NAME.'-address_id',
            self::TABLE_NAME,
            'address_id',
            'address',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk-'.self::TABLE_NAME.'-address_id', self::TABLE_NAME);
        $this->dropTable(self::TABLE_NAME);
    }
}
