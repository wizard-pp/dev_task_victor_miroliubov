<?php

use yii\helpers\Html;

$queryParams = Yii::$app->request->queryParams;
unset($queryParams['r']);
?>

<div class="row">
    <div class="pull-right">
        <p>
            <?= Html::a(Yii::t('order', 'index.save_result_btn'), array_merge(['csv'], $queryParams), ['class' => 'btn btn-success']) ?>
        </p>
    </div>
</div>