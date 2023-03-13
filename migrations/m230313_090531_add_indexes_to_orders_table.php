<?php

use yii\db\Migration;

/**
 * Class m230313_090531_add_indexes_to_orders_table
 */
class m230313_090531_add_indexes_to_orders_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->execute(<<<SQL
ALTER TABLE orders
    ADD CONSTRAINT `fk-orders-service_id` FOREIGN KEY (service_id)
    REFERENCES services(id)
    ON DELETE CASCADE
SQL);

        $this->execute(<<<SQL
ALTER TABLE orders
    ADD CONSTRAINT `fk-orders-user_id` FOREIGN KEY (user_id)
    REFERENCES users(id)
    ON DELETE CASCADE
SQL);

        $this->execute(<<<SQL
CREATE INDEX `index-orders-status` on orders(status)
SQL);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->execute(<<<SQL
ALTER TABLE orders
    DROP FOREIGN KEY `fk-orders-service_id`
SQL);
        $this->execute(<<<SQL
ALTER TABLE orders
    DROP FOREIGN KEY `fk-orders-user_id`
SQL);

        $this->execute(<<<SQL
DROP INDEX `index-orders-status` ON orders
SQL);
    }
}
