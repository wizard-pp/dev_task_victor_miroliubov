<?php

use app\models\Order;
use yii\helpers\Url;

/** @var yii\web\View $this */

$orderSearch = Yii::$app->request->get('OrderSearch');
$isAllOrders = is_null($orderSearch)|| !isset($orderSearch['status']);
$queryParams = Yii::$app->request->queryParams;
unset($queryParams['r']);
$queryParams[0] = '/' . Yii::$app->controller->getRoute();
?>

<ul class="nav nav-tabs p-b">
    <li <?php if ($isAllOrders): ?> class="active" <?php endif; ?> >
        <a href="<?= Url::toRoute('order/index') ?>">
            <?= Yii::t('app', 'All orders') ?>
        </a>
    </li>
    <?php foreach (Order::$statuses as $status => $label): ?>
        <?php $targetQueryParams = array_replace_recursive($queryParams, ['OrderSearch' => ['status' => $status]]); ?>
        <?php $isActive = isset($orderSearch['status']) && $orderSearch['status'] == $status; ?>
        <li <?php if ($isActive): ?> class="active" <?php endif; ?>>
            <a href="<?= Url::toRoute($targetQueryParams) ?>">
                <?= Yii::t('app', $label) ?>
            </a>
        </li>
    <?php endforeach; ?>

    <li class="pull-right custom-search">
        <form id="search-form" class="form-inline" action="<?= Url::current() ?>" method="get">
            <div class="input-group">
                <input type="text" name="search" class="form-control" value="" placeholder="Search orders">
                <span class="input-group-btn search-select-wrap">

            <select class="form-control search-select" name="search-type">
              <option value="OrderSearch[id]" selected="">Order ID</option>
              <option value="OrderSearch[link]">Link</option>
              <option value="OrderSearch[username]">Username</option>
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
    href = replaceUrlParam(href, paramName, paramValue);

    window.location.href = href;

    return false;
});
SCRIPT);
