<?php
/**
 * @link http://www.bigbrush-agency.com/
 * @copyright Copyright (c) 2015 Big Brush Agency ApS
 * @license http://www.bigbrush-agency.com/license/
 */

namespace cms\widgets;

use yii\helpers\Html;
use yii\widgets\InputWidget;
use yii\bootstrap\ButtonGroup;
use yii\bootstrap\BootstrapPluginAsset;

/**
 * RadioButtonGroup
 */
class RadioButtonGroup extends InputWidget
{
    /**
     * @var array list of buttons. Each array element represents a single button
     * which can be specified as a string or an array of the following structure:
     *
     * - label: string, required, the label.
     * - value: string, required, the value.
     */
    public $buttons = [
        ['label' => 'Yes', 'value' => '1'],
        ['label' => 'No', 'value' => '0'],
    ];
    /**
     * @var string defines the button class used with radio buttons
     */
    public $buttonClass = 'btn-primary';


    /**
     * Runs the widget 
     */
    public function run()
    {
        $attribute = $this->attribute;
        $buttons = [];
        foreach ($this->buttons as $button) {
            if (is_array($button)) {
                $labelOptions = 'btn ' . $this->buttonClass;
                if ($this->model->$attribute == $button['value']) {
                    $labelOptions .= ' active';
                }
                $buttons[] = Html::activeRadio($this->model, $this->attribute, [
                    'value' => $button['value'],
                    'label' => $button['label'],
                    'uncheck' => null, // removes hidden field
                    'labelOptions' => [
                        'class' => $labelOptions,
                    ]
                ]);
            } else {
                $buttons[] = $button;
            }
        }

        $view = $this->getView();
        BootstrapPluginAsset::register($view);
        $view->registerJs('
            $(".button-group-wrapper .btn").button();
        ');

        return Html::tag('div', ButtonGroup::widget([
            'options' => ['class' => 'btn-group btn-toggle', ' data-toggle' => 'buttons'],
            'buttons' => $buttons,
        ]), ['class' => 'button-group-wrapper']);
    }
}