<?php
/**
 * @link http://www.bigbrush-agency.com/
 * @copyright Copyright (c) 2015 Big Brush Agency ApS
 * @license http://www.bigbrush-agency.com/license/
 */

namespace bigbrush\cms\blocks\pagescategories\components;

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
     * @var int maximum number of pages to show in the block.
     */
    public $max_pages = 0;
    /**
     * @var string a table column to sort pages by.
     */
    public $order_by;
    /**
     * @var string the direction to sort pages.
     */
    public $order_direction;
    /**
     * @var string indicates whether to show the author or the editor of the page. Can also be disbled.
     */
    public $author_editor;
    /**
     * @var string optional text that is displayed before the author/editor.
     */
    public $author_editor_text;
    /**
     * @var string indicates which date to show. Can also be disbled.
     */
    public $date_displayed;
    /**
     * @var string optional text that is displayed before the displayed date.
     */
    public $date_displayed_text;


    /**
     * Initializes this behavior.
     */
    public function init()
    {
    	$this->owner->validators[] = Validator::createValidator('required', $this->owner, 'category_id', [
    	    'message' => Yii::t('cms', 'Please select a category')
	    ]);
        $this->owner->validators[] = Validator::createValidator('string', $this->owner, ['order_by', 'order_direction', 'author_editor', 'date_displayed', 'author_editor_text', 'date_displayed_text']);
        $this->owner->validators[] = Validator::createValidator('integer', $this->owner, ['max_pages']);
	    if (!empty($this->owner->content)) {
            $properties = Json::decode($this->owner->content);
            foreach ($properties as $key => $value) {
                $this->$key = $value;
            }
        }
    }

    /**
     * Updates attributes in [[owner]] from this behavior.
     * Called from [[cms\blocks\pagecategories\Block::save()]].
     */
    public function updateOwner()
    {
        $properties = ['category_id', 'max_pages', 'order_by', 'order_direction', 'author_editor', 'date_displayed', 'author_editor_text', 'date_displayed_text'];
        $data = [];
        foreach ($properties as $property) {
            $data[$property] = $this->$property;
        }
        $this->owner->content = Json::encode($data);
    }

    /**
     * Returns an array of available options to filter pages by.
     *
     * @return array list of options to filter by.
     */
    public function getSortByOptions()
    {
        return [
            'id' => Yii::t('cms', 'Id'),
            'title' => Yii::t('cms', 'Title'),
            'updated_at' => Yii::t('cms', 'Updated at'),
            'created_at' => Yii::t('cms', 'Created at'),
        ];
    }

    /**
     * Returns available sort directions.
     *
     * @return array list of directions
     */
    public function getSortDirectionOptions()
    {
        return [
            'DESC' => Yii::t('cms', 'Descending'),
            'ASC' => Yii::t('cms', 'Ascending'),
        ];
    }

    /**
     * Returns available dates.
     *
     * @return array list of directions
     */
    public function getDisplayDateOptions()
    {
        return [
            0 => Yii::t('cms', 'None'),
            'updated_at' => Yii::t('cms', 'Updated at'),
            'created_at' => Yii::t('cms', 'Created at'),
        ];
    }

    /**
     * Returns an array of author options.
     *
     * @return 
     */
    public function getShowAuthorOptions()
    {
        return [
            0 => Yii::t('cms', 'None'),
            'author' => Yii::t('cms', 'Created by'),
            'editor' => Yii::t('cms', 'Updated by'),
        ];
    }
}
