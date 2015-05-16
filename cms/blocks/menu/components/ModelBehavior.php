<?php
/**
 * @link http://www.bigbrush-agency.com/
 * @copyright Copyright (c) 2015 Big Brush Agency ApS
 * @license http://www.bigbrush-agency.com/license/
 */

namespace cms\blocks\menu\components;

use yii\base\Behavior;
use yii\db\ActiveRecord;
use yii\helpers\Json;
use yii\validators\Validator;

/**
 * ModelBehavior
 *
 * @property ActiveRecord $owner
 */
class ModelBehavior extends Behavior
{
    /**
     * @var int an id of the menu to display in the block.
     */
    public $menu_id;
    /**
     * @var string optional class for the menu.
     * For example "nav-pills" to create a bootstrap pills menu.
     */
    public $class = '';


    /**
     * @inheritdoc
     */
    public function events()
    {
        return [
            ActiveRecord::EVENT_BEFORE_INSERT => 'beforeSave',
            ActiveRecord::EVENT_BEFORE_UPDATE => 'beforeSave',
        ]; 
    }

    /**
     * Initializes this behavior by setting its properties and registering
     * these properties as additional validators in the [[owner]].
     */
    public function init()
    {
        $this->owner->validators[] = Validator::createValidator('required', $this->owner, 'menu_id', ['message' => 'Please select a menu']);
        $this->owner->validators[] = Validator::createValidator('default', $this->owner, 'class', ['value' => '']);
        if (!empty($this->owner->content)) {
            $properties = Json::decode($this->owner->content);
            $this->menu_id = $properties['menu_id'];
            $this->class = $properties['class'];
        }
    }

    /**
     * Runs before the owner of this behavior updates or insert a record.
     * The owner is validated at this point.
     *
     * @param yii\base\ModelEvent the event being triggered
     */
    public function beforeSave($event)
    {
    	$this->owner->content = Json::encode([
    	    'menu_id' => $this->menu_id,
    	    'class' => $this->class,
    	]);
    }
}