<?php

declare(strict_types=1);

namespace orders\widgets;

use Throwable;
use Yii;
use yii\base\Widget;
use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;

/**
 * ButtonDropdownFilter renders a button dropdown bootstrap component.
 *
 * For example,
 *
 * ```php
 * // a button group using Dropdown widget
 * echo ButtonDropdownFilter::widget([
 *     'label' => 'Action',
 *     'buttonOptions => [
 *         'class' => 'atata'
 *     ],
 *     'items' => [
 *         ['name' => 'DropdownA', 'label' => '144'],
 *         ['name' => 'DropdownB', 'label' => '256'],
 *     ],
 * ]);
 * ```
 */
class ButtonDropdownFilter extends Widget
{
    public string $label;

    public array $buttonOptions = [
        'class' => 'btn btn-th btn-default dropdown-toggle'
    ];

    public array $items = [];

    public ?int $totalCount = null;

    public string $attribute;

    /**
     * {@inheritdoc}
     * @return string
     * @throws Throwable
     */
    public function run(): string
    {
        $content = $this->renderButton() . "\n" . $this->renderDropdown();
        return Html::tag('div', $content, ['class' => 'dropdown']);
    }

    /**
     * Generates the button dropdown.
     * @return string the rendering result.
     * @throws Throwable
     */
    protected function renderButton(): string
    {
        $content = $this->label . ' ' . Html::tag('span', '',['class' => 'caret']);
        return Html::button($content, ArrayHelper::merge($this->buttonOptions, [
            'data-toggle' => 'dropdown',
            'aria-haspopup' => 'true',
            'aria-expanded' => 'false',
        ]));
    }

    /**
     * Generates the dropdown menu.
     * @return string the rendering result.
     * @throws Throwable
     */
    protected function renderDropdown(): string
    {
        $html = Html::beginTag('ul', ['class' => 'dropdown-menu']);
        $html .= $this->renderList();
        $html .= Html::endTag('ul');

        return $html;
    }

    protected function renderList(): string
    {
        $content = $this->renderTotalCount();
        foreach ($this->items as $item) {
            $content .= $this->renderListItem($item);
        }

        return $content;
    }

    protected function renderListItem(array $item): string
    {
        $content = '';
        if (array_key_exists('label', $item)) {
            $content .= Html::tag('span', $item['label'], ['class' => 'label-id']) . ' ';
        }
        $content .= $item['name'];
        $content = Html::tag('a', $content, [
            'href' => $this->getUrl([$this->attribute => $item['id']]),
        ]);

        $liOptions = [];
        if ($this->isActiveItem($item)) {
            $liOptions = ['class' => 'active'];
        }
        return Html::tag('li', $content, $liOptions);
    }

    protected function getUrl(array $withFilter): string
    {
        $queryParams = Yii::$app->request->queryParams;
        $targetQueryParams = array_replace_recursive($queryParams, $withFilter);
        $targetQueryParams[0] = '/' . Yii::$app->controller->getRoute();
        unset($targetQueryParams['r']);

        return Url::toRoute($targetQueryParams);
    }

    protected function renderTotalCount(): string
    {
        $name = Yii::t('order', 'dropdown_filter.all');

        if ($this->totalCount) {
            $name .= "({$this->totalCount})";
        }
        return $this->renderListItem([
            'name' => $name,
            'id' => null,
        ]);
    }

    protected function isActiveItem(array $item): bool
    {
        $currentFilter = Yii::$app->request->queryParams;

        if (!is_array($currentFilter) || !array_key_exists($this->attribute, $currentFilter)) {
            return $item['id'] === null;
        }

        return $currentFilter[$this->attribute] == $item['id'];
    }
}
