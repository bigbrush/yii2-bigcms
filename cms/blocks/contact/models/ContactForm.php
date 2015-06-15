<?php
/**
 * @link http://www.bigbrush-agency.com/
 * @copyright Copyright (c) 2015 Big Brush Agency ApS
 * @license http://www.bigbrush-agency.com/license/
 */

namespace bigbrush\cms\blocks\contact\models;

use Yii;
use yii\base\Model;

/**
 * ContactForm
 */
class ContactForm extends Model
{
    public $name;
    public $email;
    public $phone;
    public $message;
    /**
     * @var array list of required fields. Used during validation in [[rules()]].
     */
    public $requiredFields;


    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'name' => Yii::t('cms', 'Name'),
            'email' => Yii::t('cms', 'Email'),
            'phone' => Yii::t('cms', 'Phone'),
            'message' => Yii::t('cms', 'Message'),
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [$this->requiredFields, 'required'],
            ['email', 'email'],
            [['name', 'phone'], 'string', 'max' => 255],
            ['message', 'filter', 'filter' => '\yii\helpers\HtmlPurifier::process'],
        ];
    }
}