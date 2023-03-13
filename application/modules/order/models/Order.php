<?php

namespace app\modules\order\models;

use Yii;

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
class Order extends \yii\db\ActiveRecord
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

    public function getUser(): \yii\db\ActiveQuery
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }

    public function getService(): \yii\db\ActiveQuery
    {
        return $this->hasOne(Service::class, ['id' => 'service_id']);
    }

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

    protected function getModes(): array
    {
        return [
            self::MODE_MANUAL => Yii::t('app', 'Manual'),
            self::MODE_AUTO => Yii::t('app', 'Auto'),
        ];
    }

    public function getStatusLabel(): string
    {
        return $this->getStatuses()[$this->status];
    }

    public function getModeLabel(): string
    {
        return $this->getModes()[$this->mode];
    }
}
