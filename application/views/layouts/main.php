<?php

/** @var yii\web\View $this */
/** @var string $content */

use app\assets\AppAsset;
use app\widgets\Alert;
use app\widgets\Nav;
use app\widgets\NavBar;
use yii\bootstrap5\Html;

AppAsset::register($this);

$this->registerCsrfMetaTags();
$this->registerMetaTag(['charset' => Yii::$app->charset], 'charset');
$this->registerMetaTag(['name' => 'viewport', 'content' => 'width=device-width, initial-scale=1, shrink-to-fit=no']);
$this->registerMetaTag(['name' => 'description', 'content' => $this->params['meta_description'] ?? '']);
$this->registerMetaTag(['name' => 'keywords', 'content' => $this->params['meta_keywords'] ?? '']);
$this->registerLinkTag(['rel' => 'icon', 'type' => 'image/x-icon', 'href' => Yii::getAlias('@web/favicon.ico')]);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
    <style>
        .label-default{
            border: 1px solid #ddd;
            background: none;
            color: #333;
            min-width: 30px;
            display: inline-block;
        }
    </style>
</head>
<body>
<?php $this->beginBody() ?>

<?php
NavBar::begin([
    'options' => ['class' => 'navbar navbar-fixed-top navbar-default'],
    'togglerOptions' => [
            'class' => 'navbar-toggle collapsed',
    ],
    'innerContainerOptions' => [
            'class' => 'container-fluid'
    ],
    'togglerContent' => '<span class="sr-only">Toggle navigation</span>' . "\n"
        . '<span class="icon-bar"></span>' . "\n"
        . '<span class="icon-bar"></span>' . "\n"
        . '<span class="icon-bar"></span>' . "\n",
]);
echo Nav::widget([
    'options' => ['class' => 'navbar-nav'],
    'items' => [
        ['label' => Yii::t('app', 'Orders'), 'url' => ['/order/default/index']],
    ]
]);
NavBar::end();
?>

<div class="container-fluid">
    <?= Alert::widget() ?>
    <?= $content ?>
</div>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
