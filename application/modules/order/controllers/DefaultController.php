<?php

namespace orders\controllers;

use orders\services\OrderService;
use Yii;
use yii\base\InvalidConfigException;
use yii\web\Controller;
use yii\web\RangeNotSatisfiableHttpException;
use yii\web\Response;

/**
 * Default controller for the `order` module
 */
class DefaultController extends Controller
{
    protected OrderService $service;

    /**
     * @param $id
     * @param $module
     * @param array $config
     */
    public function __construct($id, $module, array $config = [])
    {
        parent::__construct($id, $module, $config);

        $this->service = new OrderService();
    }

    /**
     * Lists all Order models.
     *
     * @return Response|string
     */
    public function actionIndex(): Response|string
    {
        $params = $this->service->index($this->request->queryParams);

        if (!$params) {
            return $this->redirect(['/order/default/index']);
        }

        return $this->render('index', $params);
    }

    /**
     * Exports orders to .csv file
     *
     * @return Response
     * @throws InvalidConfigException
     * @throws RangeNotSatisfiableHttpException
     */
    public function actionCsv(): Response
    {
        header('Content-Disposition: attachment;filename="export.csv"');
        $f = $this->service->csv($this->request->queryParams);

        $response = Yii::$app->getResponse();
        return $response->sendStreamAsFile($f, 'export.csv');
    }
}
