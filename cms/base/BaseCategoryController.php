<?php
/**
 * @link http://www.bigbrush-agency.com/
 * @copyright Copyright (c) 2015 Big Brush Agency ApS
 * @license http://www.bigbrush-agency.com/license/
 */

namespace bigbrush\cms\base;

use Yii;
use yii\data\ArrayDataProvider;
use yii\web\Controller;

/**
 * BaseCategoryController
 */
abstract class BaseCategoryController extends Controller
{
    /**
     * Returns an id used to load a category tree.
     * If no tree exists for the returned id one will automatically be created.
     * 
     * An example of the method body:
     * ~~~php
     * return $this->module->id;
     * ~~~
     * 
     * Please note that if the categories are used in a block the active module could be different than
     * the module of this controller. In this case you need to provide the tree id directly.
     * For instance:
     * ~~~php
     * $categories = Yii::$app->big->categoryManager->getItems('YOUR_MODULE_ID');
     * ~~~
     * 
     * @return string id of a category tree.
     */
    abstract public function getTreeId();

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
                'class' => 'bigbrush\big\core\NestedSetMoveAction',
                'model' => $this->getManager()->getModel(),
                'updateContent' => function() {
                    return $this->renderPartial('_grid', ['dataProvider' => $this->getDataProvider()]);
                },
            ],
        ];
    }

    /**
     * Returns the manager of this controller.
     *
     * @return bigbrush\big\core\CategoryManager the manager used in controller.
     */
    public function getManager()
    {
        return Yii::$app->big->categoryManager;
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
        return new ArrayDataProvider([
            'allModels' => $this->getManager()->getItems($this->getTreeId()),
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
        $manager = $this->getManager();
        $model = $manager->getModel($id);
        if ($manager->saveModel($this->getTreeId(), $model)) {
            Yii::$app->getSession()->setFlash('success', Yii::t('cms', 'Category saved'));
            if (Yii::$app->toolbar->stayAfterSave()) {
                return $this->redirect(['edit', 'id' => $model->id]);
            } else {
                return $this->redirect(['index']);
            }
        }
        $unselected = '- ' . Yii::t('cms', 'Root') . ' -';
        $parents = $manager->getDropDownList($this->getTreeId(), $unselected);
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
        $model = $this->getManager()->getModel($id);
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
