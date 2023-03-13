<?php

namespace orders\services;

use orders\models\Order;
use orders\models\search\OrderSearch;
use orders\models\Service;
use Yii;
use yii2tech\csvgrid\CsvGrid;

class OrderService
{
    /**
     * Order's index page setup.
     *
     * @param array $requestData
     * @return array of index page params
     */
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

        $modes = [];
        foreach ($existedModes as $mode) {
            $modes[] = [
                'id' => $mode->mode,
                'name' => $mode->modeLabel,
            ];
        }

        $totalCount = Order::find()->count();

        return [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'services' => $services,
            'modes' => $modes,
            'totalCount' => $totalCount,
        ];
    }

    /**
     * Setup CsvGrid for orders exporting to csv.
     *
     * @param array $requestData
     * @return CsvGrid for orders
     */
    public function csv(array $requestData): CsvGrid
    {
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