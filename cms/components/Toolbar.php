<?php
/**
 * @link http://www.bigbrush-agency.com/
 * @copyright Copyright (c) 2015 Big Brush Agency ApS
 * @license http://www.bigbrush-agency.com/license/
 */

namespace bigbrush\cms\components;

use Yii;
use yii\base\Object;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;

/**
 * Toolbar
 */
class Toolbar extends Object
{
    const POST_VAR_SAVE_STAY = 'saveAndStay';

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
    public function save($text = null, $icon = 'check-square', $options = [])
    {
        if ($text === null) {
            $text = Yii::t('cms/toolbar', 'Save');
        }
        $this->items[] = Html::label($this->createText($icon, $text), 'save-button', $this->createButtonOptions($options));
        echo Html::submitInput('save', ['style' => 'display:none;', 'id' => 'save-button']);
        return $this;
    }

    /**
     * Adds a save button. When clicked the form will be submitted with the $_POST value
     * of "saveAndStay". Use [[stayAfterSave()]] to redirect appropriately in a controller.
     * 
     * This method MUST be called within a form as it renders a hidden form field. The
     * hidden field is used to save the form with a submit button outside the form. 
     *
     * @param string $text a text for the button.
     * @param string $icon name of an icon type to use
     * @param array $options additional tag options
     * @return Toolbar the current toolbar instance to support chaining.
     */
    public function saveStay($text = null, $icon = 'refresh', $options = [])
    {
        if ($text === null) {
            $text = Yii::t('cms/toolbar', 'Update');
        }
        Yii::$app->getView()->registerJs('
            $("#save-stay-button").click(function(e){
                $("#' . static::POST_VAR_SAVE_STAY . '").val("1");
            });
            $("#save-button").click(function(e){
                $("#' . static::POST_VAR_SAVE_STAY . '").val("0");
            });
        ');
        $this->items[] = Html::label($this->createText($icon, $text), 'save-stay-button', $this->createButtonOptions($options));
        echo Html::submitInput('saveStay', ['style' => 'display:none;', 'id' => 'save-stay-button']);
        echo Html::hiddenInput(static::POST_VAR_SAVE_STAY, '', ['id' => static::POST_VAR_SAVE_STAY]);
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
    public function add($text = null, $url = ['edit'], $icon = 'plus-circle', $options = [])
    {
        if ($text === null) {
            $text = Yii::t('cms/toolbar', 'New');
        }
        $this->items[] = Html::a($this->createText($icon, $text), $url, $this->createButtonOptions($options));
        return $this;
    }

    /**
     * Adds a back button to the toolbar.
     *
     * @param string $text a text for the button.
     * @return Toolbar the current toolbar instance to support chaining.
     */
    public function back($text = null, $url = ['index'], $icon = 'chevron-circle-left', $options = [])
    {
        if ($text === null) {
            $text = Yii::t('cms/toolbar', 'Back');
        }
        $this->items[] = Html::a($this->createText($icon, $text), $url, $this->createButtonOptions($options));
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
     * Creates a text value with an icon tag prepended. The icon is based on Font Awesome.
     *
     * @param string $icon a type of icon to use.
     * @param string $text a text value
     * @return string a text value an icon tag
     */
    public function createText($icon, $text)
    {
    	return '<i class="fa fa-' . $icon . '"></i> ' . $text;
    }

    /**
     * Returns options form a button tag.
     *
     * @param array $options additional options for the button tag.
     * @return array options for a button tag.
     */
    public function createButtonOptions($options = [])
    {
        return ArrayHelper::merge(['class' => 'btn btn-default'], $options);
    }

    /**
     * Returns a boolean indicating whether a [[saveStay()]] buttton has been clicked.
     *
     * @return boolean true if a "save and stay" button has been clicked, false if not.
     */
    public function stayAfterSave()
    {
        return Yii::$app->getRequest()->post(static::POST_VAR_SAVE_STAY) === '1';
    }

    /**
     * Renders the current toolbar instance.
     *
     * @return string the rendering result.
     */
    public function render()
    {
        $html = [];
        $html[] = Html::beginTag('div', ['class' => 'toolbar']);
        $html[] = implode("\n", $this->items);
        $html[] = Html::endTag('div');
        return implode("\n", $html);
    }
}