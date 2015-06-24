<?php
/**
 * @link http://www.bigbrush-agency.com/
 * @copyright Copyright (c) 2015 Big Brush Agency ApS
 * @license http://www.bigbrush-agency.com/license/
 */

namespace bigbrush\cms\modules\pages\backend\controllers;

use Yii;
use bigbrush\cms\base\BaseCategoryController;

/**
 * CategoryController
 */
class CategoryController extends BaseCategoryController
{
    /**
     * @inheritdoc
     */
    public function getManager()
    {
        return Yii::$app->big->categoryManager;
    }

    /**
     * @inheritdoc
     */
    public function getName()
    {
        return 'pages';
    }
}
