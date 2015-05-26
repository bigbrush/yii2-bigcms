<?php
/**
 * @link http://www.bigbrush-agency.com/
 * @copyright Copyright (c) 2015 Big Brush Agency ApS
 * @license http://www.bigbrush-agency.com/license/
 */

namespace cms\modules\big\backend\controllers;

use Yii;
use yii\web\Controller;
use cms\models\LoginForm;

/**
 * CmsController
 */
class CmsController extends Controller
{
    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }
    
    /**
     * Renders a login page when a user is not logged in.
     * The frontpage is rendered when a user is logged in.
     *
     * @return string
     */
    public function actionIndex()
    {
        if (Yii::$app->getUser()->getIsGuest()) {
            $model = new LoginForm();
            if ($model->load(Yii::$app->getRequest()->post()) && $model->login()) {
                return $this->goBack();
            }
            return $this->render('login', [
                'model' => $model,
            ]);
        } else {
            return $this->render('index');
        }
    }
    
    /**
     * Remembers whether the menu is collapsed.
     *
     * @param int $collapsed whether the menu is collapsed.
     */
    public function actionCollapseMenu($collapsed)
    {
        Yii::$app->cms->setMenuCollapsed($collapsed);
    }
    
    /**
     * Logs out the user currently logged in.
     *
     * @return string
     */
    public function actionLogout()
    {
        Yii::$app->getUser()->logout();
        return $this->goHome();
    }
}