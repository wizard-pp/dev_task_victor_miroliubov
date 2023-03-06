<?php

use yii\db\Migration;

/**
 * Class m230303_132122_add_indexes_to_orders_table
 */
class m230303_132122_add_indexes_to_orders_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addForeignKey(
            'fk-orders-service_id',
            'orders',
            'service_id',
            'services',
            'id',
            'CASCADE'
        );

        $this->addForeignKey(
            'fk-orders-user_id',
            'orders',
            'user_id',
            'users',
            'id',
            'CASCADE'
        );

        $this->createIndex('index-orders-status', 'orders', 'status');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk-orders-service_id', 'orders');
        $this->dropForeignKey('fk-orders-user_id', 'orders');
        $this->dropIndex('index-orders-status', 'orders');
    }
}
