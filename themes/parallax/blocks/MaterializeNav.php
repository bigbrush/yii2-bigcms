<?php
/**
 * @link http://www.bigbrush-agency.com/
 * @copyright Copyright (c) 2015 Big Brush Agency ApS
 * @license http://www.bigbrush-agency.com/license/
 */

namespace app\themes\parallax\blocks;

use Yii;
use yii\helpers\ArrayHelper;
use yii\helpers\Json;
use bigbrush\big\core\Block;

/**
 * MaterializeNav
 */
class MaterializeNav extends Block
{
    public $menuId;


    /**
     * @inheritdoc
     */
    public function init()
    {
        $this->model->content = Json::decode($this->model->content);
        if (!empty($this->model->content)) {
            foreach ($this->model->content as $name => $value) {
                $this->$name = $value;
            }
        }
    }

    /**
     * @inheritdoc
     */
    public function run()
    {
        $manager = Yii::$app->big->menuManager;
        $items = $manager->getItems($this->menuId);

        $items = $manager->createDropDownMenu($items);
        $parentMenus = [];
        $submenus = [];

        foreach ($items as $id => $item) {
            $submenuId = 'dropdown' . $id;
            $item['submenu'] = false;
            if (isset($item['items'])) {
                $submenus[$submenuId] = $item['items'];
                unset($item['items']);
                $item['submenu'] = $submenuId;
            }
            $parentMenus[] = $item;
        }
        return $this->render('nav', [
            'items' => $items,
            'parentMenus' => $parentMenus,
            'submenus' => $submenus,
        ]);
    }

    /**
     * @inheritdoc
     */
    public function edit($model, $form)
    {
        $menus = Yii::$app->big->menuManager->getMenus();
        $dropdown = ['' => Yii::t('cms', '- Select menu -')] + ArrayHelper::map($menus, 'id', 'title');
        return $form->field($model, 'content[menuId]')->dropDownList($dropdown);
    }

    /**
     * @inheritdoc
     */
    public function save($model)
    {
        $this->model->content = Json::encode($this->model->content);
        return true;
    }
}
