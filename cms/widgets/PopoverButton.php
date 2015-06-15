<?php
/**
 * @link http://www.bigbrush-agency.com/
 * @copyright Copyright (c) 2015 Big Brush Agency ApS
 * @license http://www.bigbrush-agency.com/license/
 */

namespace bigbrush\cms\widgets;

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\bootstrap\Button;

/**
 * PopoverButton renders a bootstrap popover button.
 *
 * For example,
 *
 * ```php
 * echo PopoverButton::widget([
 *     'label' => 'Button label',
 *     'options' => ['class' => 'btn-lg'],
 *     'content' => 'Content of the popover',
 *     'placement' => PopoverButton::PLACEMENT_TOP,
 * ]);
 * ```
 *
 * @see http://getbootstrap.com/javascript/#popovers
 */
class PopoverButton extends Button
{
    const PLACEMENT_TOP = 'top';
    const PLACEMENT_RIGHT = 'right';
    const PLACEMENT_BOTTOM = 'bottom';
    const PLACEMENT_LEFT = 'left';

    /**
     * @var string the content to be displayed in the popover.
     */
    public $content;
    /**
     * @var string the title of the popover.
     */
    public $title;
    /**
     * @var string the placement of the popover. Can be "top", "right", "bottom" and "left".
     */
    public $placement = self::PLACEMENT_TOP;
    /**
     * @var boolean whether html is used in the popover.
     */
    public $useHtml = false;
    /**
     * @var string the selector used when activating the popover with javascript.
     */
    public $selector = 'has-popover';


    /**
     * Runs the widget.
     *
     * @return string the rendering result of this widget.
     */
    public function run()
    {
        $this->options = ArrayHelper::merge($this->getDefaultOptions(), $this->options);
        Html::addCssClass($this->options, $this->selector);

        $this->registerPlugin('popover');
        $this->getView()->registerJs('
            $(".' . $this->selector . '").popover();
        ');
        
        return parent::run();
    }

    /**
     * Returns default configuration for a popover button.
     *
     * @return array default configuration for a button.
     * @see http://getbootstrap.com/javascript/#popovers-options
     */
    public function getDefaultOptions()
    {
        return [
            'class' => 'btn btn-default',
            'data' => [
                'container' => false,
                'title' => $this->title,
                'toggle' => 'popover',
                'placement' => $this->placement,
                'trigger' => 'focus',
                'html' => $this->useHtml,
                'content' => $this->content,
            ]
        ];
    }
}
