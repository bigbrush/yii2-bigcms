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
                'updateContent' => function() {
                    return $this->renderPartial('_grid', ['dataProvider' => $this->getDataProvider()]);
                },
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
        return $this->render('index', [
            'dataProvider' => $this->getDataProvider(),
        ]);
    }

    /**
     * Returns a dataprovider used in views.
     *
     * @return ArrayDataProvider a data provider.
     */
    public function getDataProvider()
    {
        $manager = Yii::$app->big->categoryManager;
        return new ArrayDataProvider([
            'allModels' => $manager->getCategories(),
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
            Yii::$app->getSession()->setFlash('success', Yii::t('cms', 'Category saved'));
            if (Yii::$app->toolbar->stayAfterSave()) {
                return $this->redirect(['edit', 'id' => $model->id]);
            } else {
                return $this->redirect(['index']);
            }
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

    /**
     * Deletes a category after a form submission.
     *
     * @param int $id an id of a page to delete. Must match id in posted form.
     * @throws InvalidCallException if provided id does not match id in posted form.
     */
    public function actionDelete($id)
    {
        $categoryId = Yii::$app->getRequest()->post('id');
        if ($categoryId != $id) {
            throw new InvalidCallException("Invalid form submitted. Category with id: '$id' not deleted.");
        }
        $model = Yii::$app->big->categoryManager->getModel($id);
        if ($model) {
            if ($model->delete()) {
                Yii::$app->getSession()->setFlash('success', Yii::t('cms', 'Category deleted.'));
            } else {
                Yii::$app->getSession()->setFlash('info', Yii::t('cms', 'Category not deleted, please try again.'));
            }
        } else {
            Yii::$app->getSession()->setFlash('error', Yii::t('cms', 'Category with id "{id}" not found.', [
                'id' => $id
        	]));
        }
        return $this->redirect(['index']);
    }
}