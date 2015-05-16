<?php
/**
 * @link http://www.bigbrush-agency.com/
 * @copyright Copyright (c) 2015 Big Brush Agency ApS
 * @license http://www.bigbrush-agency.com/license/
 */

namespace cms\blocks\contact\components;

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
     * @var 
     */
    public $name;
    /**
     * @var 
     */
    public $email;
    /**
     * @var 
     */
    public $message;


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
        $this->owner->validators[] = Validator::createValidator('required', $this->owner, ['name', 'email']);
        $this->owner->validators[] = Validator::createValidator('email', $this->owner, 'email');
        // $this->owner->validators[] = Validator::createValidator('default', $this->owner, 'class', ['value' => '']);
        if (!empty($this->owner->content)) {
            $properties = Json::decode($this->owner->content);
            $this->name = $properties['name'];
            $this->email = $properties['email'];
            $this->message = $properties['message'];
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
    	    'name' => $this->name,
            'email' => $this->email,
    	    'message' => $this->message,
    	]);
    }
}