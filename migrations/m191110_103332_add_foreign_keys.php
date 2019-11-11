<?php

use yii\db\Migration;

/**
 * Class m191110_103332_add_foreign_keys
 */
class m191110_103332_add_foreign_keys extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addForeignKey(
            'fk-order-client_id',
            'order',
            'client_id',
            'client',
            'id',
            'CASCADE'
        );

        $this->addForeignKey(
            'fk-shipment-order_id',
            'shipment',
            'order_id',
            'order',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk-order-client_id', 'order');
        $this->dropForeignKey('fk-shipment-order_id', 'shipment');
    }
}
