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
     * @var string an email for the receiver of an email when the contact form has been submitted.
     */
    public $receiver;
    /**
     * @var boolean defines whether to show the "name" field.
     */
    public $showName = 1;
    /**
     * @var boolean defines whether to show the "email" field.
     */
    public $showEmail = 1;
    /**
     * @var boolean defines whether to show the "phone" field.
     */
    public $showPhone = 1;
    /**
     * @var boolean defines whether to show the "message" field.
     */
    public $showMessage = 1;
    /**
     * @var string a message to display after the contact form has been submitted.
     */
    public $successMessage = 'Thank you for contacting us. We will get back to you as soon as possible.';
    /**
     * @var string|array an URL to redirect to after a form has been submitted.
     */
    public $redirectTo;


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
        $this->owner->validators[] = Validator::createValidator('required', $this->owner, 'receiver');
        $this->owner->validators[] = Validator::createValidator('email', $this->owner, 'receiver');
        $this->owner->validators[] = Validator::createValidator('boolean', $this->owner, ['showName', 'showPhone', 'showEmail', 'showMessage']);
        $this->owner->validators[] = Validator::createValidator('string', $this->owner, ['successMessage', 'redirectTo']);
        if (!empty($this->owner->content)) {
            $properties = Json::decode($this->owner->content);
            foreach ($properties as $key => $value) {
                $this->$key = $value;
            }
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
            'receiver' => $this->receiver,
            'showName' => $this->showName,
            'showPhone' => $this->showPhone,
            'showEmail' => $this->showEmail,
            'showMessage' => $this->showMessage,
            'successMessage' => $this->successMessage,
    	    'redirectTo' => $this->redirectTo,
    	]);
    }
}