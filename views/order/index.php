<?php

use app\models\Order;
use yii\grid\GridView;
use app\widgets\ButtonDropdownFilter;

/** @var yii\web\View $this */
/** @var app\models\OrderSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */
/** @var array $services */
/** @var array $modes */
/** @var int $totalCount */
/** @var string $summaryContent */

$this->title = 'Orders';
$this->params['breadcrumbs'][] = $this->title;
?>

<?php echo $this->render('_search', ['model' => $searchModel]); ?>

<?= GridView::widget([
    'dataProvider' => $dataProvider,
    'columns' => [
        'id',
        [
            'attribute' => 'user',
            'header' => Yii::t('app', 'User'),
            'value' => 'user.fullName',
        ],
        [
            'attribute' => 'link',
            'header' => Yii::t('app', 'Link'),
            'contentOptions' => ['class' => 'link'],
        ],
        'quantity',
        [
            'attribute' => 'service',
            'header' => ButtonDropdownFilter::widget([
                'label' => Yii::t('app', 'Service'),
                'items' => $services,
                'attribute' => 'service_id',
                'totalCount' => $totalCount,
                'filterModel' => $searchModel,
            ]),
            'headerOptions' => ['class' => 'dropdown-th'],
            'content' => function ($model) {
                $orders = Order::find()
                    ->select(['COUNT(orders.id) as count'])
                    ->joinWith(['user', 'service'])
                    ->groupBy('service_id, user_id')
                    ->where(['service_id' => $model->service_id])
                    ->andWhere(['user_id' => $model->user_id])
                    ->asArray()
                    ->all();
                $count = $orders[0]['count'];

                return '<span class="label-id">' . $count . '</span> ' . $model->service->name;
            },
            'contentOptions' => ['class' => 'service'],
        ],
        [
            'header' => Yii::t('app', 'Status'),
            'content' => function ($model) {
                return Yii::t('app', Order::$statuses[$model->status]);
            },
        ],
        [
            'attribute' => 'mode',
            'header' => ButtonDropdownFilter::widget([
                'label' => Yii::t('app', 'Mode'),
                'items' => $modes,
                'attribute' => 'mode',
                'filterModel' => $searchModel,
            ]),
            'headerOptions' => ['class' => 'dropdown-th'],
            'content' => function ($model) {
                return Yii::t('app', Order::$modes[$model->mode]);
            }
        ],
        [
            'attribute' => 'created_at',
            'header' => Yii::t('app', 'Created'),
            'format' => ['date', 'Y-m-d H:i:s'],
            'content' => function ($model) {
                return '<span class="nowrap">' . Yii::$app->formatter->asDate($model->created_at, 'php:Y-m-d') . '</span>'
                    . '<span>' . Yii::$app->formatter->asDate($model->created_at, 'php:H:i:s') . '</span>';
            }
        ],
    ],
    'summary' => $summaryContent,
    'layout' => "{items}\n<div class='row'><div class='col-sm-8'>{pager}</div><div class='col-sm-4 pagination-counters'>{summary}</div></div>",
    'tableOptions' => ['class' => 'table order-table'],
]); ?>

<?php echo $this->render('_csv');
