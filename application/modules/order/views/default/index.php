<?php

use orders\models\Order;
use orders\widgets\ButtonDropdownFilter;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var orders\models\search\OrderSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */
/** @var array $services */
/** @var array $modes */
/** @var int $totalCount */
/** @var string $summaryContent */

$this->title = Yii::t('order', 'index.title');
$this->params['breadcrumbs'][] = $this->title;
if ($totalCount < $dataProvider->pagination->pageSize) {
    $summaryContent = '{totalCount}';
} else {
    $summaryContent = Yii::t('order', 'index.table_summary');
}
?>

<?php echo $this->render('_search', ['model' => $searchModel]); ?>
<?php echo $this->render('_errors'); ?>

<?= GridView::widget([
    'dataProvider' => $dataProvider,
    'columns' => [
        'id',
        [
            'attribute' => 'user',
            'header' => Yii::t('order', 'order.user'),
            'value' => 'user.fullName',
        ],
        [
            'attribute' => 'link',
            'header' => Yii::t('order', 'order.link'),
            'contentOptions' => ['class' => 'link'],
        ],
        'quantity',
        [
            'attribute' => 'service',
            'header' => ButtonDropdownFilter::widget([
                'label' => Yii::t('order', 'order.service'),
                'items' => $services,
                'attribute' => 'service_id',
                'totalCount' => $totalCount,
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
            'header' => Yii::t('order', 'order.status'),
            'value' => 'statusLabel',
        ],
        [
            'attribute' => 'mode',
            'header' => ButtonDropdownFilter::widget([
                'label' => Yii::t('order', 'order.mode'),
                'items' => $modes,
                'attribute' => 'mode',
            ]),
            'headerOptions' => ['class' => 'dropdown-th'],
            'value' => 'modeLabel',
        ],
        [
            'attribute' => 'created_at',
            'header' => Yii::t('order', 'order.created'),
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
