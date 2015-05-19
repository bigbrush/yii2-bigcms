<?php
/**
 * @link http://www.bigbrush-agency.com/
 * @copyright Copyright (c) 2015 Big Brush Agency ApS
 * @license http://www.bigbrush-agency.com/license/
 */

namespace cms\blocks\contact\models;

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
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'email'], 'required'],
            ['email', 'email'],
            [['name', 'phone'], 'string', 'max' => 255],
            ['message', 'filter', 'filter' => '\yii\helpers\HtmlPurifier::process'],
        ];
    }
}