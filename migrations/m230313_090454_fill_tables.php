<?php

use yii\db\Migration;

/**
 * Class m230313_090454_fill_tables
 */
class m230313_090454_fill_tables extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        ini_set('memory_limit', '-1');
        ini_set('mysql.connect_timeout', '-1');
        $this->execute(file_get_contents(__DIR__ . '/../docker/mysql/data/' . $_ENV['DB_DUMP_NAME_DATA']));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m230313_090454_fill_tables cannot be reverted.\n";

        return false;
    }
}
