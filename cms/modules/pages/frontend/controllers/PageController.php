<?php
/**
 * @link http://www.bigbrush-agency.com/
 * @copyright Copyright (c) 2015 Big Brush Agency ApS
 * @license http://www.bigbrush-agency.com/license/
 */

namespace cms\modules\pages\frontend\controllers;

use Yii;
use yii\web\NotFoundHttpException;
use yii\web\Controller;
use cms\modules\pages\models\Page;

/**
 * PageController
 */
class PageController extends Controller
{    
    /**
     * Shows a single page
     *
     * @param int $id the id of a page
     * @return string
     * @throws InvalidParamException
     */
    public function actionShow($id)
    {
        $model = Page::findOne($id);
        if (!$model) {
            throw new NotFoundHttpException("Page with id '$id' could not be found.");
        }
        Yii::$app->big->setTemplate($model->template_id);
        return $this->render('index', [
            'model' => $model,
        ]);
    }
    
    /**
     *
     */
    public function actionNews()
    {
        return $this->render('news');
    }
}