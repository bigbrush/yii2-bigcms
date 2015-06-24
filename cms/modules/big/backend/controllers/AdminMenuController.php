<?php
/**
 * @link http://www.bigbrush-agency.com/
 * @copyright Copyright (c) 2015 Big Brush Agency ApS
 * @license http://www.bigbrush-agency.com/license/
 */

namespace bigbrush\cms\modules\big\backend\controllers;

use Yii;
use bigbrush\cms\base\BaseMenuController;

/**
 * AdminMenuController
 */
class AdminMenuController extends BaseMenuController
{
    const ACTIVE_MENU_ID = '_cms_admin_menu_id_';


    /**
     * Returns the manager of this controller.
     *
     * @return bigbrush\cms\components\AdminMenuManager the admin menu manager.
     */
    public function getManager()
    {
        return Yii::$app->cms->getAdminMenuManager();
    }

    /**
     * @inheritdoc
     */
    public function getViewPath()
    {
        if (in_array($this->action->id, ['index', 'menus', 'edit'])) {
            return parent::getViewPath();
        } else {
            return Yii::getAlias('@bigbrush/cms/modules/big/backend/views/menu');
        }
    }
}
