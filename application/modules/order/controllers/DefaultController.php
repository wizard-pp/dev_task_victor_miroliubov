<?php

namespace app\modules\order\controllers;

use app\modules\order\services\OrderService;
use yii\web\Controller;

/**
 * Default controller for the `order` module
 */
class DefaultController extends Controller
{
    protected OrderService $service;

    public function __construct($id, $module, $config = [])
    {
        parent::__construct($id, $module, $config);

        $this->service = new OrderService();
    }

    /**
     * Lists all Order models.
     *
     * @return string
     */
    public function actionIndex(): string
    {
        return $this->render('index', $this->service->index($this->request->queryParams));
    }

    public function actionCsv(): \yii\web\Response
    {
        $exporter = $this->service->csv($this->request->queryParams);

        return $exporter->export()->send('items.csv');
    }
}
