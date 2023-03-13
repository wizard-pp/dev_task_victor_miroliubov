<?php

use orders\models\Order;
use yii\helpers\Url;

/** @var yii\web\View $this */

$orderSearch = Yii::$app->request->get('OrderSearch');
$isAllOrders = is_null($orderSearch)|| !isset($orderSearch['status']);
$queryParams = Yii::$app->request->queryParams;
$targetQueryParams = $queryParams;
unset($targetQueryParams['r']);
$targetQueryParams[0] = '/' . Yii::$app->controller->getRoute();

$searchValue = $queryParams['OrderSearch']['id'] ?? $queryParams['OrderSearch']['link'] ?? $queryParams['OrderSearch']['username'] ?? '';
?>

<ul class="nav nav-tabs p-b">
    <li <?php if ($isAllOrders): ?> class="active" <?php endif; ?> >
        <a href="<?= Url::toRoute('order/index') ?>">
            <?= Yii::t('app', 'All orders') ?>
        </a>
    </li>
    <?php foreach (Order::find()->select('status')->distinct()->all() as $status): ?>
        <?php $targetQueryParams = array_replace_recursive($targetQueryParams, ['OrderSearch' => ['status' => $status->status]]); ?>
        <?php $isActive = isset($orderSearch['status']) && $orderSearch['status'] == $status->status; ?>
        <li <?php if ($isActive): ?> class="active" <?php endif; ?>>
            <a href="<?= Url::toRoute($targetQueryParams) ?>">
                <?= $status->statusLabel ?>
            </a>
        </li>
    <?php endforeach; ?>

    <li class="pull-right custom-search">
        <form id="search-form" class="form-inline" action="<?= Url::current() ?>" method="get">
            <div class="input-group">
                <input type="text"
                       name="search"
                       class="form-control"
                       value="<?= $searchValue ?>"
                       placeholder="<?= Yii::t('app', 'Search orders') ?>">
                <span class="input-group-btn search-select-wrap">

            <select class="form-control search-select" name="search-type">
              <option value="OrderSearch[id]" <?php if (!empty($queryParams['OrderSearch']['id'])): ?> selected="" <?php endif; ?>>Order ID</option>
              <option value="OrderSearch[link]" <?php if (!empty($queryParams['OrderSearch']['link'])): ?> selected="" <?php endif; ?>>Link</option>
              <option value="OrderSearch[username]" <?php if (!empty($queryParams['OrderSearch']['username'])): ?> selected="" <?php endif; ?>>Username</option>
            </select>
            <button type="submit" class="btn btn-default"><span class="glyphicon glyphicon-search" aria-hidden="true"></span></button>
            </span>
            </div>
        </form>
    </li>
</ul>

<?php
$this->registerJs(<<<SCRIPT
$('#search-form').on('submit', function (e) {
    e.preventDefault();

    let paramName = $(this).find('[name=search-type]').val();
    let paramValue = $(this).find('[name=search]').val();
    
    let href = $(this).attr('action');
    href = removeUrlParams(href, ['OrderSearch\[id\]', 'OrderSearch\[link\]', 'OrderSearch\[username\]']);

    href = replaceUrlParam(href, paramName, paramValue);

    window.location.href = href;

    return false;
});
SCRIPT);
