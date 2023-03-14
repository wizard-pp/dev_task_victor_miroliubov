<?php

use orders\models\Order;
use orders\models\search\OrderSearch;
use yii\helpers\Url;

/** @var yii\web\View $this */

$queryParams = Yii::$app->request->queryParams;

$isAllOrders = is_null($queryParams)|| !isset($queryParams['status']);
$searchValue = $queryParams['id'] ?? $queryParams['link'] ?? $queryParams['username'] ?? '';
?>

<ul class="nav nav-tabs p-b">
    <li <?php if ($isAllOrders): ?> class="active" <?php endif; ?> >
        <a href="<?= Url::toRoute('/order/default/index') ?>">
            <?= Yii::t('app', 'All orders') ?>
        </a>
    </li>
    <?php foreach (Order::find()->select('status')->distinct()->all() as $status): ?>
        <?php $isActive = isset($queryParams['status']) && $queryParams['status'] == $status->status; ?>
        <li <?php if ($isActive): ?> class="active" <?php endif; ?>>
            <a href="<?= Url::toRoute(['/order/default/index', 'status' => $status->status]) ?>">
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
              <option value="<?= OrderSearch::PARAM_ID ?>" <?php if (!empty($queryParams[OrderSearch::PARAM_ID])): ?> selected="" <?php endif; ?>>
                  <?= Yii::t('app', 'Order ID') ?>
              </option>
              <option value="<?= OrderSearch::PARAM_LINK ?>" <?php if (!empty($queryParams[OrderSearch::PARAM_LINK])): ?> selected="" <?php endif; ?>>
                  <?= Yii::t('app', 'Link') ?>
              </option>
              <option value="<?= OrderSearch::PARAM_USERNAME ?>" <?php if (!empty($queryParams[OrderSearch::PARAM_USERNAME])): ?> selected="" <?php endif; ?>>
                  <?= Yii::t('app', 'Username') ?>
              </option>
            </select>
                <button type="submit" class="btn btn-default"><span class="glyphicon glyphicon-search" aria-hidden="true"></span></button>
            </span>
            </div>
        </form>
    </li>
</ul>

<?php
$constId = OrderSearch::PARAM_ID;
$constLink = OrderSearch::PARAM_LINK;
$constUsername = OrderSearch::PARAM_USERNAME;
$this->registerJs(<<<SCRIPT
$('#search-form').on('submit', function (e) {
    e.preventDefault();

    let paramName = $(this).find('[name=search-type]').val();
    let paramValue = $(this).find('[name=search]').val();
    
    let href = $(this).attr('action');
    href = removeUrlParams(href, ['{$constId}', '{$constLink}', '{$constUsername}', 'service_id', 'mode_id', 'page']);
    
    if (paramName == '{$constLink}') {
        paramValue = encodeURIComponent(paramValue);
    }

    href = replaceUrlParam(href, paramName, paramValue);
    href = replaceUrlParam(href, 'searchType', paramName);

    window.location.href = href;

    return false;
});
SCRIPT);
