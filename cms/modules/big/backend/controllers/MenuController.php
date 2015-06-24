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
 * MenuController
 */
class MenuController extends BaseMenuController
{
    /**
     * Returns the manager of this controller.
     *
     * @return bigbrush\big\core\MenuManager the manager used in controller.
     */
    public function getManager()
    {
        return Yii::$app->big->menuManager;
    }
}
