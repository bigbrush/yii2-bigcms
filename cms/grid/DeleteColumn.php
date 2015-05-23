<?php
/**
 * @link http://www.bigbrush-agency.com/
 * @copyright Copyright (c) 2015 Big Brush Agency ApS
 * @license http://www.bigbrush-agency.com/license/
 */

namespace cms\grid;

use yii\grid\Column;
use yii\helpers\Html;
use yii\bootstrap\BootstrapPluginAsset;

/**
 * DeleteColumn
 *
 * @see [Bootstrap popovers](http://getbootstrap.com/javascript/#popovers)
 */
class DeleteColumn extends Column
{
    /**
     * @var string|\Closure an anonymous function or a string that is used to determine the value to display in the current column.
     *
     * If this is an anonymous function, it will be called for each row and the return value will be used as the value to
     * display for every data model. The signature of this function should be: `function ($model, $key, $index, $column)`.
     * Where `$model`, `$key`, and `$index` refer to the model, key and index of the row currently being rendered
     * and `$column` is a reference to the [[DataColumn]] object.
     *
     * You may also set this property to a string representing the content to be displayed in this column.
     *
     * If this is not set, a html button tag is rendered.
     */
    public $value;
    /**
     * @var string|\Closure an anonymous function or a string that is used to determine the content to display in the popover.
     *
     * If this is an anonymous function, it will be called for each row and the return value will be used as the value to
     * display for every data model. The signature of this function should be: `function ($model, $key, $index, $column)`.
     * Where `$model`, `$key`, and `$index` refer to the model, key and index of the row currently being rendered
     * and `$column` is a reference to the [[DataColumn]] object.
     *
     * You may also set this property to a string representing the content to be displayed in the popover.
     */
    public $popover;
    /**
     * @var boolean if true a javascript snippet is added to the page. If false nothing
     * is added to the page. 
     */
    public $registerJs = true;


    /**
     * Initializes by activating the bootstrap popover plugin.
     */
    public function init()
    {
        $view = $this->grid->getView();
        BootstrapPluginAsset::register($view);
        if ($this->registerJs) {
            $view->registerJs('
                $(".has-popover").popover();
            ');
        }
    }

    /**
     * Renders the data cell content.
     *
     * @param mixed $model the data model being rendered
     * @param mixed $key the key associated with the data model
     * @param int $index the zero-based index of the data item among the
     * item array returned by [[yii\grid\GridView::$dataProvider]]
     * @return string the rendering result.
     */
    public function renderDataCellContent($model, $key, $index)
    {
        if ($this->popover !== null) {
            if (is_string($this->popover)) {
                $popover = $this->popover;
            } else {
                $popover = call_user_func($this->popover, $model, $key, $index, $this);
            }
        } else {
            $popover = Html::submitButton('<i class="fa fa-check"></i>', [
                'class' => 'btn btn-success btn-xs accept-delete-button',
            ]);
        }

    	$content = Html::beginForm(['delete', 'id' => $model->id]);
        $content .= $popover;
        $content .= Html::hiddenInput('id', $model->id);
        $content .= Html::endForm();

        if ($this->value !== null) {
            if (is_string($this->value)) {
               return $this->value;
            } else {
                return call_user_func($this->value, $model, $key, $index, $this);
            }
        } else {
            return Html::button('<i class="fa fa-trash"></i>', [
                'class' => 'btn btn-default btn-xs has-popover',
                'data' => [
                    'container' => '#' . $this->grid->id,
                    'title' => 'Sure?',
                    'toggle' => 'popover',
                    'placement' => 'top',
                    'trigger' => 'focus',
                    'html' => 'true',
                    'content' => $content,
                ]
            ]);
        }
    }
}
