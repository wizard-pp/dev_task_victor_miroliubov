<?php

namespace orders\models\queries;

use orders\models\Service;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * This is the ActiveQuery class for [[Service]].
 *
 * @see Service
 */
class ServiceQuery extends ActiveQuery
{
    /**
     * {@inheritdoc}
     * @return Service[]|array
     */
    public function all($db = null): array
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return array|ActiveRecord|null
     */
    public function one($db = null): array|ActiveRecord|null
    {
        return parent::one($db);
    }
}
