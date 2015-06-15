<?php
/**
 * @link http://www.bigbrush-agency.com/
 * @copyright Copyright (c) 2015 Big Brush Agency ApS
 * @license http://www.bigbrush-agency.com/license/
 */

namespace bigbrush\cms\widgets;

use Yii;
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
     * [[content]] are set during widget configuration.
     */
    public $model;
    /**
     * @var strint|array the action of the form rendered in the popover
     */
    public $action;
    /**
     * @var string the button label. Overridden from parent impementation to set a different default value.
     */
    public $label = '<i class="fa fa-trash"></i>';
    /**
     * @var string whether the label should be HTML-encoded. Overridden from parent impementation to set a different default value.
     */
    public $encodeLabel = false;
    /**
     * @var string defines the button class.
     */
    public $buttonClass = 'btn-default';
    /**
     * @var string the text for the popover button.
     */
    public $popoverText = '<i class="fa fa-check"></i>';
    /**
     * @var array the options for the popover button.
     */
    public $popoverOptions = [];


    /**
     * Intializes the widget.
     */
    public function init()
    {
        if ($this->model === null && $this->action === null && $this->content === null) {
            throw new InvalidConfigException("The 'model' property must be set when using cms\widgets\DeleteButton.");
        }
        parent::init();
        Html::addCssClass($this->options, $this->buttonClass);
        $this->useHtml = true;

        if ($this->title === null) {
            $this->title = '<strong>' . Yii::t('cms', 'Sure?') . '</strong>';
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
            $popover .= $this->getFormFields();
        } else {
            $popover .= $this->content;
        }
        $popover .= Html::endForm();
        
        $this->content = $popover;

        return parent::run();
    }

    /**
     * Returns the default form fields used in the popover.
     *
     * @return string form fields as HTML.
     */
    public function getFormFields()
    {
        $fields = [];
        $fields[] = Html::submitButton($this->popoverText, ArrayHelper::merge([
            'class' => 'btn btn-success',
        ], $this->popoverOptions));
        $fields[] = Html::hiddenInput('id', $this->model['id']);
        return implode("\n", $fields);
    }
}