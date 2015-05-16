<?php
/**
 * @link http://www.bigbrush-agency.com/
 * @copyright Copyright (c) 2015 Big Brush Agency ApS
 * @license http://www.bigbrush-agency.com/license/
 */

namespace cms\components;

use yii\base\Object;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;

/**
 * Toolbar
 */
class Toolbar extends Object
{
    /**
     * @var array list of items added to the toolbar.
     */
    public $items = [];


    /**
     * Adds a save button to the toolbar.
     * 
     * This method MUST be called within a form as it renders a hidden form field. The
     * hidden field is used to save the form with a submit button outside the form. 
     *
     * The technique used to submit a form with a button outside the form is
     * described (on Stackoverflow)[http://stackoverflow.com/a/23456905].
     *
     * @param string $text a text for the button.
     * @param string $icon name of an icon type to use
     * @param array $options additional tag options
     * @return Toolbar the current toolbar instance to support chaining.
     */
    public function save($text = 'Save', $icon = 'check-square', $options = [])
    {
        $this->items[] = Html::label($this->createIcon($icon) . ' ' . $text, 'submit-form', $this->createButtonOptions('success', $options));
        echo Html::submitInput($text, ['style' => 'display:none;', 'id' => 'submit-form']);
        return $this;
    }

    /**
     * Adds a create button to the toolbar.
     *
     * @param string $text text for the button.
     * @param string|array $url url for the button.
     * @param string $icon name of an icon type to use.
     * @param array $options additional tag options
     * @return Toolbar the current toolbar instance to support chaining.
     */
    public function add($text = 'New', $url = ['edit'], $icon = 'plus-circle', $options = [])
    {
        $this->items[] = Html::a($this->createIcon($icon) . ' ' . $text, $url, $this->createButtonOptions('primary', $options));
        return $this;
    }

    /**
     * Adds a back button to the toolbar.
     *
     * @param string $text a text for the button.
     * @return Toolbar the current toolbar instance to support chaining.
     */
    public function back($text = 'Back', $url = ['index'], $icon = 'chevron-circle-left', $options = [])
    {
        $this->items[] = Html::a($this->createIcon($icon) . ' ' . $text, $url, $this->createButtonOptions('danger', $options));
        return $this;
    }

    /**
     * Adds a button to the toolbar
     *
     * @param string $button html string for a button.
     * @return Toolbar the current toolbar instance to support chaining.
     */
    public function addButton($button)
    {
    	$this->items[] = $button;
        return $this;
    }

    /**
     * Creates an icon tag based on Font Awesome.
     *
     * @param string $type the type of icon to create
     * @return string an icon tag
     */
    public function createIcon($type)
    {
    	return '<i class="fa fa-' . $type . '"></i>';
    }

    /**
     * Returns options form a button tag.
     *
     * @param string $type the type of button to create options for.
     * @param array $options additional options for the button tag.
     * @return array options for a button tag.
     */
    public function createButtonOptions($type, $options = [])
    {
        return ArrayHelper::merge(['class' => 'btn btn-default'], $options);
    }

    /**
     * Renders the current toolbar instance.
     *
     * @return string the rendering result.
     */
    public function render()
    {
        $html = Html::beginTag('div', ['class' => 'toolbar']);
        $html .= implode("\n", $this->items);
        $html .= Html::endTag('div');
        return $html;
    }
}