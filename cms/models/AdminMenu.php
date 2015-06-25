<?php
/**
 * @link http://www.bigbrush-agency.com/
 * @copyright Copyright (c) 2015 Big Brush Agency ApS
 * @license http://www.bigbrush-agency.com/license/
 */

namespace bigbrush\cms\models;

use Yii;
use yii\helpers\Json;
use bigbrush\big\models\Menu;

/**
 * AdminMenuManager
 */
class AdminMenu extends Menu
{
    /**
     * @var string the icon to use with the menu.
     */
    public $icon;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%admin_menu}}';
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return array_merge(parent::attributeLabels(), [
            'icon' => Yii::t('big', 'Icon'),
        ]);
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return array_merge(parent::rules(), [
            ['icon', 'string']
        ]);
    }

    /**
     * @inheritdoc
     */
    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            $this->params = Json::encode([
                'icon' => $this->icon,
            ]);
            return true;
        }
        return false;
    }

    /**
     * @inheritdoc
     */
    public function afterFind()
    {
        parent::afterFind();
        $params = Json::decode($this->params);
        $this->icon = $params['icon'];
    }
}
