<?php
/**
 * @link http://www.bigbrush-agency.com/
 * @copyright Copyright (c) 2015 Big Brush Agency ApS
 * @license http://www.bigbrush-agency.com/license/
 */

namespace bigbrush\cms\modules\pages\frontend\controllers;

use Yii;
use yii\web\NotFoundHttpException;
use yii\web\Controller;
use bigbrush\cms\modules\pages\models\Page;
use bigbrush\cms\widgets\Editor;

/**
 * PageController
 */
class PageController extends Controller
{    
    /**
     * Shows a single page.
     *
     * @param int $id the id of a page.
     * @return string the rendering result of this action.
     * @throws InvalidParamException if a model with the provided id is not found. 
     */
    public function actionShow($id)
    {
        $model = Page::find()->where(['id' => $id])->byState(Page::STATE_ACTIVE)->one();
        if (!$model) {
            throw new NotFoundHttpException("Page with id '$id' not found.");
        }
        Yii::$app->big->setTemplate($model->template_id);
        $model->content = Editor::process($model->content);
        return $this->render('index', [
            'model' => $model,
        ]);
    }
}