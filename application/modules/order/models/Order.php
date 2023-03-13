<?php

namespace orders\models;

use orders\models\queries\OrderQuery;
use Yii;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "orders".
 *
 * @property int $id
 * @property int $user_id
 * @property string $link
 * @property int $quantity
 * @property int $service_id
 * @property int $status 0 - Pending, 1 - In progress, 2 - Completed, 3 - Canceled, 4 - Fail
 * @property int $created_at
 * @property int $mode 0 - Manual, 1 - Auto
 */
class Order extends ActiveRecord
{
    const STATUS_PENDING = 0;
    const STATUS_IN_PROGRESS = 1;
    const STATUS_COMPLETED = 2;
    const STATUS_CANCELED = 3;
    const STATUS_FAIL = 4;

    const MODE_MANUAL = 0;
    const MODE_AUTO = 1;

    /**
     * {@inheritdoc}
     */
    public static function tableName(): string
    {
        return 'orders';
    }

    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [['user_id', 'link', 'quantity', 'service_id', 'status', 'created_at', 'mode'], 'required'],
            [['user_id', 'quantity', 'service_id', 'status', 'created_at', 'mode'], 'integer'],
            [['link'], 'string', 'max' => 300],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels(): array
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'user_id' => Yii::t('app', 'User ID'),
            'link' => Yii::t('app', 'Link'),
            'quantity' => Yii::t('app', 'Quantity'),
            'service_id' => Yii::t('app', 'Service ID'),
            'status' => Yii::t('app', 'Status'),
            'created_at' => Yii::t('app', 'Created At'),
            'mode' => Yii::t('app', 'Mode'),
        ];
    }

    /**
     * Getting User of current Order.
     *
     * @return ActiveQuery
     */
    public function getUser(): ActiveQuery
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }

    /**
     * Getting Service of current Order
     *
     * @return ActiveQuery
     */
    public function getService(): ActiveQuery
    {
        return $this->hasOne(Service::class, ['id' => 'service_id']);
    }

    /**
     * Translated statuses list.
     *
     * @return array
     */
    protected function getStatuses(): array
    {
        return [
            self::STATUS_PENDING => Yii::t('app','Pending'),
            self::STATUS_IN_PROGRESS => Yii::t('app', 'In Progress'),
            self::STATUS_COMPLETED => Yii::t('app', 'Completed'),
            self::STATUS_CANCELED => Yii::t('app', 'Canceled'),
            self::STATUS_FAIL => Yii::t('app', 'Error'),
        ];
    }

    /**
     * Translated modes list.
     *
     * @return array
     */
    protected function getModes(): array
    {
        return [
            self::MODE_MANUAL => Yii::t('app', 'Manual'),
            self::MODE_AUTO => Yii::t('app', 'Auto'),
        ];
    }

    /**
     * Getting translated status for current Order.
     *
     * @return string
     */
    public function getStatusLabel(): string
    {
        return $this->getStatuses()[$this->status];
    }

    /**
     * Getting translated mode for current Order.
     *
     * @return string
     */
    public function getModeLabel(): string
    {
        return $this->getModes()[$this->mode];
    }

    /**
     * {@inheritdoc}
     * @return OrderQuery the active query used by this AR class.
     */
    public static function find(): OrderQuery
    {
        return new OrderQuery(get_called_class());
    }
}
