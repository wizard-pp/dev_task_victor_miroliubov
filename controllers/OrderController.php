<?php

namespace app\controllers;

use app\services\OrderService;
use yii\web\Controller;

/**
 * OrderController implements the CRUD actions for Order model.
 */
class OrderController extends Controller
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
