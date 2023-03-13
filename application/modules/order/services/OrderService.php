<?php

namespace app\modules\order\services;

use app\modules\order\models\Order;
use app\modules\order\models\search\OrderSearch;
use app\modules\order\models\Service;
use Yii;
use yii2tech\csvgrid\CsvGrid;

class OrderService
{
    public function index(array $requestData): array
    {
        $searchModel = new OrderSearch();
        $dataProvider = $searchModel->search($requestData);

        $services = Service::find()
            ->select([
                'services.id as id',
                'services.name as name',
                'COUNT(orders.id) as label'
            ])
            ->joinWith('orders')
            ->groupBy('services.id')
            ->orderBy('label DESC')
            ->asArray()
            ->all();

        $existedModes = Order::find()
            ->select('mode')
            ->distinct()
            ->all();

        foreach ($existedModes as $mode) {
            $modes[] = [
                'id' => $mode->mode,
                'name' => $mode->modeLabel,
            ];
        }

        $totalCount = Order::find()->count();

        if ($totalCount < $dataProvider->pagination->pageSize) {
            $summaryContent = '{totalCount}';
        } else {
            $summaryContent = '{begin} to {end} of {totalCount}';
        }

        return [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'services' => $services,
            'modes' => $modes,
            'totalCount' => $totalCount,
            'summaryContent' => $summaryContent,
        ];
    }

    public function csv(array $requestData): CsvGrid
    {
        ini_set('max_execution_time', 300);
        $searchModel = new OrderSearch();
        $dataProvider = $searchModel->search($requestData);

        return new CsvGrid([
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
                ],
                'quantity',
                [
                    'attribute' => 'service',
                    'header' => Yii::t('app', 'Service'),
                    'value' => 'service.name',
                ],
                [
                    'header' => Yii::t('app', 'Status'),
                    'value' => 'statusLabel',
                ],
                [
                    'attribute' => 'mode',
                    'header' => Yii::t('app', 'Mode'),
                    'value' => 'modeLabel',
                ],
                [
                    'attribute' => 'created_at',
                    'header' => Yii::t('app', 'Created'),
                    'format' => ['date', 'Y-m-d H:i:s'],
                ],
            ],
        ]);
    }
}