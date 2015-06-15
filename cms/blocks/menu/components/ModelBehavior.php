<?php
/**
 * @link http://www.bigbrush-agency.com/
 * @copyright Copyright (c) 2015 Big Brush Agency ApS
 * @license http://www.bigbrush-agency.com/license/
 */

namespace bigbrush\cms\blocks\menu\components;

use Yii;
use yii\base\Behavior;
use yii\base\InvalidParamException;
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
    const TYPE_DEFAULT = 'nav';
    const TYPE_PILLS = 'nav-pills';
    const TYPE_PILLS_STACKED = 'nav-pills nav-stacked';
    const TYPE_TABS = 'nav-tabs';
    const TYPE_NAV_BAR = 'navbar-default';
    const TYPE_NAV_BAR_TOP = 'navbar-fixed-top';
    const TYPE_NAV_BAR_BOTTOM = 'navbar-fixed-bottom';
    const TYPE_NAV_BAR_STATIC = 'navbar-static-top';

    /**
     * @var int an id of the menu to display in the block.
     */
    public $menu_id;
    /**
     * @var string the type of bootstrap menu to display.
     * For example "nav-pills" to create a bootstrap pills menu.
     */
    public $type;
    /**
     * @var string a brand or a link to an image. Only used when the menu block is a navbar.
     */
    public $brand;


    /**
     * Initializes this behavior by setting its properties and registering
     * these properties as additional validators in the [[owner]].
     */
    public function init()
    {
        $this->owner->validators[] = Validator::createValidator('required', $this->owner, 'menu_id', ['message' => Yii::t('cms', 'Please select a menu')]);
        $this->owner->validators[] = Validator::createValidator('string', $this->owner, ['type', 'brand'], ['max' => 255]);
        if (!empty($this->owner->content)) {
            $properties = Json::decode($this->owner->content);
            $this->menu_id = $properties['menu_id'];
            $this->type = $properties['type'];
            $this->brand = $properties['brand'];
        }
    }

    /**
     * Updates attributes in [[owner]] from this behavior.
     * Called from [[cms\blocks\menu\Block::save()]].
     */
    public function updateOwner()
    {
    	$this->owner->content = Json::encode([
    	    'menu_id' => $this->menu_id,
            'type' => $this->type,
    	    'brand' => $this->brand,
    	]);
    }

    /**
     * Returns options available for [[type]].
     *
     * @return array list of available options.
     */
    public function getTypeOptions()
    {
        return [
            self::TYPE_DEFAULT => Yii::t('cms', 'Default'),
            self::TYPE_PILLS => Yii::t('cms', 'Pills'),
            self::TYPE_PILLS_STACKED => Yii::t('cms', 'Pills stacked'),
            self::TYPE_TABS => Yii::t('cms', 'Tabs'),
            self::TYPE_NAV_BAR => Yii::t('cms', 'Navbar'),
            self::TYPE_NAV_BAR_TOP => Yii::t('cms', 'Navbar fixed top'),
            self::TYPE_NAV_BAR_BOTTOM => Yii::t('cms', 'Navbar fixed bottom'),
            self::TYPE_NAV_BAR_STATIC => Yii::t('cms', 'Navbar static'),
        ]; 
    }

    /**
     * Returns an array of all types that indicates a navbar menu.
     *
     * @return array an array of navbar menu types.
     */
    public function getNavbarTypes()
    {
        return [
            ModelBehavior::TYPE_NAV_BAR,
            ModelBehavior::TYPE_NAV_BAR_TOP,
            ModelBehavior::TYPE_NAV_BAR_BOTTOM,
            ModelBehavior::TYPE_NAV_BAR_STATIC
        ];
    }
}