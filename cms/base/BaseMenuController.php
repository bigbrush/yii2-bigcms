<?php
/**
 * @link http://www.bigbrush-agency.com/
 * @copyright Copyright (c) 2015 Big Brush Agency ApS
 * @license http://www.bigbrush-agency.com/license/
 */

namespace bigbrush\cms\base;

use Yii;
use yii\base\InvalidCallException;
use yii\data\ArrayDataProvider;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use yii\web\Controller;
use bigbrush\big\models\Menu;

/**
 * BaseMenuController
 */
abstract class BaseMenuController extends Controller
{
    const ACTIVE_MENU_ID = '_cms_menu_id_';


    /**
     * Returns the manager of this controller.
     *
     * @return bigbrush\big\core\MenuManager the manager used in controller.
     */
    abstract public function getManager();

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
     * Returns an id of the active menu.
     *
     * @return string a numerical id of the active menu as a string.
     */
    public function getActiveMenuId()
    {
        $id = Yii::$app->getSession()->get(static::ACTIVE_MENU_ID, false);
        if ($id) {
            return $id;
        }

        $menus = $this->getManager()->getMenus();
        if (!empty($menus)) {
            $id = array_keys($menus)[0];
            $this->setActiveMenuId($id);
            return $id;
        } else {
            return '0';
        }
    }

    /**
     * Registers an id of the active menu.
     *
     * @param string $id an id of the active menu.
     */
    public function setActiveMenuId($id)
    {
        Yii::$app->getSession()->set(static::ACTIVE_MENU_ID, $id);
    }

    /**
     * Returns an array data provider for a menu with the provided id.
     *
     * @param int an id of menu to load items from. If not provided or 0 (zero)
     * the session will be searched for at previous set menu id. If session is empty
     * the first menu (if any exists) will be used as the active.
     * @return ArrayDataProvider an array data provider.
     */
    public function getDataProvider($id = 0)
    {
        if (!$id) {
            $id = $this->getActiveMenuId();
        } else {
            $this->setActiveMenuId($id);
        }
        $dataProvider = new ArrayDataProvider([
            'allModels' => $this->getManager()->getItems($id),
        ]);
        return $dataProvider;
    }

