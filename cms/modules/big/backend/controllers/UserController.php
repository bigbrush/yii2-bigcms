<?php
/**
 * @link http://www.bigbrush-agency.com/
 * @copyright Copyright (c) 2015 Big Brush Agency ApS
 * @license http://www.bigbrush-agency.com/license/
 */

namespace bigbrush\cms\modules\big\backend\controllers;

use Yii;
use yii\web\Controller;
use yii\data\ActiveDataProvider;
use bigbrush\cms\models\User;

/**
 * UserController
 */
class UserController extends Controller
{
    /**
     * Renders a list of users.
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => User::find(),
        ]);
        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'model' => $this->getModel(),
        ]);
    }

    /**
     * Renders the edit view for a user.
     *
     * @param int $id the id of a User model.
     */
    public function actionEdit($id = 0)
    {
        $model = $this->getModel($id);
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->getSession()->setFlash('success', Yii::t('cms', 'User saved.'));
            if (Yii::$app->toolbar->stayAfterSave()) {
                return $this->redirect(['edit', 'id' => $model->id]);
            } else {
                return $this->redirect(['index']);
            }
        }
        return $this->render('edit', [
            'model' => $model
        ]);
    }

    /**
     * Returns a User model.
     * If $id is provided, the model will be loaded from the database.
     *
     * @param int $id the id of a user.
     * @return User|null a User model. If id is provided and not found in the
     * database, null is returned.
     */
    public function getModel($id=0)
    {
        $model = new User();
        if ($id) {
            $model = $model->findOne($id);
        }
        return $model;
    }
}
