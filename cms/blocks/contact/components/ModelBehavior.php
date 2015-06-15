<?php
/**
 * @link http://www.bigbrush-agency.com/
 * @copyright Copyright (c) 2015 Big Brush Agency ApS
 * @license http://www.bigbrush-agency.com/license/
 */

namespace bigbrush\cms\blocks\contact\components;

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
     * @var string a message to display after the contact form has been submitted.
     */
    public $successMessage = 'Thank you for contacting us. We will get back to you as soon as possible.';
    /**
     * @var string|array an URL to redirect to after a form has been submitted.
     */
    public $redirectTo;
    /**
     * @var array list of fields that can be displayed in the frontend.
     */
    public $fields = [
        'name' => [
            'show' => '1',
            'required' => '1',
        ],
        'email' => [
            'show' => '1',
            'required' => '1',
        ],
        'phone' => [
            'show' => '1',
            'required' => '1',
        ],
        'message' => [
            'show' => '1',
            'required' => '1',
        ],
    ];


    /**
     * Initializes this behavior by setting its properties and registering
     * these properties as additional validators in the [[owner]].
     */
    public function init()
    {
        $this->owner->validators[] = Validator::createValidator('required', $this->owner, 'receiver');
        $this->owner->validators[] = Validator::createValidator('email', $this->owner, 'receiver');
        $this->owner->validators[] = Validator::createValidator('string', $this->owner, ['successMessage', 'redirectTo']);
        $this->owner->validators[] = Validator::createValidator(function($attribute, $params){
            foreach ($this->fields as $field) {
                if (!is_numeric($field['show']) || !is_numeric($field['required'])) {
                    $this->owner->addError($attribute, 'Invalid data type');
                }
            }
        }, $this->owner, 'fields');
        if (!empty($this->owner->content)) {
            $properties = Json::decode($this->owner->content);
            foreach ($properties as $key => $value) {
                $this->$key = $value;
            }
        }
    }

    /**
     * Returns a field value.
     *
     * @param string $field the field name.
     * @param string $parameter the field parameter.
     * @return string the field value. Can be "0" or "1".
     */
    public function getField($field, $parameter)
    {
        return $this->fields[$field][$parameter];
    }

    /**
     * Returns an array with names of required fields.
     *
     * @return array list of required fields.
     */
    public function getRequiredFields()
    {
        $fields = [];
        foreach ($this->fields as $name => $field) {
            if ($field['show'] && $field['required']) {
                $fields[] = $name;
            }
        }
        return $fields;
    }

    /**
     * Updates attributes in [[owner]] from this behavior.
     * Called from [[cms\blocks\contact\Block::save()]].
     */
    public function updateOwner()
    {
        $this->owner->content = Json::encode([            
            'receiver' => $this->receiver,
            'redirectTo' => $this->redirectTo,
            'fields' => $this->fields,
        ]);
    }
}