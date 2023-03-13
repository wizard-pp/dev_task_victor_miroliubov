<?php

namespace orders\models\queries;

use orders\models\Order;
use yii\db\ActiveQuery;

/**
 * This is the ActiveQuery class for [[Orders]].
 *
 * @see Orders
 */
class OrderQuery extends ActiveQuery
{
    /**
     * {@inheritdoc}
     * @return Order[]|array
     */
    public function all($db = null): array
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return Order|array|null
     */
    public function one($db = null): array|Order|null
    {
        return parent::one($db);
    }
}
