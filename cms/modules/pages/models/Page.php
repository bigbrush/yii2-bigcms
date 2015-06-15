<?php
/**
 * @link http://www.bigbrush-agency.com/
 * @copyright Copyright (c) 2015 Big Brush Agency ApS
 * @license http://www.bigbrush-agency.com/license/
 */

namespace bigbrush\cms\modules\pages\models;

use Yii;
use yii\db\ActiveRecord;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\SluggableBehavior;
use yii\behaviors\BlameableBehavior;
use bigbrush\big\models\Template;
use bigbrush\big\models\Category;
use bigbrush\cms\models\User;

/**
 * Page
 *
 * @property integer $id
 * @property string $title
 * @property string $alias
 * @property string $content
 * @property integer $category_id
 * @property integer $state
 * @property integer $created_at
 * @property integer $updated_at
 * @property integer $created_by
 * @property integer $updated_by
 * @property string $meta_title
 * @property string $meta_description
 * @property string $meta_keywords
 * @property integer $template_id
 */
class Page extends ActiveRecord
{
    const STATE_ACTIVE = 1;
    const STATE_INACTIVE = 2;
    const STATE_THRASHED = 100;


    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'title' => Yii::t('cms', 'Title'),
            'alias' => Yii::t('cms', 'Alias'),
            'content' => Yii::t('cms', 'Content'),
            'category_id' => Yii::t('cms', 'Category'),
            'state' => Yii::t('cms', 'State'),
            'created_at' => Yii::t('cms', 'Created'),
            'updated_at' => Yii::t('cms', 'Updated'),
            'created_by' => Yii::t('cms', 'Created by'),
            'updated_by' => Yii::t('cms', 'Updated by'),
            'meta_title' => Yii::t('cms', 'Meta title'),
            'meta_description' => Yii::t('cms', 'Meta description'),
            'meta_keywords' => Yii::t('cms', 'Meta keywords'),
            'template_id' => Yii::t('cms', 'Template'),

            // methods
            'createdAtText' => Yii::t('cms', 'Created'),
            'updatedAtText' => Yii::t('cms', 'Updated'),
            'stateText' => Yii::t('cms', 'State'),
        ];
    }

    /**
     * Returns an array used in dropdown lists for field [[state]]
     *
     * @return array
     */
    public function getStateOptions()
    {
        return [
            self::STATE_ACTIVE => Yii::t('cms', 'Active'),
            self::STATE_INACTIVE => Yii::t('cms', 'Inactive'),
            self::STATE_THRASHED => Yii::t('cms', 'Trashed'),
        ];
    }

    /**
     * Returns the text value of the [[state]] property.
     * 
     * @return string the [[state]] property as a string representation.
     */
    public function getStateText()
    {
        $options = $this->getStateOptions();
        return isset($options[$this->state]) ? $options[$this->state] : '';
    }

    /**
     * Returns the "created_at" property as a formatted date.
     *
     * @return string a formatted date.
     */
    public function getCreatedAtText()
    {
        return Yii::$app->getFormatter()->asDateTime($this->created_at);
    }

    /**
     * Returns the "created_at" property as a formatted date.
     *
     * @return string a formatted date.
     */
    public function getUpdatedAtText()
    {
        return Yii::$app->getFormatter()->asDateTime($this->updated_at);
    }

    /**
     * Returns the author of this page.
     *
     * @return ActiveQueryInterface the relational query object.
     */
    public function getAuthor()
    {
        return $this->hasOne(User::className(), ['id' => 'created_by']);
    }

    /**
     * Returns the category of this page.
     *
     * @return ActiveQueryInterface the relational query object.
     */
    public function getCategory()
    {
        return $this->hasOne(Category::className(), ['id' => 'category_id']);
    }

    /**
     * Returns the editor of this page.
     *
     * @return ActiveQueryInterface the relational query object.
     */
    public function getEditor()
    {
        if ($this->updated_by == $this->created_by) {
            return $this->getAuthor();
        }
        return $this->hasOne(User::className(), ['id' => 'updated_by']);
    }

    /**
     * Returns the template of this page.
     *
     * @return ActiveQueryInterface the relational query object.
     */
    public function getTemplate()
    {
        return $this->hasOne(Template::className(), ['id' => 'template_id']);
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title', 'category_id'], 'required'],
            ['content', 'filter', 'filter' => '\yii\helpers\HtmlPurifier::process'],
            ['state', 'default', 'value' => self::STATE_ACTIVE],
            ['state', 'in', 'range' => array_keys($this->getStateOptions())],
            [['meta_title', 'meta_description', 'meta_keywords'], 'string', 'max' => 255],
            ['template_id', 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
            BlameableBehavior::className(),
            [
                'class' => SluggableBehavior::className(),
                'attribute' => 'title',
                'slugAttribute' => 'alias',
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public static function find()
    {
        return new PageQuery(get_called_class());
    }
}