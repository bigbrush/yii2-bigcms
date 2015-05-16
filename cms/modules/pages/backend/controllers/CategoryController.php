<?php
/**
 * @link http://www.bigbrush-agency.com/
 * @copyright Copyright (c) 2015 Big Brush Agency ApS
 * @license http://www.bigbrush-agency.com/license/
 */

namespace cms\modules\pages\backend\controllers;

use Yii;
use yii\data\ArrayDataProvider;
use yii\web\Controller;

/**
 * CategoryController
 */
class CategoryController extends Controller
{
    /**
     * Returns a list of predefined actions for this controller.
     *
     * It specifically adds a move action which moves an item in a nested
     * set model up or down in the hierarchy.
     *
     * @return array a list of actions
     */
    public function actions()
    {
        return [
            'move' => [
                'class' => 'bigbrush\big\core\NestedSetAction',
                'model' => Yii::$app->big->categoryManager->getModel(),
            ],
        ];
    }

    /**
     * Lists all available categories.
     *
     * @return string the rendering result.
     */
    public function actionIndex()
    {
        $manager = Yii::$app->big->categoryManager;
        $manager->getCategories('kurt-russel');
        $dataProvider = new ArrayDataProvider([
            'allModels' => $manager->getCategories(),
        ]);
        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }
    /**
     * Edit or create a single category.
     *
     * @param int $id an id of a category to edit. If not provided a new
     * category is created.
     * @return string the rendering result.
     */
    public function actionEdit($id = 0)
    {
        $manager = Yii::$app->big->categoryManager;
        $model = $manager->getModel($id);
        if ($manager->saveModel($model)) {
            Yii::$app->getSession()->setFlash('success', 'Category saved');
            return $this->redirect(['index']);
        }
        $parents = ['Root'];
        foreach ($manager->getCategories() as $category) {
            if ($category->id != $model->id) {
                $parents[$category->id] = str_repeat('- ', $category->depth) . $category->title;
            }
        }
        if ($parent = $manager->getParent($model)) {
            $model->parent_id = $parent->id;
        }
        return $this->render('edit', [
            'model' => $model,
            'parents' => $parents,
        ]);
    }
}