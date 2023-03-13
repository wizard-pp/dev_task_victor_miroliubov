<?php

namespace app\widgets;

use Yii;
use yii\bootstrap5\Html;
use yii\bootstrap5\NavBar as BaseNavBar;
use yii\helpers\ArrayHelper;

class NavBar extends BaseNavBar
{
    /**
     * Renders collapsible toggle button.
     * @return string the rendering toggle button.
     */
    protected function renderToggleButton(): string
    {
        if ($this->offcanvasOptions !== false) {
            $bsData = ['bs-toggle' => 'offcanvas', 'bs-target' => '#' . $this->offcanvasOptions['id']];
            $aria = $this->offcanvasOptions['id'];
        } else {
            $bsData = ['bs-toggle' => 'collapse', 'bs-target' => '#' . $this->collapseOptions['id']];
            $aria = $this->collapseOptions['id'];
        }
        $options = ArrayHelper::merge($this->togglerOptions, [
            'type' => 'button',
            'data' => $bsData,
            'aria' => [
                'controls' => $aria,
                'expanded' => 'false',
                'label' => $this->screenReaderToggleText ?: Yii::t('yii/bootstrap5', 'Toggle navigation'),
            ]
        ]);

        $html = Html::beginTag('div', ['class' => 'navbar-header']) . "\n";
        $html .= Html::button($this->togglerContent, $options) . "\n";
        $html .= Html::endTag('div');

        return $html;
    }
}