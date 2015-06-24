<?php
/**
 * @link http://www.bigbrush-agency.com/
 * @copyright Copyright (c) 2015 Big Brush Agency ApS
 * @license http://www.bigbrush-agency.com/license/
 */

namespace bigbrush\cms\modules\big\backend\controllers;

use Yii;
use yii\web\Controller;
use bigbrush\cms\widgets\AdminMenu;
use bigbrush\cms\models\LoginForm;
use bigbrush\big\widgets\bigsearch\BigSearch;

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
     * @return string the rendering result.
     */
    public function actionIndex()
    {
        $user = Yii::$app->getUser();
        if ($user->getIsGuest()) {
            $model = new LoginForm();
            if ($model->load(Yii::$app->getRequest()->post()) && $model->login()) {
                return $this->redirect($user->returnUrl);
            }
            return $this->render('login', [
                'model' => $model,
            ]);
        } else {
            return $this->render('index');
        }
    }

    /**
     * Searches the Cms.
     *
     * @param string $q the query string to search for.
     * @return string the rendering result.
     */
    public function actionSearch($q)
    {
        return $this->render('search', [
            'searchValue' => $q,
            'results' => BigSearch::search($q),
        ]);
    }
    
    /**
     * Remembers whether the menu is collapsed.
     *
     * @param int $collapsed whether the menu is collapsed.
     */
    public function actionCollapseMenu($collapsed)
    {
        AdminMenu::setIsCollapsed($collapsed);
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
