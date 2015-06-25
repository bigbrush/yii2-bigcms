<?php
/**
 * @link http://www.bigbrush-agency.com/
 * @copyright Copyright (c) 2015 Big Brush Agency ApS
 * @license http://www.bigbrush-agency.com/license/
 */

namespace bigbrush\cms\blocks\menu;

use Yii;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use bigbrush\cms\blocks\menu\components\ModelBehavior;

/**
 * Block
 *
 * @property big\models\Block $model
 */
class Block extends \bigbrush\big\core\Block
{
    /**
     * Initializes this block by attaching a behavior to [[model]].
     */
    public function init()
    {
        $this->model->attachBehavior('menuBlockBehavior', ['class' => ModelBehavior::className(), 'owner' => $this->model]);
    }

    /**
     * Returns the content of this block when it is rendered.
     *
     * @return string the content of this block.
     */
    public function run()
    {
        $menus = Yii::$app->big->menuManager->getItems($this->model->menu_id);
        $items = $this->createDropDownMenu($menus);
        if ($this->getIsNavbar()) {
            $navbarOptions = ['options' => $this->getNavbarOptions()];
            if (!empty($this->model->brand)) {
                $brand = $this->model->brand;
                // images has the string "image:" prepended
                if (strpos($brand, 'image:') === 0) {
                    $brand = substr($brand, 6);
                    $navbarOptions['brandLabel'] = Html::img($brand);
                } else {
                    $navbarOptions['brandLabel'] = $brand;
                }
            }
            return $this->render('navbar', [
                'block' => $this,
                'items' => $items,
                'options' => $this->getNavOptions(true),
                'navbarOptions' => $navbarOptions,
            ]);
        } else {
            return $this->render('nav', [
                'block' => $this,
                'items' => $items,
                'options' => $this->getNavOptions(false),
            ]);
        }
    }

    /**
     * Edits the block.
     *
     * @param Block $model the model for this block.
     * @param yii\bootstrap\ActiveForm $form the form used to edit this block.
     * @return string html form ready to be rendered.
     */
    public function edit($model, $form)
    {
        $menus = Yii::$app->big->menuManager->getMenus();
        $menusDropDown = ['' => Yii::t('cms', '- Select menu -')] + ArrayHelper::map($menus, 'id', 'title');
        return $this->render('edit', [
            'model' => $model,
            'form' => $form,
            'menusDropDown' => $menusDropDown,
            'isNavbar' => $this->getIsNavbar(),
        ]);
    }

    /**
     * This method gets called right before a block model is saved. The model is validated at this point.
     * In this method any Block specific logic should run. For example saving a block specific model.
     * 
     * @param bigbrush\big\models\Block the model being saved.
     * @return boolean whether the current save procedure should proceed. If any block.
     * specific logic fails false should be returned - i.e. return $blockSpecificModel->save();
     */
    public function save($model)
    {
        $model->updateOwner();
        return true;
    }

    /**
     * Returns a configuration array for the menu items of a bootstrap nav.
     *
     * @param boolean $isNavbar a boolean indicating whether this is menu is a navbar. Use [[getIsNavbar()]] for this parameter.
     * @return array an options array.
     */
    public function getNavOptions($isNavbar)
    {
        $options = [];
        if ($isNavbar) {
            Html::addCssClass($options, 'navbar-nav');
        } else {
            Html::addCssClass($options, ModelBehavior::TYPE_DEFAULT);
            if ($this->model->type !== ModelBehavior::TYPE_DEFAULT) {
                Html::addCssClass($options, $this->model->type);
            }
        }
        return $options;
    }

    /**
     * Returns a configuration array for a bootstrap navbar.
     *
     * @return array an options array.
     */
    public function getNavbarOptions()
    {
        $options = [];
        Html::addCssClass($options, 'navbar');
        Html::addCssClass($options, ModelBehavior::TYPE_NAV_BAR);
        if ($this->model->type !== ModelBehavior::TYPE_NAV_BAR) {
            Html::addCssClass($options, $this->model->type);
        }
        return $options;
    }

    /**
     * Returns a boolean indicating whether this a navbar menu.
     *
     * @return boolean true if this menu is of type navbar and false if not.
     */
    public function getIsNavbar()
    {
        return in_array($this->model->type, $this->model->getNavbarTypes());
    }

    /**
     * Creates a drop down menu ready for [[yii\bootstrap\Nav]] and [[yii\widgets\Menu]].
     *
     * @param array list of menus to nest in an array.
     * @return array nested array ready for a drop down menu.
     */
    public function createDropDownMenu(&$menus)
    {
        $items = [];
        $active = Yii::$app->big->menuManager->getActive();
        while (list($id, $menu) = each($menus)) {
            $items[$id] = [
                'label' => $menu->title,
                'url' => $menu->getUrl(),
                'active' => $menu->id == $active->id,
                'visible' => $menu->getIsEnabled(),
            ];
            if ($menu->rgt - $menu->lft != 1) {
                $items[$id]['items'] = $this->createDropDownMenu($menus);
            }
            $next = key($menus);
            if ($next && $menus[$next]->depth != $menu->depth) {
                return $items;
            }
        }
        return $items;
    }
}