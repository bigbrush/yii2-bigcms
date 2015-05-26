<?php
/**
 * @link http://www.bigbrush-agency.com/
 * @copyright Copyright (c) 2015 Big Brush Agency ApS
 * @license http://www.bigbrush-agency.com/license/
 */

namespace cms;

use Yii;
use yii\base\Object;
use cms\components\AdminMenu;

/**
 * Cms
 */
class Cms extends Object
{
    const ADMIN_MENU_STATE_VAR = '__cms_show_sidebar__';

    /**
     * @var array list of components.
     */
    public $components = [];


    /**
     * Returns the admin menu.
     *
     * @return cms\components\AdminMenu an admin menu instance.
     */
    public function getAdminMenu()
    {

        if (!isset($this->components['adminMenu'])) {
            $this->components['adminMenu'] = Yii::createObject([
                'class' => AdminMenu::className(),
                'collapsed' => $this->getMenuCollapsed(),
            ]);
        }
        return $this->components['adminMenu'];
    }
    
    /**
     * Remebers whether the admin menu is collapsed.
     * The selection is saved in the current session.
     *
     * @param string $collapsed whether the admin menu is collapsed. 1 collapsed and 0 if not collapsed.
     */
    public function setMenuCollapsed($collapsed)
    {
        Yii::$app->getSession()->set(static::ADMIN_MENU_STATE_VAR, $collapsed);
    }
    
    /**
     * Returns a boolean indicating whether the admin menu is collapsed.
     *
     * @return boolean whether the admin menu is collapsed.
     */
    public function getMenuCollapsed()
    {
        return Yii::$app->getSession()->get(static::ADMIN_MENU_STATE_VAR) === '1';
    }
}