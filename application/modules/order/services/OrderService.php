<?php

namespace orders\services;

use DateTimeImmutable;
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


    public function csv(array $requestData, $filename = 'import.csv')
    {
        $searchModel = new OrderSearch();
        $dataProvider = $searchModel->search($requestData);

        // open raw memory as file so no temp files needed, you might run out of memory though
        $f = fopen('php://memory', 'w');

        ob_start();

        fputcsv($f, [
            Yii::t('app', 'ID'),
            Yii::t('app', 'User'),
            Yii::t('app', 'Link'),
            Yii::t('app', 'Quantity'),
            Yii::t('app', 'Service'),
            Yii::t('app', 'Status'),
            Yii::t('app', 'Mode'),
            Yii::t('app', 'Created'),
        ]);

        ob_flush();

        $page = 0;
        while (($data = $this->batchModels($dataProvider, $dataProvider->pagination, $page)) !== false) {
            foreach ($data as $line) {
                fputcsv($f, [
                    $line->id,
                    $line->user->fullName,
                    $line->link,
                    $line->quantity,
                    $line->service->name,
                    $line->statusLabel,
                    $line->modeLabel,
                    date('Y-m-d H:i:s', $line->created_at),
                ]);

            }
            ob_flush();
            flush();
        }

        ob_end_clean();

        fseek($f, 0);


        return $f;
    }


    /**
     * Iterates over {@see dataProvider} returning data by batches.
     * @return array|false models list.
     */
    protected function batchModels($dataProvider, $pagination, &$page)
    {
            if ($pagination === false || $pagination->pageCount === 0) {
                if ($page === 0) {
                    $page++;
                    return $dataProvider->getModels();
                }
            } else {
                if ($page < $pagination->pageCount) {
                    $pagination->setPage($page);
                    $dataProvider->prepare(true);
                    $page++;
                    return $dataProvider->getModels();
                }
            }

            return false;
    }

}