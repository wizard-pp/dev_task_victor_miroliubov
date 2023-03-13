<?php

use yii\db\Migration;

/**
 * Class m230313_090445_initiate_tables
 */
class m230313_090445_initiate_tables extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        ini_set('memory_limit', '-1');
        $this->execute(file_get_contents(__DIR__ . '/../docker/mysql/data/' . $_ENV['DB_DUMP_NAME_STRUCTURE']));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m230313_090445_initiate_tables cannot be reverted.\n";

        return false;
    }
}
