<?php
/**
 * @link http://www.bigbrush-agency.com/
 * @copyright Copyright (c) 2015 Big Brush Agency ApS
 * @license http://www.bigbrush-agency.com/license/
 */

namespace cms\blocks\menu;

use Yii;
use yii\helpers\ArrayHelper;
use cms\blocks\menu\components\ModelBehavior;

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
     * @return string the content of this block
     */
    public function run()
    {
        $menus = Yii::$app->big->menuManager->getMenuItems($this->model->menu_id);
        reset($menus);
        $items = $this->createDropDownMenu($menus);
        return $this->render('index', [
            'model' => $this->model,
            'items' => $items,
        ]);
    }

    /**
     * Edits the block.
     *
     * @param Block $model the model for this block.
     * @return string html form ready to be rendered.
     */
    public function edit($model)
    {
        $menus = Yii::$app->big->menuManager->getMenus();
        $dropDownList = ['' => '- Select menu -'] + ArrayHelper::map($menus, 'id', 'title');
        return $this->render('edit', [
            'model' => $model,
            'dropDownList' => $dropDownList,
        ]);
    }

    /**
     * Creates a drop down menu ready for [[yii\bootstrap\Nav]] and [[yii\widgets\Menu]].
     *
     * @param array list of menus to nest in an array
     * @return array nested array ready for a drop down menu
     */
    public function createDropDownMenu(&$menus)
    {
        $items = [];
        while (list($id, $menu) = each($menus)) {
            $items[$id] = [
                'label' => $menu->title,
                'url' => $menu->getUrl(),
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