    /**
     * Show a list of all menu items
     *
     * @param int an id of menu to load items from. If not provided or 0 (zero)
     * a new menu item is created.
     * @return string
     */
    public function actionIndex($id = 0)
    {
        // create dropdown first so all menus are loaded with $manager->getMenus()
        $dropdown = [];
        foreach ($this->getManager()->getMenus() as $menu) {
            $dropdown[] = ['label' => $menu->title, 'url' => Url::to(['index', 'id' => $menu->id])];
        }
        $dataProvider = $this->getDataProvider($id);
        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'dropdown' => $dropdown,
        ]);
    }

    /**
     * Creates and edits menu items.
     *
     * @param int $id optional if of a model to load. If id is not.
     * provided a new record is created.
     * @return string
     */
    public function actionEdit($id = 0)
    {
        $manager = $this->getManager();
        $model = $manager->getModel($id);
        if ($model->load(Yii::$app->getRequest()->post()) && $model->validate()) {
            $parent = $model->parents(1)->one();
            $menu = $manager->getModel($model->menu_id);

            if ($model->menu_id != $menu->id) {
                $model->appendTo($menu, false);
            } elseif (!$model->parent_id) {
                if (!$parent || $parent->id != $menu->id) {
                    $model->appendTo($menu, false);
                } else {
                    $model->save(false);
                }
            } else {
                if ($parent === null || $model->parent_id != $parent->id) {
                    $parent = $manager->getModel($model->parent_id);
                    $model->appendTo($parent, false);
                } else {
                    $model->save(false);
                }
            }

            Yii::$app->getSession()->setFlash('success', Yii::t('cms', 'Menu item saved.'));
            if (Yii::$app->toolbar->stayAfterSave()) {
                return $this->redirect(['edit', 'id' => $model->id]);
            } else {
                return $this->redirect(['index']);
            }
        }

        $menus = $manager->getMenus(true);
        if ($model->getIsNewRecord()) {
            $model->state = Menu::STATE_ACTIVE;
            $model->parent_id = 0;
            $model->menu_id = $this->getActiveMenuId();
        } else {
            if ($parent = $manager->getParent($model)) {
                $model->parent_id = $parent->id;
            } else {
                $model->parent_id = 0;
            }
            $model->menu_id = $menus[$model->tree]->id;
        }
        
        if ($model->menu_id) {
            $menu = $manager->getRoot($model->menu_id);
            $parents = ['- ' . Yii::t('cms', 'Root') . ' -'];
            $parents = $parents + ArrayHelper::map($manager->getItems($model->menu_id), 'id', function($data){
                return str_repeat('-', $data->depth - 1) . ' ' . $data->title ;
            });
            // remove current menu item from available parents
            if ($model->id) {
                ArrayHelper::remove($parents, $model->id);
            }
        } else {
            $parents = [];
        }
        $menus = [Yii::t('cms', 'Choose menu')] + ArrayHelper::map($menus, 'id', 'title');
        return $this->render('edit', [
            'model' => $model,
            'menus' => $menus,
            'parents' => $parents,
        ]);
    }

    /**
     * Deletes a menu item.
     *
     * @param int $id an id of a menu item.
     */
    public function actionDelete($id)
    {
        $menuId = Yii::$app->getRequest()->post('id');
        if ($menuId != $id) {
            throw new InvalidCallException("Invalid form submitted. Menu item with id: '$id' not deleted.");
        }
        $model = $this->getManager()->getModel($id);
        if ($model) {
            if ($model->is_default) {
                Yii::$app->getSession()->setFlash('info', Yii::t('cms', 'Cannot delete the default menu item.'));
            } else {
                if ($model->delete()) {
                    Yii::$app->getSession()->setFlash('success', Yii::t('cms', 'Menu item deleted.'));
                } else {
                    Yii::$app->getSession()->setFlash('error', Yii::t('cms', 'Menu item could not be deleted.'));
                }
            }
        } else {
            Yii::$app->getSession()->setFlash('error', Yii::t('cms', 'Menu item with id "{id}" not found.', [
                'id' => $id
            ]));
        }
        return $this->redirect(['index']);
    }

    /**
     * Show a list of all menus.
     *
     * @return string the rendering result.
     */
    public function actionMenus()
    {
        $dataProvider = new ArrayDataProvider([
            'allModels' => $this->getManager()->getMenus(),
        ]);
        return $this->render('menus', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Creates and edits menus
     *
     * @param int $id optional id of a model to load. If id is not
     * provided a new record is created.
     * @return string
     */
    public function actionEditMenu($id = 0)
    {
        $model = $this->getManager()->getModel($id);
        $model->setScenario(Menu::SCENARIO_MENU);
        if ($model->load(Yii::$app->getRequest()->post()) && $model->validate()) {
        	if ($model->getIsNewRecord()) {
        	    $model->makeRoot(false);
        	} else {
        	    $model->save(false);
        	}
            Yii::$app->getSession()->setFlash('success', Yii::t('cms', 'Menu saved.'));
            if (Yii::$app->toolbar->stayAfterSave()) {
                return $this->redirect(['edit-menu', 'id' => $model->id]);
            } else {
                return $this->redirect(['menus']);
            }
        }
        return $this->render('edit_menu', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes a menu.
     * TAKE CARE - All menu items will be deleted as well.
     *
     * @param int $id an id of a menu.
     */
    public function actionDeleteMenu($id)
    {
        $menuId = Yii::$app->getRequest()->post('id');
        if ($menuId != $id) {
            throw new InvalidCallException("Invalid form submitted. Menu with id: '$id' not deleted.");
        }
        $model = $this->getManager()->getModel($id);
        if ($model) {
            if ($model->deleteWithChildren()) {
                // remove the active menu from session if the currently active is the deleted one.
                $session = Yii::$app->getSession();
                if ($this->getActiveMenuId() == $id) {
                    $this->setActiveMenuId(null);
                }
                Yii::$app->getSession()->setFlash('success', Yii::t('cms', 'Menu deleted.'));
            } else {
                Yii::$app->getSession()->setFlash('error', Yii::t('cms', 'Menu could not be deleted.'));
            }
        } else {
            Yii::$app->getSession()->setFlash('error', Yii::t('cms', 'Menu with id "{id}" not found.', [
                'id' => $id
            ]));
        }
        return $this->redirect(['menus']);
    }
}
