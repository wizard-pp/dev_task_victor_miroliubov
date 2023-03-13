<?php

namespace orders\models;

use Yii;
use yii\db\ActiveQuery;

/**
 * This is the model class for table "services".
 *
 * @property int $id
 * @property string $name
 */
class Service extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName(): string
    {
        return 'services';
    }

    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [['name'], 'required'],
            [['name'], 'string', 'max' => 300],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels(): array
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'name' => Yii::t('app', 'Name'),
        ];
    }

    /**
     * Getting orders related to current Service.
     *
     * @return ActiveQuery
     */
    public function getOrders(): ActiveQuery
    {
        return $this->hasMany(Order::class, ['service_id' => 'id']);
    }
}
