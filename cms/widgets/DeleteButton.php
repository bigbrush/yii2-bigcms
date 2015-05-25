<?php
/**
 * @link http://www.bigbrush-agency.com/
 * @copyright Copyright (c) 2015 Big Brush Agency ApS
 * @license http://www.bigbrush-agency.com/license/
 */

namespace cms\widgets;

use yii\base\InvalidConfigException;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;

/**
 * DeleteButton renders a bootstrap popover button with a form with the action of [[action]]. If action is not set
 * if defaults to ['delete', 'id' => $this->model['id']].
 *
 * For example,
 *
 * ```php
 * echo DeleteButton::widget([
 *     'model' => $model,
 * ]);
 * ```
 *
 * @see http://getbootstrap.com/javascript/#popovers
 */
class DeleteButton extends PopoverButton
{
    /**
     * @var array|yii\db\ActiveRecord a model used when rendering the form. Not relevant when [[action]] and
     * [[popoverContent]] are set during widget configuration.
     */
    public $model;
    /**
     * @var strint|array the action of the form rendered in the popover
     */
    public $action;
    /**
     * @var string the button label. Overridden from parent impementation to check if this has a user provided value.
     */
    public $label;
    /**
     * @var string defines the button class.
     */
    public $buttonClass = 'btn-default';
    /**
     * @var string the text for the popover button.
     */
    public $popoverText = '<i class="fa fa-check"></i>';
    /**
     * @var string the options for the popover button.
     */
    public $popoverOptions = [];


    /**
     * Intializes the widget.
     */
    public function init()
    {
        if ($this->model === null) {
            throw new InvalidConfigException("The 'model' property must be set when using cms\widgets\DeleteButton.");
        }
        parent::init();
        Html::addCssClass($this->options, $this->buttonClass);
        $this->useHtml = true;

        if ($this->label === null) {
            $this->label = '<i class="fa fa-trash"></i>';
            $this->encodeLabel = false;
        }
        if ($this->title === null) {
            $this->title = '<strong>Sure?</strong>';
        }
        if ($this->action === null) {
            $this->action = ['delete', 'id' => $this->model['id']];
        }
    }

    /**
     * Runs the widget.
     */
    public function run()
    {
        $popover = Html::beginForm($this->action);
        if ($this->content === null) {
            $popover .= Html::submitButton($this->popoverText, ArrayHelper::merge([
                'class' => 'btn btn-success',
            ], $this->popoverOptions));
            $popover .= Html::hiddenInput('id', $this->model['id']);
        } else {
            $popover .= $this->content;
        }
        $popover .= Html::endForm();
        
        $this->content = $popover;

        return parent::run();
    }
}