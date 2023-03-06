<?php

use yii\helpers\Html;

$queryParams = Yii::$app->request->queryParams;
unset($queryParams['r']);
?>

<p>
    <?= Html::a(Yii::t('app', 'Save Result'), array_merge(['csv'], $queryParams), ['class' => 'btn btn-success']) ?>
</p>