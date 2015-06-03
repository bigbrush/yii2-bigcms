<?php
/**
 * @link http://www.bigbrush-agency.com/
 * @copyright Copyright (c) 2015 Big Brush Agency ApS
 * @license http://www.bigbrush-agency.com/license/
 */

namespace cms\blocks\pagescategories\components;

use Yii;
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
     * @var int an id of the chosen category.
     */
    public $category_id;


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
     * Initializes this behavior.
     */
    public function init()
    {
    	$this->owner->validators[] = Validator::createValidator('required', $this->owner, 'category_id', [
    	    'message' => Yii::t('cms', 'Please select a menu')
	    ]);
	    if (!empty($this->owner->content)) {
            $properties = Json::decode($this->owner->content);
            $this->category_id = $properties['category_id'];
        }
    }

    /**
     * Runs before the owner of this behavior updates or insert a record.
     * The owner is validated at this point.
     *
     * @param yii\base\ModelEvent the event being triggered.
     */
    public function beforeSave($event)
    {
    	$this->owner->content = Json::encode([
    	    'category_id' => $this->category_id,
    	]);
    }
}
