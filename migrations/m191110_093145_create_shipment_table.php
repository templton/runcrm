<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%shipment}}`.
 */
class m191110_093145_create_shipment_table extends Migration
{

    const TABLE_NAME='shipment';

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable(self::TABLE_NAME, [
            'id' => $this->primaryKey(),
            'order_id'=>$this->integer(),
            'title'=>$this->string(),
            'status'=>$this->integer(1)->defaultValue(0)->comment('состояние - в работе, выполнен'),
            'price' => $this->string()->comment('стоимость'),
            'location_id1'=>$this->integer()->comment('пункт отправления'),
            'location_id2'=>$this->integer()->comment('пункт назначения'),
            'courier_id'=>$this->integer()->comment('Курьер')
        ]);

        $this->addForeignKey(
            'fx-'.self::TABLE_NAME.'-location_id1',
            self::TABLE_NAME,
            'location_id1',
            'location',
            'id',
            'SET NULL'
        );

        $this->addForeignKey(
            'fx-'.self::TABLE_NAME.'-location_id2',
            self::TABLE_NAME,
            'location_id2',
            'location',
            'id',
            'SET NULL'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fx-'.self::TABLE_NAME.'-location_id1', self::TABLE_NAME);
        $this->dropForeignKey('fx-'.self::TABLE_NAME.'-location_id2', self::TABLE_NAME);
        $this->dropTable(self::TABLE_NAME);
    }
}
